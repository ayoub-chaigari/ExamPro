<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $quiz->title }} - Online Quiz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .question-card { display: none; }
        .question-card.active { display: block; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col selection:bg-blue-200 selection:text-blue-900 overflow-x-hidden relative">
    
    <!-- Immersive Background Orbs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-400/10 rounded-full mix-blend-multiply filter blur-[120px] animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-400/10 rounded-full mix-blend-multiply filter blur-[120px] animate-blob animation-delay-2000"></div>
    </div>

    <!-- Navbar / Header (Glassmorphism) -->
    <header class="sticky top-0 z-50 bg-white/70 backdrop-blur-xl border-b border-white/50 shadow-sm transition-all duration-300">
        <div class="max-w-5xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h1 class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-tight">Quiz en cours</h1>
                    <p class="text-base font-black text-slate-800 leading-tight">{{ $quiz->title }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-6 bg-white pl-6 pr-2 py-2 rounded-2xl shadow-sm border border-slate-100">
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Temps Restant</p>
                    <p id="timer" class="text-xl font-mono font-black text-blue-600 leading-none">--:--</p>
                </div>
                <div class="w-10 h-10 rounded-xl border-4 border-slate-50 flex items-center justify-center relative bg-slate-50 shadow-inner">
                    <svg class="w-full h-full -rotate-90 absolute inset-0">
                        <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="3" fill="transparent" class="text-blue-600 transition-all duration-1000" id="progress-circle" stroke-dasharray="87.96" stroke-dashoffset="0" />
                    </svg>
                    <span id="progress-percent" class="text-[9px] font-bold text-slate-600">100%</span>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-4xl mx-auto w-full px-4 py-12 relative z-10">
        <form id="quiz-form" action="{{ route('quizzes.submit', $quiz->code) }}" method="POST">
            @csrf
            <input type="hidden" name="student_name" value="{{ $student_name }}">

            @foreach($quiz->questions as $qIndex => $question)
                <div class="question-card {{ $qIndex === 0 ? 'active' : '' }}" data-index="{{ $qIndex }}">
                    <div class="mb-8 flex justify-between items-end">
                        <span class="px-4 py-1.5 bg-blue-50 text-blue-700 rounded-full text-xs font-bold font-mono uppercase tracking-widest">
                            Question {{ $qIndex + 1 }} / {{ $quiz->questions->count() }}
                        </span>
                    </div>

                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 md:p-12 shadow-2xl shadow-blue-900/5 border border-white min-h-[450px] flex flex-col relative overflow-hidden">
                        <!-- Decorative top shine -->
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-200 to-transparent opacity-50"></div>

                        <div class="text-xl md:text-2xl font-semibold text-slate-800 mb-10 leading-relaxed prose prose-lg prose-slate max-w-none">
                            {!! $question->content !!}
                        </div>

                        <div class="space-y-4 flex-grow">
                            @if($question->type === 'mcq' || $question->type === 'qcm')
                                @if(is_array($question->options) && count($question->options) > 0)
                                    @foreach($question->options as $optIndex => $optionText)
                                        @php $key = chr(65 + $optIndex); @endphp
                                        <label class="flex items-center p-5 rounded-2xl border-2 border-slate-100 bg-white hover:border-blue-300 hover:bg-blue-50/50 cursor-pointer transition-all duration-300 group relative overflow-hidden shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" class="hidden peer">
                                            <div class="w-10 h-10 rounded-xl bg-slate-50 border-2 border-slate-200 flex items-center justify-center text-sm font-black text-slate-400 peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white transition-all duration-300 shadow-inner group-hover:scale-110">
                                                {{ $key }}
                                            </div>
                                            <span class="ml-5 text-slate-700 font-semibold group-hover:text-slate-900 text-lg peer-checked:text-blue-900 transition-colors">{{ $optionText }}</span>
                                            
                                            <!-- Selected Indicator Indicator -->
                                            <div class="absolute inset-y-0 right-0 w-2 bg-blue-600 transform scale-y-0 peer-checked:scale-y-100 transition-transform duration-300 origin-bottom"></div>
                                            <div class="absolute right-6 opacity-0 peer-checked:opacity-100 transition-opacity duration-300 text-blue-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </label>
                                    @endforeach
                                @else
                                    @php $hasOptions = false; @endphp
                                    @foreach(['A' => 'option_a', 'B' => 'option_b', 'C' => 'option_c', 'D' => 'option_d'] as $key => $field)
                                        @if($question->$field)
                                            @php $hasOptions = true; @endphp
                                            <label class="flex items-center p-5 rounded-2xl border-2 border-slate-100 bg-white hover:border-blue-300 hover:bg-blue-50/50 cursor-pointer transition-all duration-300 group relative overflow-hidden shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" class="hidden peer">
                                                <div class="w-10 h-10 rounded-xl bg-slate-50 border-2 border-slate-200 flex items-center justify-center text-sm font-black text-slate-400 peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white transition-all duration-300 shadow-inner group-hover:scale-110">
                                                    {{ $key }}
                                                </div>
                                                <span class="ml-5 text-slate-700 font-semibold group-hover:text-slate-900 text-lg peer-checked:text-blue-900 transition-colors">{{ $question->$field }}</span>
                                                <div class="absolute inset-y-0 right-0 w-2 bg-blue-600 transform scale-y-0 peer-checked:scale-y-100 transition-transform duration-300 origin-bottom"></div>
                                                <div class="absolute right-6 opacity-0 peer-checked:opacity-100 transition-opacity duration-300 text-blue-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                            </label>
                                        @endif
                                    @endforeach
                                    
                                    @if(!$hasOptions)
                                        <div class="p-8 bg-amber-50 text-amber-800 border-2 border-amber-200 rounded-3xl text-center font-bold flex flex-col items-center justify-center space-y-4">
                                            <svg class="w-12 h-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            <p>Cette question n'a pas d'options configurées.</p>
                                        </div>
                                    @endif
                                @endif
                            @elseif($question->type === 'true_false' || $question->type === 'tf')
                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <label class="flex flex-col items-center justify-center p-10 bg-white rounded-3xl border-2 border-slate-100 hover:border-green-400 hover:bg-green-50/50 cursor-pointer transition-all duration-300 group shadow-sm hover:shadow-lg transform hover:-translate-y-1 relative overflow-hidden">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="Vrai" class="hidden peer">
                                        <div class="absolute inset-0 bg-green-50/80 transform scale-y-0 peer-checked:scale-y-100 transition-transform duration-300 origin-bottom z-0"></div>
                                        <div class="relative z-10 flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-inner">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <span class="font-black text-xl text-slate-700 peer-checked:text-green-700 uppercase tracking-widest">Vrai</span>
                                        </div>
                                    </label>
                                    <label class="flex flex-col items-center justify-center p-10 bg-white rounded-3xl border-2 border-slate-100 hover:border-red-400 hover:bg-red-50/50 cursor-pointer transition-all duration-300 group shadow-sm hover:shadow-lg transform hover:-translate-y-1 relative overflow-hidden">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="Faux" class="hidden peer">
                                        <div class="absolute inset-0 bg-red-50/80 transform scale-y-0 peer-checked:scale-y-100 transition-transform duration-300 origin-bottom z-0"></div>
                                        <div class="relative z-10 flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-inner">
                                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </div>
                                            <span class="font-black text-xl text-slate-700 peer-checked:text-red-700 uppercase tracking-widest">Faux</span>
                                        </div>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-between items-center mt-12 pt-8 border-t border-slate-50">
                            @if($qIndex > 0)
                                <button type="button" onclick="showQuestion({{ $qIndex - 1 }})" class="px-6 py-3 text-slate-500 font-bold hover:text-slate-900 transition-all flex items-center gap-2">
                                    ← Précédent
                                </button>
                            @else
                                <div></div>
                            @endif

                            @if($qIndex < $quiz->questions->count() - 1)
                                <button type="button" onclick="showQuestion({{ $qIndex + 1 }})" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 flex items-center gap-2">
                                    Suivant →
                                </button>
                            @else
                                <button type="submit" class="px-10 py-4 bg-green-600 text-white font-bold rounded-2xl hover:bg-green-700 transition-all shadow-lg shadow-green-100 flex items-center gap-2">
                                    Terminer le Quiz 🏁
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </form>
    </main>

    <script>
        const duration = {{ $quiz->duration * 60 }}; // seconds
        let timeLeft = duration;
        const timerElement = document.getElementById('timer');
        const progressCircle = document.getElementById('progress-circle');
        const progressPercent = document.getElementById('progress-percent');
        const totalDash = 125.66;

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Update progress circle
            const offset = totalDash * (timeLeft / duration);
            progressCircle.style.strokeDashoffset = totalDash - offset;
            progressPercent.textContent = Math.round((timeLeft / duration) * 100) + '%';

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                alert('Temps écoulé! Votre quiz sera soumis automatiquement.');
                document.getElementById('quiz-form').submit();
            }
            timeLeft--;
        }

        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();

        function showQuestion(index) {
            document.querySelectorAll('.question-card').forEach(card => card.classList.remove('active'));
            document.querySelector(`.question-card[data-index="${index}"]`).classList.add('active');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>
