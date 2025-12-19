<section class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-10 shadow-2xl">
    <header>
        <h2 class="text-xl font-black text-white tracking-tight flex items-center gap-3">
            <span class="p-2 bg-red-500/20 rounded-lg border border-red-500/30">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </span>
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-4 text-sm text-slate-400 leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <div class="mt-8">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="bg-red-500/10 border border-red-500/20 text-red-500 font-black px-6 py-3 rounded-xl hover:bg-red-500/20 transition-all shadow-[0_0_20px_rgba(239,68,68,0.1)]">
            {{ __('Permanently Delete Account') }}
        </x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        {{-- Inner Modal Glass Styling --}}
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-[#0f172a] border border-white/10 rounded-3xl">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-4 text-sm text-slate-400 leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-8 group">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-red-500/20 focus:border-red-500/50 py-3 px-5 transition-all"
                    placeholder="{{ __('Confirm your password to proceed...') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-white/5 border-white/10 text-slate-400 hover:text-white rounded-xl px-6 py-2">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-500 text-white font-black px-8 py-2 rounded-xl shadow-lg shadow-red-600/20 transition-all">
                    {{ __('Confirm Deletion') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>