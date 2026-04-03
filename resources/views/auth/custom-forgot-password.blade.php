<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - OFPPT Exam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8 border-t-4 border-[#1E3A8A]">
        <div class="text-center mb-8">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="w-32 mx-auto mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Mot de passe oublié ?</h2>
            <p class="text-gray-600 mt-2">Pas de souci. Entrez votre email et nous vous enverrons un lien de réinitialisation.</p>
        </div>

        @if (session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                <p>{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('custom.password.email') }}">
            @csrf
            <div class="mb-6">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Adresse Email</label>
                <input type="email" name="email" id="email" 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent outline-none transition"
                       placeholder="votre@email.com" required value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    class="w-full bg-[#1E3A8A] hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md">
                Envoyer le lien
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="text-sm text-[#1E3A8A] hover:underline">Retour à la connexion</a>
        </div>
    </div>
</body>
</html>
