@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 ml-1']) }}>
    {{ $value ?? $slot }}
</label>