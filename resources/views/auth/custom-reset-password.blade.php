<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - OFPPT Exam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 border-t-4 border-[#1E3A8A]">
        <div class="text-center mb-8">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="w-32 mx-auto mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Nouveau mot de passe</h2>
            <p class="text-gray-600 mt-2">Veuillez entrer votre nouveau mot de passe ci-dessous.</p>
        </div>

        <form method="POST" action="{{ route('custom.password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ request()->get('email') }}">

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent outline-none transition"
                       required autocomplete="new-password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent outline-none transition"
                       required autocomplete="new-password">
            </div>

            <button type="submit" 
                    class="w-full bg-[#1E3A8A] hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md">
                Réinitialiser le mot de passe
            </button>
        </form>
    </div>
</body>
</html>
