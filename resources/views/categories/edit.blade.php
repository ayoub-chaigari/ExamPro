<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight mb-2">
                {{ __('Modifier la Catégorie') }}
            </h2>
            <p class="text-sm font-bold text-orange-500 uppercase tracking-widest">Ajustez les paramètres de structure</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-600/5 border border-gray-100 overflow-hidden">
            <div class="p-10">
                <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        {{-- Nom --}}
                        <div class="space-y-2">
                            <label for="name" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">Intitulé</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required 
                                   class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 transition-all">
                            @error('name') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        {{-- Type --}}
                        <div class="space-y-2">
                            <label for="type" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">Type de structure</label>
                            <select name="type" id="type" required 
                                    class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 cursor-pointer transition-all">
                                <option value="subject" {{ old('type', $category->type) == 'subject' ? 'selected' : '' }}>Matière (Module)</option>
                                <option value="level" {{ old('type', $category->type) == 'level' ? 'selected' : '' }}>Niveau (Filière/Année)</option>
                            </select>
                            @error('type') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="pt-10 flex items-center justify-end space-x-6 border-t border-gray-50">
                        <a href="{{ route('categories.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-10 py-5 rounded-2xl font-black text-[10px] shadow-xl shadow-orange-500/20 transition-all transform hover:-translate-y-1 active:translate-y-0 uppercase tracking-widest">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
