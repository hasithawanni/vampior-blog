@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-2 bg-[#0f172a]/90 backdrop-blur-2xl'])

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
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open" class="cursor-pointer">
        {{ $trigger }}
    </div>

    <div x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-3 {{ $width }} rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/10 {{ $alignmentClasses }}"
        style="display: none;"
        @click="open = false">
        {{-- The ring color is shifted to white/5 to match the glass theme --}}
        <div class="rounded-2xl ring-1 ring-white/5 overflow-hidden {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>