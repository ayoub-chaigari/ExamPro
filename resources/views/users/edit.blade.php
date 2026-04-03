<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight mb-2">
                {{ __('Modifier l\'Utilisateur') }}
            </h2>
            <p class="text-sm font-bold text-orange-500 uppercase tracking-widest">Mise à jour des accès de la plateforme</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-600/5 border border-gray-100 overflow-hidden">
            <div class="p-10">
                <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        {{-- Nom complet --}}
                        <div class="space-y-2">
                            <label for="name" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">Nom complet</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                                   class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 transition-all">
                            @error('name') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label for="email" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">Adresse Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                                   class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 transition-all">
                            @error('email') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        {{-- Rôle --}}
                        <div class="space-y-2">
                            <label for="role" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">Rôle & Permissions</label>
                            <select name="role" id="role" required class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 cursor-pointer transition-all">
                                <option value="teacher" {{ old('role', $user->role) == 'teacher' ? 'selected' : '' }}>Enseignant</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                            </select>
                            @error('role') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        {{-- Password --}}
                        <div class="space-y-2">
                            <label for="password" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] block pl-1">Mot de passe</label>
                            <input type="password" name="password" id="password" minlength="8" placeholder="Laisser vide pour conserver l'actuel"
                                   class="w-full bg-gray-50 border-none rounded-2xl p-4 text-xs font-black text-gray-800 focus:ring-2 focus:ring-blue-600 transition-all">
                            @error('password') <p class="text-red-500 text-[10px] font-black uppercase mt-1 tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="pt-10 flex items-center justify-end space-x-6 border-t border-gray-50">
                        <a href="{{ route('users.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">
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
