<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Résultats : {{ $quiz->title }}
        </h2>
    </x-slot>

<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Classement des Participants</h1>
                <div class="flex items-center gap-3 mt-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-black uppercase tracking-widest border border-blue-200">
                        Code Quiz : {{ $quiz->code }}
                    </span>
                    <span class="text-slate-500 text-sm font-medium">Partagez ce code avec vos étudiants</span>
                </div>
            </div>
            <a href="{{ route('quizzes.index') }}" class="px-6 py-3 bg-white text-slate-700 border border-slate-200 font-bold rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white/80 backdrop-blur-xl p-8 rounded-[2rem] border border-white shadow-xl shadow-blue-900/5 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-20 group-hover:scale-110 group-hover:opacity-30 transition-all duration-500">
                    <svg class="w-24 h-24 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 relative z-10">Participants</p>
                <div class="text-5xl font-black text-slate-800 tracking-tight relative z-10"><span class="text-blue-600">{{ count($results) }}</span><span class="text-xl text-slate-300 ml-1">/ 20</span></div>
            </div>
            
            <div class="bg-white/80 backdrop-blur-xl p-8 rounded-[2rem] border border-white shadow-xl shadow-green-900/5 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-20 group-hover:scale-110 group-hover:opacity-30 transition-all duration-500">
                    <svg class="w-24 h-24 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 relative z-10">Moyenne Globale</p>
                <div class="text-5xl font-black text-slate-800 tracking-tight relative z-10">
                    <span class="text-transparent bg-clip-text bg-gradient-to-br from-green-500 to-emerald-600">
                        {{ count($results) > 0 ? round(collect($results)->avg('score'), 1) : 0 }}%
                    </span>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-xl p-8 rounded-[2rem] border border-white shadow-xl shadow-purple-900/5 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-6 opacity-20 group-hover:scale-110 group-hover:opacity-30 transition-all duration-500">
                    <svg class="w-24 h-24 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 relative z-10">Questions</p>
                <div class="text-5xl font-black text-slate-800 tracking-tight relative z-10"><span class="text-purple-600">{{ $quiz->questions->count() }}</span></div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-2xl shadow-slate-200/50 sm:rounded-[2.5rem] border border-slate-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Rang</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Participant</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Score</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Bonnes Rép.</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($results as $index => $result)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-black text-sm shadow-sm
                                        {{ $index === 0 ? 'bg-gradient-to-br from-yellow-100 to-yellow-200 text-yellow-800 border-2 border-yellow-300' : 
                                          ($index === 1 ? 'bg-gradient-to-br from-slate-100 to-slate-200 text-slate-700 border-2 border-slate-300' : 
                                          ($index === 2 ? 'bg-gradient-to-br from-orange-100 to-orange-200 text-orange-800 border-2 border-orange-300' : 
                                          'bg-slate-50 text-slate-500 border-2 border-slate-100 group-hover:border-slate-200')) }}">
                                        {{ $index + 1 }}
                                    </div>
                                </td>
                                <td class="px-8 py-5 font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $result['name'] }}</td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black tracking-widest uppercase shadow-sm
                                        {{ $result['score'] >= 50 ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                        {{ $result['score'] }}%
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-sm font-bold text-slate-600">
                                    {{ $result['correct'] }} <span class="text-slate-400 font-medium">/ {{ $result['total'] }}</span>
                                </td>
                                <td class="px-8 py-5 text-sm font-medium text-slate-500">
                                    {{ $result['date']->format('d/m/Y') }} <span class="text-slate-400 ml-1">{{ $result['date']->format('H:i') }}</span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('quizzes.student_details', [$quiz->id, $result['name']]) }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl font-bold text-xs hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Consulter
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-slate-50 text-slate-300 mb-6 shadow-sm border border-slate-100">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-800 mb-2">Aucun Résultat</h3>
                                    <p class="text-slate-500 font-medium max-w-sm mx-auto">Personne n'a encore complété ce quiz. Partagez le code du quiz avec vos étudiants pour commencer.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
