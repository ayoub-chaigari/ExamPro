<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 dark:bg-[#151521] text-slate-900 dark:text-slate-200 flex min-h-screen selection:bg-blue-200 selection:text-blue-900" 
          x-data="{ showDeleteModal: false, deleteUrl: '', deleteMessage: '', sidebarOpen: false }" 
          @open-delete-modal.window="showDeleteModal = true; deleteUrl = $event.detail.url; deleteMessage = $event.detail.message || 'Voulez-vous vraiment supprimer cet élément ?'">
        
        <!-- Global Delete Confirmation Modal -->
        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center">
            <!-- Backdrop -->
            <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showDeleteModal = false"></div>
            
            <!-- Modal Content -->
            <div x-show="showDeleteModal" 
                 x-transition:enter="transition ease-out duration-300 transform" 
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                 x-transition:leave="transition ease-in duration-200 transform" 
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-8 scale-95" 
                 class="relative bg-white dark:bg-premium-card rounded-3xl shadow-2xl p-8 pt-10 max-w-[22rem] w-full mx-4 text-center border border-slate-100/10 transition-colors">
                
                <!-- Close Button -->
                <button @click="showDeleteModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Illustrated Trash Bin -->
                <div class="mb-6 flex justify-center">
                    <div class="relative w-32 h-24 flex items-center justify-center">
                        <!-- Cloud Shapes Background -->
                        <div class="absolute -left-2 top-4 w-12 h-8 bg-teal-100/60 rounded-full blur-[2px]"></div>
                        <div class="absolute -right-4 bottom-2 w-16 h-10 bg-teal-100/60 rounded-full blur-[2px]"></div>
                        <!-- White clouds -->
                        <div class="absolute left-0 bottom-3 w-10 h-6 bg-white border-2 border-slate-700 rounded-full z-10"></div>
                        <div class="absolute right-0 top-6 w-8 h-8 bg-white border-2 border-slate-700 rounded-full px-2 z-0 flex rounded-b-none items-end"></div>
                        <div class="absolute right-2 top-4 w-10 h-6 bg-white border-2 border-slate-700 rounded-full -z-10"></div>
                        
                        <!-- Purple Trash Icon -->
                        <div class="relative z-20 bg-[#978FF1] border-2 border-slate-800 rounded-b-lg w-14 h-16 flex flex-col justify-end pb-1 shadow-[2px_2px_0_rgba(0,0,0,0.1)]">
                            <!-- Lid -->
                            <div class="absolute -top-3 -left-2 w-[4.5rem] h-3 bg-[#978FF1] border-2 border-slate-800 rounded-md shadow-[1px_2px_0_rgba(0,0,0,0.1)]">
                                <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 w-4 h-2 border-2 border-b-0 border-slate-800 rounded-t-sm"></div>
                            </div>
                            <!-- Lines -->
                            <div class="flex justify-evenly w-full px-1">
                                <div class="w-1 h-9 bg-slate-800/20 rounded-full"></div>
                                <div class="w-1 h-9 bg-slate-800/20 rounded-full"></div>
                                <div class="w-1 h-9 bg-slate-800/20 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2 leading-tight" x-text="deleteMessage"></h3>
                <p class="text-xs font-semibold text-slate-400 mb-8 max-w-[16rem] mx-auto">Vous ne pourrez pas récupérer ces données par la suite.</p>

                <form :action="deleteUrl" method="POST" class="flex flex-col gap-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3.5 px-4 bg-transparent border-[1.5px] border-indigo-600 text-indigo-700 dark:text-indigo-400 font-bold rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:shadow-lg hover:shadow-indigo-600/10 transition-all font-sans">
                        Oui, supprimer
                    </button>
                    <button type="button" @click="showDeleteModal = false" class="w-full py-3.5 px-4 bg-transparent text-indigo-700 dark:text-indigo-400 font-bold rounded-full hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10 transition-all font-sans">
                        Annuler
                    </button>
                </form>
            </div>
        </div>

        
        <!-- Global Toast Notifications -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-10"
                  class="fixed top-24 right-8 z-50 bg-white dark:bg-premium-card border border-emerald-100 dark:border-emerald-500/20 shadow-xl shadow-emerald-600/10 rounded-2xl p-4 flex items-start gap-4 max-w-sm transition-colors">
                 <div class="p-2 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-800 dark:text-slate-100 uppercase tracking-tight">Succès</h4>
                     <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mt-1">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-slate-400 hover:text-slate-600 transition-colors ml-auto"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-10"
                  class="fixed top-24 right-8 z-50 bg-white dark:bg-premium-card border border-red-100 dark:border-red-500/20 shadow-xl shadow-red-600/10 rounded-2xl p-4 flex items-start gap-4 max-w-sm transition-colors">
                 <div class="p-2 rounded-xl bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h4 class="text-sm font-black text-slate-800 dark:text-slate-100 uppercase tracking-tight">Erreur</h4>
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mt-1">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-slate-400 hover:text-slate-600 transition-colors ml-auto"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif


        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 md:ml-64 transition-all duration-300">
            <!-- Top Navbar -->
            @include('layouts.navigation')

            <!-- Page Heading -->
             @isset($header)
                <header class="bg-white dark:bg-premium-card border-b border-slate-100/50 dark:border-premium-border/30 shadow-sm transition-all duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-8">
                        <div class="flex items-center">
                            <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight tracking-tight">
                                {{ $header }}
                            </h2>
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 p-6">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
