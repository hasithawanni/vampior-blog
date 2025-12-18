<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <form action="{{ route('dashboard') }}" method="GET" class="flex-grow max-w-lg w-full">
                <div class="relative">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search posts..."
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 pl-4 pr-10 py-2 shadow-sm">

                    <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            @hasanyrole('admin|editor')
            <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-md whitespace-nowrap">
                + New Post
            </a>
            @endhasanyrole
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col h-full">

                    @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}"
                        alt="{{ $post->title }}"
                        class="w-full h-56 object-cover object-top">
                    @else
                    <div class="w-full h-56 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                        <span class="text-gray-400 font-bold">NO IMAGE</span>
                    </div>
                    @endif

                    <div class="p-6 flex-grow flex flex-col">
                        {{-- UPDATED: Flex-wrap ensures Category and Tags stay in a neat row --}}
                        <div class="mb-3 flex flex-wrap items-center gap-2">
                            @if($post->category)
                            <a href="{{ route('categories.show', $post->category->slug) }}" class="inline-block hover:opacity-75 transition">
                                <span class="bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">
                                    {{ $post->category->name }}
                                </span>
                            </a>
                            @endif

                            {{-- TAGS: Styled as small hashtag badges --}}
                            @foreach($post->tags as $tag)
                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-gray-200 dark:border-gray-600">
                                #{{ $tag->name }}
                            </span>
                            @endforeach
                        </div>

                        <a href="{{ route('posts.show', $post->slug) }}" class="block mb-2 group">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-blue-400 transition-colors">
                                {{ $post->title }}
                            </h3>
                        </a>

                        {{-- UPDATED: strip_tags removes the Trix <div> and <strong> tags from preview --}}
                        <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-4 flex-grow">
                            {{ Str::limit(strip_tags($post->content), 100) }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <div class="flex items-center">
                                @if($post->user->avatar)
                                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-6 h-6 rounded-full object-cover mr-2 border border-gray-300 dark:border-gray-600">
                                @else
                                <div class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                @endif
                                <span class="text-xs font-medium text-gray-900 dark:text-gray-100">{{ $post->user->name }}</span>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>

                                @auth
                                @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('editor') && auth()->id() === $post->user_id))
                                <div class="flex items-center gap-2 pl-3 border-l border-gray-300 dark:border-gray-600">
                                    <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 hover:text-yellow-600 transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');" class="flex m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 transition" title="Delete">
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
                </div>
                @endforeach
            </div>

            @if($posts->hasPages())
            <div class="mt-8 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                {{ $posts->withQueryString()->links() }}
            </div>
            @endif

            @if($posts->isEmpty())
            <div class="text-center py-20">
                <p class="text-gray-500 dark:text-gray-400">No posts found.</p>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>