<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-slate-800 tracking-tight flex-col flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl shadow-sm flex items-center justify-center border border-blue-100 mb-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            </div>
            Mot de passe oublié ?
        </h2>
        <p class="text-slate-500 mt-4 text-sm font-medium leading-relaxed">
            {{ __('Aucun problème. Indiquez simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation de mot de passe qui vous permettra d\'en choisir un nouveau.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-bold text-sm text-slate-700 mb-2">{{ __('Adresse Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white text-slate-900 font-medium transition-all outline-none" type="email" name="email" :value="old('email')" required autofocus placeholder="exemple@ofppt.ma" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 font-semibold text-sm" />
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
            <a class="text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors" href="{{ route('login') }}">
                {{ __('Retour à la connexion') }}
            </a>

            <button type="submit" class="w-full sm:w-auto px-6 py-3.5 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 active:bg-blue-800 focus:ring-4 focus:ring-blue-200 transition-all shadow-lg shadow-blue-600/20 transform active:scale-[0.98]">
                {{ __('Envoyer le lien') }}
            </button>
        </div>
    </form>
</x-guest-layout>
