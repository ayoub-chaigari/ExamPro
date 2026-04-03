<section class="space-y-6">
    <header>
        <h2 class="text-[10px] font-black text-red-600 uppercase tracking-[0.2em] mb-4">
            {{ __('Supprimer le compte') }}
        </h2>

        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-loose">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez télécharger toutes les données ou informations que vous souhaitez conserver avant de procéder.') }}
        </p>
    </header>

    <button 
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-50 hover:bg-red-600 text-red-600 hover:text-white px-8 py-4 rounded-2xl font-black text-[10px] transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest border border-red-100 shadow-sm"
    >
        {{ __('Supprimer mon compte') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-white rounded-[2.5rem]">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight mb-4 text-center">
                {{ __('Êtes-vous sûr ?') }}
            </h2>

            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-loose text-center mb-8">
                {{ __('Cette action est irréversible. Toutes vos données seront définitivement supprimées. Veuillez saisir votre mot de passe pour confirmer la suppression de votre compte.') }}
            </p>

            <div class="space-y-2 max-w-sm mx-auto">
                <x-input-label for="password" value="{{ __('Mot de passe') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-red-600 transition-all text-center"
                    placeholder="{{ __('Votre mot de passe') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[10px] font-black uppercase text-red-600" />
            </div>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="w-full sm:w-auto text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">
                    {{ __('Annuler') }}
                </button>

                <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-10 py-5 rounded-2xl font-black text-[10px] shadow-xl shadow-red-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest">
                    {{ __('Confirmer la suppression') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
