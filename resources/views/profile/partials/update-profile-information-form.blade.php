<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <div class="space-y-6">
            {{-- Name --}}
            <div class="space-y-2">
                <x-input-label for="name" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1" :value="__('Nom')" />
                <x-text-input id="name" name="name" type="text" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 transition-all" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            {{-- Email --}}
            <div class="space-y-2">
                <x-input-label for="email" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1" :value="__('Adresse Email')" />
                <x-text-input id="email" name="email" type="email" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 transition-all" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="bg-amber-50 rounded-xl p-4 border border-amber-100 mt-4">
                        <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest leading-loose">
                            {{ __('Votre adresse e-mail n\'est pas vérifiée.') }}
                            <button form="send-verification" class="block mt-1 underline hover:text-amber-700 transition-colors uppercase">
                                {{ __('Cliquez ici pour renvoyer l\'e-mail de vérification.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-3 text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                                {{ __('Un nouveau lien de vérification a été envoyé.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-6 pt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-[10px] shadow-xl shadow-blue-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest">
                Enregistrer
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-[10px] font-black text-emerald-600 uppercase tracking-widest"
                >{{ __('Modifications enregistrées.') }}</p>
            @endif
        </div>
    </form>
</section>
