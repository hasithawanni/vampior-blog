<x-guest-layout>
    {{-- Background Aura: Specific to the login portal --}}
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full h-[400px] bg-blue-600/10 blur-[100px] pointer-events-none -z-10"></div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-6" :status="session('status')" />

    {{-- Main Glass Login Card --}}
    <div class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2.5rem] p-8 md:p-12 shadow-2xl w-full max-w-md mx-auto">

        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-white tracking-tighter uppercase italic">
                Welcome <span class="text-blue-500 not-italic">Back</span>
            </h2>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mt-2">Access your portal</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- Email Address --}}
            <div class="group">
                <x-input-label for="email" :value="__('Email Address')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1" />
                <x-text-input id="email" class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3.5 px-5 transition-all shadow-inner"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@vampior.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="group">
                <div class="flex justify-between items-center mb-2 ml-1">
                    <x-input-label for="password" :value="__('Security Token')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]" />
                    @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-blue-500 hover:text-blue-400 transition-colors uppercase tracking-wider" href="{{ route('password.request') }}">
                        {{ __('Recovery?') }}
                    </a>
                    @endif
                </div>
                <x-text-input id="password" class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3.5 px-5 transition-all shadow-inner"
                    type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center ml-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded-md bg-white/5 border-white/10 text-blue-600 shadow-sm focus:ring-blue-500/20 transition-all" name="remember">
                    <span class="ms-3 text-[10px] font-black text-slate-500 group-hover:text-slate-300 transition-colors uppercase tracking-widest">{{ __('Maintain Session') }}</span>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded-2xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:scale-[1.02] active:scale-95 transition-all text-xs uppercase tracking-widest">
                    {{ __('Authorize Login') }}
                </button>
            </div>
        </form>

        {{-- Divider --}}
        <div class="relative my-10">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-white/5"></div>
            </div>
            <div class="relative flex justify-center text-[10px] font-black uppercase tracking-[0.3em]">
                <span class="px-4 bg-[#0f172a] text-slate-600">External Sync</span>
            </div>
        </div>

        {{-- Social Login Stack --}}
        <div class="grid grid-cols-1 gap-4">
            {{-- GitHub --}}
            <a href="{{ route('social.redirect', 'github') }}"
                class="flex items-center justify-center gap-3 w-full py-3.5 bg-[#24292F] hover:bg-gray-800 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-white/5">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                </svg>
                GitHub Access
            </a>

            {{-- Google --}}
            <a href="{{ route('social.redirect', 'google') }}"
                class="flex items-center justify-center gap-3 w-full py-3.5 bg-white hover:bg-gray-100 text-gray-900 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg">
                <svg class="w-4 h-4" viewBox="0 0 48 48">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                </svg>
                Google Access
            </a>
        </div>

        <div class="mt-10 text-center">
            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest">
                No authorization? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Request access</a>
            </p>
        </div>
    </div>
    </form>
</x-guest-layout>