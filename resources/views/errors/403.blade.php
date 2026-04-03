<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Accès Interdit</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
    </style>
</head>
<body class="h-full bg-slate-50 flex items-center justify-center p-6 overflow-hidden">
    <!-- Background Decor -->
    <div class="fixed top-0 left-0 w-full h-full -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-100 rounded-full blur-[120px] opacity-60"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-orange-100 rounded-full blur-[120px] opacity-60"></div>
    </div>

    <div class="max-w-md w-full text-center">
        <!-- Icon Container -->
        <div class="relative mb-8 inline-block">
            <div class="absolute inset-0 bg-blue-100 rounded-full blur-2xl opacity-50 animate-pulse-slow"></div>
            <div class="relative bg-white p-8 rounded-full shadow-2xl border border-blue-50 animate-float">
                <svg class="w-20 h-20 text-ofppt-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #1E3A8A;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <!-- Forbidden badge -->
            <div class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full px-3 py-1 text-xs font-bold shadow-lg transform rotate-12">
                REFUSÉ
            </div>
        </div>

        <!-- Content -->
        <h1 class="text-9xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#1E3A8A] to-[#1E3A8A]/60 mb-4 tracking-tighter">
            403
        </h1>
        
        <h2 class="text-3xl font-bold text-slate-800 mb-4">Oups ! Accès Restreint</h2>
        
        <div class="glass p-6 rounded-2xl shadow-xl mb-8 transform transition hover:scale-[1.02]">
            <p class="text-slate-600 font-medium leading-relaxed">
                {{ $exception->getMessage() ?: "Désolé, vous n'avez pas les autorisations nécessaires pour accéder à cet espace." }}
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url()->previous() }}" class="flex items-center px-6 py-3 bg-white text-slate-700 font-bold rounded-xl shadow-md hover:shadow-lg transition-all border border-slate-100 active:scale-95 group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center px-8 py-3 bg-[#1E3A8A] text-white font-bold rounded-xl shadow-lg hover:bg-blue-900 transition-all hover:shadow-xl active:scale-95 group" style="background-color: #1E3A8A;">
                Tableau de bord
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>

        <!-- Footer Footer -->
        <p class="mt-12 text-slate-400 text-sm font-medium">
            &copy; {{ date('Y') }} Exam Manager - Tous droits réservés.
        </p>
    </div>
</body>
</html>
