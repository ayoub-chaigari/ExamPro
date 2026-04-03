<!-- Mobile Backdrop -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm md:hidden" style="display: none;">
</div>

<aside class="w-64 bg-white dark:bg-premium-card border-r border-slate-100 dark:border-premium-border/50 flex flex-col fixed inset-y-0 z-50 transition-all duration-300 transform md:translate-x-0"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
    <div class="flex items-center px-8 h-24 border-b border-slate-50 dark:border-premium-border/30">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
            <div class="p-2 rounded-xl bg-blue-600 shadow-lg shadow-blue-600/20 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.183.394l-1.154.908a2.404 2.404 0 00-.147 3.564l1.756 1.756a3 3 0 004.244 0l11.072-11.072a3 3 0 000-4.244l-1.756-1.756a2.404 2.404 0 00-3.564.147l-.908 1.154a2 2 0 00-.394 1.183l.23 2.532a6 6 0 01-.517 3.86l-.158.318a6 6 0 00-.517 3.86l.477 2.387c.075.37.264.708.547 1.022L11 21"></path></svg>
            </div>
            <span class="text-xl font-black text-slate-800 dark:text-white tracking-tighter">Exam<span class="text-blue-600">Pro</span></span>
        </a>
    </div>

    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
        <div class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-4 mb-4">Menu Principal</div>
        
        @php
            $navItems = [
                ['route' => 'dashboard', 'label' => 'Analytique', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['route' => 'categories.index', 'label' => 'Matières', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                ['route' => 'questions.index', 'label' => 'Banque Q', 'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['route' => 'exams.index', 'label' => 'Générateur', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['route' => 'quizzes.index', 'label' => 'Quizzes', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
        @endphp

        @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs($item['route'].'*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-premium-bg hover:text-slate-900 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-4 transition-colors {{ request()->routeIs($item['route'].'*') ? 'text-white' : 'text-slate-400 dark:text-slate-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $item['icon'] }}"></path></svg>
                <span class="text-sm font-bold tracking-tight">{{ $item['label'] }}</span>
            </a>
        @endforeach

        @if(auth()->user()->role === 'admin')
        <div class="pt-8 mt-8 border-t border-slate-50 dark:border-premium-border/30">
            <div class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-4 mb-4">Administration</div>
            <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-premium-bg hover:text-slate-900 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-4 transition-colors {{ request()->routeIs('users.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="text-sm font-bold tracking-tight">Utilisateurs</span>
            </a>
        </div>
        @endif
    </nav>

    <!-- Bottom Sidebar Section -->
    <div class="p-6">
        <div class="bg-slate-50 dark:bg-premium-bg/50 rounded-2xl p-4 border border-slate-100 dark:border-premium-border/10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-black text-xs">
                    {{ substr(auth()->user()->role, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Rôle</p>
                    <p class="text-xs font-bold text-slate-800 dark:text-white truncate uppercase">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </div>
</aside>
