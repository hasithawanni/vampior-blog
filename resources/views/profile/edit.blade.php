<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-2xl text-white leading-tight tracking-tight">
                {{ __('Account Settings') }}
            </h2>
            <div class="px-4 py-1 bg-blue-500/10 border border-blue-500/20 rounded-lg text-[10px] font-black text-blue-400 uppercase tracking-widest">
                User Configuration
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- Profile Information Section --}}
            <div class="transition-all duration-500 hover:translate-y-[-2px]">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Security / Password Section --}}
            <div class="transition-all duration-500 hover:translate-y-[-2px]">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Danger Zone / Account Deletion Section --}}
            <div class="transition-all duration-500 hover:translate-y-[-2px]">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>