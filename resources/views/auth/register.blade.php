<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-slate-800 tracking-tight flex-col flex items-center gap-4">
            <div class="w-20 h-20 bg-white rounded-2xl shadow-xl shadow-blue-900/10 flex items-center justify-center p-3 border border-slate-100 mb-2">
                <img src="{{ asset('logo.png') }}" alt="OFPPT Logo" class="w-full h-full object-contain">
            </div>
            Créer un compte
        </h2>
        <p class="text-slate-500 mt-2 text-sm font-medium">Rejoignez l'espace enseignant</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-bold text-sm text-slate-700 mb-2">{{ __('Nom complet') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input id="name" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white text-slate-900 font-medium transition-all outline-none" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 font-semibold text-sm" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-bold text-sm text-slate-700 mb-2">{{ __('Adresse Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white text-slate-900 font-medium transition-all outline-none" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="exemple@ofppt.ma" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 font-semibold text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-bold text-sm text-slate-700 mb-2">{{ __('Mot de passe') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white text-slate-900 font-medium transition-all outline-none"
                                type="password"
                                name="password"
                                required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 font-semibold text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block font-bold text-sm text-slate-700 mb-2">{{ __('Confirmer le mot de passe') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password_confirmation" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white text-slate-900 font-medium transition-all outline-none"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 font-semibold text-sm" />
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
            <a class="text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors" href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>

            <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 active:bg-blue-800 focus:ring-4 focus:ring-blue-200 transition-all shadow-lg shadow-blue-600/20 transform active:scale-[0.98]">
                {{ __('S\'inscrire') }}
            </button>
        </div>
    </form>
</x-guest-layout>
