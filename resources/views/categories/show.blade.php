<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="p-2.5 bg-blue-600/20 rounded-xl border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.2)]">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <h2 class="font-black text-2xl text-white leading-tight tracking-tight uppercase italic">
                    Category: <span class="text-blue-500 not-italic">{{ $category->name }}</span>
                </h2>
            </div>
            <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-white/5 border border-white/10 rounded-xl text-[10px] font-black text-slate-400 hover:text-white hover:bg-white/10 transition-all uppercase tracking-widest flex items-center gap-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Global Feed
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($posts->isEmpty())
            <div class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[3rem] p-20 text-center shadow-2xl">
                <div class="inline-flex p-6 bg-slate-800/50 rounded-full mb-6">
                    <svg class="w-12 h-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <p class="text-slate-400 text-xl font-bold tracking-tight">Empty Archives</p>
                <p class="text-slate-500 text-sm mt-2">No transmissions found in this frequency yet.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                <div class="glass-card group bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] overflow-hidden flex flex-col h-full transition-all duration-500 hover:translate-y-[-8px] hover:shadow-[0_20px_40px_rgba(0,0,0,0.4)] hover:border-blue-500/30">

                    {{-- Featured Media --}}
                    <div class="relative h-64 overflow-hidden">
                        @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover object-center transform group-hover:scale-110 transition-transform duration-700">
                        @else
                        <div class="w-full h-full bg-slate-800/50 flex items-center justify-center">
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">No Visual Signal</span>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a]/80 via-transparent to-transparent opacity-60"></div>

                        {{-- Floating Category Badge --}}
                        <div class="absolute bottom-4 left-6">
                            <span class="bg-blue-600/60 backdrop-blur-md text-white text-[9px] font-black px-3 py-1 rounded-lg uppercase tracking-[0.1em] border border-white/10">
                                {{ $category->name }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8 flex-grow flex flex-col">
                        {{-- Tag Row --}}
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($post->tags as $tag)
                            <span class="text-[9px] font-black text-blue-400 uppercase tracking-wider bg-blue-500/10 border border-blue-500/20 px-2 py-0.5 rounded-md">
                                #{{ $tag->name }}
                            </span>
                            @endforeach
                        </div>

                        {{-- Title --}}
                        <a href="{{ route('posts.show', $post->slug) }}" class="block mb-4">
                            <h3 class="text-xl font-extrabold text-white group-hover:text-blue-400 transition-colors leading-tight tracking-tight line-clamp-2">
                                {{ $post->title }}
                            </h3>
                        </a>

                        {{-- Preview Content --}}
                        <p class="text-slate-400 text-sm line-clamp-3 mb-8 leading-relaxed italic">
                            "{{ Str::limit(strip_tags($post->content), 100) }}"
                        </p>

                        {{-- Author & Actions Footer --}}
                        <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                @if($post->user->avatar)
                                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-8 h-8 rounded-full object-cover border-2 border-blue-500/20">
                                @else
                                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-[10px] font-black text-white border-2 border-white/5">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                                @endif
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-300">{{ $post->user->name }}</span>
                                    <span class="text-[9px] font-black text-slate-600 uppercase">{{ $post->created_at->format('M d') }}</span>
                                </div>
                            </div>

                            {{-- Role-Based Quick Controls --}}
                            @auth
                            @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('editor') && auth()->id() === $post->user_id))
                            <div class="flex items-center gap-1">
                                <a href="{{ route('posts.edit', $post) }}" class="p-2 text-yellow-500/50 hover:text-yellow-400 transition-colors" title="Edit Entry">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Archive Transmission?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500/50 hover:text-red-400 transition-colors" title="Delete Entry">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            <div class="mt-12 glass-pagination">
                {{ $posts->links() }}
            </div>
            @endif

        </div>
    </div>
</x-app-layout>