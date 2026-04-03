<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails des Réponses : {{ $student_name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen relative selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden">
        <!-- Immersive Background Orbs -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-400/10 rounded-full mix-blend-multiply filter blur-[120px] animate-blob"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-purple-400/10 rounded-full mix-blend-multiply filter blur-[120px] animate-blob animation-delay-2000"></div>
        </div>

        <main class="max-w-4xl mx-auto px-4 relative z-10">
            <!-- Summary Header -->
            <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-blue-900/5 border border-white relative overflow-hidden mb-12">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 opacity-80"></div>
                
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="text-left">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px] uppercase tracking-widest mb-4">
                            Consultation Formateur
                        </div>
                        <h2 class="text-3xl font-black text-slate-900 mb-2 tracking-tight">{{ $quiz->title }}</h2>
                        <p class="text-slate-500 font-medium">Étudiant : <span class="text-slate-900 font-bold">{{ $student_name }}</span></p>
                    </div>

                    @php
                        $total = $answers->count();
                        $correct = $answers->where('is_correct', true)->count();
                        $score = $total > 0 ? round(($correct / $total) * 100, 2) : 0;
                    @endphp

                    <div class="flex flex-col items-center justify-center p-6 bg-slate-50 rounded-3xl border border-slate-100 min-w-[160px]">
                        <span class="text-4xl font-black {{ $score >= 50 ? 'text-green-600' : 'text-red-600' }}">{{ $score }}%</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase mt-1 tracking-widest">Score Final</span>
                        <div class="mt-3 text-xs font-bold text-slate-600">{{ $correct }} / {{ $total }} Correctes</div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-100 flex justify-start">
                    <a href="{{ route('quizzes.teacher_results', $quiz->id) }}" class="px-6 py-3 bg-white text-slate-700 border border-slate-200 font-bold rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Retour aux résultats
                    </a>
                </div>
            </div>

            <!-- Detailed Answers -->
            <div class="space-y-6">
                @foreach($answers as $index => $answer)
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <!-- Side indicator line -->
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $answer->is_correct ? 'bg-green-500' : 'bg-red-500' }}"></div>

                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-6">
                            <span class="inline-block px-4 py-2 bg-slate-50 text-slate-500 rounded-xl text-[10px] font-black font-mono tracking-widest uppercase border border-slate-100">
                                Question {{ $index + 1 }}
                            </span>
                            
                            @if($answer->is_correct)
                                <div class="flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-xl border border-green-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Correct</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-700 rounded-xl border border-red-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Incorrect</span>
                                </div>
                            @endif
                        </div>

                        <div class="text-lg md:text-xl font-medium text-slate-800 mb-8 prose prose-slate max-w-none leading-relaxed">
                            {!! $answer->question->content !!}
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Answer Given -->
                            <div class="p-6 rounded-2xl border-2 {{ $answer->is_correct ? 'border-green-100 bg-green-50/50' : 'border-red-100 bg-red-50/50' }}">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center {{ $answer->is_correct ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <p class="text-[10px] font-black uppercase tracking-widest {{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">Réponse de l'étudiant</p>
                                </div>
                                
                                @if(is_array($answer->question->options) && count($answer->question->options) > 0)
                                    <p class="font-bold text-lg {{ $answer->is_correct ? 'text-green-800' : 'text-red-800' }}">
                                        {{ $answer->selected_answer }}: {{ $answer->question->options[ord($answer->selected_answer) - 65] ?? '' }}
                                    </p>
                                @else
                                    <p class="font-bold text-lg {{ $answer->is_correct ? 'text-green-800' : 'text-red-800' }}">
                                        @if($answer->question->type === 'mcq' || $answer->question->type === 'qcm')
                                            {{ $answer->selected_answer }}: {{ $answer->question->{'option_'.strtolower($answer->selected_answer)} }}
                                        @else
                                            {{ $answer->selected_answer }}
                                        @endif
                                    </p>
                                @endif
                            </div>
                            
                            <!-- Correct Answer -->
                            <div class="p-6 rounded-2xl border-2 border-blue-100 bg-blue-50/50">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-6 h-6 rounded-full bg-blue-200 text-blue-700 flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-blue-600">Réponse attendue</p>
                                </div>
                                
                                @if(is_array($answer->question->options) && count($answer->question->options) > 0)
                                    <p class="font-bold text-lg text-blue-800">
                                        {{ $answer->question->correct_answer }}: {{ $answer->question->options[ord($answer->question->correct_answer) - 65] ?? '' }}
                                    </p>
                                @else
                                    <p class="font-bold text-lg text-blue-800">
                                        @if($answer->question->type === 'mcq' || $answer->question->type === 'qcm')
                                            {{ $answer->question->correct_answer }}: {{ $answer->question->{'option_'.strtolower($answer->question->correct_answer)} }}
                                        @else
                                            {{ $answer->question->correct_answer }}
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</x-app-layout>
