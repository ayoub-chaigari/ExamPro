<x-app-layout>
    <div class="space-y-10">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight mb-2">
                    {{ __('Gestion des Examens') }}
                </h2>
                <p class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Gérez vos évaluations et générez des variantes</p>
            </div>
            @if(Auth::user()->role === 'teacher')
            <a href="{{ route('exams.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-[10px] shadow-xl shadow-blue-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Nouvel Examen
            </a>
            @endif
        </div>


        <!-- Table Card -->
        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] shadow-xl shadow-blue-600/5 border border-slate-100 dark:border-premium-border/50 overflow-hidden transition-colors">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-premium-bg/50 border-b border-slate-100 dark:border-premium-border/30">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Examen / Module</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Filière</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Durée</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Auteur</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-premium-border/20">
                        @foreach($exams as $exam)
                        <tr class="group hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-premium-bg flex items-center justify-center mr-4 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <a href="{{ route('exams.show', $exam) }}" class="text-xs font-black text-slate-800 dark:text-slate-100 uppercase tracking-tight hover:text-blue-600 dark:hover:text-blue-400 transition-colors block mb-0.5">
                                            {{ $exam->title }}
                                        </a>
                                        <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ $exam->module_no ?? 'No Module' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-slate-100 dark:bg-premium-bg text-slate-500 dark:text-slate-400 rounded-lg text-[9px] font-black uppercase tracking-widest border border-slate-200/50 dark:border-premium-border/30">
                                    {{ $exam->category->name ?? 'Général' }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-tighter">
                                    <svg class="w-3.5 h-3.5 mr-2 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $exam->duration }} Min
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ $exam->creator->name ?? 'Système' }}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('exams.show', $exam) }}" class="p-2.5 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm active:scale-90" title="Gérer l'examen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    @if(Auth::user()->role === 'teacher')
                                    <a href="{{ route('exams.edit', $exam) }}" class="p-2.5 bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 rounded-xl hover:bg-orange-600 dark:hover:bg-orange-500 hover:text-white transition-all shadow-sm active:scale-90" title="Modifier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                        <button @click.prevent="$dispatch('open-delete-modal', { url: '{{ route('exams.destroy', $exam) }}', message: 'Supprimer cet examen ?' })" class="p-2.5 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 rounded-xl hover:bg-red-600 dark:hover:bg-red-500 hover:text-white transition-all shadow-sm active:scale-90" title="Supprimer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($exams->hasPages())
            <div class="px-8 py-6 border-t border-slate-50 dark:border-premium-border/20 bg-slate-50/50 dark:bg-premium-bg/50">
                {{ $exams->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
