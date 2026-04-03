<x-app-layout>
    <x-slot name="header">
        {{ __('Tableau de Bord Administrateur') }}
    </x-slot>

    {{-- ── Section title ────────────────────────────────────────────── --}}
    <div class="mb-10">
        <h2 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight uppercase">Statistiques Globales</h2>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Supervision de l'ensemble de la plateforme</p>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ROW 1 — Core Platform Stats
    ══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-10">

        {{-- Total Questions --}}
        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] p-6 sm:p-8 border border-slate-100 dark:border-premium-border/50 shadow-[0_8px_30px_rgb(0,0,0,0.02)] group hover:border-blue-500/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Total Questions</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/50 flex items-center justify-center text-slate-400 group-hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $totalQuestions }}</h3>
            <div class="flex items-center mt-2 text-[10px] font-bold text-emerald-500 uppercase tracking-widest">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                Banque active
            </div>
        </div>

        {{-- Total Exams --}}
        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] p-6 sm:p-8 border border-slate-100 dark:border-premium-border/50 shadow-[0_8px_30px_rgb(0,0,0,0.02)] group hover:border-orange-500/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Total Examens</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/50 flex items-center justify-center text-slate-400 group-hover:text-orange-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $totalExams }}</h3>
            <div class="flex items-center mt-2 text-[10px] font-bold text-orange-500 uppercase tracking-widest">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                Générés
            </div>
        </div>

        {{-- Exams this week --}}
        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] p-6 sm:p-8 border border-slate-100 dark:border-premium-border/50 shadow-[0_8px_30px_rgb(0,0,0,0.02)] group hover:border-green-500/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Cette Semaine</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/50 flex items-center justify-center text-slate-400 group-hover:text-green-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $examsThisWeek }}</h3>
            <div class="flex items-center mt-2 text-[10px] font-bold text-green-500 uppercase tracking-widest">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7 7 7M12 3v18"/></svg>
                Nouveaux
            </div>
        </div>

        {{-- Teachers --}}
        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] p-6 sm:p-8 border border-slate-100 dark:border-premium-border/50 shadow-[0_8px_30px_rgb(0,0,0,0.02)] group hover:border-purple-500/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Enseignants</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/50 flex items-center justify-center text-slate-400 group-hover:text-purple-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $totalTeachers }}</h3>
            <div class="flex items-center mt-2 text-[10px] font-bold text-purple-500 uppercase tracking-widest">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Inscrit(s)
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ROW 2 — Visitor Stats
    ══════════════════════════════════════════════════════════════ --}}
    <div class="mb-4">
        <h3 class="text-sm font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">
            <svg class="w-4 h-4 inline-block mr-1 -mt-0.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Suivi des Visiteurs
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        {{-- Total Visitors --}}
        <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-[2rem] p-6 sm:p-8 text-white shadow-lg shadow-cyan-500/20">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Visiteurs Uniques</p>
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <h3 class="text-5xl font-black tracking-tighter">{{ $totalVisitors }}</h3>
            <p class="text-[11px] font-bold uppercase tracking-widest opacity-70 mt-2">Total depuis le début</p>
        </div>

        {{-- Visitors Today --}}
        <div class="bg-gradient-to-br from-violet-500 to-purple-700 rounded-[2rem] p-6 sm:p-8 text-white shadow-lg shadow-violet-500/20">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Visiteurs Aujourd'hui</p>
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m8.66-13l-.87.5M4.21 17.5l-.87.5M20.66 17.5l-.87-.5M4.21 6.5l-.87-.5M21 12h-1M4 12H3m15.07-7.07l-.7.7M6.63 17.37l-.7.7M17.37 17.37l.7.7M6.63 6.63l.7.7"/></svg>
                </div>
            </div>
            <h3 class="text-5xl font-black tracking-tighter">{{ $visitorsToday }}</h3>
            <p class="text-[11px] font-bold uppercase tracking-widest opacity-70 mt-2">Aujourd'hui</p>
        </div>

        {{-- Visitors this week --}}
        <div class="bg-gradient-to-br from-emerald-500 to-teal-700 rounded-[2rem] p-6 sm:p-8 text-white shadow-lg shadow-emerald-500/20">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Cette Semaine</p>
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
            <h3 class="text-5xl font-black tracking-tighter">{{ $visitorsThisWeek }}</h3>
            <p class="text-[11px] font-bold uppercase tracking-widest opacity-70 mt-2">IPs uniques / 7 jours</p>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ROW 3 — Most Visited Pages + Teacher Activity
    ══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">

        {{-- Most Visited Pages --}}
        <div class="bg-white dark:bg-premium-card rounded-[2rem] border border-slate-100 dark:border-premium-border/50 p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
            <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest mb-6 flex items-center gap-2">
                <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                Pages les Plus Visitées
            </h3>
            @if($mostVisitedPages->isEmpty())
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest italic">Aucune visite enregistrée pour le moment.</p>
            @else
                @php $maxVisits = $mostVisitedPages->first()->visits ?: 1; @endphp
                <div class="space-y-4">
                    @foreach($mostVisitedPages as $i => $page)
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 truncate max-w-[75%]" title="{{ $page->page }}">
                                <span class="text-[10px] font-black text-slate-300 dark:text-slate-600 mr-2">#{{ $i+1 }}</span>{{ $page->page }}
                            </span>
                            <span class="text-xs font-black text-cyan-600 dark:text-cyan-400 shrink-0">{{ $page->visits }} visites</span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-premium-bg h-2 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-cyan-500 to-blue-600 h-full rounded-full transition-all duration-500"
                                 style="width: {{ round(($page->visits / $maxVisits) * 100) }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Teacher Activity --}}
        <div class="bg-white dark:bg-premium-card rounded-[2rem] border border-slate-100 dark:border-premium-border/50 p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
            <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest mb-6 flex items-center gap-2">
                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Activité des Enseignants
            </h3>
            @if($teacherActivity->isEmpty())
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest italic">Aucun enseignant inscrit.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-premium-border/30">
                                <th class="pb-3 font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Enseignant</th>
                                <th class="pb-3 font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest text-center">Examens</th>
                                <th class="pb-3 font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest text-center">Questions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-premium-border/20">
                            @foreach($teacherActivity as $teacher)
                            <tr class="hover:bg-slate-50 dark:hover:bg-premium-bg/50 transition-colors">
                                <td class="py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-black text-xs shrink-0">
                                            {{ substr($teacher->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-700 dark:text-slate-200">{{ $teacher->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">{{ $teacher->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-orange-100 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 font-black text-sm">
                                        {{ $teacher->exams_count }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-black text-sm">
                                        {{ $teacher->questions_count }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ROW 4 — Activity Logs
    ══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-premium-card rounded-[2.5rem] border border-slate-100 dark:border-premium-border/50 p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
        <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest mb-6 flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            Journal d'Activité Récente
        </h3>

        @if($recentLogs->isEmpty())
            <div class="text-center py-10">
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest italic">Aucune activité enregistrée pour le moment.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($recentLogs as $log)
                @php
                    $colors = [
                        'exam_created'    => ['bg' => 'bg-green-100 dark:bg-green-900/20',  'text' => 'text-green-600 dark:text-green-400',   'label' => 'Examen créé'],
                        'exam_deleted'    => ['bg' => 'bg-red-100 dark:bg-red-900/20',      'text' => 'text-red-600 dark:text-red-400',        'label' => 'Examen supprimé'],
                        'question_created'=> ['bg' => 'bg-blue-100 dark:bg-blue-900/20',    'text' => 'text-blue-600 dark:text-blue-400',      'label' => 'Question créée'],
                        'question_updated'=> ['bg' => 'bg-amber-100 dark:bg-amber-900/20',  'text' => 'text-amber-600 dark:text-amber-400',    'label' => 'Question modifiée'],
                        'question_deleted'=> ['bg' => 'bg-rose-100 dark:bg-rose-900/20',    'text' => 'text-rose-600 dark:text-rose-400',      'label' => 'Question supprimée'],
                    ];
                    $style = $colors[$log->action] ?? ['bg' => 'bg-slate-100 dark:bg-slate-800', 'text' => 'text-slate-500', 'label' => $log->action];
                @endphp
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-premium-bg/40 border border-slate-100 dark:border-premium-border/20 hover:border-slate-200 dark:hover:border-premium-border/40 transition-colors">
                    <span class="shrink-0 inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider {{ $style['bg'] }} {{ $style['text'] }}">
                        {{ $style['label'] }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-slate-700 dark:text-slate-200 truncate">{{ $log->description }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">
                            @if($log->user)
                                <span class="font-bold text-slate-500 dark:text-slate-400">{{ $log->user->name }}</span> •
                            @endif
                            {{ $log->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</x-app-layout>
