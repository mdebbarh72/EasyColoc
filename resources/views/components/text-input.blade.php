@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-50 border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-sm transition-all py-3 px-4']) }}>
