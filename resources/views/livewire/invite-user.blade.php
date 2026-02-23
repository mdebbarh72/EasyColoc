<div>
    <div id="inviteModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" wire:ignore.self>
        <div class="min-h-screen px-4 text-center flex items-center justify-center">
            <!-- Solid Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('inviteModal')"></div>
            
            <!-- Solid Premium Modal Box -->
            <div class="inline-block w-full max-w-md p-10 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] rounded-[2.5rem] relative border border-slate-100">
                <!-- Close Button -->
                <button onclick="closeModal('inviteModal')" class="absolute top-8 right-8 p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Header -->
                <div class="mb-10">
                    <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 text-indigo-600 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 leading-tight">Generate Invitation</h2>
                    <p class="text-slate-500 mt-2 text-sm font-medium">Create a secure link or QR code for your new roommate.</p>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="invite" class="space-y-8">
                    <div class="space-y-3">
                        <label for="invite_email" class="block text-xs font-black uppercase tracking-widest text-slate-400 ml-1">Roommate's Email (Optional)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path>
                                </svg>
                            </div>
                            <input wire:model.live="email" type="email" id="invite_email" 
                                class="block w-full pl-12 pr-4 py-4 bg-slate-50 border-2 border-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-0 rounded-2xl text-slate-900 font-bold placeholder:text-slate-300 transition-all" 
                                placeholder="mate@example.com">
                        </div>
                        <p class="text-[10px] text-slate-400 font-bold ml-1">Leave empty to generate a public link/QR.</p>
                        @error('email') <span class="text-red-500 text-xs mt-1 ml-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Search Result Preview -->
                    @if($foundUser)
                        <div class="p-5 bg-indigo-50 border border-indigo-100 rounded-3xl flex items-center gap-4 animate-in fade-in zoom-in-95 duration-300">
                            <div class="w-12 h-12 rounded-2xl gradient-bg flex items-center justify-center text-white font-black text-lg shadow-md">
                                {{ strtoupper(substr($foundUser->first_name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-900 leading-none mb-1">{{ $foundUser->first_name }} {{ $foundUser->last_name }}</h4>
                                <p class="text-[10px] text-indigo-600 font-black uppercase tracking-widest">Matched Account Found</p>
                            </div>
                        </div>
                    @elseif($email && filter_var($email, FILTER_VALIDATE_EMAIL))
                        <div class="p-5 bg-slate-50 border border-slate-100 rounded-3xl flex items-center gap-4 group">
                            <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-indigo-500 group-hover:border-indigo-100 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-900 leading-none mb-1">New Roommate</h4>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Invitation Email will be sent</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex gap-4 pt-4">
                        <button type="button" onclick="closeModal('inviteModal')" class="flex-1 py-4 px-6 text-slate-600 font-bold hover:bg-slate-50 rounded-2xl transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 py-4 px-6 gradient-bg text-white font-extrabold rounded-2xl shadow-xl shadow-indigo-100 hover:shadow-indigo-200 transition-all active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none" 
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Generate Invitation</span>
                            <span wire:loading>Please wait...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('close-modal', (id) => {
            closeModal(id);
        });
    });
</script>
