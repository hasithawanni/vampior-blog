<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}"
                    alt="{{ $post->title }}"
                    class="w-full h-[400px] object-cover object-top">
                @endif

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-wrap items-center gap-8 text-sm text-gray-500 mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <span class="font-bold text-blue-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            By {{ $post->user->name }}
                        </span>

                        <span class="bg-gray-200 dark:bg-gray-700 px-3 py-1 rounded text-xs uppercase tracking-wide font-semibold text-gray-700 dark:text-gray-300">
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </span>

                        <span>
                            {{ $post->created_at->format('F j, Y') }}
                        </span>
                    </div>

                    {{-- Post Content --}}
                    <div class="trix-content prose dark:prose-invert max-w-none text-lg leading-relaxed mb-6">
                        {!! $post->content !!}
                    </div>

                    {{-- 🛠️ UPDATED: Interaction Bar with Real Routes --}}
                    <div class="flex items-center gap-6 py-4 border-y border-gray-100 dark:border-gray-700 mb-6">
                        @auth
                        {{-- Like Button --}}
                        <form action="{{ route('posts.like', $post->id) }}" method="POST" class="flex items-center gap-2 group">
                            @csrf
                            <button type="submit"
                                class="{{ $post->isLikedBy(auth()->user()) ? 'text-red-500' : 'text-gray-400' }} group-hover:text-red-500 transition-colors">
                                <svg class="w-6 h-6" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                            <span class="text-sm font-medium text-gray-500">{{ $post->likes->count() }} Likes</span>
                        </form>

                        {{-- Save/Bookmark Button --}}
                        <form action="{{ route('posts.save', $post->id) }}" method="POST" class="flex items-center gap-2 group">
                            @csrf
                            <button type="submit"
                                class="{{ $post->isSavedBy(auth()->user()) ? 'text-yellow-500' : 'text-gray-400' }} group-hover:text-yellow-500 transition-colors">
                                <svg class="w-6 h-6" fill="{{ $post->isSavedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                </svg>
                            </button>
                            <span class="text-sm font-medium text-gray-500">
                                {{ $post->isSavedBy(auth()->user()) ? 'Saved' : 'Save for Later' }}
                            </span>
                        </form>
                        @else
                        <p class="text-xs text-gray-400">Log in to like or save this post.</p>
                        @endauth
                    </div>

                    {{-- Tags --}}
                    <div class="flex flex-wrap gap-2 mb-8">
                        @foreach($post->tags as $tag)
                        <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-medium px-2.5 py-1 rounded">
                            #{{ $tag->name }}
                        </span>
                        @endforeach
                    </div>

                    {{-- Admin/Author Actions --}}
                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6 flex justify-between items-center">
                        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700 font-semibold transition flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Dashboard
                        </a>

                        @auth
                        @if(auth()->id() === $post->user_id || auth()->user()->hasRole('admin'))
                        <div class="flex space-x-3">
                            <a href="{{ route('posts.edit', $post->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 transition">
                                Edit
                            </a>

                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                        @endif
                        @endauth
                    </div>
                </div>
            </div>

            {{-- --- COMMENTS SECTION --- --}}
            <div class="mt-12 border-t border-gray-200 dark:border-gray-700 pt-8">
                <div class="max-w-2xl mx-auto">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
                        Comments ({{ $post->comments->count() }})
                    </h3>

                    @auth
                    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-10">
                        @csrf
                        <textarea name="content" rows="3"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm p-3"
                            placeholder="Write a comment..." required></textarea>
                        <div class="mt-3 flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                                Post Comment
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="bg-blue-50 dark:bg-gray-700/50 p-6 rounded-lg text-center mb-10 border border-blue-100 dark:border-gray-600">
                        <p class="text-gray-700 dark:text-gray-300">
                            Want to join the discussion? <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">Log in</a> to leave a comment.
                        </p>
                    </div>
                    @endauth

                    <div class="space-y-6">
                        @forelse($post->comments as $comment)
                        <div class="flex space-x-4 p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-grow">
                                <div class="flex flex-col mb-1">
                                    <h4 class="text-gray-900 dark:text-white font-bold text-sm">{{ $comment->user->name }}</h4>
                                    <span class="text-gray-500 dark:text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                                    {{ $comment->content }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500 italic">No comments yet. Be the first!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>