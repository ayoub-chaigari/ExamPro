<x-app-layout>
    <div x-data="{ tab: 'profile' }" class="max-w-7xl mx-auto py-10 px-4 sm:px-8">
        
        <div class="flex flex-col md:flex-row gap-8 lg:gap-12">
            <!-- Left Sidebar Menu -->
            <div class="w-full md:w-64 flex-shrink-0">
                <h1 class="text-2xl lg:text-3xl font-black text-slate-800 dark:text-white mb-8 tracking-tight transition-colors">Paramètres du compte</h1>
                
                <nav class="space-y-2">
                    <button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-blue-50 dark:bg-blue-600/10 text-blue-600 dark:text-blue-400 font-bold shadow-sm' : 'text-slate-500 dark:text-slate-400 font-medium hover:bg-slate-50 dark:hover:bg-premium-bg hover:text-slate-800 dark:hover:text-white'" class="w-full flex items-center px-5 py-3.5 text-sm rounded-2xl transition-all text-left">
                        Mon Profil
                    </button>
                    <button @click="tab = 'security'" :class="tab === 'security' ? 'bg-blue-50 dark:bg-blue-600/10 text-blue-600 dark:text-blue-400 font-bold shadow-sm' : 'text-slate-500 dark:text-slate-400 font-medium hover:bg-slate-50 dark:hover:bg-premium-bg hover:text-slate-800 dark:hover:text-white'" class="w-full flex items-center px-5 py-3.5 text-sm rounded-2xl transition-all text-left">
                        Sécurité
                    </button>
                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-premium-border/30"></div>
                    <button @click="tab = 'delete'" :class="tab === 'delete' ? 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 font-bold shadow-sm' : 'text-red-400 font-medium hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-600'" class="w-full flex items-center px-5 py-3.5 text-sm rounded-2xl transition-all text-left">
                        Supprimer le compte
                    </button>
                </nav>
            </div>

            <!-- Right Content Area -->
            <div class="flex-1 mt-2">
                <!-- Profile Tab -->
                 <div x-show="tab === 'profile'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
                    
                    <!-- Header Card -->
                    <div class="bg-white dark:bg-premium-card rounded-[2rem] p-8 border border-slate-100/50 dark:border-premium-border/30 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-none transition-colors">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-black text-slate-800 dark:text-slate-100">Mon Profil</h2>
                            <button class="px-5 py-2.5 rounded-xl border-2 border-slate-100 dark:border-premium-border/50 text-slate-600 dark:text-slate-400 font-bold text-sm hover:bg-slate-50 dark:hover:bg-premium-bg hover:border-slate-200 dark:hover:border-premium-border transition-all flex items-center gap-1.5 focus:outline-none">
                                Éditer <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        </div>
                         <div class="mt-8 flex items-center gap-6 border-t border-slate-50 dark:border-premium-border/20 pt-8">
                            <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-blue-600 to-blue-400 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-blue-600/20 ring-4 ring-slate-50 dark:ring-premium-bg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-800 dark:text-white tracking-tight">{{ Auth::user()->name }}</h3>
                                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 mt-0.5">Enseignant</p>
                                <p class="text-xs font-semibold text-slate-400 dark:text-slate-500 mt-2 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    OFPPT, Maroc
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Form Card -->
                    <div class="bg-white dark:bg-premium-card rounded-[2rem] p-8 border border-slate-100/50 dark:border-premium-border/30 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-none transition-colors">
                        <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-50 dark:border-premium-border/20">
                            <h2 class="text-lg font-black text-slate-800 dark:text-slate-100">Informations Personnelles</h2>
                            <button class="px-5 py-2.5 rounded-xl border-2 border-slate-100 dark:border-premium-border/50 text-slate-600 dark:text-slate-400 font-bold text-sm hover:bg-slate-50 dark:hover:bg-premium-bg hover:border-slate-200 dark:hover:border-premium-border transition-all flex items-center gap-1.5 focus:outline-none">
                                Éditer <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        </div>
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div x-cloak x-show="tab === 'security'" class="space-y-8" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-white dark:bg-premium-card rounded-[2rem] p-8 border border-slate-100/50 dark:border-premium-border/30 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-none transition-colors">
                        <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-50 dark:border-premium-border/20">
                            <h2 class="text-lg font-black text-slate-800 dark:text-slate-100">Mot de passe & Sécurité</h2>
                            <button class="px-5 py-2.5 rounded-xl border-2 border-slate-100 dark:border-premium-border/50 text-slate-600 dark:text-slate-400 font-bold text-sm hover:bg-slate-50 dark:hover:bg-premium-bg hover:border-slate-200 dark:hover:border-premium-border transition-all flex items-center gap-1.5 focus:outline-none">
                                Éditer <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        </div>
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <!-- Delete Tab -->
                <div x-cloak x-show="tab === 'delete'" class="space-y-8" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-white dark:bg-premium-card rounded-[2rem] p-8 border border-red-50 dark:border-red-500/20 shadow-[0_8px_30px_rgb(239,68,68,0.06)] dark:shadow-none transition-colors">
                        <div class="flex items-center justify-between mb-8 pb-6 border-b border-red-50 dark:border-red-500/30">
                            <h2 class="text-lg font-black text-red-600 dark:text-red-400">Zone de danger</h2>
                        </div>
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
