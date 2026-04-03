<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Exam;
use App\Models\Category;
use App\Models\Question;
use App\Models\ExamVariant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

class ExamController extends Controller
{
    public function index()
    {
        $query = Exam::with('category', 'creator')->latest();

        if (auth()->user()->role !== 'admin') {
            $query->where('created_by', auth()->id());
        }

        $exams = $query->paginate(10);
        return view('exams.index', compact('exams'));
    }

    public function create()
    {
        $categories = Category::where('type', 'subject')->get();
        return view('exams.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'duration'    => 'required|integer|min:1',
            'type'        => 'required|in:efm,examen',
            'niveau'      => 'nullable|string|max:100',
            'module_no'   => 'nullable|string|max:20',
            'bareme'      => 'nullable|string|max:20',
        ]);

        $validated['created_by'] = auth()->id();
        $exam = Exam::create($validated);

        ActivityLog::log('exam_created', 'Examen créé : "' . $exam->title . '"');

        return redirect()->route('exams.index')->with('success', 'Examen créé avec succès.');
    }

    public function show(Exam $exam)
    {
        $exam->load('sections.questions.subQuestions', 'variants');
        $availableQuestions = Question::where('category_id', $exam->category_id)
            ->where('created_by', auth()->id())
            ->whereNull('section_id')
            ->whereNull('parent_id')
            ->get();

        return view('exams.show', compact('exam', 'availableQuestions'));
    }

    public function edit(Exam $exam)
    {
        $categories = Category::where('type', 'subject')->get();
        return view('exams.edit', compact('exam', 'categories'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'duration'    => 'required|integer|min:1',
            'type'        => 'required|in:efm,examen',
            'niveau'      => 'nullable|string|max:100',
            'module_no'   => 'nullable|string|max:20',
            'bareme'      => 'nullable|string|max:20',
        ]);

        $exam->update($validated);
        return redirect()->route('exams.index')->with('success', 'Examen mis à jour.');
    }

    public function destroy(Exam $exam)
    {
        $title = $exam->title;
        $exam->delete();

        ActivityLog::log('exam_deleted', 'Examen supprimé : "' . $title . '"');

        return redirect()->route('exams.index')->with('success', 'Examen supprimé.');
    }

    // Custom method to add questions to exam (handled in update conceptually or a dedicated route)
    // Actually we can just do sync in a separate route or update. Let's do it in update if request has 'questions' array.
    // Wait, let's create a generateVariants method.
    public function generateVariants(Request $request, Exam $exam)
    {
        $num_variants = $request->num_variants ?? 1;

        // Clear existing
        foreach ($exam->variants as $variant) {
            $variant->questions()->detach();
            $variant->delete();
        }

        $names = range('A', 'Z');

        for ($i = 0; $i < $num_variants; $i++) {
            $variant = $exam->variants()->create(['name' => 'Variante ' . $names[$i]]);

            $syncData = [];
            
            // Iterate over sections to maintain structure
            foreach ($exam->sections as $section) {
                // Group questions into blocks (Consigne + Following Questions)
                $allSectionQuestions = $section->questions()->whereNull('parent_id')->orderBy('order')->get();
                $blocks = [];
                $currentBlock = null;

                foreach ($allSectionQuestions as $q) {
                    if (strtolower($q->type) === 'consigne') {
                        if ($currentBlock) $blocks[] = $currentBlock;
                        $currentBlock = ['questions' => [$q]];
                    } elseif ($currentBlock) {
                        $currentBlock['questions'][] = $q;
                    } else {
                        $blocks[] = ['questions' => [$q]];
                    }
                }
                if ($currentBlock) $blocks[] = $currentBlock;

                // Shuffle ONLY the blocks within this section
                shuffle($blocks);
                
                $order = 1;
                foreach ($blocks as $block) {
                    foreach ($block['questions'] as $q) {
                        $pivotData = ['order' => $order++];

                        // Handle MCQ Shuffling
                        if ($q->type == 'mcq' && is_array($q->options)) {
                            $opts = $q->options;
                            shuffle($opts);
                            $pivotData['shuffled_options'] = json_encode($opts);
                        }

                        // Handle Open Question Variation Selection
                        if ($q->type == 'open') {
                             $variation = $q->textVariants()->inRandomOrder()->first();
                             if ($variation) {
                                 $pivotData['custom_text'] = $variation->text;
                             }
                        }

                        $syncData[$q->id] = $pivotData;
                        
                        // Attach sub-questions right after the parent (always keep them with parent)
                        $subQs = $section->questions->where('parent_id', $q->id)->sortBy('order');
                        foreach($subQs as $subQ) {
                            $subPivot = ['order' => $order++];
                            if ($subQ->type == 'mcq' && is_array($subQ->options)) {
                                $opts = $subQ->options;
                                shuffle($opts);
                                $subPivot['shuffled_options'] = json_encode($opts);
                            }
                            // Variations can also apply to sub-questions if they are open
                            if ($subQ->type == 'open') {
                                $subVariation = $subQ->textVariants()->inRandomOrder()->first();
                                if ($subVariation) {
                                    $subPivot['custom_text'] = $subVariation->text;
                                }
                            }
                            $syncData[$subQ->id] = $subPivot;
                        }
                    }
                }
            }

            $variant->questions()->sync($syncData);
        }

        return redirect()->route('exams.show', $exam)->with('success', "$num_variants variantes générées avec succès.");
    }



    public function addQuestionsToSection(Request $request, Exam $exam, \App\Models\Section $section)
    {
        if ($section->exam_id !== $exam->id) abort(403);

        $questionIds = $request->input('question_ids', $request->input('questions', []));

        if (empty($questionIds)) {
            if ($request->wantsJson()) return response()->json(['success' => false, 'message' => 'Aucune question sélectionnée.']);
            return back()->with('error', 'Veuillez sélectionner au moins une question pour l\'ajouter.');
        }

        $order = $section->questions()->count() + 1;
        $newHtml = "";
        
        foreach ($questionIds as $qid) {
            $original = Question::find($qid);
            if (!$original) continue;

            $newQuestion = $original->replicate();
            $newQuestion->section_id = $section->id;
            $newQuestion->order = $order++;
            $newQuestion->save();

            // Replicate Text Variations
            foreach ($original->textVariants as $variant) {
                $newVariant = $variant->replicate();
                $newVariant->question_id = $newQuestion->id;
                $newVariant->save();
            }

            $exam->questions()->attach($newQuestion->id, ['order' => $newQuestion->order]);

            foreach ($original->subQuestions as $sub) {
                $newSub = $sub->replicate();
                $newSub->section_id = $section->id;
                $newSub->parent_id = $newQuestion->id;
                $newSub->save();
                
                // Replicate sub-question text variations
                foreach ($sub->textVariants as $subVariant) {
                    $newSubVariant = $subVariant->replicate();
                    $newSubVariant->question_id = $newSub->id;
                    $newSubVariant->save();
                }

                $exam->questions()->attach($newSub->id, ['order' => $newSub->order]);
            }

            if ($request->wantsJson()) {
                $newHtml .= view('questions.partials.question-card', [
                    'question' => $newQuestion->load('subQuestions'),
                    'index' => $order - 1,
                    'section_id' => $section->id
                ])->render();
            }
        }

        if ($request->wantsJson()) {
            $section->load('questions');
            $exam->load('sections.questions');
            return response()->json([
                'success' => true,
                'html' => $newHtml,
                'section_total' => $section->total_points,
                'exam_total' => $exam->total_points
            ]);
        }

        return back()->with('success', 'Sélection ajoutée avec succès à l\'examen.');
    }

    public function generateCorrection(Exam $exam)
    {
        $exam->load(['sections.questions' => function($q) {
            $q->whereIn('type', ['qcm', 'true_false', 'mcq', 'tf'])->orderBy('order');
        }, 'category']);

        // Check if there are any QCM/TF questions at all
        $hasCorrection = $exam->sections->some(function($s) {
            return $s->questions->count() > 0;
        });

        if (!$hasCorrection) {
            return back()->with('error', 'Cet examen ne contient aucune question QCM ou Vrai/Faux.');
        }

        $pdf = Pdf::loadView('pdf.correction', compact('exam'));
        
        return $pdf->stream('Correction_' . str_replace(' ', '_', $exam->title) . '.pdf');
    }

    public function exportToWord(Request $request, Exam $exam)
    {
        $exam->load(['sections.questions.subQuestions', 'category']);
        $showAnswers = $request->boolean('show_answers');

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop' => 1200, 'marginBottom' => 1200, 'marginLeft' => 1200, 'marginRight' => 1200,
        ]);

        // Title
        $section->addText(strtoupper($exam->title), ['bold' => true, 'size' => 18, 'color' => '1E3A8A'], ['alignment' => Jc::CENTER, 'spaceAfter' => 600]);

        // Header Info
        $headerTable = $section->addTable(['width' => 100 * 50]);
        $headerTable->addRow();
        $headerTable->addCell(5000)->addText("Filière : " . $exam->category->name, ['bold' => true]);
        $headerTable->addCell(5000)->addText("Date : " . date('d/m/Y'), ['bold' => true], ['alignment' => Jc::RIGHT]);
        $headerTable->addRow();
        $headerTable->addCell(5000)->addText("Durée : " . $exam->duration . " min", ['bold' => true]);
        $headerTable->addCell(5000)->addText("Barème : /" . $exam->total_points, ['bold' => true], ['alignment' => Jc::RIGHT]);
        
        $section->addTextBreak(1);

        $qIndex = 1;
        foreach ($exam->sections as $examSection) {
            $section->addText($examSection->title, ['bold' => true, 'size' => 14, 'underline' => 'single', 'color' => '1E3A8A'], ['spaceBefore' => 400, 'spaceAfter' => 200]);

            foreach ($examSection->questions->whereNull('parent_id')->sortBy('order') as $question) {
                $isConsigne = strtolower($question->type) === 'consigne';
                if (!$isConsigne) {
                    $textRun = $section->addTextRun(['spaceBefore' => 200]);
                    $textRun->addText($qIndex++ . ". ", ['bold' => true]);
                    
                    // Simple points label
                    if ($question->points > 0) {
                        $textRun->addText(" (" . $question->points . " pts)", ['italic' => true, 'color' => '4B5563']);
                    }
                    $section->addTextBreak(1);
                }
                
                // Process HTML for Word
                $htmlContent = $question->content;
                // Replace storage URLs with local paths for Word to find them
                $htmlContent = str_replace(url('storage'), public_path('storage'), $htmlContent);
                
                try {
                    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $htmlContent, false, false);
                } catch (\Exception $e) {
                    // Fallback to stripped text if HTML parsing fails
                    $qContent = html_entity_decode(strip_tags($question->content), ENT_QUOTES, 'UTF-8');
                    $qContent = preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $qContent);
                    $section->addText($qContent);
                }

                // Options for QCM/MCQ
                if (in_array(strtolower($question->type), ['qcm', 'mcq'])) {
                    foreach (['a', 'b', 'c', 'd'] as $opt) {
                        $field = 'option_' . $opt;
                        if ($question->$field) {
                            $optClean = html_entity_decode($question->$field, ENT_QUOTES, 'UTF-8');
                            $optClean = preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $optClean);
                            $section->addText(strtoupper($opt) . ") " . $optClean, null, ['marginLeft' => 400, 'spaceBefore' => 50]);
                        }
                    }
                }

                if ($showAnswers && $question->correct_answer) {
                    $section->addText("Réponse : " . $question->correct_answer, ['bold' => true, 'color' => '059669'], ['marginLeft' => 400, 'spaceBefore' => 100]);
                }

                // Sub-questions
                foreach ($question->subQuestions->sortBy('order') as $subQ) {
                    $section->addTextBreak(1);
                    $subHtml = $subQ->content;
                    $subHtml = str_replace(url('storage'), public_path('storage'), $subHtml);

                    try {
                        \PhpOffice\PhpWord\Shared\Html::addHtml($section, "<b>- </b>" . $subHtml, false, false);
                    } catch (\Exception $e) {
                        $subQContent = html_entity_decode(strip_tags($subQ->content), ENT_QUOTES, 'UTF-8');
                        $subQContent = preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $subQContent);
                        $section->addText("- " . $subQContent);
                    }

                    if ($subQ->points > 0) {
                        $section->addText(" (" . $subQ->points . " pts)", ['italic' => true, 'color' => '4B5563'], ['marginLeft' => 400]);
                    }
                }
            }
        }

        // Clear output buffer to prevent corruption
        if (ob_get_length()) ob_end_clean();

        $fileName = 'Examen_' . str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $exam->title) . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), 'word_');
        
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
