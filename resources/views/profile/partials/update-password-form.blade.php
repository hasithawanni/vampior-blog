<section class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-10 shadow-2xl">
    <header>
        <h2 class="text-xl font-black text-white tracking-tight flex items-center gap-3">
            <span class="p-2 bg-blue-500/20 rounded-lg border border-blue-500/30">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </span>
            {{ __('Update Password') }}
        </h2>

        <p class="mt-4 text-sm text-slate-400 leading-relaxed">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-8">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div class="group">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3 px-5 transition-all shadow-inner"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- New Password --}}
        <div class="group">
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3 px-5 transition-all shadow-inner"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="group">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3 px-5 transition-all shadow-inner"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-6 pt-4 border-t border-white/5">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-black py-3 px-10 rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:scale-105 active:scale-95 transition-all text-xs uppercase tracking-widest">
                {{ __('Update Security') }}
            </button>

            @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="text-sm font-bold text-green-400 flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ __('Security updated.') }}
            </p>
            @endif
        </div>
    </form>
</section>