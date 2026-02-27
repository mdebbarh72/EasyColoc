@props(['colocation'])

<div id="create-expense-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/75 transition-opacity" aria-hidden="true" onclick="closeModal('create-expense-modal')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative z-10 inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" onclick="event.stopPropagation()">
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
                
                <div class="bg-white px-8 pt-8 pb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                        <h3 class="text-2xl font-black text-slate-900" id="modal-title">
                            Add Shared Expense
                        </h3>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl">
                            <ul class="list-disc list-inside text-sm text-red-600 font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Expense Description</label>
                            <input type="text" name="title" id="title" required placeholder="e.g. Weekly Groceries" 
                                class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-2xl shadow-sm transition-all @error('title') border-red-300 @enderror" 
                                value="{{ old('title') }}">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="amount" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Amount (€)</label>
                                <input type="number" step="0.01" name="amount" id="amount" required placeholder="0.00" 
                                    class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-2xl shadow-sm transition-all @error('amount') border-red-300 @enderror"
                                    value="{{ old('amount') }}">
                            </div>

                            <div>
                                <label for="category_id" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Category</label>
                                <select name="category_id" id="category_id" required 
                                    class="block w-full p-4 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-2xl shadow-sm transition-all">
                                    <option value="" disabled selected>Select category</option>
                                    @foreach($colocation->categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-8 py-6 flex flex-row-reverse gap-3">
                    <button type="submit" class="flex-1 py-4 px-6 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-[0.98]">
                        Log Expense
                    </button>
                    <button type="button" onclick="closeModal('create-expense-modal')" class="flex-1 py-4 px-6 text-slate-600 font-bold hover:bg-slate-200 rounded-2xl transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        window.addEventListener('load', () => {
            if (typeof openModal === 'function') {
                openModal('create-expense-modal');
            }
        });
    </script>
@endif
