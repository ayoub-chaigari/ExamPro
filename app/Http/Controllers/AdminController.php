<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ── Existing stats ──────────────────────────────────────────────────
        $totalQuestions = Question::count();
        $totalExams     = Exam::count();
        $examsThisWeek  = Exam::where('created_at', '>=', now()->subDays(7))->count();
        $totalTeachers  = User::where('role', 'teacher')->count();

        // ── Visitor stats ────────────────────────────────────────────────────
        $totalVisitors   = Visitor::distinct('ip_address')->count('ip_address');
        $visitorsToday   = Visitor::whereDate('created_at', today())->distinct('ip_address')->count('ip_address');
        $visitorsThisWeek = Visitor::where('created_at', '>=', now()->subDays(7))
                                   ->distinct('ip_address')->count('ip_address');

        $mostVisitedPages = Visitor::select('page', DB::raw('count(*) as visits'))
            ->groupBy('page')
            ->orderByDesc('visits')
            ->limit(5)
            ->get();

        // ── Teacher activity ─────────────────────────────────────────────────
        $teacherActivity = User::where('role', 'teacher')
            ->withCount([
                'exams'     => fn ($q) => $q->where('created_by', DB::raw('users.id')),
                'questions' => fn ($q) => $q->where('created_by', DB::raw('users.id')),
            ])
            ->orderByDesc('exams_count')
            ->get();

        // ── Recent activity logs ─────────────────────────────────────────────
        $recentLogs = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalQuestions',
            'totalExams',
            'examsThisWeek',
            'totalTeachers',
            'totalVisitors',
            'visitorsToday',
            'visitorsThisWeek',
            'mostVisitedPages',
            'teacherActivity',
            'recentLogs'
        ));
    }
}
