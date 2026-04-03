<x-app-layout>
    <x-slot name="header">
        {{ __('Banque de questions') }}
    </x-slot>

    <div class="space-y-6">

        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-premium-border/50 p-8 transition-colors">
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-600 p-3 rounded-2xl shadow-lg shadow-blue-600/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Banque de Questions</h3>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1">Gérez vos items d'évaluation</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    <a href="{{ route('questions.import.show') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-4 bg-white dark:bg-premium-bg border border-slate-200 dark:border-premium-border/50 rounded-2xl font-black text-xs text-slate-600 dark:text-slate-400 uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-premium-border transition-all shadow-sm active:scale-95">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        Importer
                    </a>
                    <a href="{{ route('questions.create') }}" class="flex-1 sm:flex-none bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/20 active:scale-95 text-center flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Ajouter une question
                    </a>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-slate-50/50 dark:bg-premium-bg/50 rounded-[2rem] p-6 mb-10 border border-slate-100 dark:border-premium-border/30">
                <form action="{{ route('questions.index') }}" method="GET" class="flex flex-col gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Bar -->
                        <div class="md:col-span-1 relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400 dark:text-slate-500 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." class="block w-full pl-11 pr-4 py-3 bg-white dark:bg-premium-bg border-slate-200 dark:border-premium-border/50 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500">
                        </div>

                        <!-- Subject Filter -->
                        <div>
                            <select name="category_id" onchange="this.form.submit()" class="block w-full py-3 px-4 bg-white dark:bg-premium-bg border-slate-200 dark:border-premium-border/50 rounded-xl text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all cursor-pointer">
                                <option value="">📚 Toutes les matières</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Level Filter -->
                        <div>
                            <select name="level" onchange="this.form.submit()" class="block w-full py-3 px-4 bg-white dark:bg-premium-bg border-slate-200 dark:border-premium-border/50 rounded-xl text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all cursor-pointer">
                                <option value="">🎓 Tous les niveaux</option>
                                <option value="Beginner" {{ request('level') == 'Beginner' ? 'selected' : '' }}>Débutant</option>
                                <option value="Intermediate" {{ request('level') == 'Intermediate' ? 'selected' : '' }}>Intermédiaire</option>
                                <option value="Advanced" {{ request('level') == 'Advanced' ? 'selected' : '' }}>Avancé</option>
                            </select>
                        </div>

                        <!-- Type Filter -->
                        <div>
                            <select name="type" onchange="this.form.submit()" class="block w-full py-3 px-4 bg-white dark:bg-premium-bg border-slate-200 dark:border-premium-border/50 rounded-xl text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all cursor-pointer">
                                <option value="">❓ Tous les types</option>
                                <option value="mcq" {{ request('type') == 'mcq' ? 'selected' : '' }}>QCM</option>
                                <option value="tf" {{ request('type') == 'tf' ? 'selected' : '' }}>Vrai / Faux</option>
                                <option value="open" {{ request('type') == 'open' ? 'selected' : '' }}>Question Ouverte</option>
                                <option value="consigne" {{ request('type') == 'consigne' ? 'selected' : '' }}>Consigne</option>
                            </select>
                        </div>
                    </div>
                    
                    @if(request()->anyFilled(['search', 'category_id', 'level', 'type']))
                        <div class="flex justify-end">
                            <a href="{{ route('questions.index') }}" class="text-[10px] font-black text-red-500 hover:text-red-700 uppercase tracking-widest flex items-center bg-red-50 dark:bg-red-500/10 px-4 py-2 rounded-lg transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Réinitialiser les filtres
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="overflow-hidden rounded-[2rem] border border-slate-100 dark:border-premium-border/50 shadow-sm transition-all hover:shadow-md">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-premium-bg/50">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-premium-border/30">Matière</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-premium-border/30">Niveau</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-premium-border/30">Type</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-premium-border/30">Question</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-premium-border/30 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-premium-border/20">
                        @forelse($questions as $question)
                        <tr class="bg-white dark:bg-premium-card hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-all group">
                            <td class="px-8 py-6">
                                <span class="text-sm font-black text-blue-600 dark:text-blue-400 uppercase tracking-tight">{{ $question->category->name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm {{ $question->level == 'Advanced' ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-500/20' : ($question->level == 'Intermediate' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 border border-orange-100 dark:border-orange-500/20' : 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20') }}">
                                    {{ $question->level }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                @if($question->type == 'mcq') <span class="bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-widest border border-indigo-100 dark:border-indigo-500/20">QCM</span>
                                @elseif($question->type == 'tf') <span class="bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-widest border border-amber-100 dark:border-amber-500/20">V/F</span>
                                @elseif($question->type == 'consigne') <span class="bg-slate-50 dark:bg-premium-bg text-slate-700 dark:text-slate-400 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-widest border border-slate-200 dark:border-premium-border/30">Consigne</span>
                                @else <span class="bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-widest border border-emerald-100 dark:border-emerald-500/20">Ouverte</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 max-w-md">
                                <div class="line-clamp-2 text-sm text-slate-600 dark:text-slate-400 font-medium italic group-hover:text-slate-900 dark:group-hover:text-slate-100 group-hover:not-italic transition-all">
                                    {!! strip_tags($question->content) !!}
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all transform translate-x-4 group-hover:translate-x-0">
                                     <a href="{{ route('questions.edit', $question) }}" class="p-3 bg-white dark:bg-premium-bg border border-slate-100 dark:border-premium-border/30 text-orange-500 rounded-xl hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-sm hover:shadow-orange-500/20 active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                     </a>
                                     <button @click.prevent="$dispatch('open-delete-modal', { url: '{{ route('questions.destroy', $question) }}', message: 'Supprimer cette question ?' })" class="p-3 bg-white dark:bg-premium-bg border border-slate-100 dark:border-premium-border/30 text-red-500 rounded-xl hover:bg-red-500 hover:text-white hover:border-red-500 transition-all shadow-sm hover:shadow-red-500/20 active:scale-90">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                     </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="p-6 bg-gray-50 rounded-full text-gray-200">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="font-black text-xl text-slate-300 dark:text-slate-700 uppercase tracking-[0.2em]">Aucune question trouvée</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest">Essayez de modifier vos filtres de recherche.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($questions->hasPages())
                <div class="mt-10 px-4">
                    {{ $questions->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
