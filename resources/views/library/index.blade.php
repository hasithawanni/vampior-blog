<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-white leading-tight tracking-tight">
                {{ __('My Library') }}
            </h2>
            <div class="flex gap-4">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest bg-white/5 px-3 py-1 rounded-lg border border-white/10">
                    Collections: 2
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-16">

            {{-- Section 1: Saved Posts --}}
            <div class="relative">
                <div class="flex items-center gap-4 mb-8">
                    <div class="p-3 bg-yellow-500/20 rounded-2xl border border-yellow-500/30">
                        <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white tracking-tight">Saved for Later</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-tighter">Your bookmarked collection ({{ $savedPosts->count() }})</p>
                    </div>
                </div>

                @if($savedPosts->isEmpty())
                <div class="bg-white/5 backdrop-blur-md border border-white/10 p-12 rounded-[2rem] text-center shadow-2xl">
                    <p class="text-slate-500 font-medium italic">You haven't bookmarked any articles yet. Discover something new on the feed.</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($savedPosts as $post)
                    <div class="glass-card group relative bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl overflow-hidden flex flex-col h-full transition-all duration-500 hover:shadow-[0_0_40px_rgba(234,179,8,0.1)] hover:border-yellow-500/40">
                        @if($post->image)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        </div>
                        @endif
                        <div class="p-6">
                            <span class="bg-blue-600/60 backdrop-blur-md text-white text-[10px] font-black px-2 py-0.5 rounded-lg uppercase tracking-widest border border-white/10">
                                {{ $post->category->name ?? 'Article' }}
                            </span>
                            <a href="{{ route('posts.show', $post->slug) }}" class="block mt-4">
                                <h4 class="text-lg font-extrabold text-white group-hover:text-yellow-400 transition-colors line-clamp-2">
                                    {{ $post->title }}
                                </h4>
                            </a>
                            <p class="text-slate-400 text-xs mt-3 line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($post->content), 80) }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Section 2: Liked Posts --}}
            <div class="relative">
                <div class="flex items-center gap-4 mb-8">
                    <div class="p-3 bg-red-500/20 rounded-2xl border border-red-500/30">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white tracking-tight">Liked Articles</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-tighter">Your favorites ({{ $likedPosts->count() }})</p>
                    </div>
                </div>

                @if($likedPosts->isEmpty())
                <div class="bg-white/5 backdrop-blur-md border border-white/10 p-12 rounded-[2rem] text-center shadow-2xl">
                    <p class="text-slate-500 font-medium italic">No liked posts to show yet. Tap the heart on a post to see it here.</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($likedPosts as $post)
                    <div class="glass-card group relative bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl overflow-hidden flex flex-col h-full transition-all duration-500 hover:shadow-[0_0_40px_rgba(239,68,68,0.1)] hover:border-red-500/40">
                        @if($post->image)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        </div>
                        @endif
                        <div class="p-6">
                            <span class="bg-indigo-600/60 backdrop-blur-md text-white text-[10px] font-black px-2 py-0.5 rounded-lg uppercase tracking-widest border border-white/10">
                                {{ $post->category->name ?? 'Article' }}
                            </span>
                            <a href="{{ route('posts.show', $post->slug) }}" class="block mt-4">
                                <h4 class="text-lg font-extrabold text-white group-hover:text-red-400 transition-colors line-clamp-2">
                                    {{ $post->title }}
                                </h4>
                            </a>
                            <p class="text-slate-400 text-xs mt-3 line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($post->content), 80) }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>