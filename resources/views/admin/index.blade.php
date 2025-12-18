<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-600 dark:text-red-400 leading-tight flex items-center">
            Admin Dashboard 🛡️
        </h2>
    </x-slot>

    <div class="py-12 space-y-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2">Users Management</h3>
                <table class="w-full text-left dark:text-gray-300">
                    <thead>
                        <tr class="text-xs uppercase text-gray-500 border-b border-gray-700">
                            <th class="py-3">Name</th>
                            <th>Email</th>
                            <th>Current Role</th>
                            <th class="text-right">Assign New Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="py-4 font-medium">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                <span class="px-2 py-1 rounded text-[10px] uppercase font-bold 
                                        {{ $role->name === 'admin' ? 'bg-red-900/30 text-red-400 border border-red-800' : 
                                           ($role->name === 'editor' ? 'bg-yellow-900/30 text-yellow-400 border border-yellow-800' : 
                                           'bg-blue-900/30 text-blue-400 border border-blue-800') }}">
                                    {{ $role->name }}
                                </span>
                                @endforeach
                            </td>
                            <td class="text-right">
                                <form action="{{ route('admin.users.role', $user) }}" method="POST" class="inline-block">
                                    @csrf @method('PATCH')
                                    <select name="role" onchange="this.form.submit()"
                                        class="text-xs bg-gray-900 border-gray-700 text-gray-300 rounded focus:ring-red-500 focus:border-red-500"
                                        {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                        <option value="reader" {{ $user->hasRole('reader') ? 'selected' : '' }}>Reader</option>
                                        <option value="editor" {{ $user->hasRole('editor') ? 'selected' : '' }}>Editor</option>
                                        <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2">All Posts ({{ $posts->count() }})</h3>
                <table class="w-full text-left dark:text-gray-300">
                    <thead>
                        <tr class="text-xs uppercase text-gray-500 border-b border-gray-700">
                            <th class="py-3">Author</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th class="text-right">Moderation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="py-4 text-sm">{{ $post->user->name }}</td>
                            <td class="font-medium text-white">{{ $post->title }}</td>
                            <td>
                                <span class="px-2 py-1 rounded text-xs uppercase font-bold 
                                    {{ $post->status === 'published' ? 'text-green-400' : ($post->status === 'rejected' ? 'text-red-400' : 'text-yellow-400') }}">
                                    {{ $post->status }}
                                </span>
                            </td>
                            <td class="text-right flex justify-end items-center space-x-4 py-4">
                                @if($post->status !== 'published')
                                <form action="{{ route('admin.posts.status', [$post, 'published']) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="text-xs font-bold text-green-500 hover:text-green-300 uppercase">Approve</button>
                                </form>
                                @endif

                                @if($post->status !== 'rejected')
                                <form action="{{ route('admin.posts.status', [$post, 'rejected']) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="text-xs font-bold text-yellow-600 hover:text-yellow-400 uppercase">Reject</button>
                                </form>
                                @endif

                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Nuke this post forever?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs font-bold text-red-600 hover:text-red-400 uppercase">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>