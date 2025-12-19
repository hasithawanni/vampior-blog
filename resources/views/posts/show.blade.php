<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                {{ $post->title }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Feed
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Main Glass Article Card --}}
            <article class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl mb-12">

                {{-- Post Cover Image --}}
                @if($post->image)
                <div class="relative h-[450px] w-full">
                    <img src="{{ asset('storage/' . $post->image) }}"
                        alt="{{ $post->title }}"
                        class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent"></div>

                    {{-- Floating Category Badge --}}
                    @if($post->category)
                    <div class="absolute bottom-6 left-8">
                        <span class="bg-blue-600/60 backdrop-blur-xl text-white text-xs font-black px-4 py-1.5 rounded-xl uppercase tracking-widest border border-white/20 shadow-xl">
                            {{ $post->category->name }}
                        </span>
                    </div>
                    @endif
                </div>
                @endif

                <div class="p-8 md:p-12">
                    {{-- Meta Info Row --}}
                    <div class="flex flex-wrap items-center gap-6 text-sm mb-10 pb-8 border-b border-white/5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg">
                                {{ substr($post->user->name, 0, 1) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-white font-bold">{{ $post->user->name }}</span>
                                <span class="text-slate-500 text-[10px] uppercase font-medium">{{ $post->created_at->format('F j, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Post Content --}}
                    <div class="trix-content prose prose-invert prose-blue max-w-none text-slate-300 text-lg leading-relaxed mb-12">
                        {!! $post->content !!}
                    </div>

                    {{-- Interaction Bar --}}
                    <div class="flex items-center gap-8 py-6 border-y border-white/5 mb-10">
                        @auth
                        {{-- Like Button --}}
                        <form action="{{ route('posts.like', $post->id) }}" method="POST" class="flex items-center gap-3 group">
                            @csrf
                            <button type="submit"
                                class="p-3 rounded-xl transition-all {{ $post->isLikedBy(auth()->user()) ? 'bg-red-500/20 text-red-500' : 'bg-white/5 text-slate-400 group-hover:text-red-400' }}">
                                <svg class="w-6 h-6" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                            <span class="text-sm font-bold text-slate-300">{{ $post->likes->count() }} Likes</span>
                        </form>

                        {{-- Save/Bookmark Button --}}
                        <form action="{{ route('posts.save', $post->id) }}" method="POST" class="flex items-center gap-3 group">
                            @csrf
                            <button type="submit"
                                class="p-3 rounded-xl transition-all {{ $post->isSavedBy(auth()->user()) ? 'bg-yellow-500/20 text-yellow-500' : 'bg-white/5 text-slate-400 group-hover:text-yellow-400' }}">
                                <svg class="w-6 h-6" fill="{{ $post->isSavedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                </svg>
                            </button>
                            <span class="text-sm font-bold text-slate-300">
                                {{ $post->isSavedBy(auth()->user()) ? 'Saved to Library' : 'Save for Later' }}
                            </span>
                        </form>
                        @else
                        <p class="text-xs text-slate-500 italic">Sign in to interact with this post.</p>
                        @endauth
                    </div>

                    {{-- Tags --}}
                    <div class="flex flex-wrap gap-2 mb-10">
                        @foreach($post->tags as $tag)
                        <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-widest">
                            #{{ $tag->name }}
                        </span>
                        @endforeach
                    </div>

                    {{-- Admin/Author Actions --}}
                    @auth
                    @if(auth()->id() === $post->user_id || auth()->user()->hasRole('admin'))
                    <div class="flex justify-end gap-3 pt-8 border-t border-white/5">
                        <a href="{{ route('posts.edit', $post->id) }}" class="px-6 py-2 bg-yellow-500/20 text-yellow-500 border border-yellow-500/30 rounded-xl font-bold text-xs uppercase hover:bg-yellow-500/30 transition">
                            Edit Post
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Permanently delete this post?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-6 py-2 bg-red-500/20 text-red-500 border border-red-500/30 rounded-xl font-bold text-xs uppercase hover:bg-red-500/30 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                    @endif
                    @endauth
                </div>
            </article>

            {{-- --- GLASS COMMENTS SECTION --- --}}
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-12 shadow-2xl">
                <h3 class="text-2xl font-black text-white mb-10 flex items-center gap-3">
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    Discussion ({{ $post->comments->count() }})
                </h3>

                @auth
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-12">
                    @csrf
                    <textarea name="content" rows="4"
                        class="w-full bg-white/5 border-white/10 text-white focus:ring-blue-500/50 focus:border-blue-500/50 rounded-2xl p-4 transition shadow-inner"
                        placeholder="Share your thoughts..." required></textarea>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-black py-3 px-8 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                            Post Comment
                        </button>
                    </div>
                </form>
                @else
                <div class="bg-blue-500/5 border border-blue-500/20 p-8 rounded-2xl text-center mb-12">
                    <p class="text-slate-300">
                        Join the conversation. <a href="{{ route('login') }}" class="text-blue-400 font-black hover:underline">Log in</a> to comment.
                    </p>
                </div>
                @endauth

                {{-- Individual Comments --}}
                <div class="space-y-6">
                    @forelse($post->comments as $comment)
                    <div class="flex gap-4 p-6 rounded-2xl bg-white/5 border border-white/5 transition-all hover:border-white/10">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-slate-700 to-slate-900 rounded-xl flex items-center justify-center text-blue-400 font-black border border-white/10">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-white font-bold text-sm">{{ $comment->user->name }}</h4>
                                <span class="text-slate-500 text-[10px] uppercase font-bold tracking-tighter">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-slate-400 text-sm leading-relaxed italic">
                                "{{ $comment->content }}"
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-slate-500 font-medium">No comments yet. Start the conversation!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>