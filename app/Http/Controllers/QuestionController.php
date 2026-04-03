<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Question;
use App\Models\Category;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $query = Question::where('created_by', auth()->id())
            ->whereNull('section_id') // Bank questions don't have a section_id
            ->whereNull('parent_id')  // Only top-level questions in bank
            ->with('category');

        if ($request->filled('search')) {
            $query->where('content', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $questions = $query->latest()->paginate(10);
        $categories = Category::where('type', 'subject')->get();
        
        return view('questions.index', compact('questions', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('type', 'subject')->get();
        return view('questions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:mcq,tf,open,consigne,qcm,true_false',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'content' => 'required|string',
            'option_a' => 'nullable|string',
            'option_b' => 'nullable|string',
            'option_c' => 'nullable|string',
            'option_d' => 'nullable|string',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
            'points' => 'nullable|numeric|min:0',
            'requires_answer_space' => 'boolean',
            'answer_space_size' => 'nullable|in:small,medium,large',
            'parent_id' => 'nullable|exists:questions,id',
            'section_id' => 'nullable|exists:sections,id'
        ]);

        if (in_array($validated['type'], ['qcm', 'mcq'])) {
            $validated['correct_answer'] = $request->input('correct_answer_mcq') ?? $request->input('correct_answer');
        } elseif (in_array($validated['type'], ['true_false', 'tf'])) {
            $validated['correct_answer'] = $request->input('correct_answer_tf') ?? $request->input('correct_answer');
        }

        $validated['requires_answer_space'] = $request->boolean('requires_answer_space');
        $validated['points'] = $validated['points'] ?? 0;

        // Automatically assign correct order for sub-questions or section top-questions
        if (empty($validated['order'])) {
            if (!empty($validated['parent_id'])) {
                $parent = Question::find($validated['parent_id']);
                if ($parent) {
                    $validated['order'] = $parent->subQuestions()->count() + 1;
                }
            } elseif (!empty($validated['section_id'])) {
                $section = \App\Models\Section::find($validated['section_id']);
                if ($section) {
                    $validated['order'] = $section->questions()->whereNull('parent_id')->count() + 1;
                }
            } else {
                $validated['order'] = 1;
            }
        }

        try {
            $validated['created_by'] = auth()->id();
            $question = Question::create($validated);

            ActivityLog::log('question_created', 'Question créée (type: ' . $question->type . ') par ' . auth()->user()->name);

            // Handle text variations
            if ($request->has('text_variants')) {
                foreach ($request->text_variants as $variantText) {
                    if (!empty($variantText)) {
                        $question->textVariants()->create(['text' => $variantText]);
                    }
                }
            }
            
            // If created inside a section, link to the exam
            if ($question->section_id) {
                $section = \App\Models\Section::find($question->section_id);
                if ($section) {
                    $section->exam->questions()->attach($question->id, ['order' => $question->order]);
                }
            }

            if ($request->wantsJson()) {
                // Re-fetch question with its subquestions (if any) to prevent logic errors in partial
                $question->load('subQuestions');
                $section = $question->section;
                if ($section) {
                    $section->load('questions');
                    if ($section->exam) $section->exam->load('sections.questions');
                }
                
                $html = view('questions.partials.question-card', [
                    'question' => $question, 
                    'index' => $section ? $section->questions()->whereNull('parent_id')->count() : 'Nouveau',
                    'section_id' => $question->section_id
                ])->render();

                return response()->json([
                    'success' => true, 
                    'question' => $question, 
                    'html' => $html,
                    'section_total' => $section ? $section->total_points : 0,
                    'exam_total' => ($section && $section->exam) ? $section->exam->total_points : 0
                ]);
            }
            
            return back()->with('success', 'Question ajoutée.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            throw $e;
        }
    }

    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $categories = Category::where('type', 'subject')->get();
        return view('questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:mcq,tf,open,consigne,qcm,true_false',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'content' => 'required|string',
            'option_a' => 'nullable|string',
            'option_b' => 'nullable|string',
            'option_c' => 'nullable|string',
            'option_d' => 'nullable|string',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
            'points' => 'nullable|numeric|min:0',
            'requires_answer_space' => 'boolean',
            'answer_space_size' => 'nullable|in:small,medium,large',
            'parent_id' => 'nullable|exists:questions,id'
        ]);
        
        if (in_array($validated['type'], ['qcm', 'mcq'])) {
            $validated['correct_answer'] = $request->input('correct_answer_mcq') ?? $request->input('correct_answer');
        } elseif (in_array($validated['type'], ['true_false', 'tf'])) {
            $validated['correct_answer'] = $request->input('correct_answer_tf') ?? $request->input('correct_answer');
        }

        $validated['requires_answer_space'] = $request->boolean('requires_answer_space');
        $validated['points'] = $validated['points'] ?? 0;

        $question->update($validated);

        ActivityLog::log('question_updated', 'Question mise à jour (ID: ' . $question->id . ') par ' . auth()->user()->name);

        // Handle text variations
        if ($request->has('text_variants')) {
            $question->textVariants()->delete();
            foreach ($request->text_variants as $variantText) {
                if (!empty($variantText)) {
                    $question->textVariants()->create(['text' => $variantText]);
                }
            }
        }

        return back()->with('success', 'Question mise à jour.');
    }

    public function destroy(Question $question)
    {
        $id = $question->id;
        $question->delete();

        ActivityLog::log('question_deleted', 'Question supprimée (ID: ' . $id . ') par ' . auth()->user()->name);

        return redirect()->route('questions.index')->with('success', 'Question supprimée.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'exists:questions,id'
        ]);

        foreach ($request->items as $index => $id) {
            Question::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function removeFromExam(Question $question)
    {
        try {
            $section = $question->section;
            
            if ($question->section_id) {
                // Delete the cloned question and its subquestions
                $question->delete();
            }

            if ($section) {
                $section->refresh();
                if ($section->exam) $section->exam->refresh();
                
                return response()->json([
                    'success' => true,
                    'section_total' => $section->total_points,
                    'exam_total' => $section->exam ? $section->exam->total_points : 0
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function rephrase(Request $request)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $rephrased = AIService::rephrase($request->content);

        return response()->json([
            'success' => true,
            'rephrased' => $rephrased
        ]);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('questions', $filename, 'public');
            
            return response()->json([
                'location' => Storage::url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
