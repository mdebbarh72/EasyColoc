@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];

$id = 'modal-' . Str::slug($name);
@endphp

<div
    id="{{ $id }}"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 transition-all duration-300 opacity-0 invisible"
    style="display: none;"
>
    <!-- Backdrop -->
    <div class="fixed inset-0 transform transition-all transition-opacity duration-300 opacity-0" onclick="window.closeModal('{{ $name }}')">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
    </div>

    <!-- Content -->
    <div class="mb-6 bg-white rounded-[2.5rem] overflow-hidden shadow-2xl transform transition-all duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 sm:w-full {{ $maxWidth }} sm:mx-auto border border-slate-100">
        {{ $slot }}
    </div>
</div>

<script>
    window.openModal = window.openModal || function(name) {
        const id = 'modal-' + name.replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.style.display = 'block';
        document.body.classList.add('overflow-y-hidden');

        setTimeout(() => {
            modal.classList.remove('invisible', 'opacity-0');
            modal.querySelector('.fixed.inset-0').classList.add('opacity-100');
            modal.querySelector('.bg-white').classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
            modal.querySelector('.bg-white').classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
        }, 10);
    };

    window.closeModal = window.closeModal || function(name) {
        const id = 'modal-' + name.replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.classList.add('invisible', 'opacity-0');
        modal.querySelector('.fixed.inset-0').classList.remove('opacity-100');
        modal.querySelector('.bg-white').classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');
        modal.querySelector('.bg-white').classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');

        setTimeout(() => {
            modal.style.display = 'none';
            document.body.classList.remove('overflow-y-hidden');
        }, 300);
    };

    @if($show)
        window.addEventListener('DOMContentLoaded', () => {
            window.openModal('{{ $name }}');
        });
    @endif

    // Global listeners
    window.addEventListener('open-modal', (e) => window.openModal(e.detail));
    window.addEventListener('close-modal', (e) => window.closeModal(e.detail));
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal-"]').forEach(m => {
                if (!m.classList.contains('invisible')) {
                    const name = m.id.replace('modal-', '');
                    window.closeModal(name);
                }
            });
        }
    });
</script>
