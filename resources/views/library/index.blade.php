<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Library') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Section 1: Saved Posts --}}
            <div class="mb-12">
                <div class="flex items-center gap-2 mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Saved for Later</h3>
                    <span class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-0.5 rounded-full text-xs">
                        {{ $savedPosts->count() }}
                    </span>
                </div>

                @if($savedPosts->isEmpty())
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow text-center">
                    <p class="text-gray-500 italic">You haven't bookmarked any posts yet.</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($savedPosts as $post)
                    {{-- We are using the post card logic directly here --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col h-full border border-gray-100 dark:border-gray-700">
                        @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6 flex-grow">
                            <span class="bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </span>
                            <a href="{{ route('posts.show', $post->slug) }}" class="block mt-2">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white hover:text-blue-500 transition">
                                    {{ $post->title }}
                                </h4>
                            </a>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mt-2 line-clamp-2">
                                {{ Str::limit(strip_tags($post->content), 80) }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Section 2: Liked Posts --}}
            <div>
                <div class="flex items-center gap-2 mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Liked Posts</h3>
                    <span class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-0.5 rounded-full text-xs">
                        {{ $likedPosts->count() }}
                    </span>
                </div>

                @if($likedPosts->isEmpty())
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow text-center">
                    <p class="text-gray-500 italic">No liked posts to show.</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($likedPosts as $post)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col h-full border border-gray-100 dark:border-gray-700">
                        @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6 flex-grow">
                            <span class="bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase">
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </span>
                            <a href="{{ route('posts.show', $post->slug) }}" class="block mt-2">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white hover:text-blue-500 transition">
                                    {{ $post->title }}
                                </h4>
                            </a>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mt-2 line-clamp-2">
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