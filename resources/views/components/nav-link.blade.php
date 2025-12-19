@props(['active'])

@php
$classes = ($active ?? false)
? 'inline-flex items-center px-1 pt-1 border-b-2 border-blue-500 text-[10px] font-black uppercase tracking-[0.2em] leading-5 text-white focus:outline-none transition-all duration-300 ease-in-out shadow-[0_4px_12px_-2px_rgba(59,130,246,0.3)]'
: 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-[10px] font-black uppercase tracking-[0.2em] leading-5 text-slate-500 hover:text-white hover:border-blue-500/50 focus:outline-none focus:text-white focus:border-blue-500/50 transition-all duration-300 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>