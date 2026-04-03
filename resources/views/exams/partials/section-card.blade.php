<div class="bg-white dark:bg-premium-card rounded-[2rem] shadow-sm border border-slate-100 dark:border-premium-border/50 overflow-hidden section-card group/section transition-all duration-500 hover:shadow-xl hover:shadow-blue-600/5 mb-10" id="section_wrapper_{{$section->id}}">
    <!-- Section Header -->
    <div class="bg-slate-50 dark:bg-premium-bg border-b border-slate-100 dark:border-premium-border/30 px-8 py-5 flex justify-between items-center relative overflow-hidden transition-colors">
        <div class="flex-1 mr-6 relative z-10">
            <div class="flex items-center space-x-4">
                <div class="flex items-center group/title cursor-pointer" onclick="toggleEditSection({{$section->id}})" id="section_title_display_{{$section->id}}">
                    <h4 class="text-sm font-black text-slate-800 dark:text-slate-100 uppercase tracking-widest group-hover/title:text-blue-600 dark:group-hover/title:text-blue-400 transition-colors duration-300">
                        {{ $section->title }}
                    </h4>
                    <svg class="w-3 h-3 text-slate-300 dark:text-slate-600 ml-2 group-hover/title:text-blue-600 dark:group-hover/title:text-blue-400 opacity-0 group-hover/title:opacity-100 transition-all font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>

                <div id="section_edit_form_{{$section->id}}" class="hidden flex items-center space-x-2 flex-1 max-w-lg">
                    <input type="text" value="{{ $section->title }}" id="input_title_{{$section->id}}" class="bg-white dark:bg-premium-bg border-slate-200 dark:border-premium-border/50 text-slate-800 dark:text-slate-100 rounded-xl px-4 py-2 text-xs font-black w-full focus:ring-blue-600 focus:border-blue-600 placeholder-slate-300 dark:placeholder-slate-600 transition-colors" placeholder="Titre de la section...">
                    <button onclick="saveSectionTitle({{$section->id}})" class="p-2 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition shadow-lg shadow-emerald-500/20 active:scale-90 flex-shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                    <button onclick="toggleEditSection({{$section->id}})" class="p-2 bg-red-500 text-white rounded-xl hover:bg-red-600 transition shadow-lg shadow-red-500/20 active:scale-90 flex-shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="px-3 py-1 bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-500/20 rounded-lg flex items-center space-x-2 transition-colors">
                    <span class="text-[9px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest" id="section_points_{{$section->id}}">
                        {{ $section->total_points }} PTS
                    </span>
                </div>
            </div>
            @if($section->description)
                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1 font-bold uppercase tracking-tight">{{ $section->description }}</p>
            @endif
        </div>

        <div class="flex items-center space-x-3 relative z-10">
            @if(Auth::user()->role === 'teacher')
            <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-black text-[10px] transition-all uppercase tracking-widest flex items-center group/btn active:scale-95 shadow-lg shadow-blue-600/10" onclick="openQuestionModal({{$section->id}})">
                <svg class="w-3.5 h-3.5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Ajouter
            </button>
            <button type="button" class="text-gray-300 hover:text-red-500 transition-colors p-2.5 rounded-xl hover:bg-red-50 active:scale-90" onclick="deleteSection({{$section->id}})" title="Supprimer la section">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
            @endif
        </div>
    </div>
    
    <!-- Section Content -->
    <div class="p-8 space-y-8">
        <div id="section_questions_{{$section->id}}" class="space-y-6">
            @php
                $topQuestions = $section->questions->whereNull('parent_id')->sortBy('order');
            @endphp
             @forelse($topQuestions as $qIndex => $question)
                @include('questions.partials.question-card', ['question' => $question, 'index' => $qIndex + 1, 'section_id' => $section->id])
            @empty
                <div id="empty_msg_{{$section->id}}" class="py-12 text-center group/empty">
                    <div class="inline-flex p-6 bg-slate-50 dark:bg-premium-bg rounded-full text-slate-200 dark:text-slate-700 group-hover/empty:bg-blue-50 dark:group-hover/empty:bg-blue-900/10 group-hover/empty:text-blue-200 dark:group-hover/empty:text-blue-800 transition-all duration-500 mb-4 font-black">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest">Aucune question</p>
                </div>
            @endforelse
        </div>

        @if(Auth::user()->role === 'teacher')
         <!-- Bank Import -->
        <div class="mt-10 pt-10 border-t border-slate-50 dark:border-premium-border/20 transition-colors">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3 shadow-lg shadow-blue-600/10">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h5 class="text-[11px] font-black text-slate-800 dark:text-slate-100 uppercase tracking-widest">Bibliothèque de Questions</h5>
                        <p class="text-[9px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-tight">Importer depuis votre banque personnelle</p>
                    </div>
                </div>
            </div>
                         <form onsubmit="addQuestionsFromBank(event, {{ $section->id }}, {{ $exam->id }})" class="space-y-4">
                @csrf
                <div class="max-h-60 overflow-y-auto custom-scrollbar border border-slate-100 dark:border-premium-border/50 rounded-2xl bg-slate-50/50 dark:bg-premium-bg/50 p-4 space-y-2 transition-colors">
                    @forelse($availableQuestions as $q)
                        <label class="flex items-center p-4 bg-white dark:bg-premium-card rounded-xl border border-slate-100 dark:border-premium-border/50 hover:border-blue-600 transition-all cursor-pointer group shadow-sm">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="questions[]" value="{{ $q->id }}" class="peer h-4 w-4 rounded border-slate-300 dark:border-premium-border/50 bg-white dark:bg-premium-bg text-blue-600 focus:ring-0 focus:ring-offset-0 transition-all cursor-pointer quest-check-{{ $section->id }}">
                                <div class="absolute inset-0 bg-blue-600 rounded scale-0 peer-checked:scale-100 transition-transform duration-200 pointer-events-none flex items-center justify-center">
                                    <svg class="h-2.5 w-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest {{ $q->type === 'consigne' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 border border-orange-100 dark:border-orange-500/20' : 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20' }}">
                                        {{ $q->type }}
                                    </span>
                                    <span class="text-[9px] font-black text-slate-400 dark:text-slate-600 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $q->points }} PTS</span>
                                </div>
                                <p class="text-[11px] font-bold text-slate-600 dark:text-slate-400 line-clamp-1 group-hover:text-slate-900 dark:group-hover:text-slate-100 transition-colors uppercase tracking-tight">{{ strip_tags($q->content) }}</p>
                            </div>
                        </label>

                    @empty
                        <div class="py-10 text-center">
                            <p class="text-[9px] font-black text-slate-300 dark:text-slate-700 uppercase tracking-widest italic">Aucune question disponible</p>
                        </div>
                    @endforelse
                </div>
                
                @if(count($availableQuestions) > 0)
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-600/10 active:scale-95 transition-all flex items-center justify-center space-x-3 btn-import-{{$section->id}} group/btnimp">
                        <span>Importer la sélection</span>
                        <svg class="w-4 h-4 group-hover/btnimp:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>
                @endif
            </form>
        </div>
        @endif
    </div>
</div>

</div>v>
</div>
