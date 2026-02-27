@props(['type' => 'success', 'message' => ''])

<div x-data="{ show: true }" 
     x-init="setTimeout(() => show = false, 5000)" 
     x-show="show" 
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-8 opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-8"
     @class([
        'fixed bottom-6 right-6 z-[100] w-auto min-w-[320px] max-w-md bg-white shadow-2xl rounded-2xl p-4 border flex items-center gap-4',
        'border-emerald-100' => $type === 'success',
        'border-red-100' => $type === 'error' || $type === 'danger',
        'border-amber-100' => $type === 'warning',
        'border-indigo-100' => $type === 'info',
     ])>
    
    <div @class([
        'w-12 h-12 rounded-2xl flex items-center justify-center shrink-0',
        'bg-emerald-50 text-emerald-600' => $type === 'success',
        'bg-red-50 text-red-600' => $type === 'error' || $type === 'danger',
        'bg-amber-50 text-amber-600' => $type === 'warning',
        'bg-indigo-50 text-indigo-600' => $type === 'info',
    ])>
        @if($type === 'success')
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        @elseif($type === 'error' || $type === 'danger')
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        @elseif($type === 'warning')
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 14c-.77 1.333.192 3 1.732 3z"></path></svg>
        @else
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        @endif
    </div>

    <div class="flex-1">
        <p class="text-slate-900 font-bold text-sm">{{ $message }}</p>
    </div>

    <button @click="show = false" class="text-slate-300 hover:text-slate-500 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

<script>
    // Native JS fallback if Alpine isn't loading or for manual triggers
    window.showToast = function(message, type = 'success') {
        const id = 'toast-' + Math.random().toString(36).substr(2, 9);
        const toastHtml = `
            <div id="${id}" class="fixed bottom-6 right-6 z-[100] w-auto min-w-[320px] max-w-md bg-white shadow-2xl rounded-2xl p-4 border flex items-center gap-4 transition-all duration-300 translate-y-8 opacity-0 border-${type === 'success' ? 'emerald' : 'red'}-100">
                <div class="w-12 h-12 rounded-2xl bg-${type === 'success' ? 'emerald' : 'red'}-50 text-${type === 'success' ? 'emerald' : 'red'}-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"></path></svg>
                </div>
                <div class="flex-1">
                    <p class="text-slate-900 font-bold text-sm">${message}</p>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', toastHtml);
        const el = document.getElementById(id);
        
        // Animate in
        setTimeout(() => {
            el.classList.remove('translate-y-8', 'opacity-0');
        }, 10);

        setTimeout(() => {
            el.classList.add('translate-y-8', 'opacity-0');
            setTimeout(() => el.remove(), 300);
        }, 5000);
    }
</script>
