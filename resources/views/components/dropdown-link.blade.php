<a {{ $attributes->merge(['class' => 'block w-full px-5 py-2.5 text-start text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-white hover:bg-blue-600/20 focus:outline-none focus:bg-blue-600/20 transition-all duration-300 ease-in-out border-l-2 border-transparent hover:border-blue-500']) }}>
    {{ $slot }}
</a>