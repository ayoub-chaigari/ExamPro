<x-app-layout>
    <x-slot name="header">
        {{ __('Gestion des Quizzes') }}
    </x-slot>

<div class="py-12 bg-slate-50 dark:bg-premium-bg min-h-screen transition-colors">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Mes Quizzes</h1>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">Gérez vos évaluations et consultez les résultats.</p>
            </div>
            <a href="{{ route('quizzes.create') }}" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 hover:-translate-y-0.5 transition-all shadow-lg shadow-blue-600/30 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Nouveau Quiz
            </a>
        </div>


        <div class="bg-white dark:bg-premium-card overflow-hidden shadow-2xl shadow-slate-200/50 dark:shadow-none sm:rounded-[2rem] border border-slate-100 dark:border-premium-border/50 transition-colors">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 dark:bg-premium-bg/50 border-b border-slate-100 dark:border-premium-border/30">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none">Titre</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none">Code</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none">Durée</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none">Questions</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-premium-border/20">
                        @forelse($quizzes as $quiz)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-blue-900/10 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="text-sm font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 transition-colors">{{ $quiz->title }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 font-medium flex items-center gap-1 mt-1">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $quiz->created_at->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex py-1 px-3 rounded-lg bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-500/20 text-sm font-mono font-black text-blue-700 dark:text-blue-400 tracking-wider">
                                        {{ $quiz->code }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2 text-sm font-bold text-slate-600 dark:text-slate-300">
                                        <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-premium-bg flex items-center justify-center text-slate-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        {{ $quiz->duration }} <span class="text-slate-400 font-medium">min</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2 text-sm font-bold text-slate-600 dark:text-slate-300">
                                        <div class="w-6 h-6 rounded-full bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        {{ $quiz->questions->count() }} <span class="text-slate-400 font-medium">Q</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('quizzes.teacher_results', $quiz) }}" class="inline-flex items-center justify-center w-9 h-9 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white rounded-xl transition-colors tooltip relative" title="Résultats">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        </a>
                                        <button @click.prevent="$dispatch('open-delete-modal', { url: '{{ route('quizzes.destroy', $quiz) }}', message: 'Supprimer ce quiz ?' })" class="inline-flex items-center justify-center w-9 h-9 bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-slate-50 dark:bg-premium-bg text-slate-300 dark:text-slate-700 mb-6 shadow-sm border border-slate-100 dark:border-premium-border/30">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Aucun Quiz Actuellement</h3>
                                    <p class="text-slate-500 dark:text-slate-400 font-medium mb-6">Commencez par créer votre premier quiz pour évaluer vos étudiants.</p>
                                    <a href="{{ route('quizzes.create') }}" class="inline-flex items-center gap-2 px-6 py-3 border-2 border-slate-200 dark:border-premium-border text-slate-700 dark:text-slate-300 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-premium-bg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Créer mon premier quiz
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
