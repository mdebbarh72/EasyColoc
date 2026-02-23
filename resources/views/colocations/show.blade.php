<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('colocations.index') }}" class="p-2 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:shadow-sm transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $colocation->name }}</h2>
                        <span @class([
                            'px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider',
                            'bg-emerald-100 text-emerald-700' => $colocation->status === 'active',
                            'bg-slate-100 text-slate-600' => $colocation->status === 'canceled',
                        ])>
                            {{ $colocation->status }}
                        </span>
                    </div>
                    <p class="text-slate-500 mt-1">Shared space management dashboard.</p>
                </div>
            </div>

            <div class="flex gap-3">
                <button onclick="openModal('create-expense-modal')" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all flex items-center gap-2 shadow-lg shadow-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    New Expense
                </button>

                @can('update', $colocation)
                    <button onclick="openModal('editModal')" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </button>
                @endcan

                @can('delete', $colocation)
                    <button onclick="openModal('cancelModal')" class="px-5 py-2.5 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                        Cancel Colocation
                    </button>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-full -mr-16 -mt-16 transition-all group-hover:bg-indigo-100"></div>
                        
                        <h3 class="text-xl font-bold text-slate-900 mb-4 relative">About this Colocation</h3>
                        <p class="text-slate-600 leading-relaxed max-w-2xl relative">
                            {{ $colocation->description ?? 'No description has been added for this shared space yet.' }}
                        </p>

                        <div class="mt-8 flex flex-wrap gap-8 relative">
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Created By</span>
                                <span class="text-sm font-semibold text-slate-700">{{ $colocation->owner->first()->first_name ?? 'Unknown' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Joined</span>
                                <span class="text-sm font-semibold text-slate-700">{{ $colocation->created_at->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Status</span>
                                <span class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Operational
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-slate-900">Recent Expenses</h3>
                        </div>
                        <div class="space-y-4">
                            @forelse($colocation->expenses as $expense)
                                <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-slate-50 transition-all group">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-900">{{ $expense->title }}</h4>
                                            <p class="text-xs text-slate-500">{{ $expense->payer->first_name }} • {{ $expense->category->name }} • {{ $expense->created_at->format('M d') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="font-black text-slate-900">{{ number_format($expense->amount, 2) }} €</span>
                                        @can('delete', $expense)
                                            <button type="button" onclick="openDeleteExpenseModal('{{ route('expenses.destroy', $expense) }}', '{{ addslashes($expense->title) }}')" class="p-2 text-slate-400 hover:text-red-500 transition-colors" title="Delete Expense">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        @else
                                            <button type="button" disabled class="p-2 text-slate-200 cursor-not-allowed" title="Only the creator can delete this expense">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-slate-400 py-4">No expenses yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-slate-900">Settlements (Debts)</h3>
                        </div>
                        <div class="space-y-4">
                            @forelse($colocation->expenses->flatMap->debts->where('paid', false) as $debt)
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-50 transition-all hover:border-indigo-100">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-amber-50 text-amber-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-900">
                                                {{ $debt->debtor->first_name }} owes {{ $debt->expense->payer->first_name }}
                                            </h4>
                                            <p class="text-xs text-slate-500">For: {{ $debt->expense->title }} • {{ number_format($debt->amount, 2) }} €</p>
                                        </div>
                                    </div>
                                    <button onclick="openSettlementModal('{{ route('debts.mark-paid', $debt) }}', '{{ $debt->debtor->first_name }}', '{{ number_format($debt->amount, 2) }}')" 
                                        class="px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-lg hover:bg-indigo-600 hover:text-white transition-all">
                                        Mark Paid
                                    </button>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-500 font-medium">All settled up!</p>
                                    <p class="text-xs text-slate-400 mt-1">No pending debts found in this colocation.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-slate-900">Household</h3>
                            @can('create', [App\Models\Invitation::class, $colocation])
                                <button onclick="openModal('inviteModal')" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 font-bold rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm shadow-indigo-100/50 group" title="Invite new member">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <span class="text-sm">Invite</span>
                                </button>
                            @endcan
                        </div>

                        <div class="space-y-4">
                            @foreach($colocation->users as $user)
                                <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 transition-colors group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl gradient-bg flex items-center justify-center text-white font-black">
                                            {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-900">{{ $user->first_name }} {{ $user->last_name }}</h4>
                                            <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400 group-hover:text-indigo-400 transition-colors">
                                                {{ $user->pivot->role }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($user->id === Auth::id())
                                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-500 text-[10px] font-bold rounded-lg uppercase">You</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @php
                        $activeInvitations = $colocation->invitations()->where('status', 'pending')->get()->filter(fn($i) => !$i->expired());
                    @endphp

                    @if($activeInvitations->count() > 0)
                        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm animate-in fade-in slide-in-from-bottom-4">
                            <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 101.342-2.684 3 3 0 00-1.342 2.684zm0 9.368a3 3 0 101.342 2.684 3 3 0 00-1.342-2.684z"></path>
                                </svg>
                                Active Invitations
                            </h3>

                            <div class="space-y-6">
                                @foreach($activeInvitations as $invitation)
                                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 group relative">
                                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 items-center sm:items-start justify-between">
                                            
                                            <div class="flex-1 text-center sm:text-left min-w-0 w-full sm:w-auto">
                                                <span class="text-[10px] font-black uppercase tracking-widest text-indigo-500 mb-2 block">
                                                    {{ $invitation->email ? 'Private: ' . $invitation->email : 'Public Invite Link' }}
                                                </span>
                                                <p class="text-sm font-medium text-slate-800 mb-3 truncate w-full" title="{{ route('invitations.show', $invitation->token) }}">
                                                    {{ route('invitations.show', $invitation->token) }}
                                                </p>
                                                <button onclick="navigator.clipboard.writeText('{{ route('invitations.show', $invitation->token) }}').then(() => alert('Link copied!'))" 
                                                    class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center justify-center sm:justify-start gap-1.5 w-full sm:w-auto">
                                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                                    </svg>
                                                    Copy Link
                                                </button>
                                            </div>

                                            <div class="text-center sm:text-right shrink-0 mt-4 sm:mt-0">
                                                <span class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Expires</span>
                                                <span class="inline-flex px-3 py-1.5 bg-amber-50 text-amber-600 text-xs font-bold rounded-lg whitespace-nowrap">
                                                    {{ $invitation->expires_at->diffForHumans() }}
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>

    @can('update', $colocation)
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="min-h-screen px-4 text-center flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60" onclick="closeModal('editModal')"></div>
            
            <div class="inline-block w-full max-w-2xl p-8 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl relative">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-8 flex items-center gap-3">
                    <span class="w-2 h-8 gradient-bg rounded-full"></span>
                    Update Colocation
                </h2>

                <form action="{{ route('colocations.update', $colocation) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="edit_name" :value="__('Colocation Name')" class="mb-2" />
                            <x-text-input id="edit_name" name="name" type="text" class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-2xl" :value="$colocation->name" required />
                        </div>

                        <div>
                            <x-input-label for="edit_description" :value="__('Description')" class="mb-2" />
                            <textarea id="edit_description" name="description" rows="3" class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-2xl shadow-sm transition-all resize-none" placeholder="A little about your shared home...">{{ $colocation->description }}</textarea>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-bold text-slate-800">Expense Categories</h4>
                            <button type="button" onclick="addEditCategoryRow()" class="px-4 py-2 text-sm font-bold text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors">
                                + Add Row
                            </button>
                        </div>
                        
                        <div id="editCategoryContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($colocation->categories as $index => $category)
                                <div class="category-row relative group">
                                    <input type="hidden" name="categories[{{ $index }}][id]" value="{{ $category->id }}">
                                    <x-text-input name="categories[{{ $index }}][name]" type="text" class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-xl" :value="$category->name" required />
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-4 pt-6">
                        <button type="button" onclick="closeModal('editModal')" class="flex-1 py-4 px-6 text-slate-600 font-bold hover:bg-slate-100 rounded-2xl transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 py-4 px-6 gradient-bg text-white font-extrabold rounded-2xl shadow-xl shadow-indigo-100 hover:shadow-indigo-200 transition-all active:scale-[0.98]">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    @can('delete', $colocation)
    <div id="cancelModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60" onclick="closeModal('cancelModal')"></div>
        <div class="relative bg-white w-full max-w-md rounded-3xl p-8 text-center animate-in zoom-in-95 duration-200">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 14c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-slate-900 mb-2">Cancel Colocation?</h3>
            <p class="text-slate-500 mb-8 px-4">This will mark the colocation as inactive. This action is carefully protected by our shared governance policy.</p>
            
            <form action="{{ route('colocations.destroy', $colocation) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('cancelModal')" class="flex-1 py-3 text-slate-600 font-bold hover:bg-slate-50 rounded-2xl transition-all">Keep it</button>
                    <button type="submit" class="flex-1 py-3 bg-red-600 text-white font-bold rounded-2xl hover:bg-red-700 transition-all shadow-lg shadow-red-100">Yes, Cancel</button>
                </div>
            </form>
        </div>
    </div>
    @endcan

    <script>
        let editCategoryIndex = {{ $colocation->categories->count() }};

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function addEditCategoryRow() {
            const container = document.getElementById('editCategoryContainer');
            const row = document.createElement('div');
            row.className = 'category-row relative group';
            row.innerHTML = `
                <input type="text" name="categories[${editCategoryIndex}][name]" 
                    class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-xl transition-all pr-12" 
                    placeholder="New Category..." required>
                <button type="button" onclick="this.parentElement.remove()" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(row);
            editCategoryIndex++;
            row.querySelector('input').focus();
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal('editModal');
                closeModal('cancelModal');
                closeModal('inviteModal');
                closeModal('create-expense-modal');
                closeModal('settlementModal');
            }
        });

        function openSettlementModal(actionUrl, debtorName, amount) {
            const form = document.getElementById('settlementForm');
            const text = document.getElementById('settlementModalText');
            form.action = actionUrl;
            text.innerHTML = `Are you sure you want to confirm that <span class="font-bold text-slate-900">${debtorName}</span> has paid the <span class="font-bold text-slate-900">${amount} €</span>?`;
            openModal('settlementModal');
        }
        function openDeleteExpenseModal(actionUrl, expenseTitle) {
            const form = document.getElementById('deleteExpenseForm');
            const text = document.getElementById('deleteExpenseModalText');
            form.action = actionUrl;
            text.innerHTML = `Are you sure you want to delete the expense: <span class="font-bold text-slate-900">"${expenseTitle}"</span>?<br><br>This will permanently remove the expense and reverse any associated paid debts.`;
            openModal('deleteExpenseModal');
        }
    </script>

    @can('create', [App\Models\Invitation::class, $colocation])
        <livewire:invite-user :colocation="$colocation" />
    @endcan

    <div id="settlementModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6">
        <div class="fixed inset-0 bg-slate-900/80 transition-opacity" onclick="closeModal('settlementModal')"></div>
        <div class="relative bg-white w-full max-w-lg rounded-[2.5rem] p-10 text-center shadow-2xl animate-in zoom-in-95 duration-200" onclick="event.stopPropagation()">
            <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Confirm Settlement</h3>
            <p class="text-slate-500 mb-10 px-4 leading-relaxed font-medium" id="settlementModalText">
                Are you sure you want to mark this debt as paid?
            </p>
            
            <form id="settlementForm" method="POST" class="flex gap-4">
                @csrf
                <button type="button" onclick="closeModal('settlementModal')" class="flex-1 py-4 px-6 text-slate-600 font-bold hover:bg-slate-50 rounded-2xl transition-all border border-slate-100">
                    Cancel
                </button>
                <button type="submit" class="flex-1 py-4 px-6 bg-emerald-600 text-white font-extrabold rounded-2xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100 active:scale-[0.98]">
                    Confirm Paid
                </button>
            </form>
        </div>
    </div>

    <div id="deleteExpenseModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6">
        <div class="fixed inset-0 bg-slate-900/80 transition-opacity" onclick="closeModal('deleteExpenseModal')"></div>
        <div class="relative bg-white w-full max-w-lg rounded-[2.5rem] p-10 text-center shadow-2xl animate-in zoom-in-95 duration-200" onclick="event.stopPropagation()">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Delete Expense</h3>
            <p class="text-slate-500 mb-10 px-4 leading-relaxed font-medium" id="deleteExpenseModalText">
                Are you sure you want to delete this expense?
            </p>
            
            <form id="deleteExpenseForm" method="POST" class="flex gap-4">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('deleteExpenseModal')" class="flex-1 py-4 px-6 text-slate-600 font-bold hover:bg-slate-50 rounded-2xl transition-all border border-slate-100">
                    Cancel
                </button>
                <button type="submit" class="flex-1 py-4 px-6 bg-red-600 text-white font-extrabold rounded-2xl hover:bg-red-700 transition-all shadow-xl shadow-red-100 active:scale-[0.98]">
                    Delete Expense
                </button>
            </form>
        </div>
    </div>

    <x-create-expense-modal :colocation="$colocation" />

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }
    </style>
</x-app-layout>
