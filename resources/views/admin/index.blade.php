<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-extrabold text-2xl text-white leading-tight tracking-tight flex items-center gap-3">
                <span class="p-2 bg-red-500/20 rounded-lg border border-red-500/30">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </span>
                Admin Management Center
            </h2>
            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest bg-white/5 px-4 py-2 rounded-xl border border-white/10">
                System Status: <span class="text-green-500">Secure</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 space-y-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Users Management Section --}}
            <div class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl mb-12">
                <div class="p-8">
                    <h3 class="text-xl font-black text-white mb-8 flex items-center gap-2">
                        <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                        User Permissions
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] uppercase font-black text-slate-500 tracking-[0.2em] border-b border-white/5">
                                    <th class="pb-4 pl-4">Member Info</th>
                                    <th class="pb-4">Current Authorization</th>
                                    <th class="pb-4 text-right pr-4">Access Control</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($users as $user)
                                <tr class="group hover:bg-white/5 transition-all duration-300">
                                    <td class="py-5 pl-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-white">{{ $user->name }}</span>
                                            <span class="text-xs text-slate-500 tracking-tighter">{{ $user->email }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex gap-2">
                                            @foreach($user->roles as $role)
                                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border
                                                {{ $role->name === 'admin' ? 'bg-red-500/10 text-red-400 border-red-500/20' : 
                                                   ($role->name === 'editor' ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' : 
                                                   'bg-blue-500/10 text-blue-400 border-blue-500/20') }}">
                                                {{ $role->name }}
                                            </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-right pr-4">
                                        <form action="{{ route('admin.users.role', $user) }}" method="POST" class="inline-block">
                                            @csrf @method('PATCH')
                                            <select name="role" onchange="this.form.submit()"
                                                class="text-[10px] font-bold bg-[#0f172a] border-white/10 text-slate-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer py-1.5 pl-3 pr-8"
                                                {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                                <option value="reader" {{ $user->hasRole('reader') ? 'selected' : '' }}>READER</option>
                                                <option value="editor" {{ $user->hasRole('editor') ? 'selected' : '' }}>EDITOR</option>
                                                <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>ADMIN</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Content Moderation Section --}}
            <div class="glass-card bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] overflow-hidden shadow-2xl">
                <div class="p-8">
                    <h3 class="text-xl font-black text-white mb-8 flex items-center gap-2">
                        <span class="w-2 h-6 bg-red-500 rounded-full"></span>
                        Content Moderation Queue ({{ $posts->count() }})
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] uppercase font-black text-slate-500 tracking-[0.2em] border-b border-white/5">
                                    <th class="pb-4 pl-4">Title & Author</th>
                                    <th class="pb-4">Publish State</th>
                                    <th class="pb-4 text-right pr-4">Decision Engine</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($posts as $post)
                                <tr class="group hover:bg-white/5 transition-all duration-300">
                                    <td class="py-5 pl-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-white group-hover:text-blue-400 transition-colors">{{ Str::limit($post->title, 40) }}</span>
                                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">By {{ $post->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border
                                            {{ $post->status === 'published' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 
                                               ($post->status === 'rejected' ? 'bg-red-500/10 text-red-400 border-red-500/20' : 
                                               'bg-yellow-500/10 text-yellow-400 border-yellow-500/20') }}">
                                            {{ $post->status }}
                                        </span>
                                    </td>
                                    <td class="text-right pr-4">
                                        <div class="flex justify-end items-center gap-2">
                                            @if($post->status !== 'published')
                                            <form action="{{ route('admin.posts.status', [$post, 'published']) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button class="px-4 py-1.5 bg-green-500/10 text-green-400 border border-green-500/20 rounded-xl text-[9px] font-black uppercase hover:bg-green-500/20 transition-all">
                                                    Approve
                                                </button>
                                            </form>
                                            @endif

                                            @if($post->status !== 'rejected')
                                            <form action="{{ route('admin.posts.status', [$post, 'rejected']) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button class="px-4 py-1.5 bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 rounded-xl text-[9px] font-black uppercase hover:bg-yellow-500/20 transition-all">
                                                    Reject
                                                </button>
                                            </form>
                                            @endif

                                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Nuke this post forever?')">
                                                @csrf @method('DELETE')
                                                <button class="p-2 text-slate-500 hover:text-red-500 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>