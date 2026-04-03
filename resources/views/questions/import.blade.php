<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight tracking-tight uppercase">
                Importer des Questions
            </h2>
            <a href="{{ route('questions.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 dark:bg-premium-bg border border-transparent rounded-xl font-bold text-xs text-slate-600 dark:text-slate-400 uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-premium-border transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Error Summary --}}
            @if ($errors->any())
                <div class="mb-8 p-6 bg-rose-50 dark:bg-rose-900/20 border-l-4 border-rose-500 rounded-2xl shadow-sm">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-rose-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h3 class="text-sm font-black text-rose-800 dark:text-rose-400 uppercase tracking-wider">Erreurs d'importation</h3>
                    </div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-xs font-bold text-rose-600/80 dark:text-rose-400/80">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-premium-card overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-none border border-slate-100 dark:border-premium-border/50 rounded-[2.5rem] p-8 sm:p-12 transition-all">
                
                <div class="mb-10 text-center">
                    <div class="w-20 h-20 bg-blue-50 dark:bg-blue-900/20 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tight mb-2">Charger votre fichier</h3>
                    <p class="text-sm font-bold text-slate-400 max-w-sm mx-auto">Importez vos questions en masse via un fichier Excel (.xlsx) ou CSV.</p>
                </div>

                <form action="{{ route('questions.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    
                    <div class="relative group">
                        <label class="block mb-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-4">Fichier (Max 10Mo)</label>
                        <div class="relative border-4 border-dashed border-slate-100 dark:border-premium-border/50 rounded-[2rem] p-10 text-center hover:border-blue-500/30 dark:hover:border-blue-400/30 transition-all group-hover:bg-slate-50/50 dark:group-hover:bg-premium-bg/30">
                            <input type="file" name="file" id="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                            <div class="space-y-2">
                                <span class="block text-sm font-black text-slate-600 dark:text-slate-300 transition-colors group-hover:text-blue-600 dark:group-hover:text-blue-400">Glissez-déposez le fichier ici</span>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Ou cliquez pour sélectionner</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 dark:bg-premium-bg/50 rounded-3xl p-6 border border-slate-100 dark:border-premium-border/20">
                        <h4 class="text-[10px] font-black text-slate-800 dark:text-white uppercase tracking-[0.2em] mb-4 flex items-center opacity-70">
                            <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Structure du fichier requise
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach(['question_text', 'type', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'level', 'subject'] as $col)
                                <div class="px-3 py-2 bg-white dark:bg-premium-card rounded-xl border border-slate-100 dark:border-premium-border/30 text-[10px] font-black text-slate-500 dark:text-slate-400 truncate">
                                    {{ $col }}
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-4 text-[10px] font-bold text-slate-400 leading-relaxed uppercase tracking-widest italic">
                            Les colonnes <span class="text-blue-500">question_text</span>, <span class="text-blue-500">type</span> (qcm/true_false), <span class="text-blue-500">correct_answer</span> et <span class="text-blue-500">subject</span> sont obligatoires.
                        </p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-blue-600/20 hover:translate-y-[-2px] hover:shadow-2xl hover:shadow-blue-600/30 transition-all uppercase tracking-widest text-xs">
                            Démarrer l'importation
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Simple file name display (optional enhancement)
        const fileInput = document.getElementById('file');
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                const label = this.nextElementSibling.querySelector('span');
                label.innerText = `Fichier sélectionné : ${fileName}`;
                label.classList.add('text-blue-600');
            }
        });
    </script>
</x-app-layout>
