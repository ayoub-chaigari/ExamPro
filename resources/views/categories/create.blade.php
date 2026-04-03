<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Ajouter une Filière / Niveau') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 max-w-2xl mx-auto mt-6">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" id="type" required 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="" disabled selected>Sélectionnez un type</option>
                    <option value="subject" {{ old('type') == 'subject' ? 'selected' : '' }}>Matière (Module)</option>
                    <option value="level" {{ old('type') == 'level' ? 'selected' : '' }}>Niveau (Filière/Année)</option>
                </select>
                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">Annuler</a>
                <button type="submit" class="px-4 py-2 bg-[#1E3A8A] text-white rounded-md hover:bg-blue-800 transition">Enregistrer</button>
            </div>
        </form>
    </div>
</x-app-layout>
