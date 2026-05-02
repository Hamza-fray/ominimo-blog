<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Blog Posts</h2>
            @auth
                <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">New Post</a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse($posts as $post)
                <div class="bg-white shadow rounded-lg p-6 mb-4">
                    <h3 class="text-lg font-bold">
                        <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-gray-500 text-sm">By {{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}</p>
                    <p class="mt-2 text-gray-700">{{ Str::limit($post->content, 150) }}</p>
                </div>
            @empty
                <p class="text-gray-500">No posts yet.</p>
            @endforelse
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
        </div>
    </div>
</x-app-layout>
