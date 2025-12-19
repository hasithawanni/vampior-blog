<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">
                {{ __('Create New Post') }}
            </h2>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Editor Mode</p>
        </div>
    </x-slot>

    {{-- Trix Editor Styling --}}
    <style>
        trix-editor {
            min-height: 20em !important;
            border-radius: 1rem !important;
        }

        /* Custom Trix toolbar for the theme */
        .dark trix-toolbar .trix-button {
            background-color: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark trix-toolbar .trix-button--active {
            background-color: rgba(59, 130, 246, 0.2) !important;
            color: #60a5fa !important;
        }

        .dark trix-editor {
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(15, 23, 42, 0.5);
        }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Main Glass Form Container --}}
            <div class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl">
                <div class="p-8 md:p-12">

                    {{-- Error Handling --}}
                    @if ($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl mb-8 flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <ul class="text-sm font-medium">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        {{-- Title Field --}}
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1">Post Title</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:border-blue-500/50 focus:ring-blue-500/20 py-3.5 px-5 transition-all shadow-inner"
                                required placeholder="Catchy and relevant...">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Category Selection --}}
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1">Category</label>
                                <select name="category_id"
                                    class="w-full bg-white/5 border-white/10 rounded-xl text-slate-300 focus:border-blue-500/50 focus:ring-blue-500/20 py-3.5 px-5 cursor-pointer">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} class="bg-[#0f172a]">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tags Field --}}
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1">Tags (Comma Separated)</label>
                                <input type="text" name="tags" value="{{ old('tags') }}"
                                    class="w-full bg-white/5 border-white/10 rounded-xl text-white placeholder-slate-600 focus:border-blue-500/50 focus:ring-blue-500/20 py-3.5 px-5 transition-all shadow-inner"
                                    placeholder="laravel, coding, design">
                            </div>
                        </div>

                        {{-- File Input --}}
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1">Cover Image</label>
                            <div class="relative group">
                                <input type="file" name="image"
                                    class="block w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-600/20 file:text-blue-400 hover:file:bg-blue-600/30 file:transition-all cursor-pointer bg-white/5 border border-white/10 rounded-xl p-2">
                            </div>
                        </div>

                        {{-- Rich Text Editor --}}
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 ml-1">Article Body</label>
                            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                            <trix-editor input="content" class="trix-content prose prose-invert max-w-none shadow-inner"></trix-editor>
                        </div>

                        {{-- Submit Row --}}
                        <div class="flex items-center justify-between pt-8 border-t border-white/5">
                            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-slate-500 hover:text-white transition">Cancel</a>

                            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-black py-4 px-10 rounded-2xl shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:scale-105 active:scale-95 transition-all text-xs uppercase tracking-widest">
                                Publish Article
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>