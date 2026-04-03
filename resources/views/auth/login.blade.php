<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-slate-800 tracking-tight flex-col flex items-center gap-4">
            <div class="w-20 h-20 bg-white rounded-2xl shadow-xl shadow-blue-900/10 flex items-center justify-center p-3 border border-slate-100 mb-2">
                <img src="{{ asset('logo.png') }}" alt="OFPPT Logo" class="w-full h-full object-contain">
            </div>
            Bienvenue
        </h2>
        <p class="text-slate-500 mt-2 text-sm font-medium">Connectez-vous à votre espace enseignant</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-bold text-sm text-slate-700 mb-2">{{ __('Adresse Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white text-slate-900 font-medium transition-all outline-none" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="exemple@ofppt.ma" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 font-semibold text-sm" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block font-bold text-sm text-slate-700">{{ __('Mot de passe') }}</label>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white text-slate-900 font-medium transition-all outline-none"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 font-semibold text-sm" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <div class="relative flex items-center">
                    <input id="remember_me" type="checkbox" class="peer h-5 w-5 rounded border-slate-300 bg-slate-50 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer transition-all" name="remember">
                </div>
                <span class="ms-2 text-sm font-semibold text-slate-600 group-hover:text-blue-600 transition-colors">{{ __('Se souvenir de moi') }}</span>
            </label>

            @if (Route::has('custom.password.request'))
                <a class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors" href="{{ route('custom.password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 active:bg-blue-800 focus:ring-4 focus:ring-blue-200 transition-all shadow-lg shadow-blue-600/20 transform active:scale-[0.98] flex items-center justify-center gap-2">
                {{ __('Se Connecter') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
            </button>
        </div>
    </form>
</x-guest-layout>
