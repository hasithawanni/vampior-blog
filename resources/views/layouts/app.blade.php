<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Trix Editor Assets --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <style>
        /* Pro Dark Mode support for Trix */
        .dark trix-toolbar .trix-button {
            background-color: #374151;
            color: white;
            border-color: #4b5563;
        }

        .dark trix-toolbar .trix-button--active {
            background-color: #1f2937 !important;
        }

        .dark trix-editor {
            color: #d1d5db;
            border-color: #374151;
            background-color: #111827;
            min-height: 300px;
        }

        /* Custom Scrollbar for a cleaner look */
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

        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        /* Add this inside your <style> tag in layouts/app.blade.php */
        .glass-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right,
                    transparent,
                    rgba(255, 255, 255, 0.05),
                    transparent);
            transform: skewX(-25deg);
            transition: 0.75s;
        }

        .glass-card:hover::before {
            left: 125%;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-200 selection:bg-blue-500/30">
    {{-- Deep Background Gradient: Necessary for Glassmorphism to work --}}
    <div class="min-h-screen bg-[#0f172a] bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-900/20 via-[#0f172a] to-[#0f172a]">

        @include('layouts.navigation')

        @isset($header)
        <header class="sticky top-0 z-40 w-full backdrop-blur-md bg-[#0f172a]/60 border-b border-white/5 shadow-2xl">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    {{ $header }}
                </div>
            </div>
        </header>
        @endisset

        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>