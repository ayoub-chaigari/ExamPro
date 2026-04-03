<x-app-layout>
    <div class="space-y-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight mb-2">
                    {{ __('Filières & Niveaux') }}
                </h2>
                <p class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Gérez les structures de vos évaluations</p>
            </div>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-[10px] shadow-xl shadow-blue-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Nouveau
            </a>
        </div>


        <!-- Table Card -->
        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] shadow-xl shadow-blue-600/5 border border-slate-100 dark:border-premium-border/50 overflow-hidden max-w-4xl transition-colors">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-premium-bg/50 border-b border-slate-100 dark:border-premium-border/30">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Intitulé</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Type de catégorie</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-premium-border/20">
                        @foreach($categories as $category)
                        <tr class="group hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors">
                            <td class="px-8 py-6">
                                <span class="text-xs font-black text-slate-800 dark:text-slate-100 uppercase tracking-tight">{{ $category->name }}</span>
                            </td>
                            <td class="px-8 py-6">
                                @if($category->type == 'subject')
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg text-[9px] font-black uppercase tracking-widest border border-blue-200/50 dark:border-blue-500/20">Matière</span>
                                @else
                                    <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-200/50 dark:border-emerald-500/20">Niveau</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('categories.edit', $category) }}" class="p-2.5 bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 rounded-xl hover:bg-orange-600 dark:hover:bg-orange-500 hover:text-white transition-all shadow-sm active:scale-90" title="Modifier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <button @click.prevent="$dispatch('open-delete-modal', { url: '{{ route('categories.destroy', $category) }}', message: 'Supprimer cette catégorie ?' })" class="p-2.5 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 rounded-xl hover:bg-red-600 dark:hover:bg-red-500 hover:text-white transition-all shadow-sm active:scale-90" title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($categories->hasPages())
            <div class="px-8 py-6 border-t border-slate-50 dark:border-premium-border/20 bg-slate-50/50 dark:bg-premium-bg/50">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
