<x-guest-layout>
    {{-- Background Aura: Specific to the onboarding phase --}}
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full h-[400px] bg-blue-600/10 blur-[100px] pointer-events-none -z-10"></div>

    <div class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2.5rem] p-8 md:p-12 shadow-2xl w-full max-w-md mx-auto text-center">

        <div class="mb-10">
            <div class="inline-flex p-3 bg-blue-500/20 rounded-2xl border border-blue-500/30 mb-6">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-black text-white tracking-tighter uppercase italic">
                Verify <span class="text-blue-500 not-italic">Uplink</span>
            </h2>
            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-4 leading-relaxed">
                {{ __('Thanks for signing up! Please verify your communications uplink by clicking the link we just sent to your inbox.') }}
            </p>
        </div>

        {{-- Link Sent Status --}}
        @if (session('status') == 'verification-link-sent')
        <div class="mb-8 p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
            <p class="text-xs font-bold text-green-400">
                {{ __('A fresh verification link has been established.') }}
            </p>
        </div>
        @endif

        <div class="space-y-6">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded-2xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:scale-[1.02] active:scale-95 transition-all text-[10px] uppercase tracking-[0.2em]">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[10px] font-black text-slate-500 hover:text-white uppercase tracking-widest transition-colors">
                    {{ __('Abort Session & Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>