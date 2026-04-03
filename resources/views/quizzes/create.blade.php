<x-app-layout>
    <x-slot name="header">
        {{ __('Créer un Nouveau Quiz') }}
    </x-slot>

<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('quizzes.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Titre du Quiz</label>
                        <input type="text" name="title" required placeholder="Ex: QCM Mathématiques"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Durée (minutes)</label>
                        <input type="number" name="duration" required min="1" placeholder="Ex: 30"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-4">Sélectionner les Questions</label>
                    <div class="space-y-3 max-h-96 overflow-y-auto pr-2 custom-scrollbar border border-gray-100 rounded-xl p-4 bg-gray-50">
                        @foreach($questions as $question)
                            <label class="flex items-start p-4 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 transition-all group">
                                <input type="checkbox" name="questions[]" value="{{ $question->id }}" class="mt-1 w-5 h-5 text-blue-600 rounded-md border-gray-300 focus:ring-blue-500">
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-800 group-hover:text-blue-700 transition-colors">{{ Str::limit($question->content, 150) }}</div>
                                    <div class="mt-1 flex gap-3">
                                        <span class="px-2 py-0.5 bg-gray-100 text-[10px] font-bold uppercase rounded-md text-gray-600">{{ $question->type }}</span>
                                        <span class="px-2 py-0.5 bg-blue-50 text-[10px] font-bold uppercase rounded-md text-blue-600">{{ $question->category->name ?? 'Catégorie' }}</span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('questions')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-50">
                    <a href="{{ route('quizzes.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition-all">Annuler</a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                        Créer le Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
