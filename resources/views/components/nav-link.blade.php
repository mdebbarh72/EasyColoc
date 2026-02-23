@props(['active'])

@php
$classes = ($active ?? false)
            ? 'relative inline-flex items-center px-4 py-2 mt-1 rounded-full bg-indigo-50/50 text-sm font-bold leading-5 text-indigo-600 focus:outline-none transition-all duration-200'
            : 'relative inline-flex items-center px-4 py-2 mt-1 rounded-full text-sm font-semibold leading-5 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 focus:outline-none focus:text-slate-700 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
