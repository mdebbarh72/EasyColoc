@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};

$id = 'dropdown-' . Str::random(8);
@endphp

<div class="relative inline-block text-left" id="{{ $id }}">
    <div class="dropdown-trigger cursor-pointer">
        {{ $trigger }}
    </div>

    <div class="dropdown-menu absolute z-50 mt-2 {{ $width }} rounded-2xl shadow-2xl border border-slate-100 {{ $alignmentClasses }} opacity-0 invisible scale-95 transition-all duration-200 transform origin-top-right"
         style="display: none;">
        <div class="rounded-2xl ring-1 ring-black ring-opacity-5 {{ $contentClasses }} overflow-hidden">
            {{ $content }}
        </div>
    </div>
</div>

<script>
    (function() {
        const dropdown = document.getElementById('{{ $id }}');
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        const toggle = (e) => {
            e.stopPropagation();
            const isOpen = !menu.classList.contains('invisible');
            
            // Close all other dropdowns first
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if (m !== menu) {
                    m.classList.add('invisible', 'opacity-0', 'scale-95');
                    m.classList.remove('visible', 'opacity-100', 'scale-100');
                    setTimeout(() => { if (m.classList.contains('invisible')) m.style.display = 'none'; }, 200);
                }
            });

            if (isOpen) {
                menu.classList.add('invisible', 'opacity-0', 'scale-95');
                menu.classList.remove('visible', 'opacity-100', 'scale-100');
                setTimeout(() => { if (menu.classList.contains('invisible')) menu.style.display = 'none'; }, 200);
            } else {
                menu.style.display = 'block';
                // Small timeout to allow display:block to take effect before transition
                setTimeout(() => {
                    menu.classList.remove('invisible', 'opacity-0', 'scale-95');
                    menu.classList.add('visible', 'opacity-100', 'scale-100');
                }, 10);
            }
        };

        trigger.addEventListener('click', toggle);

        window.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target)) {
                menu.classList.add('invisible', 'opacity-0', 'scale-95');
                menu.classList.remove('visible', 'opacity-100', 'scale-100');
                setTimeout(() => { if (menu.classList.contains('invisible')) menu.style.display = 'none'; }, 200);
            }
        });
    })();
</script>
