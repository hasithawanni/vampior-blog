<nav x-data="{ open: false }" class="bg-[#0f172a]/60 backdrop-blur-xl border-b border-white/5 sticky top-0 z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> {{-- Increased height slightly for a more airy feel --}}
            <div class="flex">
                {{-- Branded Logo Section --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <span class="text-lg font-black tracking-tighter text-white uppercase italic hidden md:block">
                            Vampior<span class="text-blue-500 not-italic">Blog</span>
                        </span>
                    </a>
                </div>

                {{-- Desktop Navigation Links --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Global Feed') }}
                    </x-nav-link>

                    @auth
                    <x-nav-link :href="route('library.index')" :active="request()->routeIs('library.index')">
                        {{ __('My Library') }}
                    </x-nav-link>
                    @endauth

                    {{-- Glass Categories Dropdown --}}
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-4 py-2 border border-white/5 text-[10px] font-black uppercase tracking-widest rounded-xl text-slate-400 bg-white/5 hover:text-white hover:bg-white/10 focus:outline-none transition-all duration-300">
                                <div>Categories</div>
                                <div class="ms-2">
                                    <svg class="fill-current h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @foreach($allCategories as $cat)
                            <x-dropdown-link :href="route('categories.show', $cat->slug)">
                                {{ $cat->name }}
                            </x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>

                    @auth
                    @role('admin')
                    <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                        <span class="text-indigo-400">{{ __('Admin Core') }}</span>
                    </x-nav-link>
                    @endrole
                    @endauth
                </div>
            </div>

            {{-- Right-Side: User Settings --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 px-4 py-2 bg-white/5 border border-white/5 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                            <div class="relative">
                                @if(Auth::user()->avatar)
                                <img class="h-8 w-8 rounded-full object-cover border-2 border-blue-500/20 group-hover:border-blue-500/50 transition-all"
                                    src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                    alt="{{ Auth::user()->name }}" />
                                @else
                                <div class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center border-2 border-white/10">
                                    <svg class="h-4 w-4 text-slate-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-[#0f172a] rounded-full"></div>
                            </div>
                            <div class="text-[10px] font-black uppercase tracking-widest text-slate-300 group-hover:text-white transition-colors">{{ Auth::user()->name }}</div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Account Settings') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400">
                                {{ __('Disconnect') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="text-[10px] font-black text-slate-400 hover:text-white uppercase tracking-widest transition-colors">Log in</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-600 rounded-xl text-[10px] font-black text-white uppercase tracking-widest shadow-lg shadow-blue-500/20 hover:scale-105 transition-all">Sign Up</a>
                </div>
                @endauth
            </div>

            {{-- Mobile Menu Trigger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-xl text-slate-400 bg-white/5 border border-white/5 hover:text-white hover:bg-white/10 transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Mobile Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#0f172a]/95 backdrop-blur-2xl border-b border-white/5">
        <div class="pt-4 pb-6 space-y-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Global Feed') }}
            </x-responsive-nav-link>

            @auth
            <x-responsive-nav-link :href="route('library.index')" :active="request()->routeIs('library.index')">
                {{ __('My Library') }}
            </x-responsive-nav-link>

            @role('admin')
            <x-responsive-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                {{ __('Admin Core') }}
            </x-responsive-nav-link>
            @endrole
            @endauth

            <div class="px-4 pt-4 pb-2 text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] border-t border-white/5">
                Categories
            </div>
            @foreach($allCategories as $cat)
            <x-responsive-nav-link :href="route('categories.show', $cat->slug)">
                {{ $cat->name }}
            </x-responsive-nav-link>
            @endforeach
        </div>

        @auth
        <div class="pt-6 pb-6 border-t border-white/5 bg-white/5">
            <div class="px-6 flex items-center gap-4">
                <img class="h-10 w-10 rounded-full border border-blue-500/30" src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '#' }}" alt="">
                <div>
                    <div class="text-xs font-black text-white uppercase">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] font-bold text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-4 px-2 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile Configuration') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400">
                        {{ __('Disconnect Session') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>