<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight mb-2">
                {{ __('Nouvel Examen') }}
            </h2>
            <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Configurer les paramètres de votre évaluation</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-600/5 border border-gray-100 overflow-hidden">
            <div class="p-10">
                <form action="{{ route('exams.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Type d'évaluation Section -->
                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block">Type d'évaluation</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="relative flex items-center p-5 rounded-2xl border-2 cursor-pointer transition-all group {{ old('type','efm')=='efm' ? 'border-blue-600 bg-blue-50/50' : 'border-gray-50 bg-gray-50/30 hover:border-gray-200' }}">
                                <input type="radio" name="type" value="efm" {{ old('type','efm')=='efm'?'checked':'' }} class="hidden peer">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 mr-4 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                                </div>
                                <div>
                                    <span class="block text-xs font-black text-gray-800 uppercase tracking-widest">EFM</span>
                                    <span class="block text-[10px] text-gray-400 font-bold uppercase mt-0.5">Fin de Module</span>
                                </div>
                            </label>

                            <label class="relative flex items-center p-5 rounded-2xl border-2 cursor-pointer transition-all group {{ old('type')=='examen' ? 'border-blue-600 bg-blue-50/50' : 'border-gray-50 bg-gray-50/30 hover:border-gray-200' }}">
                                <input type="radio" name="type" value="examen" {{ old('type')=='examen'?'checked':'' }} class="hidden peer">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-300 mr-4 flex items-center justify-center peer-checked:border-blue-600 peer-checked:bg-blue-600 transition-all">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                                </div>
                                <div>
                                    <span class="block text-xs font-black text-gray-800 uppercase tracking-widest">Examen</span>
                                    <span class="block text-[10px] text-gray-400 font-bold uppercase mt-0.5">Contrôle / Test</span>
                                </div>
                            </label>
                        </div>
                        @error('type') <p class="text-red-500 text-[10px] font-black uppercase mt-2 tracking-widest">{{ $message }}</p> @enderror
                    </div>

                    <div class="h-px bg-gray-50 w-full"></div>

                    <!-- Main Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Titre --}}
                        <div class="md:col-span-2 space-y-2">
                            <label for="title" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">Intitulé du module</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Ex: Développement Front-end"
                                   class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 placeholder-gray-300 transition-all">
                            @error('title') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        {{-- Matière --}}
                        <div class="space-y-2">
                            <label for="category_id" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">Filière / Matière</label>
                            <select name="category_id" id="category_id" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 cursor-pointer transition-all">
                                <option value="" disabled selected>Choisir une matière</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        {{-- Niveau --}}
                        <div class="space-y-2">
                            <label for="niveau" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">Niveau</label>
                            <input type="text" name="niveau" id="niveau" value="{{ old('niveau') }}" placeholder="Ex: TS - 2ème Année"
                                   class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 placeholder-gray-300 transition-all">
                            @error('niveau') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        {{-- N° Module --}}
                        <div class="space-y-2">
                            <label for="module_no" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">N° du Module</label>
                            <input type="text" name="module_no" id="module_no" value="{{ old('module_no') }}" placeholder="Ex: M201"
                                   class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 placeholder-gray-300 transition-all">
                            @error('module_no') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        {{-- Durée --}}
                        <div class="space-y-2">
                            <label for="duration" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">Durée (Minutes)</label>
                            <input type="number" name="duration" id="duration" value="{{ old('duration') }}" required min="1"
                                   class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 placeholder-gray-300 transition-all">
                            @error('duration') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="pt-10 flex items-center justify-end space-x-6 border-t border-gray-50">
                        <a href="{{ route('exams.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">
                            Annuler l'opération
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-5 rounded-2xl font-black text-[10px] shadow-xl shadow-blue-600/20 transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest">
                            Créer l'examen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
