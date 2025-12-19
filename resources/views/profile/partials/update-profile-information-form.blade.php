<section class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-10 shadow-2xl">
    <header>
        <h2 class="text-xl font-black text-white tracking-tight flex items-center gap-3">
            <span class="p-2 bg-blue-500/20 rounded-lg border border-blue-500/30">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </span>
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-4 text-sm text-slate-400 leading-relaxed">
            {{ __("Update your account's profile identity, avatar, and contact email.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-8" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Avatar Preview & Upload --}}
        <div class="flex flex-col md:flex-row items-center gap-8 p-6 bg-white/5 border border-white/5 rounded-2xl shadow-inner">
            <div class="relative group">
                @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-blue-500/20 group-hover:border-blue-500/50 transition-all shadow-lg">
                @else
                <div class="w-24 h-24 rounded-full bg-slate-800 flex items-center justify-center border-4 border-white/10 text-slate-500">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                @endif
            </div>

            <div class="flex-grow w-full">
                <x-input-label for="avatar" :value="__('Upload New Photo')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2" />
                <input id="avatar" name="avatar" type="file"
                    class="block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600/20 file:text-blue-400 hover:file:bg-blue-600/30 file:transition-all cursor-pointer" />
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        {{-- Name Field --}}
        <div class="group">
            <x-input-label for="name" :value="__('Full Name')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1" />
            <x-text-input id="name" name="name" type="text"
                class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3 px-5 transition-all shadow-inner"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Bio Field --}}
        <div class="group">
            <x-input-label for="bio" :value="__('Bio / About Me')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1" />
            <textarea id="bio" name="bio" rows="4"
                class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3 px-5 transition-all shadow-inner"
                placeholder="Tell the community about yourself...">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        {{-- Email Field --}}
        <div class="group">
            <x-input-label for="email" :value="__('Email Address')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1" />
            <x-text-input id="email" name="email" type="email"
                class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3 px-5 transition-all shadow-inner"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-4 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-xl">
                <p class="text-sm text-yellow-400">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" class="ml-2 underline font-bold hover:text-yellow-300">
                        {{ __('Resend link') }}
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-bold text-xs text-green-400">
                    {{ __('A new link has been sent!') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-6 pt-6 border-t border-white/5">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-black py-3 px-10 rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:scale-105 active:scale-95 transition-all text-xs uppercase tracking-widest">
                {{ __('Update Profile') }}
            </button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="text-sm font-bold text-green-400 flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ __('Saved successfully.') }}
            </p>
            @endif
        </div>
    </form>
</section>