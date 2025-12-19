@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3 px-5 transition-all shadow-inner disabled:opacity-25 disabled:cursor-not-allowed']) }}>