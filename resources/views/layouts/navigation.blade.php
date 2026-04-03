<nav class="bg-slate-50 dark:bg-premium-bg border-b border-transparent dark:border-premium-border/30 h-[5.5rem] w-full sticky top-0 z-40 px-4 sm:px-8 flex items-center justify-between transition-colors">
    <!-- Left: Mobile Menu Button & Logo -->
    <div class="flex items-center md:hidden">
        <button @click="sidebarOpen = ! sidebarOpen" class="inline-flex items-center justify-center p-2.5 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-white dark:hover:bg-premium-card shadow-sm border border-slate-200/50 dark:border-premium-border/50 focus:outline-none transition-all">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': sidebarOpen, 'inline-flex': ! sidebarOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Mobile Logo -->
        <a href="{{ route('dashboard') }}" class="ml-4 flex items-center md:hidden group">
            <span class="text-xl font-black text-slate-800 dark:text-white tracking-tighter">Exam<span class="text-blue-600">Pro</span></span>
        </a>
    </div>
    <div class="hidden md:block w-1/4"></div> <!-- Spacer for flex distribution on desktop -->

    <!-- Center: Search Bar (Global for relevant sections) -->
    <div class="hidden md:flex flex-1 justify-center max-w-lg w-full">
        @if(request()->routeIs('users.*') || request()->routeIs('questions.*') || request()->routeIs('exams.*') || request()->routeIs('quizzes.*'))
        <form action="{{ url()->current() }}" method="GET" class="relative w-[28rem]">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            @php
                $placeholder = "Rechercher...";
                if(request()->routeIs('users.*')) $placeholder = "Rechercher un utilisateur...";
                elseif(request()->routeIs('questions.*')) $placeholder = "Rechercher une question...";
                elseif(request()->routeIs('exams.*')) $placeholder = "Rechercher un examen...";
                elseif(request()->routeIs('quizzes.*')) $placeholder = "Rechercher un quiz...";
            @endphp
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $placeholder }}" class="w-full pl-12 pr-4 py-3 bg-white dark:bg-slate-800 border-0 text-slate-700 dark:text-slate-200 text-sm font-medium rounded-[1.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.4)] focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900/60 placeholder-slate-400 dark:placeholder-slate-500 transition-all outline-none">
        </form>
        @endif
    </div>

    <!-- Right: Actions & Profile -->
    <div class="flex items-center justify-end w-1/4 space-x-4 sm:space-x-6">
        
        <!-- Notifications -->
        <div class="relative hidden sm:block" x-data="{ openNotifications: false }">
            <button @click="openNotifications = !openNotifications" @click.outside="openNotifications = false" class="relative w-11 h-11 flex items-center justify-center rounded-full bg-white dark:bg-premium-card text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-none transition-all hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-3 right-3 w-2 h-2 bg-orange-500 rounded-full border border-white dark:border-premium-card"></span>
            </button>
            <div x-show="openNotifications" style="display: none;" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="absolute right-0 mt-3 w-64 bg-white dark:bg-premium-card rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-premium-border py-4 px-4 z-50">
                 <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3 border-b border-slate-50 pb-2">Notifications</h3>
                 <div class="text-sm font-medium text-slate-500 py-3 text-center">Aucune nouvelle notification</div>
            </div>
        </div>

        <!-- Theme Toggle -->
        <div class="hidden sm:flex items-center bg-white dark:bg-premium-card rounded-full p-1 shadow-[0_8px_30px_rgb(0,0,0,0.05)] dark:shadow-none border dark:border-premium-border/50">
            <button @click="darkMode = false" :class="{'bg-blue-600 text-white shadow-sm': !darkMode, 'text-slate-400 hover:text-slate-600': darkMode}" class="w-9 h-9 flex items-center justify-center rounded-full transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </button>
            <button @click="darkMode = true" :class="{'bg-blue-600 text-white shadow-sm': darkMode, 'text-slate-400 hover:text-slate-600': !darkMode}" class="w-9 h-9 flex items-center justify-center rounded-full transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>

        <!-- User Profile Dropdown -->
        <div class="flex items-center">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center space-x-3 bg-transparent focus:outline-none transition group">
                        <div class="w-11 h-11 rounded-[1rem] bg-gradient-to-tr from-blue-600 to-blue-400 flex items-center justify-center text-white text-sm font-black shadow-md shadow-blue-600/20 overflow-hidden ring-2 ring-white dark:ring-premium-card">
                            <!-- Show initals if no avatar, otherwise image -->
                            @if(Auth::user()->avatar ?? false)
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <svg class="hidden md:block w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-4 py-3 border-b border-slate-50 dark:border-premium-border/30 bg-slate-50/50 dark:bg-premium-bg/50">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Connecté en tant que</p>
                        <p class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    </div>

                    <x-dropdown-link :href="route('profile.edit')" class="font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-premium-bg hover:text-blue-600 dark:hover:text-blue-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('Mon Profil') }}
                        </div>
                    </x-dropdown-link>

                    <!-- Theme Toggle in Dropdown (requested as 'Sombre') -->
                    <button @click="darkMode = !darkMode" class="w-full text-left px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-premium-bg hover:text-blue-600 dark:hover:text-blue-400 flex items-center gap-2 transition-colors">
                        <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="darkMode" class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span x-text="darkMode ? 'Mode Clair' : 'Mode Sombre'"></span>
                    </button>

                    <div class="h-px bg-slate-100 dark:bg-premium-border/30 my-1 mx-2"></div>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                class="font-bold text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-700"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                {{ __('Se déconnecter') }}
                            </div>
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>
