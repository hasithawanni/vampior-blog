<x-guest-layout>
    {{-- Background Aura: Specific to security checkpoints --}}
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full h-[400px] bg-blue-600/10 blur-[100px] pointer-events-none -z-10"></div>

    {{-- Main Glass Security Card --}}
    <div class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2.5rem] p-8 md:p-12 shadow-2xl w-full max-w-md mx-auto">

        <div class="text-center mb-10">
            <div class="inline-flex p-3 bg-blue-500/20 rounded-2xl border border-blue-500/30 mb-6">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-black text-white tracking-tighter uppercase italic">
                Security <span class="text-blue-500 not-italic">Checkpoint</span>
            </h2>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mt-4 leading-relaxed">
                {{ __('Verify your identity before entering this secure sector.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-8">
            @csrf

            {{-- Password Verification --}}
            <div class="group">
                <x-input-label for="password" :value="__('Security Token (Password)')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1" />

                <x-text-input id="password"
                    class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3.5 px-5 transition-all shadow-inner"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded-2xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:scale-[1.02] active:scale-95 transition-all text-[10px] uppercase tracking-[0.2em]">
                    {{ __('Authorize Access') }}
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('dashboard') }}" class="text-[10px] font-black text-slate-600 hover:text-white uppercase tracking-widest transition-colors">
                Return to Neutral Zone
            </a>
        </div>
    </div>
</x-guest-layout>