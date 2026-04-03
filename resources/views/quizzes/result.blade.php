<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Résultats - {{ $quiz->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen relative selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden">
    <!-- Immersive Background Orbs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-400/10 rounded-full mix-blend-multiply filter blur-[120px] animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-purple-400/10 rounded-full mix-blend-multiply filter blur-[120px] animate-blob animation-delay-2000"></div>
    </div>

    <main class="max-w-4xl mx-auto px-4 py-16 relative z-10">
        <!-- Main Score Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-blue-900/5 border border-white text-center relative overflow-hidden mb-16">
            <!-- Decorative top shine -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 opacity-80"></div>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-100/50 text-slate-500 font-bold text-[10px] uppercase tracking-widest mb-6">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                Quiz Terminé
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-12 tracking-tight">{{ $quiz->title }}</h2>

            <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-16 mb-12">
                <!-- Score Circle -->
                <div class="relative">
                    <div class="w-56 h-56 rounded-[2.5rem] border-8 border-slate-50 border-white/50 flex flex-col items-center justify-center bg-white shadow-xl rotate-3 hover:rotate-0 transition-transform duration-500">
                        <span class="text-6xl font-black bg-clip-text text-transparent {{ $score >= 50 ? 'bg-gradient-to-br from-green-400 to-green-600' : 'bg-gradient-to-br from-red-400 to-red-600' }}">
                            {{ $score }}%
                        </span>
                        <span class="text-xs font-bold text-slate-400 uppercase mt-2 tracking-widest">Votre Score</span>
                    </div>
                </div>

                <!-- Stats -->
                <div class="flex flex-col gap-4 text-left w-full max-w-xs">
                    <div class="flex items-center gap-5 p-5 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Correctes</p>
                            <p class="text-2xl font-black text-slate-800 leading-none">{{ $answers->where('is_correct', true)->count() }} <span class="text-slate-400 text-base font-bold">/ {{ $answers->count() }}</span></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-5 p-5 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Étudiant</p>
                            <p class="text-lg font-bold text-slate-800 leading-tight">{{ $student_name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center gap-4">
                <a href="{{ url('/') }}" class="px-10 py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-[0.98]">
                    Retour à l'accueil
                </a>
            </div>
        </div>

        <!-- Details Section -->
        <div>
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm border border-slate-100 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Détails des Réponses</h3>
            </div>
            
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
                        
                        <div class="grid grid-cols-1 {{ !$answer->is_correct ? 'md:grid-cols-2' : '' }} gap-4">
                            <!-- Answer Given -->
                            <div class="p-6 rounded-2xl border-2 {{ $answer->is_correct ? 'border-green-100 bg-green-50/50' : 'border-red-100 bg-red-50/50' }}">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center {{ $answer->is_correct ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <p class="text-[10px] font-black uppercase tracking-widest {{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">Votre réponse</p>
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
                            
                            <!-- Correct Answer (if wrong) -->
                            @if(!$answer->is_correct)
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
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</body>
</html>
