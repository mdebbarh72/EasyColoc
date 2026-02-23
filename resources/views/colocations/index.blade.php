<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ __('Your Colocations') }}
                </h2>
                <p class="text-slate-500 mt-1">Manage your shared living spaces and shared expenses.</p>
            </div>
            
            @can('create', App\Models\Colocation::class)
                <button onclick="openModal('createModal')" 
                    class="inline-flex items-center px-6 py-3 gradient-bg text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all active:scale-[0.98]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Start New Colocation
                </button>
            @else
                <div class="px-5 py-3.5 bg-amber-50 rounded-2xl border border-amber-100 flex items-center gap-3 text-sm text-amber-700 shadow-sm animate-in fade-in slide-in-from-right-4 duration-500 max-w-md">
                    <div class="p-2 bg-amber-100 rounded-xl text-amber-600">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 14c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <span class="font-bold leading-tight">One active colocation maximum at a time.</span>
                </div>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($colocations as $colocation)
                    <div class="group relative bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="flex justify-between items-start mb-6">
                            <div class="p-3 rounded-2xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                            <span @class([
                                'px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider',
                                'bg-emerald-100 text-emerald-700' => $colocation->status === 'active',
                                'bg-slate-100 text-slate-600' => $colocation->status === 'canceled',
                            ])>
                                {{ $colocation->status }}
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $colocation->name }}</h3>
                        <p class="text-slate-500 text-sm mb-6 line-clamp-2">
                            {{ $colocation->description ?? 'No description provided.' }}
                        </p>

                        <div class="flex items-center -space-x-2 mb-6">
                            @foreach($colocation->users as $user)
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600 ring-1 ring-slate-100" title="{{ $user->first_name }}">
                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                </div>
                            @endforeach
                            @if($colocation->users->count() > 4)
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-400">
                                    +{{ $colocation->users->count() - 4 }}
                                </div>
                            @endif
                        </div>

                        <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                            <span class="text-xs text-slate-400 font-medium">
                                Created {{ $colocation->created_at->diffForHumans() }}
                            </span>
                            <a href="{{ route('colocations.show', $colocation) }}" class="text-indigo-600 font-bold text-sm hover:text-indigo-700 flex items-center gap-1 group/link">
                                View Details
                                <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">No colocations found</h3>
                        <p class="text-slate-500 mb-8 max-w-sm mx-auto">You aren't part of any share house yet. Create one to start managing expenses!</p>
                        @can('create', App\Models\Colocation::class)
                            <button onclick="openModal('createModal')" class="px-8 py-3 gradient-bg text-white font-bold rounded-2xl shadow-lg">
                                Create My First Colocation
                            </button>
                        @endcan
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="fixed inset-0 z-50 hidden overflow-y-auto" wire:ignore.self>
        <div class="min-h-screen px-4 text-center flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity" onclick="closeModal('createModal')"></div>
            
            <div class="inline-block w-full max-w-2xl p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl relative">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-8 flex items-center gap-3">
                    <span class="w-2 h-8 gradient-bg rounded-full"></span>
                    {{ __('Setup New Colocation') }}
                </h2>

                <form id="createForm" action="{{ route('colocations.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Colocation Name')" class="mb-2" />
                            <x-text-input id="name" name="name" type="text" class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-2xl shadow-sm transition-all" placeholder="e.g., Central Park Loft" required />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description (Optional)')" class="mb-2" />
                            <textarea id="description" name="description" rows="3" class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-2xl shadow-sm transition-all resize-none" placeholder="A little about your shared home..."></textarea>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-bold text-slate-800">Initial Expense Categories</h4>
                            <button type="button" onclick="addCategoryRow()" class="px-4 py-2 text-sm font-bold text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors">
                                + Add Row
                            </button>
                        </div>
                        
                        <div id="categoryContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="category-row relative">
                                <x-text-input name="categories[0][name]" type="text" class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-xl" placeholder="Rent" required />
                            </div>
                            <div class="category-row relative">
                                <x-text-input name="categories[1][name]" type="text" class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-xl" placeholder="Electricity" required />
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 italic font-medium">You can add or change these later.</p>
                    </div>

                    <div class="flex gap-4 pt-6">
                        <button type="button" onclick="closeModal('createModal')" class="flex-1 py-4 px-6 text-slate-600 font-bold hover:bg-slate-100 rounded-2xl transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 py-4 px-6 gradient-bg text-white font-extrabold rounded-2xl shadow-xl shadow-indigo-100 hover:shadow-indigo-200 transition-all active:scale-[0.98]">
                            Launch Colocation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let categoryIndex = 2;

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function addCategoryRow() {
            const container = document.getElementById('categoryContainer');
            const row = document.createElement('div');
            row.className = 'category-row relative group';
            row.innerHTML = `
                <input type="text" name="categories[${categoryIndex}][name]" 
                    class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-xl transition-all pr-12" 
                    placeholder="Other Expense..." required>
                <button type="button" onclick="this.parentElement.remove()" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(row);
            categoryIndex++;
            row.querySelector('input').focus();
        }

        // Handle ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal('createModal');
        });
    </script>

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
    </style>
</x-app-layout>
