<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    // Teacher Methods
    public function index()
    {
        $quizzes = Quiz::where('created_by', auth()->id())->latest()->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $questions = Question::where('created_by', auth()->id())
            ->whereIn('type', ['mcq', 'tf', 'qcm', 'true_false'])
            ->get();
        return view('quizzes.create', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
        ]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'duration' => $request->duration,
            'code' => 'QUIZ-' . strtoupper(Str::random(6)),
            'created_by' => auth()->id(),
        ]);

        $quiz->questions()->attach($request->questions);

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully! Code: ' . $quiz->code);
    }

    public function destroy(Quiz $quiz)
    {
        if ($quiz->created_by !== auth()->id()) {
            abort(403);
        }
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    // Student Methods
    public function access(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'student_name' => 'required|string|max:255',
        ]);

        $quiz = Quiz::where('code', $request->code)->where('is_active', true)->first();

        if (!$quiz) {
            return back()->with('error', 'Code de quiz invalide ou inactif.');
        }

        $participantsCount = StudentAnswer::where('quiz_id', $quiz->id)
            ->distinct('student_name')
            ->count('student_name');

        $hasSubmitted = StudentAnswer::where('quiz_id', $quiz->id)
            ->where('student_name', $request->student_name)
            ->exists();

        if ($hasSubmitted) {
            return back()->with('error', 'Vous avez déjà soumis vos réponses pour ce quiz.');
        }

        if ($participantsCount >= 20) {
            return back()->with('error', 'Le nombre maximum de participants (20) a été atteint pour ce quiz.');
        }

        return redirect()->route('quizzes.start', ['code' => $quiz->code, 'student_name' => $request->student_name]);
    }

    public function start($code, $student_name)
    {
        $quiz = Quiz::where('code', $code)->with('questions')->firstOrFail();
        return view('quizzes.show', compact('quiz', 'student_name'));
    }

    public function submit(Request $request, $code)
    {
        $quiz = Quiz::where('code', $code)->firstOrFail();
        $student_name = $request->student_name;
        $answers = $request->answers; // [question_id => selected_option]

        foreach ($quiz->questions as $question) {
            $selected = $answers[$question->id] ?? null;
            $isCorrect = false;
            
            if ($selected) {
                // Uniform comparison (trim and case-insensitive)
                $isCorrect = (trim(strtoupper($selected)) === trim(strtoupper($question->correct_answer)));
            }

            StudentAnswer::create([
                'quiz_id' => $quiz->id,
                'student_name' => $student_name,
                'question_id' => $question->id,
                'selected_answer' => $selected ?? '',
                'is_correct' => $isCorrect,
            ]);
        }

        return redirect()->route('quizzes.result', ['code' => $code, 'student_name' => $student_name]);
    }

    public function result($code, $student_name)
    {
        $quiz = Quiz::where('code', $code)->firstOrFail();
        $answers = StudentAnswer::where('quiz_id', $quiz->id)
            ->where('student_name', $student_name)
            ->with('question')
            ->get();

        $score = $answers->count() > 0 
            ? round(($answers->where('is_correct', true)->count() / $quiz->questions->count()) * 100, 2)
            : 0;

        return view('quizzes.result', compact('quiz', 'student_name', 'answers', 'score'));
    }

    public function teacherResults(Quiz $quiz)
    {
        if ($quiz->created_by !== auth()->id()) {
            abort(403);
        }

        $totalQuestions = $quiz->questions->count();

        $results = StudentAnswer::where('quiz_id', $quiz->id)
            ->with('question')
            ->get()
            ->groupBy('student_name')
            ->map(function ($answers, $name) use ($totalQuestions) {
                $correctCount = $answers->where('is_correct', true)->count();
                return [
                    'name' => $name,
                    'score' => $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100, 2) : 0,
                    'correct' => $correctCount,
                    'total' => $totalQuestions,
                    'date' => $answers->max('created_at')
                ];
            })->values()->toArray();

        // Sort by score descending
        usort($results, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return view('quizzes.teacher_results', compact('quiz', 'results'));
    }

    public function studentDetails(Quiz $quiz, $student_name)
    {
        if ($quiz->created_by !== auth()->id()) {
            abort(403);
        }

        $answers = StudentAnswer::where('quiz_id', $quiz->id)
            ->where('student_name', $student_name)
            ->with('question')
            ->get();

        if ($answers->isEmpty()) {
            abort(404, 'No answers found for this student.');
        }

        return view('quizzes.student_details', compact('quiz', 'student_name', 'answers'));
    }
}
