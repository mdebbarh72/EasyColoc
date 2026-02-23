<div>
    <!-- Create Colocation Modal -->
    <div id="createModal" class="fixed inset-0 z-50 hidden" wire:ignore.self>
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('createModal')"></div>
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl p-6">
            <div class="bg-white rounded-2xl shadow-2xl p-8 max-h-[90vh] overflow-y-auto">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 gradient-bg rounded-full"></span>
                    Create New Colocation
                </h2>

                <form @submit.prevent="" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Colocation Name</label>
                        <input type="text" wire:model="name" placeholder="e.g., Sweet Home" 
                            class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                        <textarea wire:model="description" placeholder="Describe your colocation..." rows="3"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"></textarea>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-slate-700">Expense Categories</label>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($categories as $index => $category)
                                <div class="relative group">
                                    <input type="text" wire:model="categories.{{ $index }}.name" placeholder="e.g., Rent, Groceries..." 
                                        class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all pr-10">
                                    @if(count($categories) > 1)
                                        <button type="button" wire:click="removeCategory({{ $index }})" 
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <button type="button" wire:click="addCategory" 
                            class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 mt-2">
                            + Add Category
                        </button>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeModal('createModal')" class="flex-1 py-3 text-slate-600 font-semibold hover:bg-slate-50 rounded-xl transition-all">
                            Cancel
                        </button>
                        <button type="button" class="flex-1 py-4 gradient-bg text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-200 transition-all active:scale-[0.98]">
                            Create Colocation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Example List with Actions -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Your Colocations (Preview)</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:bg-slate-50 transition-colors">
                <div>
                    <h4 class="font-semibold text-slate-900">Dream Apartment</h4>
                    <p class="text-sm text-slate-500">Rent, Wifi, Electricity</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="openModal('editModal')" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-white hover:shadow-sm rounded-lg transition-all">
                        Edit
                    </button>
                    <button onclick="openModal('deleteModal')" class="px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-all">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden" wire:ignore.self>
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('editModal')"></div>
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg p-6">
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Edit Colocation</h2>
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Colocation Name</label>
                        <input type="text" value="Dream Apartment" class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                        <textarea placeholder="Describe your colocation..." rows="3"
                            class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">This is a beautiful dream apartment shared by friends.</textarea>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-medium text-slate-700">Expense Categories</label>
                            <button type="button" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                                + Add Category
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-3">
                            <div class="relative group">
                                <input type="text" value="Rent" class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all pr-10">
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="relative group">
                                <input type="text" value="Wifi" class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all pr-10">
                                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeModal('editModal')" class="flex-1 py-3 text-slate-600 font-semibold hover:bg-slate-50 rounded-xl transition-all">
                            Cancel
                        </button>
                        <button type="button" class="flex-1 py-3 gradient-bg text-white font-semibold rounded-xl transition-all">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden" wire:ignore.self>
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('deleteModal')"></div>
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm p-6">
            <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
                <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 14c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Delete Colocation?</h2>
                <p class="text-slate-500 text-sm mb-6">This action cannot be undone. All data related to this colocation will be lost.</p>
                <div class="flex gap-3">
                    <button type="button" onclick="closeModal('deleteModal')" class="flex-1 py-3 text-slate-600 font-semibold hover:bg-slate-50 rounded-xl transition-all">
                        Cancel
                    </button>
                    <button type="button" class="flex-1 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-all">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal('createModal');
                closeModal('editModal');
                closeModal('deleteModal');
            }
        });
    </script>
</div>
