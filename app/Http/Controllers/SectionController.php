<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function store(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['exam_id'] = $exam->id;
        $validated['order'] = $exam->sections()->count() + 1;

        $section = Section::create($validated);

        if ($request->wantsJson()) {
            $availableQuestions = \App\Models\Question::where('category_id', $exam->category_id)
                ->where('created_by', auth()->id())
                ->whereNull('section_id')
                ->whereNull('parent_id')
                ->get();

            return response()->json([
                'success' => true,
                'section' => $section,
                'html' => view('exams.partials.section-card', [
                    'section' => $section, 
                    'exam' => $exam,
                    'availableQuestions' => $availableQuestions
                ])->render()
            ]);
        }

        return back()->with('success', 'Section ajoutée.');
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $section->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'section' => $section]);
        }

        return back()->with('success', 'Section mise à jour.');
    }

    public function destroy(Section $section)
    {
        $exam = $section->exam;
        $section->delete();

        if (request()->wantsJson()) {
            if ($exam) $exam->refresh();
            return response()->json([
                'success' => true,
                'exam_total' => $exam ? $exam->total_points : 0
            ]);
        }

        return back()->with('success', 'Section supprimée.');
    }
}
