<x-guest-layout>
    {{-- Background Aura: Specific to the recovery portal --}}
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full h-[400px] bg-blue-600/10 blur-[100px] pointer-events-none -z-10"></div>

    {{-- Main Glass Recovery Card --}}
    <div class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2.5rem] p-8 md:p-12 shadow-2xl w-full max-w-md mx-auto">

        <div class="text-center mb-10">
            <div class="inline-flex p-3 bg-blue-500/20 rounded-2xl border border-blue-500/30 mb-6">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m-2 4h2a2 2 0 012 2v3a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 20h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-black text-white tracking-tighter uppercase italic">
                Password <span class="text-blue-500 not-italic">Recovery</span>
            </h2>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mt-4 leading-relaxed">
                {{ __('Forgot your password? Enter your email to request a secure reset link.') }}
            </p>
        </div>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-6 bg-green-500/10 border border-green-500/20 p-4 rounded-xl text-green-400 text-xs font-bold" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
            @csrf

            {{-- Email Address --}}
            <div class="group">
                <x-input-label for="email" :value="__('Recovery Email')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1" />

                <x-text-input id="email"
                    class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3.5 px-5 transition-all shadow-inner"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    placeholder="name@vampior.com" />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded-2xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:scale-[1.02] active:scale-95 transition-all text-[10px] uppercase tracking-[0.2em]">
                    {{ __('Email Reset Link') }}
                </button>
            </div>
        </form>

        <div class="mt-10 text-center">
            <a href="{{ route('login') }}" class="text-[10px] font-black text-slate-500 hover:text-white uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Return to Login Portal
            </a>
        </div>
    </div>
</x-guest-layout>