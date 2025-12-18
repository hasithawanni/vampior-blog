<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Post: {{ $post->title }}
        </h2>
    </x-slot>

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Post Title --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Post Title</label>
                            <input type="text" name="title" value="{{ old('title', $post->title) }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Category --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Category</label>
                                <select name="category_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tags (New Requirement: Uses pluck to turn existing tags back into a string) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tags (Comma separated)</label>
                                <input type="text" name="tags" value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" placeholder="e.g. tech, lifestyle, news">
                            </div>
                        </div>

                        {{-- Cover Image --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Change Cover Image (Optional)</label>
                            @if($post->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $post->image) }}" class="w-32 h-20 object-cover rounded shadow">
                            </div>
                            @endif
                            <input type="file" name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-1">
                        </div>

                        {{-- Rich Text Content (Trix integration replaces the old textarea) --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Content</label>
                            <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
                            <trix-editor input="content" class="trix-content prose dark:prose-invert max-w-none rounded-md shadow-sm border-gray-300 dark:border-gray-700 min-h-[300px]"></trix-editor>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:underline">Cancel</a>

                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                Update Post
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>