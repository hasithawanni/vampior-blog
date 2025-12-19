<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Scrollbar to match the theme */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }
    </style>
</head>

<body class="font-sans text-gray-200 antialiased selection:bg-blue-500/30">

    {{-- Deep Radial Background & Auras --}}
    <div class="min-h-screen bg-[#0f172a] bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-900/20 via-[#0f172a] to-[#0f172a] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">

        {{-- Floating Background Glows --}}
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-600/10 blur-[120px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] bg-indigo-600/10 blur-[120px] rounded-full pointer-events-none"></div>

        {{-- Branded Logo Section --}}
        <div class="mb-8 relative z-10 transition-transform duration-500 hover:scale-105">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-blue-500 shadow-2xl" />
            </a>
        </div>

        {{-- Main Content Slot --}}
        <div class="w-full sm:max-w-md px-6 relative z-10">
            {{ $slot }}
        </div>

        {{-- Decorative Footer Detail --}}
        <div class="mt-12 text-[10px] font-black uppercase tracking-[0.3em] text-slate-600 relative z-10">
            &copy; 2025 Vampior Protocol
        </div>
    </div>
</body>

</html>