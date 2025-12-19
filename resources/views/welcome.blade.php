<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Scrollbar for the theme */
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

        /* Shimmer Effect for Hero Card */
        .glass-hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.05), transparent);
            transform: skewX(-25deg);
            transition: 0.75s;
        }

        .glass-hero:hover::before {
            left: 125%;
        }
    </style>
</head>

<body class="antialiased text-gray-200 selection:bg-blue-500/30 font-sans">

    {{-- Deep Background Gradient & Auras --}}
    <div class="min-h-screen bg-[#0f172a] bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-900/20 via-[#0f172a] to-[#0f172a] relative overflow-hidden flex flex-col">

        {{-- Floating Background Glows --}}
        <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-blue-600/10 blur-[120px] pointer-events-none"></div>
        <div class="fixed bottom-0 right-0 w-[400px] h-[400px] bg-indigo-600/5 blur-[100px] pointer-events-none"></div>

        <header class="w-full max-w-7xl mx-auto px-6 py-8 flex justify-between items-center relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <span class="text-xl font-black tracking-tighter text-white uppercase italic">Vampior<span class="text-blue-500 not-italic">Blog</span></span>
            </div>

            @if (Route::has('login'))
            <nav class="flex items-center gap-4">
                @auth
                <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-white/5 backdrop-blur-md border border-white/10 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-white/10 transition-all">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-white transition-colors">Log in</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.3)] transition-all hover:scale-105 active:scale-95">Get Started</a>
                @endif
                @endauth
            </nav>
            @endif
        </header>

        <main class="flex-grow flex items-center justify-center px-6 relative z-10">
            <div class="max-w-4xl w-full">
                <div class="glass-hero relative bg-white/5 backdrop-blur-md border border-white/10 rounded-[3rem] overflow-hidden shadow-2xl p-12 md:p-20 text-center">

                    {{-- Small Label --}}
                    <span class="inline-block px-4 py-1.5 bg-blue-500/10 border border-blue-500/20 rounded-full text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] mb-8">
                        The Future of Content
                    </span>

                    <h1 class="text-5xl md:text-7xl font-black text-white leading-none tracking-tighter mb-8">
                        Share your ideas <br> with the <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">World.</span>
                    </h1>

                    <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed">
                        A premium multi-user blogging platform featuring role-based management, immersive visuals, and seamless community engagement.
                    </p>

                    <div class="flex flex-wrap justify-center gap-6">
                        <a href="{{ route('register') }}" class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl shadow-xl shadow-blue-600/20 transition-all hover:-translate-y-1 text-sm uppercase tracking-widest">
                            Start Writing Now
                        </a>
                        <a href="{{ route('login') }}" class="px-10 py-4 bg-white/5 border border-white/10 hover:bg-white/10 text-white font-black rounded-2xl transition-all hover:-translate-y-1 text-sm uppercase tracking-widest">
                            Welcome Back
                        </a>
                    </div>

                    {{-- Featured Tech Badges --}}
                    <div class="mt-20 pt-10 border-t border-white/5 flex flex-wrap justify-center gap-8 opacity-40 grayscale hover:grayscale-0 transition-all duration-700">
                        <span class="text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div> Laravel 11
                        </span>
                        <span class="text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-indigo-500"></div> Spatie RBAC
                        </span>
                        <span class="text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-blue-400"></div> Socialite
                        </span>
                    </div>
                </div>
            </div>
        </main>

        <footer class="w-full max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row justify-between items-center gap-6 relative z-10 opacity-60">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">
                &copy; 2025 Vampior Designs Assessment Task.
            </p>
            <div class="flex gap-8">
                <a href="#" class="text-[10px] font-black text-slate-500 hover:text-white uppercase tracking-[0.2em] transition-colors">Privacy</a>
                <a href="#" class="text-[10px] font-black text-slate-500 hover:text-white uppercase tracking-[0.2em] transition-colors">Terms</a>
                <a href="https://github.com" class="text-[10px] font-black text-slate-500 hover:text-white uppercase tracking-[0.2em] transition-colors">Source Code</a>
            </div>
        </footer>
    </div>
</body>

</html>