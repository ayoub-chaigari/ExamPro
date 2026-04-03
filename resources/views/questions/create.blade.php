<x-app-layout>
    <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-black text-slate-900 dark:text-white uppercase tracking-tight mb-2">
                {{ __('Ajouter une Question') }}
            </h2>
            <p class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Enrichissez votre banque de questions personnalisée</p>
        </div>

        <div class="bg-white dark:bg-premium-card rounded-[2.5rem] shadow-xl shadow-blue-600/5 border border-slate-100 dark:border-premium-border/50 overflow-hidden transition-colors">
            <div class="p-10">
                <form action="{{ route('questions.store') }}" method="POST" id="questionForm" class="space-y-10">
                    @csrf

                    <!-- Core Settings Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Matière --}}
                        <div class="space-y-2">
                            <label for="category_id" class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] block pl-1">Matière / Filière</label>
                            <select name="category_id" id="category_id" required class="w-full bg-slate-50 dark:bg-premium-bg border-none rounded-2xl p-4 text-xs font-black text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 cursor-pointer transition-all">
                                <option value="" disabled selected>Choisir une matière</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Type --}}
                        <div class="space-y-2">
                            <label for="type" class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] block pl-1">Type de l'élément</label>
                            <select name="type" id="type" required class="w-full bg-slate-50 dark:bg-premium-bg border-none rounded-2xl p-4 text-xs font-black text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 cursor-pointer transition-all" onchange="toggleType()">
                                <option value="open">Question Ouverte</option>
                                <option value="mcq">QCM (Choix Multiples)</option>
                                <option value="tf">Vrai / Faux</option>
                                <option value="consigne">Consigne (Texte informatif)</option>
                            </select>
                        </div>

                        {{-- Points --}}
                        <div id="points_container" class="space-y-2">
                            <label for="points" class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] block pl-1">Points (Barème)</label>
                            <input type="number" step="0.5" name="points" id="points" value="{{ old('points', 1) }}" 
                                   class="w-full bg-slate-50 dark:bg-premium-bg border-none rounded-2xl p-4 text-xs font-black text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 transition-all">
                        </div>

                        {{-- Niveau --}}
                        <div class="space-y-2">
                            <label for="level" class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] block pl-1">Difficulté</label>
                            <select name="level" id="level" required class="w-full bg-slate-50 dark:bg-premium-bg border-none rounded-2xl p-4 text-xs font-black text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-600 cursor-pointer transition-all uppercase tracking-widest">
                                <option value="Beginner" {{ old('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="Intermediate" {{ old('level') == 'Intermediate' || !old('level') ? 'selected' : '' }}>Intermediate</option>
                                <option value="Advanced" {{ old('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>
                    </div>

                    {{-- Question Content --}}
                    <div class="space-y-3">
                        <div class="flex items-center justify-between pl-1">
                            <label for="content" class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] block">Énoncé de la question</label>
                            <span id="consigne_hint" class="hidden text-[9px] font-bold text-blue-500 uppercase tracking-wider animate-pulse">✨ Utilisez l'éditeur pour insérer des tableaux ou des images</span>
                        </div>
                        <div class="rounded-2xl border border-slate-200 dark:border-premium-border/50 shadow-inner bg-white dark:bg-premium-bg">
                            <textarea name="content" id="content" rows="6" required class="w-full border-none focus:ring-0 min-h-[200px] p-4 text-slate-800 dark:text-slate-100 bg-transparent"></textarea>
                        </div>
                    </div>

                    <!-- Dynamic Options Sections -->
                    <div class="space-y-6">
                        <!-- Options Question Ouverte -->
                        <div id="open_options" class="bg-blue-50/30 rounded-[2rem] p-8 border border-blue-50">
                            <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-6">Mise en page PDF</h4>
                            <div class="space-y-6">
                                <label class="flex items-center space-x-4 cursor-pointer group">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" name="requires_answer_space" id="requires_answer_space" value="1" class="peer h-6 w-6 rounded-lg border-gray-300 bg-white text-blue-600 focus:ring-0 focus:ring-offset-0 transition-all cursor-pointer" onchange="toggleAnswerSize()">
                                        <div class="absolute inset-0 bg-blue-600 rounded-lg scale-0 peer-checked:scale-100 transition-transform duration-200 pointer-events-none flex items-center justify-center">
                                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </div>
                                    <span class="text-xs font-black text-gray-600 uppercase tracking-widest group-hover:text-blue-600 transition-colors">Réserver un espace pour la réponse</span>
                                </label>
                                
                                <div id="answer_size_container" class="hidden space-y-2 animate-fadeIn">
                                    <label for="answer_space_size" class="text-[10px] font-black text-gray-400 uppercase tracking-widest block pl-1">Taille de l'espace</label>
                                    <select name="answer_space_size" id="answer_space_size" class="w-full md:w-1/2 bg-white border-2 border-blue-100 rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 cursor-pointer transition-all">
                                        <option value="small">Compact (~2 lignes)</option>
                                        <option value="medium">Standard (~5 lignes)</option>
                                        <option value="large">Spacieux (~10 lignes)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Options pour QCM -->
                        <div id="mcq_options" class="hidden bg-gray-50/50 rounded-[2rem] p-8 border border-gray-100">
                            <div class="flex items-center justify-between mb-8">
                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Options multiples</h4>
                                <button type="button" onclick="addOption()" class="bg-white hover:bg-blue-600 hover:text-white text-blue-600 px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest border border-blue-100 shadow-sm transition-all active:scale-95">
                                    + Ajouter
                                </button>
                            </div>
                            
                            <div id="options_container" class="space-y-4 mb-8">
                                <div class="flex items-center space-x-3 group">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-[10px] font-black text-gray-400 uppercase tracking-tighter shadow-sm group-hover:border-blue-600 transition-all">A</div>
                                    <input type="text" name="options[]" class="flex-1 bg-white border-none rounded-xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 shadow-sm" placeholder="Saisir l'option...">
                                </div>
                                <div class="flex items-center space-x-3 group">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-[10px] font-black text-gray-400 uppercase tracking-tighter shadow-sm group-hover:border-blue-600 transition-all">B</div>
                                    <input type="text" name="options[]" class="flex-1 bg-white border-none rounded-xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 shadow-sm" placeholder="Saisir l'option...">
                                </div>
                            </div>
                            
                            <div class="pt-8 border-t border-slate-100 dark:border-premium-border/30 transition-colors">
                                <label for="mcq_correct" class="text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest block mb-2 pl-1">Réponse correcte</label>
                                <select name="correct_answer_mcq" id="mcq_correct" 
                                       class="w-full bg-white dark:bg-premium-bg border-2 border-emerald-100 dark:border-emerald-500/30 rounded-xl p-4 text-xs font-black text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-emerald-500 shadow-sm transition-all cursor-pointer">
                                    <option value="A">OPTION A</option>
                                    <option value="B">OPTION B</option>
                                    <option value="C">OPTION C</option>
                                    <option value="D">OPTION D</option>
                                </select>
                            </div>
                        </div>

                        <!-- Options pour Vrai/Faux -->
                        <div id="tf_options" class="hidden bg-gray-50/50 rounded-[2rem] p-8 border border-gray-100">
                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 text-center">Sélectionnez la réponse correcte</h4>
                            <div class="grid grid-cols-2 gap-6 max-w-md mx-auto">
                                <label class="relative flex items-center justify-center p-6 rounded-2xl border-2 cursor-pointer transition-all group border-gray-50 bg-white hover:border-gray-200">
                                    <input type="radio" name="correct_answer_tf" value="Vrai" class="peer hidden">
                                    <div class="absolute inset-0 border-2 border-emerald-500 rounded-2xl scale-0 peer-checked:scale-100 transition-transform duration-300"></div>
                                    <div class="relative z-10 flex flex-col items-center">
                                        <div class="w-4 h-4 rounded-full border-2 border-gray-300 mb-2 flex items-center justify-center peer-checked:border-emerald-500 peer-checked:bg-emerald-500 transition-all">
                                            <div class="w-1 h-1 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                                        </div>
                                        <span class="text-xs font-black text-gray-600 uppercase tracking-widest peer-checked:text-emerald-600 transition-colors">Vrai</span>
                                    </div>
                                </label>
                                <label class="relative flex items-center justify-center p-6 rounded-2xl border-2 cursor-pointer transition-all group border-gray-50 bg-white hover:border-gray-200">
                                    <input type="radio" name="correct_answer_tf" value="Faux" class="peer hidden">
                                    <div class="absolute inset-0 border-2 border-red-500 rounded-2xl scale-0 peer-checked:scale-100 transition-transform duration-300"></div>
                                    <div class="relative z-10 flex flex-col items-center">
                                        <div class="w-4 h-4 rounded-full border-2 border-gray-300 mb-2 flex items-center justify-center peer-checked:border-red-500 peer-checked:bg-red-500 transition-all">
                                            <div class="w-1 h-1 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                                        </div>
                                        <span class="text-xs font-black text-gray-600 uppercase tracking-widest peer-checked:text-red-600 transition-colors">Faux</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Text Variations / Alternate Formulations -->
                        <div id="variations_container" class="bg-indigo-50/30 dark:bg-indigo-900/10 rounded-[2rem] p-8 border border-indigo-100 dark:border-indigo-900/30 shadow-sm">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h4 class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-[0.2em] mb-1">Variantes de l'énoncé</h4>
                                    <p class="text-[9px] font-bold text-indigo-400/80 uppercase">Formulations alternatives pour les variantes d'examen</p>
                                </div>
                                <button type="button" onclick="addTextVariant()" class="bg-white dark:bg-indigo-900/20 hover:bg-indigo-600 hover:text-white text-indigo-600 dark:text-indigo-400 px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest border border-indigo-100 dark:border-indigo-900/30 shadow-sm transition-all active:scale-95 flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Ajouter
                                </button>
                            </div>
                            
                            <div id="text_variants_list" class="space-y-4">
                                <!-- Dynamic variations added here -->
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="pt-10 flex items-center justify-end space-x-6 border-t border-gray-50 dark:border-slate-700">
                        <a href="{{ route('questions.index') }}" class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                            Abandonner
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-5 rounded-2xl font-black text-[10px] shadow-xl shadow-blue-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest">
                            Enregistrer la question
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleType() {
            const type = document.getElementById('type').value;
            const mcqDiv = document.getElementById('mcq_options');
            const tfDiv = document.getElementById('tf_options');
            const openDiv = document.getElementById('open_options');
            const pointsDiv = document.getElementById('points_container');
            const variationsDiv = document.getElementById('variations_container');
            const consigneHint = document.getElementById('consigne_hint');

            mcqDiv.classList.add('hidden');
            tfDiv.classList.add('hidden');
            openDiv.classList.add('hidden');
            pointsDiv.classList.remove('hidden');
            variationsDiv.classList.add('hidden');
            if (consigneHint) consigneHint.classList.add('hidden');

            if (type === 'mcq') {
                mcqDiv.classList.remove('hidden');
            } else if (type === 'tf') {
                tfDiv.classList.remove('hidden');
            } else if (type === 'open') {
                openDiv.classList.remove('hidden');
                variationsDiv.classList.remove('hidden');
            } else if (type === 'consigne') {
                pointsDiv.classList.add('hidden');
                if (consigneHint) consigneHint.classList.remove('hidden');
            }
        }

        function toggleAnswerSize() {
            const isChecked = document.getElementById('requires_answer_space').checked;
            const sizeContainer = document.getElementById('answer_size_container');
            if (isChecked) {
                sizeContainer.classList.remove('hidden');
            } else {
                sizeContainer.classList.add('hidden');
            }
        }

        function addOption() {
            const container = document.getElementById('options_container');
            const count = container.children.length;
            const letter = String.fromCharCode(65 + count);
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-3 group animate-fadeIn';
            div.innerHTML = `
                <div class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-[10px] font-black text-gray-400 uppercase tracking-tighter shadow-sm group-hover:border-blue-600 transition-all font-inter">${letter}</div>
                <input type="text" name="options[]" class="flex-1 bg-white border-none rounded-xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 shadow-sm" placeholder="Saisir l'option...">
            `;
            container.appendChild(div);
        }

        function addTextVariant(value = '') {
            const container = document.getElementById('text_variants_list');
            const div = document.createElement('div');
            div.className = 'flex items-start gap-4 p-5 bg-indigo-50/10 dark:bg-indigo-900/10 rounded-2xl border border-indigo-100 dark:border-indigo-900/30 group animate-in slide-in-from-top-2 duration-300';
            div.innerHTML = `
                <div class="flex-1">
                    <textarea name="text_variants[]" class="w-full bg-white dark:bg-premium-bg border-2 border-indigo-100/50 dark:border-indigo-900/30 rounded-xl p-4 text-sm font-bold text-indigo-700 dark:text-indigo-300 focus:ring-indigo-500 focus:border-indigo-500 transition-all" rows="2" placeholder="Saisissez une formulation alternative...">${value}</textarea>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            `;
            container.appendChild(div);
        }

        function aiRephrase() {
            const content = tinymce.get('content').getContent({format: 'text'});
            if (!content || content.trim().length < 5) {
                alert('Veuillez saisir un contenu de question d\'abord.');
                return;
            }

            const btn = document.getElementById('ai_rephrase_btn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="animate-spin mr-2">⏳</span> REFORMULATION...';

            fetch("{{ route('questions.rephrase') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content: content })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                if (data.success) {
                    addTextVariant(data.rephrased);
                } else {
                    alert('Erreur lors de la reformulation.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                alert('Erreur de connexion au service IA.');
            });
        }

        document.getElementById('questionForm').addEventListener('submit', function(e) {
            const type = document.getElementById('type').value;
            if (type === 'tf') {
                const tfVal = document.querySelector('input[name="correct_answer_tf"]:checked');
                if(tfVal) {
                    let hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'correct_answer';
                    hiddenInput.value = tfVal.value;
                    this.appendChild(hiddenInput);
                }
            }
        });

        // init
        toggleType();
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        function initializeTinyMCE() {
            if (typeof tinymce === 'undefined') return;

            const isDark = document.documentElement.classList.contains('dark');

            tinymce.init({
                selector: '#content',
                plugins: 'table lists link image code',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | table image | code',
                menubar: 'file edit view insert format tools table',
                height: 400,
                skin: isDark ? 'oxide-dark' : 'oxide',
                content_css: isDark ? 'dark' : 'default',
                branding: false,
                promotion: false,
                content_style: 'body { font-family: Inter, sans-serif; font-size: 14px; color: ' + (isDark ? '#e2e8f0' : '#374151') + '; font-weight: 600; } table { border-collapse: collapse; width: 100%; } table td, table th { border: 1px solid #ddd; padding: 8px; }',
                automatic_uploads: true,
                images_upload_handler: function (blobInfo, progress) {
                    return new Promise((resolve, reject) => {
                        var xhr = new XMLHttpRequest();
                        xhr.withCredentials = false;
                        xhr.open('POST', '{{ route('questions.upload-image') }}');
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        
                        xhr.onload = function() {
                            if (xhr.status < 200 || xhr.status >= 300) {
                                reject('HTTP Error: ' + xhr.status);
                                return;
                            }
                            var json = JSON.parse(xhr.responseText);
                            if (!json || typeof json.location != 'string') {
                                reject('Invalid JSON: ' + xhr.responseText);
                                return;
                            }
                            resolve(json.location);
                        };
                        
                        var formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        xhr.send(formData);
                    });
                },
                setup: function (editor) {
                    editor.on('change', function () {
                        tinymce.triggerSave();
                    });
                }
            });
        }

        window.addEventListener('load', initializeTinyMCE);
    </script>
</x-app-layout>
