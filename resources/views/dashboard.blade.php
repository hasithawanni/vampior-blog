<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 w-full">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                {{ __('Dashboard') }}
            </h2>

            {{-- Glassmorphic Search & Filter Bar --}}
            <form action="{{ route('dashboard') }}" method="GET" class="flex-grow max-w-3xl w-full flex gap-3">
                <div class="relative flex-grow group">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search for articles..."
                        class="w-full rounded-xl border-white/10 bg-white/5 backdrop-blur-md text-gray-200 placeholder-gray-500 focus:border-blue-500/50 focus:ring-blue-500/20 pl-11 pr-4 py-2.5 transition-all shadow-inner">

                    <div class="absolute left-4 top-3 text-gray-500 group-focus-within:text-blue-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <select name="category" onchange="this.form.submit()"
                    class="rounded-xl border-white/10 bg-white/5 backdrop-blur-md text-gray-300 focus:border-blue-500/50 focus:ring-blue-500/20 py-2.5 px-4 cursor-pointer">
                    <option value="" class="bg-[#0f172a]">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }} class="bg-[#0f172a]">
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </form>

            @hasanyrole('admin|editor')
            <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:scale-105 active:scale-95 whitespace-nowrap">
                + New Post
            </a>
            @endhasanyrole
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-8 p-4 bg-green-500/10 border border-green-500/20 backdrop-blur-md rounded-xl text-green-400 flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                <div class="group relative bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl overflow-hidden flex flex-col h-full transition-all duration-500 hover:shadow-[0_0_40px_rgba(59,130,246,0.15)] hover:border-blue-500/40 hover:-translate-y-1">

                    {{-- Image Section --}}
                    <div class="relative h-72 overflow-hidden border-b border-white/5">
                        @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover object-center transform group-hover:scale-105 transition-transform duration-700">
                        @else
                        <div class="w-full h-full bg-slate-800 flex items-center justify-center">
                            <span class="text-slate-600 font-black text-2xl tracking-tighter">NO IMAGE</span>
                        </div>
                        @endif

                        {{-- Category Badge --}}
                        @if($post->category)
                        <div class="absolute top-4 left-4">
                            <a href="{{ route('dashboard', ['category' => $post->category->slug]) }}" class="hover:scale-105 transition-transform inline-block">
                                <span class="bg-blue-600/80 backdrop-blur-md text-white text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-widest border border-white/20">
                                    {{ $post->category->name }}
                                </span>
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- Content Section --}}
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="mb-4 flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                            <a href="{{ route('dashboard', ['tag' => $tag->slug]) }}" class="text-[10px] font-bold px-2.5 py-1 rounded-md bg-blue-500/10 text-blue-400 border border-blue-500/20 hover:bg-blue-500/20 transition-colors">
                                #{{ strtoupper($tag->name) }}
                            </a>
                            @endforeach
                        </div>

                        <a href="{{ route('posts.show', $post->slug) }}" class="block mb-3">
                            <h3 class="text-xl font-extrabold text-white group-hover:text-blue-400 transition-colors line-clamp-2">
                                {{ $post->title }}
                            </h3>
                        </a>

                        <p class="text-slate-400 text-sm line-clamp-3 mb-6 leading-relaxed flex-grow">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>

                        {{-- Card Footer --}}
                        <div class="mt-auto pt-5 border-t border-white/5 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    @if($post->user->avatar)
                                    <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-white/10 group-hover:ring-blue-500/50 transition-all">
                                    @else
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center ring-2 ring-white/10">
                                        <span class="text-white text-xs font-bold">{{ substr($post->user->name, 0, 1) }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <a href="{{ route('dashboard', ['author' => $post->user->name]) }}" class="text-sm font-bold text-slate-200 hover:text-blue-400 transition-colors">
                                        {{ $post->user->name }}
                                    </a>
                                    <span class="text-[10px] text-slate-500 font-medium uppercase">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            {{-- Actions --}}
                            @auth
                            @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('editor') && auth()->id() === $post->user_id))
                            <div class="flex items-center gap-1">
                                <a href="{{ route('posts.edit', $post) }}" class="p-2 text-slate-400 hover:text-yellow-400 transition-colors rounded-lg hover:bg-white/5" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this post?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors rounded-lg hover:bg-white/5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            @endif
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Glassmorphic Pagination --}}
            @if($posts->hasPages())
            <div class="mt-12 bg-white/5 backdrop-blur-md border border-white/10 p-4 rounded-2xl shadow-xl">
                {{ $posts->withQueryString()->links() }}
            </div>
            @endif

            @if($posts->isEmpty())
            <div class="text-center py-32 bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl">
                <div class="text-slate-500 mb-4 flex justify-center">
                    <svg class="w-16 h-16 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <p class="text-slate-400 font-medium">No posts matched your search criteria.</p>
                <a href="{{ route('dashboard') }}" class="mt-4 inline-block text-blue-400 hover:text-blue-300 font-bold transition-colors">Clear all filters</a>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>