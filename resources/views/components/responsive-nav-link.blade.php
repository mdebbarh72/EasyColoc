@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-3 border-l-4 border-indigo-500 text-base font-bold text-indigo-700 bg-indigo-50 focus:outline-none transition duration-150 ease-in-out rounded-r-xl'
            : 'block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-base font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:outline-none transition duration-150 ease-in-out rounded-r-xl';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
