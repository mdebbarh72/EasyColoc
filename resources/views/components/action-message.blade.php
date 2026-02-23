@props(['on'])

<div id="action-message-{{ $on }}"
     class="text-sm font-bold text-green-600 transition-all duration-1000 opacity-0 invisible"
     style="display: none;">
    {{ $slot->isEmpty() ? __('Saved.') : $slot }}
</div>

<script>
    window.addEventListener('{{ $on }}', () => {
        const el = document.getElementById('action-message-{{ $on }}');
        if (!el) return;

        el.style.display = 'block';
        setTimeout(() => {
            el.classList.remove('invisible', 'opacity-0');
            el.classList.add('visible', 'opacity-100');
        }, 10);

        setTimeout(() => {
            el.classList.add('invisible', 'opacity-0');
            el.classList.remove('visible', 'opacity-100');
            setTimeout(() => { el.style.display = 'none'; }, 1000);
        }, 3000);
    });
</script>
