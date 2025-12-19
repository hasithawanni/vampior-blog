@props(['status'])

@if ($status)
<div {{ $attributes->merge(['class' => 'p-4 bg-green-500/10 border border-green-500/20 rounded-2xl flex items-start gap-3 shadow-[0_0_20px_rgba(34,197,94,0.05)]']) }}>
    {{-- Success Check Icon --}}
    <svg class="w-5 h-5 text-green-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>

    <span class="text-sm font-bold text-green-400 tracking-tight leading-relaxed">
        {{ $status }}
    </span>
</div>
@endif