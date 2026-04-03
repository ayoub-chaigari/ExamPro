<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Générateur Exam - Plateforme en ligne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .hero-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 32px 32px;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-blue-200 selection:text-blue-900">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 glass-panel border-b border-slate-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                        <i data-lucide="graduation-cap" class="text-white w-6 h-6"></i>
                    </div>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-700 to-indigo-700 tracking-tight">
                        Générateur Exam
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="#quiz-access" class="hidden sm:block text-slate-600 font-semibold hover:text-blue-600 transition-colors">Rejoindre un Quiz</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-full transition-all shadow-md hover:shadow-xl hover:shadow-slate-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full transition-all shadow-lg shadow-blue-200 hover:shadow-blue-300">
                            Espace Enseignant
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-pattern">
        <!-- Background Blur Orbs -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                <!-- Text Content -->
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-blue-700 font-semibold text-sm mb-6 shadow-sm">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        Plateforme d'évaluation 2.0
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-6">
                        Passez vos examens en <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">toute simplicité</span>
                    </h1>
                    <p class="text-lg lg:text-xl text-slate-600 mb-10 leading-relaxed font-medium max-w-lg">
                        Une interface moderne et intuitive pour les enseignants et les étudiants. Créez, partagez et réussissez vos QCM en quelques clics.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#quiz-access" class="px-8 py-4 bg-slate-900 text-white font-bold rounded-full hover:bg-slate-800 hover:-translate-y-1 transition-all duration-300 shadow-xl shadow-slate-300 flex items-center justify-center gap-2 group">
                            Passer un Quiz
                            <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="#features" class="px-8 py-4 bg-white text-slate-700 font-bold rounded-full border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                            Découvrir <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400"></i>
                        </a>
                    </div>
                </div>

                <!-- Hero Image Container -->
                <div class="relative lg:ml-auto w-full max-w-lg select-none">
                    <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl shadow-blue-900/10 border-8 border-white transform rotate-2 hover:rotate-0 transition-all duration-500">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Students learning" class="w-full h-[500px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                    </div>
                    <!-- Floating Card -->
                    <div class="absolute -bottom-6 -left-6 glass-panel p-6 rounded-3xl shadow-2xl border border-white/40 transform -rotate-3 hover:translate-y-[-5px] transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                                <i data-lucide="check-circle-2" class="text-green-600 w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-500 uppercase">Correction Auto</p>
                                <p class="text-xl font-bold text-slate-900">Résultats Immédiats</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Quiz Access Section -->
    <section id="quiz-access" class="py-24 bg-white relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[3rem] p-10 lg:p-16 shadow-2xl shadow-blue-900/20 relative overflow-hidden">
                <!-- decorative circles -->
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-60 h-60 bg-indigo-400 opacity-20 rounded-full blur-2xl"></div>

                <div class="relative z-10 flex flex-col md:flex-row gap-12 items-center">
                    <div class="flex-1 text-white">
                        <h2 class="text-3xl lg:text-4xl font-extrabold mb-4 leading-tight">Prêt à tester vos <br>connaissances ?</h2>
                        <p class="text-blue-100 text-lg mb-8">Saisissez le code fourni par votre enseignant pour démarrer l'évaluation.</p>
                        
                        <div class="flex items-center gap-4 text-sm font-medium text-blue-200">
                            <span class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4"></i> Chronométré</span>
                            <span class="flex items-center gap-2"><i data-lucide="shield-check" class="w-4 h-4"></i> Sécurisé</span>
                        </div>
                    </div>

                    <div class="w-full max-w-md">
                        <div class="bg-white rounded-3xl p-8 shadow-xl">
                            @if(session('error'))
                                <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-2xl text-sm font-bold border border-red-100 flex items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('quizzes.access') }}" method="POST" class="space-y-5">
                                @csrf
                                <div>
                                    <label for="code" class="block text-sm font-bold text-slate-700 mb-2">Code du Quiz</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i data-lucide="hash" class="w-5 h-5 text-slate-400"></i>
                                        </div>
                                        <input type="text" name="code" id="code" placeholder="EX: QUIZ-123" required
                                            class="w-full pl-11 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-100 focus:bg-white text-slate-900 font-bold uppercase tracking-wider outline-none transition-all placeholder:font-normal placeholder:lowercase placeholder:tracking-normal">
                                    </div>
                                </div>
                                <div>
                                    <label for="student_name" class="block text-sm font-bold text-slate-700 mb-2">Votre Nom Complet</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                                        </div>
                                        <input type="text" name="student_name" id="student_name" placeholder="Ex: Jean Dupont" required
                                            class="w-full pl-11 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-100 focus:bg-white text-slate-900 font-semibold outline-none transition-all">
                                    </div>
                                </div>
                                <button type="submit" class="w-full py-4 mt-2 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all flex justify-center items-center gap-2">
                                    Démarrer le Quiz <i data-lucide="play" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-slate-50 border-t border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-sm font-bold text-blue-600 uppercase tracking-widest mb-3">Fonctionnalités</h2>
                <h3 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mb-6 leading-tight">Tout pour évaluer et réussir</h3>
                <p class="text-lg text-slate-600">Une suite complète d'outils conçus pour optimiser le processus de test pour tout le monde.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <i data-lucide="timer" class="w-7 h-7"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-3 text-slate-900">Temps Contrôlé</h4>
                    <p class="text-slate-600 leading-relaxed text-sm">Chaque évaluation dispose d'un chronomètre précis, assurant l'équité et le respect des délais imposés.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                        <i data-lucide="bar-chart-3" class="w-7 h-7"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-3 text-slate-900">Résultats Immédiats</h4>
                    <p class="text-slate-600 leading-relaxed text-sm">Correction automatique instantanée avec détails des réponses justes et fausses pour un apprentissage rapide.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <i data-lucide="database" class="w-7 h-7"></i>
                    </div>
                    <h4 class="text-xl font-bold mb-3 text-slate-900">Banque de Questions</h4>
                    <p class="text-slate-600 leading-relaxed text-sm">Les enseignants peuvent piocher dans une vaste bibliothèque de questions pour générer des quiz variés.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="graduation-cap" class="text-white w-5 h-5"></i>
                    </div>
                    <span class="text-lg font-bold text-slate-900">Générateur Exam</span>
                </div>
                <p class="text-slate-500 font-medium text-sm">
                    &copy; {{ date('Y') }} Tous droits réservés.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all">
                        <i data-lucide="github" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Navbar blur effect on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 20) {
                nav.classList.add('shadow-sm');
            } else {
                nav.classList.remove('shadow-sm');
            }
        });
    </script>
</body>
</html>
