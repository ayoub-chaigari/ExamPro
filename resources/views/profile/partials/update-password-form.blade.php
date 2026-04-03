<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="space-y-6">
            {{-- Current Password --}}
            <div class="space-y-2">
                <x-input-label for="update_password_current_password" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1" :value="__('Mot de passe actuel')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 transition-all" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            {{-- New Password --}}
            <div class="space-y-2">
                <x-input-label for="update_password_password" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1" :value="__('Nouveau mot de passe')" />
                <x-text-input id="update_password_password" name="password" type="password" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 transition-all" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            {{-- Confirm Password --}}
            <div class="space-y-2">
                <x-input-label for="update_password_password_confirmation" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1" :value="__('Confirmer le mot de passe')" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 transition-all" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-[10px] shadow-xl shadow-blue-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest">
                Mettre à jour
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-[10px] font-black text-emerald-600 uppercase tracking-widest"
                >{{ __('Mot de passe mis à jour.') }}</p>
            @endif
        </div>
    </form>
</section>
