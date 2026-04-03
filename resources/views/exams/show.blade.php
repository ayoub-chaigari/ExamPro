<x-app-layout>
    <x-slot name="header">
        {{ __('Éditeur d\'Examen') }}
    </x-slot>

    <!-- Tinymce load -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    <div class="space-y-10">
        <!-- Premium Abstract Header -->
        <div class="relative group">
            <div class="bg-white dark:bg-premium-card rounded-[2.5rem] p-10 md:p-12 shadow-sm border border-slate-100 dark:border-premium-border/50 flex flex-col lg:flex-row justify-between items-center relative overflow-hidden transition-all duration-500 hover:shadow-xl hover:shadow-blue-600/5">
                <!-- Decorative background -->
                <div class="absolute -right-24 -top-24 w-80 h-80 bg-blue-600/5 rounded-full blur-[100px] group-hover:bg-blue-600/10 transition-colors duration-700"></div>
                
                <div class="relative z-10 flex flex-col lg:flex-row items-center lg:items-start lg:space-x-10 text-center lg:text-left">
                    <div class="bg-blue-600 p-8 rounded-[2rem] shadow-2xl shadow-blue-600/20 transform lg:-rotate-3 group-hover:rotate-0 transition-all duration-500 mb-8 lg:mb-0">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 mb-4">
                            <span class="px-4 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[10px] font-black rounded-full uppercase tracking-widest border border-blue-100 dark:border-blue-500/20">{{ $exam->category->name }}</span>
                            <span class="px-4 py-1.5 bg-slate-50 dark:bg-premium-bg text-slate-500 dark:text-slate-400 text-[10px] font-black rounded-full uppercase tracking-widest border border-slate-100 dark:border-premium-border/30">{{ $exam->duration }} min</span>
                            <span class="px-4 py-1.5 bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 text-[10px] font-black rounded-full uppercase tracking-widest border border-orange-100 dark:border-orange-500/20">{{ $exam->created_at->format('M Y') }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-slate-800 dark:text-white leading-tight tracking-tight uppercase max-w-2xl transition-colors">
                            {{ $exam->title }}
                        </h1>
                        <p class="text-slate-400 dark:text-slate-500 font-bold mt-3 max-w-xl italic leading-relaxed text-xs uppercase tracking-wide">
                            {{ $exam->description ?? 'Structurez votre examen en ajoutant des sections et des questions.' }}
                        </p>
                    </div>
                </div>

                <div class="mt-12 lg:mt-0 flex flex-col items-center lg:items-end justify-center relative z-10 w-full lg:w-auto">
                    <div class="bg-gray-800 px-10 py-6 rounded-[2rem] text-center shadow-xl shadow-gray-800/20 border-b-4 border-blue-600 w-full sm:w-56 transform transition-all hover:scale-105 duration-300">
                        <span class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1 opacity-80">Score Total</span>
                        <div class="text-5xl font-black text-white flex items-baseline justify-center tracking-tighter" id="exam_total_display">
                            {{ $exam->total_points }} <span class="text-lg ml-2 opacity-30">PTS</span>
                        </div>
                    </div>
                    
                    @if(Auth::user()->role === 'teacher')
                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                        <button onclick="document.getElementById('sectionModal').classList.remove('hidden')" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-xs transition-all uppercase tracking-widest flex items-center shadow-lg shadow-blue-600/20 active:scale-95 group">
                            <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                            Nouvelle Section
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-10">
            <!-- Sidebar: Tools & Stats -->
            <div class="xl:col-span-3 space-y-8">
                @if(Auth::user()->role === 'teacher')
                <!-- Exam Tools Card -->
                <div class="bg-gray-800 rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/20 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-blue-600/30 transition-colors"></div>
                    
                    <div class="relative z-10 space-y-8">
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] mb-6 flex items-center text-blue-400">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                Génération PDF
                            </h4>
                            
                            @if($exam->questions->count() > 0)
                                <form action="{{ route('exams.generate-variants', $exam) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest pl-1">Nombre d'exemplaires</label>
                                        <select name="num_variants" class="w-full bg-gray-700 border-none rounded-xl text-xs font-black p-4 focus:ring-2 focus:ring-blue-600 transition-all hover:bg-gray-650 text-white cursor-pointer uppercase tracking-widest">
                                            @for($i=1; $i<=5; $i++)
                                                <option value="{{ $i }}">{{ $i }} Variantes</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-black text-[10px] shadow-xl shadow-blue-600/20 transition-all transform active:scale-95 uppercase tracking-widest" onclick="return confirm('Générer les variantes PDF ?')">
                                        Générer les PDF
                                    </button>
                                </form>
                            @else
                                <div class="bg-blue-600/10 border border-blue-600/20 rounded-2xl p-4 text-[10px] font-black text-blue-400 uppercase tracking-widest italic leading-relaxed">
                                    Ajoutez des questions pour activer l'exportation.
                                </div>
                            @endif
                        </div>

                        @php
                            $hasCorrectionQuestions = $exam->questions->filter(function($q) {
                                return in_array(strtolower($q->type), ['qcm', 'true_false', 'mcq', 'tf']);
                            })->count() > 0;
                        @endphp

                        @if($hasCorrectionQuestions || $exam->questions->count() > 0)
                            <div class="pt-8 border-t border-gray-700 space-y-4">
                                @if($hasCorrectionQuestions)
                                    <a href="{{ route('exams.correction', $exam) }}" target="_blank" class="w-full flex items-center justify-center bg-gray-700 hover:bg-emerald-600 text-white py-4 rounded-xl font-black text-[10px] transition-all transform active:scale-95 uppercase tracking-widest group">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Générer Corrigé
                                    </a>
                                @endif

                                @if($exam->questions->count() > 0)
                                    <form action="{{ route('exams.export-word', $exam) }}" method="GET" target="_blank" class="space-y-4">
                                        <label class="flex items-center space-x-3 cursor-pointer group px-2">
                                            <div class="relative flex items-center">
                                                <input type="checkbox" name="show_answers" value="1" class="peer h-5 w-5 rounded border-gray-600 bg-gray-700 text-blue-500 focus:ring-0 focus:ring-offset-0 transition-all cursor-pointer">
                                                <div class="absolute inset-0 bg-blue-600 rounded scale-0 peer-checked:scale-100 transition-transform duration-200 pointer-events-none flex items-center justify-center">
                                                    <svg class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7"/></svg>
                                                </div>
                                            </div>
                                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest group-hover:text-white transition-colors">Réponses incluses</span>
                                        </label>
                                        
                                        <button type="submit" class="w-full flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-black text-[10px] shadow-xl shadow-blue-600/20 transition-all transform active:scale-95 uppercase tracking-widest">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Exporter Word
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Dynamic Variant List -->
                <div class="space-y-4">
                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-4">Documents</h4>
                    @forelse($exam->variants as $variant)
                        <a href="{{ route('exam_variants.export-pdf', $variant) }}" target="_blank" class="flex items-center justify-between p-5 bg-white dark:bg-premium-card border border-slate-100 dark:border-premium-border/50 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-600 transition-all group">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-red-50 dark:bg-red-900/30 rounded-lg group-hover:bg-red-100 dark:group-hover:bg-red-800 transition-colors">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $variant->name }}</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    @empty
                        <div class="p-8 text-center bg-gray-50 border border-dashed rounded-[2rem] border-gray-200">
                            <p class="text-[10px] font-black text-gray-300 uppercase italic tracking-widest">Aucun PDF</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Main Content: Exam Builder -->
            <div class="xl:col-span-9 space-y-12 pb-20">
                <div id="alert_container"></div>
                
                <div class="flex items-center space-x-4 mb-8">
                    <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tight transition-colors">Constructeur d'Examen</h2>
                    <div class="h-px flex-1 bg-slate-100 dark:bg-premium-border/30"></div>
                </div>

                @if(Auth::user()->role === 'teacher')
                <!-- Premium Add Section Mini-Form -->
                <form id="add_section_form" class="bg-blue-600/5 dark:bg-blue-600/10 border border-blue-600/10 dark:border-blue-500/20 p-4 pr-4 rounded-3xl flex flex-col sm:flex-row items-center gap-3 transition-all hover:bg-blue-600/[0.07] dark:hover:bg-blue-600/[0.15] group">
                    @csrf
                    <div class="flex-1 w-full relative">
                        <input type="text" name="title" id="new_section_title" placeholder="Ex: PARTIE I : CONNAISSANCES THÉORIQUES" required class="w-full bg-white/50 dark:bg-premium-card border-none rounded-2xl p-4 text-sm font-bold text-blue-600 dark:text-blue-400 placeholder-blue-600/30 dark:placeholder-blue-400/30 focus:ring-0 group-focus-within:bg-white dark:group-focus-within:bg-premium-bg transition-all shadow-sm">
                    </div>
                    <button type="submit" id="btn_add_section" class="w-full sm:w-auto bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-blue-900/10 hover:bg-blue-700 transition-all transform active:scale-95 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Ajouter Section
                    </button>
                </form>
                @endif

                <div id="sections_container" class="space-y-16">
                    @forelse($exam->sections as $section)
                        @include('exams.partials.section-card', ['section' => $section, 'exam' => $exam, 'availableQuestions' => $availableQuestions])
                    @empty
                        <div id="empty_exam_msg" class="py-32 text-center bg-white dark:bg-premium-card rounded-[3rem] border-4 border-dashed border-slate-50 dark:border-premium-border/20 group transition-all duration-500 hover:border-blue-600/10 dark:hover:border-blue-500/20">
                            <div class="inline-flex p-10 bg-slate-50 dark:bg-premium-bg rounded-full text-slate-200 dark:text-slate-700 group-hover:scale-110 group-hover:bg-blue-600/5 group-hover:text-blue-600/20 transition-all duration-700 mb-8">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-300 uppercase tracking-[0.2em]">Examen en attente de contenu</h3>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced AJAX Question Modal -->
    <div id="ajaxQuestionModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8">
            <div class="bg-white dark:bg-premium-card rounded-[2rem] shadow-2xl w-full max-w-4xl transform transition-all overflow-hidden border border-white/20 dark:border-premium-border/50 animate-in fade-in zoom-in duration-300">
                <!-- Premium Header -->
                <div class="bg-gradient-to-br from-blue-600 via-blue-900 to-indigo-950 px-8 py-6 flex justify-between items-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 pointer-events-none">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0 100 L100 0 L100 100 Z" fill="white"/></svg>
                    </div>
                    <div class="relative z-10 flex items-center space-x-3">
                        <div class="p-2 bg-orange-500 rounded-xl shadow-lg ring-4 ring-orange-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-white uppercase tracking-wider leading-none" id="modalTitle">Nouvelle Question</h3>
                            <p class="text-blue-200 text-[10px] font-bold mt-1 uppercase tracking-tighter opacity-80">Configuration de l'item d'examen</p>
                        </div>
                    </div>
                    <button type="button" class="relative z-10 text-white/50 hover:text-white transition-all bg-white/5 hover:bg-white/10 p-2 rounded-xl border border-white/10 hover:border-white/20 group" onclick="closeQuestionModal()">
                        <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form id="ajax_q_form" class="bg-white dark:bg-premium-card transition-colors">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $exam->category_id }}">
                    
                    <div class="p-8 grid grid-cols-1 lg:grid-cols-12 gap-8 max-h-[65vh] overflow-y-auto custom-scrollbar">
                        <!-- Left Column: Configuration -->
                        <div class="lg:col-span-4 space-y-6">
                            <div class="space-y-4">
                                <div class="bg-slate-50/50 dark:bg-premium-bg/50 p-5 rounded-2xl border border-slate-100/50 dark:border-premium-border/30 space-y-4 shadow-sm transition-colors">
                                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-premium-border/20 pb-2">Paramètres de base</h4>
                                    
                                    <div class="space-y-1.5">
                                        <label class="block text-[11px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-tighter">Format</label>
                                        <select name="type" id="ajax_type" class="w-full rounded-xl border-slate-200 dark:border-premium-border/50 bg-white dark:bg-premium-bg text-slate-700 dark:text-slate-200 font-bold text-sm focus:ring-blue-600 focus:border-blue-600 py-3 transition-all cursor-pointer" onchange="toggleAjaxType()">
                                            <option value="open">Question Ouverte</option>
                                            <option value="qcm">QCM</option>
                                            <option value="true_false">Vrai / Faux</option>
                                            <option value="consigne">Consigne (Texte)</option>
                                        </select>
                                    </div>

                                    <div class="space-y-1.5">
                                        <label class="block text-[11px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-tighter">Niveau</label>
                                        <select name="level" class="w-full rounded-xl border-slate-200 dark:border-premium-border/50 bg-white dark:bg-premium-bg text-slate-700 dark:text-slate-200 font-bold text-sm focus:ring-blue-600 focus:border-blue-600 py-3 transition-all cursor-pointer">
                                            <option value="Beginner">Débutant</option>
                                            <option value="Intermediate" selected>Intermédiaire</option>
                                            <option value="Advanced">Avancé</option>
                                        </select>
                                    </div>

                                    <div class="space-y-1.5" id="ajax_points_container">
                                        <label class="block text-[11px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-tighter">Points</label>
                                        <div class="relative group/points">
                                            <input type="number" step="0.5" name="points" id="ajax_points" value="1" class="w-full rounded-xl border-slate-200 dark:border-premium-border/50 bg-white dark:bg-premium-bg text-slate-700 dark:text-slate-200 font-black text-lg focus:ring-orange-500 focus:border-orange-500 pl-5 py-3 transition-all">
                                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400 group-focus-within/points:text-orange-500 transition-colors uppercase">PTS</span>
                                        </div>
                                    </div>
                                </div>

                                <div id="ajax_qcm_options" class="hidden p-5 rounded-2xl border border-slate-100 dark:border-premium-border/30 bg-slate-50/50 dark:bg-premium-bg/50 space-y-4 shadow-sm transition-colors">
                                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-premium-border/20 pb-2">Options QCM</h4>
                                    <div class="grid grid-cols-1 gap-3">
                                        <input type="text" name="option_a" placeholder="Option A" class="w-full rounded-xl border-slate-200 dark:border-premium-border/50 bg-white dark:bg-premium-bg text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-blue-600">
                                        <input type="text" name="option_b" placeholder="Option B" class="w-full rounded-xl border-slate-200 dark:border-premium-border/50 bg-white dark:bg-premium-bg text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-blue-600">
                                        <input type="text" name="option_c" placeholder="Option C" class="w-full rounded-xl border-slate-200 dark:border-premium-border/50 bg-white dark:bg-premium-bg text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-blue-600">
                                        <input type="text" name="option_d" placeholder="Option D" class="w-full rounded-xl border-slate-200 dark:border-premium-border/50 bg-white dark:bg-premium-bg text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-blue-600">
                                    </div>
                                    <div class="space-y-1.5 pt-2">
                                        <label class="block text-[11px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-tighter">Réponse Correcte</label>
                                        <select name="correct_answer_qcm" class="w-full rounded-xl border-emerald-100 dark:border-emerald-500/30 bg-emerald-50/30 dark:bg-emerald-900/10 text-emerald-700 dark:text-emerald-400 font-black text-sm focus:ring-emerald-500">
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="ajax_tf_options" class="hidden p-5 rounded-2xl border border-slate-100 dark:border-premium-border/30 bg-slate-50/50 dark:bg-premium-bg/50 space-y-4 shadow-sm transition-colors">
                                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-premium-border/20 pb-2">Réponse Vrai/Faux</h4>
                                    <select name="correct_answer_tf" class="w-full rounded-xl border-emerald-100 dark:border-emerald-500/30 bg-emerald-50/30 dark:bg-emerald-900/10 text-emerald-700 dark:text-emerald-400 font-black text-sm focus:ring-emerald-500">
                                        <option value="True">VRAI</option>
                                        <option value="False">FAUX</option>
                                    </select>
                                </div>

                                <div id="ajax_open_options" class="p-5 rounded-2xl border-2 border-blue-50 dark:border-blue-900/20 bg-blue-50/20 dark:bg-blue-900/10 space-y-3 transition-all hover:bg-blue-50/40 dark:hover:bg-blue-900/20 shadow-sm">
                                    <label class="flex items-center space-x-3 cursor-pointer group/opt">
                                        <div class="relative">
                                            <input type="checkbox" name="requires_answer_space" id="ajax_requires_answer_space" value="1" class="peer h-5 w-5 rounded border-blue-200 dark:border-blue-800 bg-white dark:bg-premium-bg text-blue-600 focus:ring-offset-0 focus:ring-blue-400 transition-all cursor-pointer" onchange="toggleAjaxAnswerSize()">
                                            <div class="absolute inset-0 bg-blue-600 rounded scale-0 peer-checked:scale-100 transition-transform duration-200 pointer-events-none flex items-center justify-center">
                                                <svg class="h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                        </div>
                                        <span class="text-xs font-black text-blue-600 dark:text-blue-400 uppercase tracking-tighter group-hover/opt:text-blue-800 dark:group-hover/opt:text-blue-300 transition-colors">Espace de réponse PDF</span>
                                    </label>
                                    
                                    <div id="ajax_answer_size_container" class="hidden animate-in slide-in-from-top-2 duration-200">
                                        <select name="answer_space_size" class="w-full rounded-xl border-blue-100 dark:border-blue-900/30 bg-white dark:bg-premium-bg text-slate-700 dark:text-slate-300 font-bold text-xs focus:ring-blue-600 focus:border-blue-600 py-2.5 shadow-sm">
                                            <option value="small">S (Petit ~2 lignes)</option>
                                            <option value="medium">M (Moyen ~5 lignes)</option>
                                            <option value="large">L (Grand ~10 lignes)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Text Variations Group (AJAX) -->
                                <div id="ajax_variations_container" class="p-5 rounded-2xl border border-indigo-100 dark:border-indigo-900/30 bg-indigo-50/20 dark:bg-indigo-900/10 space-y-4 shadow-sm">
                                    <div class="flex items-center justify-between border-b border-indigo-100 dark:border-indigo-900/20 pb-2">
                                        <div class="flex flex-col">
                                            <h4 class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest leading-none">Variantes</h4>
                                            <p class="text-[8px] font-bold text-indigo-400/60 uppercase mt-1">Formulations alternatives</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" id="ajax_ai_rephrase_btn" onclick="aiRephraseAjax()" class="text-[9px] font-black text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1.5 rounded-lg transition-all uppercase flex items-center gap-1.5 shadow-sm active:scale-95">
                                                <span>✨ IA</span>
                                            </button>
                                            <button type="button" onclick="addAjaxTextVariant()" class="text-[9px] font-black text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 transition-all uppercase border border-indigo-200 dark:border-indigo-800 px-3 py-1.5 rounded-lg">+ Ajouter</button>
                                        </div>
                                    </div>
                                    <div id="ajax_text_variants_list" class="space-y-3">
                                        <!-- Dynamic inputs -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Editor -->
                        <div class="lg:col-span-8 flex flex-col h-full">
                            <div class="flex-1 flex flex-col space-y-2">
                                <label class="block text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest flex items-center px-1">
                                    <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Contenu de la question
                                </label>
                                <div class="flex-1 border-2 border-slate-100 dark:border-premium-border/30 rounded-3xl overflow-hidden shadow-inner focus-within:border-blue-600/30 transition-all bg-slate-50/30 dark:bg-premium-bg/50 min-h-[300px]">
                                    <textarea name="content" id="content_ajax" class="w-full border-none focus:ring-0 bg-transparent"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modern Footer -->
                    <div class="px-8 py-6 bg-slate-50/80 dark:bg-premium-bg/80 backdrop-blur border-t border-slate-100 dark:border-premium-border/20 flex justify-between items-center sm:rounded-b-[2rem] transition-colors">
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest hidden sm:block">Fermer sans enregistrer pour annuler</p>
                        <div class="flex items-center space-x-4 w-full sm:w-auto">
                            <button type="button" onclick="closeQuestionModal()" class="flex-1 sm:flex-none px-8 py-3.5 rounded-2xl text-[11px] font-black text-slate-500 hover:text-slate-800 dark:hover:text-slate-100 transition-all uppercase tracking-widest hover:bg-slate-100/50 dark:hover:bg-premium-bg">
                                Annuler
                            </button>
                            <button type="submit" id="btn_save_q" class="flex-1 sm:flex-none relative bg-blue-600 hover:bg-blue-700 text-white px-12 py-3.5 rounded-2xl font-black text-[11px] shadow-2xl shadow-blue-900/40 transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest group overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                <span class="relative z-10 flex items-center justify-center">
                                    <span>Enregistrer</span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        let currentSectionId = null;
        let currentParentId = null;

        // SORTING
        function initSortable() {
            document.querySelectorAll('[id^="section_questions_"]').forEach(container => {
                if (container.dataset.sortable) return;
                container.dataset.sortable = 'true';
                
                new Sortable(container, {
                    handle: '.drag-handle',
                    animation: 200,
                    ghostClass: 'bg-ofppt-blue/5',
                    onEnd: function (evt) {
                        let items = Array.from(container.querySelectorAll('.question-item')).map(el => el.dataset.id);
                        fetch("{{ route('questions.reorder') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ items: items })
                        });
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initSortable();

            tinymce.init({
                selector: '#content_ajax',
                plugins: 'table lists link image code autoresize',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | table image',
                menubar: false,
                height: 250,
                content_style: 'body { font-family: Inter, sans-serif; font-size: 14px; color: #374151; font-weight: 600; } table { border-collapse: collapse; width: 100%; } table td, table th { border: 1px solid #ddd; padding: 8px; }',
                images_upload_url: '{{ route('questions.upload-image') }}',
                automatic_uploads: true,
                images_upload_handler: function (blobInfo, success, failure, progress) {
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '{{ route('questions.upload-image') }}');
                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                    xhr.upload.onprogress = function (e) {
                        progress(e.loaded / e.total * 100);
                    };
                    xhr.onload = function() {
                        var json;
                        if (xhr.status < 200 || xhr.status >= 300) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(json.location);
                    };
                    xhr.onerror = function () {
                        failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                },
                setup: function (editor) {
                    editor.on('change', function () {
                        tinymce.triggerSave();
                    });
                }
            });
        });

        // SECTION ACTIONS
        document.getElementById('add_section_form').addEventListener('submit', function(e) {
            e.preventDefault();
            let btn = document.getElementById('btn_add_section');
            btn.disabled = true;
            btn.innerText = "Création...";

            let formData = new FormData(this);
            fetch("{{ route('exams.sections.store', $exam) }}", {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false; btn.innerText = "AJOUTER LA SECTION";
                if(data.success) {
                    let container = document.getElementById('sections_container');
                    let emptyMsg = document.getElementById('empty_exam_msg');
                    if(emptyMsg) emptyMsg.remove();
                    container.insertAdjacentHTML('beforeend', data.html);
                    document.getElementById('new_section_title').value = '';
                    initSortable();
                }
            });
        });

        function toggleEditSection(id) {
            document.getElementById('section_title_display_' + id).classList.toggle('hidden');
            document.getElementById('section_edit_form_' + id).classList.toggle('hidden');
        }

        function saveSectionTitle(id) {
            let newTitle = document.getElementById('input_title_' + id).value;
            fetch(`/sections/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ title: newTitle })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('section_title_display_' + id).querySelector('h4').innerText = data.section.title;
                    toggleEditSection(id);
                }
            });
        }

        function deleteSection(id) {
            if(!confirm('Supprimer cette section et toutes ses questions ?')) return;
            fetch(`/sections/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('section_wrapper_' + id).remove();
                    if(data.exam_total !== undefined) {
                      document.getElementById('exam_total_display').innerHTML = data.exam_total + ' <span class="text-xl ml-2 opacity-30">PTS</span>';
                    }
                }
            });
        }

        // QUESTION ACTIONS
        function removeQuestionFromExam(questionId, sectionId) {
            if(!confirm('Retirer cette question de l\'examen ?')) return;
            
            fetch(`/questions/${questionId}/remove-from-exam`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    let qEl = document.getElementById('question_' + questionId);
                    if(qEl) qEl.remove();
                    
                    // Update Totals
                    if(data.section_total !== undefined) {
                        let secPoints = document.getElementById('section_points_' + sectionId);
                        if(secPoints) secPoints.innerText = data.section_total + ' PTS';
                        document.getElementById('exam_total_display').innerHTML = data.exam_total + ' <span class="text-xl ml-2 opacity-30">PTS</span>';
                    }
                }
            });
        }

        function openQuestionModal(sectionId, parentId = null) {
            currentSectionId = sectionId;
            currentParentId = parentId;
            document.getElementById('modalTitle').innerText = parentId ? "Ajouter une sous-question" : "Créer une question";
            document.getElementById('ajaxQuestionModal').classList.remove('hidden');
            document.getElementById('ajax_q_form').reset();
            tinymce.get('content_ajax').setContent('');
            toggleAjaxType();
            toggleAjaxAnswerSize();
        }

        function closeQuestionModal() {
            document.getElementById('ajaxQuestionModal').classList.add('hidden');
        }

        function toggleAjaxType() {
            const type = document.getElementById('ajax_type').value;
            
            // Hide everything first
            document.getElementById('ajax_points_container').classList.remove('hidden');
            document.getElementById('ajax_open_options').classList.add('hidden');
            document.getElementById('ajax_qcm_options').classList.add('hidden');
            document.getElementById('ajax_tf_options').classList.add('hidden');
            document.getElementById('ajax_variations_container').classList.add('hidden');

            if (type === 'consigne') {
                document.getElementById('ajax_points_container').classList.add('hidden');
                document.getElementById('ajax_points').value = 0;
            } else if (type === 'open') {
                document.getElementById('ajax_open_options').classList.remove('hidden');
                document.getElementById('ajax_variations_container').classList.remove('hidden');
            } else if (type === 'qcm') {
                document.getElementById('ajax_qcm_options').classList.remove('hidden');
            } else if (type === 'true_false') {
                document.getElementById('ajax_tf_options').classList.remove('hidden');
            }
        }

        function toggleAjaxAnswerSize() {
            const checked = document.getElementById('ajax_requires_answer_space').checked;
            document.getElementById('ajax_answer_size_container').classList.toggle('hidden', !checked);
        }

        function addAjaxTextVariant(value = '') {
            const container = document.getElementById('ajax_text_variants_list');
            const div = document.createElement('div');
            div.className = 'flex items-start gap-2 bg-white dark:bg-premium-bg/50 p-2 rounded-xl border border-indigo-100 dark:border-indigo-900/30 shadow-sm animate-in fade-in slide-in-from-top-1 duration-200';
            div.innerHTML = `
                <textarea name="text_variants[]" class="flex-1 bg-transparent border-none focus:ring-0 text-xs font-bold text-indigo-700 dark:text-indigo-300 placeholder-indigo-300 dark:placeholder-indigo-500/50 min-h-[60px]" placeholder="Autre formulation de la question...">${value}</textarea>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 transition-colors p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            `;
            container.appendChild(div);
        }

        function aiRephraseAjax() {
            const content = tinymce.get('content_ajax').getContent({format: 'text'});
            if (!content || content.trim().length < 5) {
                alert('Veuillez saisir un contenu de question d\'abord.');
                return;
            }

            const btn = document.getElementById('ajax_ai_rephrase_btn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span>⏳...</span>';

            fetch("{{ route('questions.rephrase') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content: content })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                if (data.success) {
                    addAjaxTextVariant(data.rephrased);
                } else {
                    alert('Erreur lors de la reformulation.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                alert('Erreur de connexion au service IA.');
            });
        }

        document.getElementById('ajax_q_form').addEventListener('submit', function(e) {
            e.preventDefault();
            tinymce.triggerSave();
            let btn = document.getElementById('btn_save_q');
            btn.innerText = "Sauvegarde..."; btn.disabled = true;

            let formData = new FormData(this);
            formData.append('section_id', currentSectionId);
            if (currentParentId) formData.append('parent_id', currentParentId);
            
            fetch("{{ route('questions.store') }}", {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(res => res.json().then(data => ({ status: res.status, data })))
            .then(({ status, data }) => {
                btn.innerText = "Enregistrer"; btn.disabled = false;
                if(status === 200 && data.success) {
                    closeQuestionModal();
                    let container = currentParentId ? document.getElementById('subquestions_' + currentParentId) : document.getElementById('section_questions_' + currentSectionId);
                    
                    if(container) {
                        if(!currentParentId) {
                            let emptyMsg = document.getElementById('empty_msg_' + currentSectionId);
                            if(emptyMsg) emptyMsg.remove();
                        }
                        container.insertAdjacentHTML('beforeend', data.html);
                        initSortable();
                    }
                    
                    // Update Totals
                    if(data.section_total !== undefined) {
                        let secPoints = document.getElementById('section_points_' + currentSectionId);
                        if(secPoints) secPoints.innerText = data.section_total + ' PTS';
                        document.getElementById('exam_total_display').innerHTML = data.exam_total + ' <span class="text-xl ml-2 opacity-30">PTS</span>';
                    }
                } else if (status === 422) {
                    let errors = Object.values(data.errors).flat().join('\n');
                    alert("Erreur de validation:\n" + errors);
                } else {
                    console.error("Server Error:", data);
                    alert("Erreur serveur: " + (data.message || "Erreur inconnue"));
                }
            })
            .catch(err => {
                btn.innerText = "Enregistrer"; btn.disabled = false;
                console.error("Fetch Error:", err);
                alert("Erreur de connexion ou erreur système (consultez la console).");
            });
        });

        function addQuestionsFromBank(event, sectionId, examId) {
            event.preventDefault();
            let checkboxes = document.querySelectorAll('.quest-check-' + sectionId + ':checked');
            if(checkboxes.length === 0) return alert('Sélectionnez au moins une question.');

            let ids = Array.from(checkboxes).map(c => c.value);
            let btn = document.querySelector('.btn-import-' + sectionId);
            btn.disabled = true; btn.innerText = "Importation...";

            fetch(`/exams/${examId}/sections/${sectionId}/add-questions`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: JSON.stringify({ questions: ids })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    let qContainer = document.getElementById('section_questions_' + sectionId);
                    if(qContainer) {
                        let emptyMsg = document.getElementById('empty_msg_' + sectionId);
                        if(emptyMsg) emptyMsg.remove();
                        qContainer.insertAdjacentHTML('beforeend', data.html);
                        initSortable();
                    }
                    
                    // Update Points
                    let secPoints = document.getElementById('section_points_' + sectionId);
                    if(secPoints) secPoints.innerText = data.section_total + ' PTS';
                    document.getElementById('exam_total_display').innerHTML = data.exam_total + ' <span class="text-xl ml-2 opacity-30">PTS</span>';
                    
                    // Clear checks and remove from bank list UI
                    checkboxes.forEach(c => {
                        c.closest('label').remove();
                    });
                    btn.disabled = false; btn.innerText = "Importer la sélection";
                }
            })
            .catch(err => {
                btn.disabled = false; btn.innerText = "Importer la sélection";
                console.error(err);
                alert("Erreur lors de l'importation.");
            });
        }
    </script>

    <!-- Premium Confirm Modal -->
    <div id="confirmModal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity duration-300 opacity-0" id="confirmBackdrop"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="bg-white dark:bg-premium-card w-full max-w-sm rounded-[2rem] shadow-2xl border border-white/20 dark:border-premium-border/50 overflow-hidden transform scale-90 opacity-0 transition-all duration-300" id="confirmCard">
                <!-- Visual Header -->
                <div class="h-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600"></div>
                
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900/20 rounded-2xl flex items-center justify-center mx-auto mb-6 text-red-600 dark:text-red-400 shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    
                    <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tight mb-2" id="confirmTitle">Confirmation</h3>
                    <p class="text-slate-500 dark:text-slate-400 font-bold text-xs leading-relaxed uppercase tracking-wide opacity-80" id="confirmMessage"></p>
                </div>

                <div class="px-8 pb-8 flex gap-3">
                    <button id="cancelBtn" class="flex-1 px-6 py-4 bg-slate-100 dark:bg-premium-bg text-slate-500 dark:text-slate-400 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all hover:bg-slate-200 dark:hover:bg-gray-800 active:scale-95">
                        Annuler
                    </button>
                    <button id="confirmBtn" class="flex-1 px-6 py-4 bg-blue-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-blue-600/20 hover:bg-blue-700 active:scale-95">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
