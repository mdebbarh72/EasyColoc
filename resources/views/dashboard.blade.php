<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center gap-6 mb-8 mt-4">
            <h2 class="text-2xl font-black text-slate-900 uppercase tracking-widest">
                Dashboard
            </h2>
            <a href="{{ route('colocations.index') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-indigo-200 flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                New Colocation
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col justify-center">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <p class="text-slate-500 font-medium mb-1">My Reputation Score</p>
                <h3 class="text-4xl font-black text-slate-900">{{ $reputation ?? 0 }}</h3>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col justify-center">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <p class="text-slate-500 font-medium mb-1">Global Expenses ({{ now()->format('M') }})</p>
                <h3 class="text-4xl font-black text-slate-900">{{ number_format($globalExpenses ?? 0, 2, ',', ' ') }} €</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-4 px-2">
                    <h3 class="text-xl font-bold text-slate-900">Recent Expenses</h3>
                    <a href="{{ route('colocations.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">View All</a>
                </div>

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100">
                                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-widest">Title / Category</th>
                                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Payer</th>
                                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Amount</th>
                                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Coloc</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($recentExpenses as $expense)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold uppercase shrink-0">
                                                    {{ substr($expense->title, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-slate-900">{{ $expense->title }}</p>
                                                    <p class="text-xs text-slate-500">{{ $expense->category->name ?? 'General' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center justify-center font-semibold text-slate-700">
                                                {{ $expense->payer->first_name }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="font-black text-slate-900">{{ number_format($expense->amount, 2, ',', ' ') }} €</span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="text-sm font-medium text-slate-600 bg-slate-100 px-3 py-1 rounded-lg">
                                                {{ $expense->colocation->name }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 px-6 text-center text-slate-400 font-medium">
                                            No recent expenses.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 relative overflow-hidden h-[300px]">
                    <div class="relative z-10 w-full h-full flex flex-col">
                        <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-4">
                            <h3 class="text-lg font-black text-slate-100 drop-shadow-sm uppercase tracking-wider opacity-20">Colocation Members</h3>
                            @if($colocationMembers->isEmpty())
                                <span class="px-3 py-1 bg-slate-50 text-slate-400 text-[10px] font-bold tracking-widest rounded-md uppercase border border-slate-200">0 Members</span>
                            @else
                                <span class="px-3 py-1 bg-white text-slate-700 text-[10px] font-black tracking-widest rounded-md uppercase border border-slate-200 shadow-sm">{{ $colocationMembers->count() }} Members</span>
                            @endif
                        </div>

                        @if($colocationMembers->isEmpty())
                            <div class="flex items-center justify-center p-8 text-center flex-1">
                                <p class="text-sm text-slate-400 font-medium">No active colocation.</p>
                            </div>
                        @else
                            <ul class="space-y-4 overflow-y-auto pr-2 custom-scrollbar flex-1 pb-2">
                                @foreach($colocationMembers as $member)
                                    <li class="flex items-center gap-4 py-1">
                                        <div class="w-8 h-8 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center font-black text-xs shrink-0 drop-shadow-sm">
                                            {{ strtoupper(substr($member->first_name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-black text-slate-100 drop-shadow-sm truncate">{{ $member->first_name }} {{ $member->last_name }}</p>
                                            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">{{ $member->pivot->role }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(226, 232, 240, 0.8);
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.8);
        }
    </style>
</x-app-layout>
