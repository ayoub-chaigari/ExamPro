<div class="group/question relative p-6 bg-white dark:bg-premium-bg/50 rounded-2xl border border-slate-100 dark:border-premium-border/30 shadow-sm transition-all duration-300 hover:shadow-lg hover:shadow-blue-600/5 hover:border-blue-600/20 dark:hover:border-blue-600/30 question-item" id="question_{{ $question->id }}" data-id="{{ $question->id }}">
    <!-- Drag Handle (Teacher Only) -->
    @if(Auth::user()->role === 'teacher' && isset($section_id))
    <div class="absolute -left-3 top-1/2 -translate-y-1/2 opacity-0 group-hover/question:opacity-100 transition-opacity cursor-grab active:cursor-grabbing p-2.5 bg-white dark:bg-premium-card shadow-xl rounded-xl border border-slate-100 dark:border-premium-border/50 text-slate-300 dark:text-slate-600 hover:text-blue-600 dark:hover:text-blue-400 drag-handle z-20">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 5v.01M12 12v.01M12 19v.01M19 5v.01M19 12v.01M19 19v.01M5 5v.01M5 12v.01M5 19v.01"></path></svg>
    </div>
    @endif

    <!-- Level Accent Border -->
    <div class="absolute left-0 top-6 bottom-6 w-1 rounded-r-full 
        @if($question->level === 'Beginner') bg-emerald-500 
        @elseif($question->level === 'Intermediate') bg-blue-600 
        @elseif($question->level === 'Advanced') bg-orange-600 
        @else bg-gray-200 @endif">
    </div>

    <div class="pl-4">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-2.5 py-1 bg-slate-50 dark:bg-premium-bg text-slate-400 dark:text-slate-500 rounded-lg text-[10px] font-black uppercase tracking-widest border border-slate-100 dark:border-premium-border/30">
                    Q#{{ $index ?? '?' }}
                </span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest transition-colors
                    @if($question->level === 'Beginner') bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20
                    @elseif($question->level === 'Intermediate') bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20
                    @elseif($question->level === 'Advanced') bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 border border-orange-100 dark:border-orange-500/20
                    @else bg-slate-50 dark:bg-premium-bg text-slate-400 dark:text-slate-500 border border-slate-100 dark:border-premium-border/30 @endif">
                    {{ $question->level ?? 'Standard' }}
                </span>
            </div>

            <div class="flex items-center space-x-2">
                @if(Auth::user()->role === 'teacher' && isset($section_id))
                <button type="button" onclick="removeQuestionFromExam({{ $question->id }}, {{ $section_id }})" class="p-2 text-slate-300 dark:text-slate-600 hover:text-red-500 dark:hover:text-red-400 transition-colors mr-2" title="Retirer de l'examen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
                @endif

                @if($question->type === 'consigne')
                    <span class="px-3 py-1 bg-slate-800 dark:bg-slate-700 text-white rounded-lg text-[9px] font-black uppercase tracking-widest shadow-lg shadow-slate-800/10">Consigne</span>
                @else
                    <div class="flex items-center space-x-1.5 px-3 py-1 bg-blue-600 text-white rounded-lg shadow-lg shadow-blue-600/10 border border-white/10">
                        <span class="text-[9px] font-black uppercase tracking-widest opacity-70">Scale</span>
                        <span class="text-[11px] font-black">{{ $question->points }} PTS</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="prose prose-sm max-w-none text-slate-700 dark:text-slate-300 font-bold leading-relaxed break-words transition-colors">
            {!! $question->content !!}
        </div>

        @if(in_array(strtolower($question->type), ['qcm', 'mcq']))
            <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-3">
                 @foreach(['a', 'b', 'c', 'd'] as $opt)
                    @php $field = 'option_' . $opt; @endphp
                    @if($question->$field)
                        <div class="flex items-center space-x-3 text-[11px] p-3 rounded-xl border {{ strtoupper($question->correct_answer) === strtoupper($opt) ? 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-500/30 text-emerald-800 dark:text-emerald-400 shadow-sm' : 'bg-slate-50 dark:bg-premium-bg border-slate-100 dark:border-premium-border/20 text-slate-500 dark:text-slate-500 opacity-80' }} transition-colors">
                            <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-lg {{ strtoupper($question->correct_answer) === strtoupper($opt) ? 'bg-emerald-500 text-white' : 'bg-slate-200 dark:bg-premium-card text-slate-500' }} font-black uppercase text-[10px]">{{ $opt }}</span>
                            <span class="font-bold flex-1 transition-colors">{{ $question->$field }}</span>
                            @if(strtoupper($question->correct_answer) === strtoupper($opt))
                                <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l3-3z" clip-rule="evenodd"></path></svg>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @elseif(in_array(strtolower($question->type), ['true_false', 'tf']))
            <div class="mt-5 inline-flex items-center space-x-2 px-4 py-2 rounded-xl border {{ in_array(strtolower($question->correct_answer), ['true', '1', 'vrai']) ? 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-500/30 text-emerald-700 dark:text-emerald-400' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-500/30 text-red-700 dark:text-red-400' }} transition-colors">
                <span class="text-[9px] font-black uppercase opacity-60">Réponse attendue :</span>
                <span class="text-[11px] font-black uppercase tracking-widest">{{ in_array(strtolower($question->correct_answer), ['true', '1', 'vrai']) ? 'Vrai' : 'Faux' }}</span>
            </div>
        @endif

        <!-- Sub Questions Container -->
        <div class="mt-6 space-y-4 empty:mt-0" id="subquestions_{{ $question->id }}">
            @if($question->subQuestions && $question->subQuestions->count() > 0)
                <div class="ml-4 pl-6 border-l-2 border-slate-100 dark:border-premium-border/20 space-y-4 transition-colors">
                    @foreach($question->subQuestions as $subIndex => $subQuestion)
                        @include('questions.partials.question-card', ['question' => $subQuestion, 'index' => $index . '.' . ($subIndex + 1), 'section_id' => $section_id])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
