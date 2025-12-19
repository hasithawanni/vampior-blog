<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-2xl text-white leading-tight tracking-tight flex items-center gap-3">
                <span class="p-2 bg-blue-500/20 rounded-lg border border-blue-500/30">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </span>
                {{ __('Refine Entry') }}
            </h2>
            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest bg-white/5 px-4 py-1 rounded-full border border-white/10">
                Editing: {{ Str::limit($post->title, 30) }}
            </div>
        </div>
    </x-slot>

    {{-- Trix Dependencies --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2.5rem] overflow-hidden shadow-2xl transition-all duration-500 hover:border-blue-500/20">
                <div class="p-8 md:p-12">

                    <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        @method('PUT')

                        {{-- Post Title Section --}}
                        <div class="group">
                            <x-input-label for="title" :value="__('Transmission Title')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1" />
                            <x-text-input id="title" name="title" type="text"
                                class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-4 px-6 transition-all shadow-inner text-lg font-bold"
                                :value="old('title', $post->title)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            {{-- Category Selection --}}
                            <div class="group">
                                <x-input-label for="category_id" :value="__('Classification')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1" />
                                <select name="category_id" id="category_id"
                                    class="block w-full bg-[#0f172a] border-white/10 rounded-xl text-slate-300 focus:ring-blue-500/20 focus:border-blue-500/50 py-3 px-5 transition-all shadow-inner cursor-pointer appearance-none">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                            {{-- Tag Input --}}
                            <div class="group">
                                <x-input-label for="tags" :value="__('Signal Markers (Tags)')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 ml-1" />
                                <x-text-input id="tags" name="tags" type="text"
                                    class="block w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:ring-blue-500/20 focus:border-blue-500/50 py-3 px-5 transition-all shadow-inner"
                                    :value="old('tags', $post->tags->pluck('name')->implode(', '))"
                                    placeholder="e.g. protocol, tech, alert" />
                                <x-input-error class="mt-2" :messages="$errors->get('tags')" />
                            </div>
                        </div>

                        {{-- Media Revision Section --}}
                        <div class="p-6 bg-white/5 border border-white/5 rounded-[2rem] shadow-inner">
                            <x-input-label :value="__('Media Revision (Optional)')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4 ml-1" />

                            <div class="flex flex-col md:flex-row items-center gap-8">
                                @if($post->image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $post->image) }}" class="w-40 h-24 object-cover rounded-2xl border-2 border-white/10 group-hover:border-blue-500/30 transition-all shadow-lg">
                                    <div class="absolute -top-2 -right-2 bg-blue-600 text-white text-[8px] font-black px-2 py-1 rounded uppercase tracking-widest shadow-lg">Current</div>
                                </div>
                                @endif

                                <div class="flex-grow w-full">
                                    <input type="file" name="image" id="image"
                                        class="block w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600/20 file:text-blue-400 hover:file:bg-blue-600/30 file:transition-all cursor-pointer" />
                                    <p class="mt-2 text-[9px] font-bold text-slate-600 uppercase tracking-widest ml-1">Upload to overwrite existing media asset.</p>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        {{-- Content Editor --}}
                        <div class="group">
                            <x-input-label for="content" :value="__('Transmission Data (Content)')" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4 ml-1" />
                            <div class="rounded-2xl border border-white/10 bg-white/5 shadow-inner overflow-hidden">
                                <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
                                <trix-editor input="content" class="trix-content prose dark:prose-invert max-w-none p-6 min-h-[400px] border-none text-white focus:outline-none"></trix-editor>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>

                        <div class="flex items-center justify-between pt-8 border-t border-white/5">
                            <a href="{{ route('dashboard') }}" class="text-[10px] font-black text-slate-500 hover:text-white uppercase tracking-widest transition-colors flex items-center gap-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('Abort Changes') }}
                            </a>

                            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-black py-4 px-12 rounded-2xl shadow-[0_0_30px_rgba(37,99,235,0.3)] hover:scale-105 active:scale-95 transition-all text-xs uppercase tracking-widest">
                                {{ __('Commit Updates') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <style>
        /* Trix Editor Dark Theme Overrides */
        trix-toolbar .trix-button-group {
            border-color: rgba(255, 255, 255, 0.1) !important;
            background: rgba(255, 255, 255, 0.02);
        }

        trix-toolbar .trix-button {
            border-bottom: none !important;
        }

        trix-toolbar .trix-button:hover {
            background: rgba(59, 130, 246, 0.1) !important;
        }

        trix-toolbar .trix-button--active {
            background: rgba(59, 130, 246, 0.2) !important;
        }

        trix-editor {
            color: #e2e8f0 !important;
        }

        trix-editor a {
            color: #60a5fa !important;
        }
    </style>
</x-app-layout>