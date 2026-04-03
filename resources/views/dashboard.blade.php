<x-app-layout>
    <x-slot name="header">
        {{ __('Tableau de bord') }}
    </x-slot>

    @php
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';

        $totalExams = $isAdmin
            ? \App\Models\Exam::count()
            : \App\Models\Exam::where('created_by', $user->id)->count();

        $totalQuestions = $isAdmin
            ? \App\Models\Question::count()
            : \App\Models\Question::where('created_by', $user->id)->count();

        $totalCategories = \App\Models\Category::count();
        $totalUsers = \App\Models\User::count();
        $totalQuizzes = $isAdmin ? \App\Models\Quiz::count() : \App\Models\Quiz::where('teacher_id', $user->id)->count();
    @endphp

    <div class="mb-10">
        <h2 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight uppercase">Analytique</h2>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Vue d'ensemble de votre plateforme</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-12">
        <!-- Stat Card 1: Examens -->
        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] p-8 border border-slate-100 dark:border-premium-border/50 shadow-[0_8px_30px_rgb(0,0,0,0.02)] dark:shadow-none group hover:border-blue-500/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ $isAdmin ? 'Total Examens' : 'Mes Examens' }}</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/50 flex items-center justify-center text-slate-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $totalExams }}</h3>
                    <div class="flex items-center mt-2 text-[10px] font-bold text-emerald-500 uppercase tracking-widest">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7 7 7M12 3v18"></path></svg>
                        Actifs
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 2: Questions -->
        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] p-8 border border-slate-100 dark:border-premium-border/50 shadow-[0_8px_30px_rgb(0,0,0,0.02)] dark:shadow-none group hover:border-green-500/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ $isAdmin ? 'Banque Questions' : 'Mes Questions' }}</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/50 flex items-center justify-center text-slate-400 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $totalQuestions }}</h3>
                    <div class="flex items-center mt-2 text-[10px] font-bold text-blue-500 uppercase tracking-widest">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Items
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 3: Quizzes -->
        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] p-8 border border-slate-100 dark:border-premium-border/50 shadow-[0_8px_30px_rgb(0,0,0,0.02)] dark:shadow-none group hover:border-purple-500/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Total Quizzes</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/50 flex items-center justify-center text-slate-400 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $totalQuizzes }}</h3>
                    <div class="flex items-center mt-2 text-[10px] font-bold text-purple-500 uppercase tracking-widest">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        En ligne
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 4: Utilisateurs/Matières -->
        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] p-8 border border-slate-100 dark:border-premium-border/50 shadow-[0_8px_30px_rgb(0,0,0,0.02)] dark:shadow-none group hover:border-orange-500/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">{{ $isAdmin ? 'Utilisateurs' : 'Matières' }}</p>
                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/50 flex items-center justify-center text-slate-400 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                    @if($isAdmin)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    @endif
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tighter">{{ $isAdmin ? $totalUsers : $totalCategories }}</h3>
                    <div class="flex items-center mt-2 text-[10px] font-bold text-orange-500 uppercase tracking-widest">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Inscrits
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Widget -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white dark:bg-premium-card rounded-[2.5rem] border border-slate-100 dark:border-premium-border/50 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)] dark:shadow-none">
            <h3 class="text-lg font-black text-slate-800 dark:text-white uppercase tracking-tight mb-8">Actions Rapides</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('exams.create') }}" class="group flex items-center p-4 bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/20 rounded-2xl hover:bg-blue-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-white dark:bg-premium-card flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover:text-white transition-colors">Nouvel Examen</h4>
                        <p class="text-[10px] font-bold text-slate-400 group-hover:text-blue-100 transition-colors uppercase tracking-widest mt-0.5">Créer un contrôle</p>
                    </div>
                </a>
                
                <a href="{{ route('questions.create') }}" class="group flex items-center p-4 bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/20 rounded-2xl hover:bg-green-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-white dark:bg-premium-card flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover:text-white transition-colors">Ajouter Question</h4>
                        <p class="text-[10px] font-bold text-slate-400 group-hover:text-green-100 transition-colors uppercase tracking-widest mt-0.5">Enrichir la banque</p>
                    </div>
                </a>

                <a href="{{ route('quizzes.create') }}" class="group flex items-center p-4 bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/20 rounded-2xl hover:bg-purple-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-white dark:bg-premium-card flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover:text-white transition-colors">Lancer un Quiz</h4>
                        <p class="text-[10px] font-bold text-slate-400 group-hover:text-purple-100 transition-colors uppercase tracking-widest mt-0.5">Évaluation en ligne</p>
                    </div>
                </a>

                <a href="{{ route('categories.index') }}" class="group flex items-center p-4 bg-slate-50 dark:bg-premium-bg border border-slate-100 dark:border-premium-border/20 rounded-2xl hover:bg-orange-600 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-white dark:bg-premium-card flex items-center justify-center text-orange-600 group-hover:scale-110 transition-transform shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-black text-slate-800 dark:text-white group-hover:text-white transition-colors">Mes Matières</h4>
                        <p class="text-[10px] font-bold text-slate-400 group-hover:text-orange-100 transition-colors uppercase tracking-widest mt-0.5">Gérer les catégories</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Help Widget -->
        <div class="bg-blue-600 rounded-[2.5rem] p-8 text-white relative overflow-hidden group shadow-xl shadow-blue-600/20">
            <div class="relative z-10">
                <h3 class="text-xl font-black uppercase tracking-tight mb-2">Besoin d'aide ?</h3>
                <p class="text-sm font-bold text-blue-100 mb-8 opacity-80 leading-relaxed">Consultez notre documentation ou contactez le support pour toute question.</p>
                <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-50 transition-colors shadow-lg">Documentation</a>
            </div>
            <!-- Animated background shapes -->
            <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="absolute -left-8 -top-8 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
        </div>
    </div>
</x-app-layout>
