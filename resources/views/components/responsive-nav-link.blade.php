@props(['active'])

@php
$classes = ($active ?? false)
? 'block w-full ps-3 pe-4 py-3 border-l-4 border-blue-500 text-start text-[10px] font-black uppercase tracking-[0.2em] text-blue-400 bg-blue-500/10 focus:outline-none transition-all duration-300 ease-in-out'
: 'block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-start text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 hover:text-white hover:bg-white/5 hover:border-blue-500/50 focus:outline-none transition-all duration-300 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>