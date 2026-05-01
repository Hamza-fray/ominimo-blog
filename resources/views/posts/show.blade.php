<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $post->title }}</h2>
            @can('update', $post)
                <div class="flex gap-2">
                    <a href="{{ route('posts.edit', $post) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded"
                                onclick="return confirm('Delete this post?')">Delete</button>
                    </form>
                </div>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <p class="text-gray-500 text-sm mb-4">By {{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}</p>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $post->content }}</p>
            </div>

            <!-- Comments -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="font-bold text-lg mb-4">Comments ({{ $post->comments->count() }})</h3>

                @forelse($post->comments as $comment)
                    <div class="border-b py-3">
                        <p class="text-gray-700">{{ $comment->comment }}</p>
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-gray-500 text-sm">
                                {{ $comment->user->name ?? 'Guest' }} · {{ $comment->created_at->diffForHumans() }}
                            </p>
                            @can('delete', $comment)
                                <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 text-sm">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No comments yet.</p>
                @endforelse
            </div>

            <!-- Add Comment -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-bold text-lg mb-4">Leave a Comment</h3>
                <form method="POST" action="{{ route('comments.store', $post) }}">
                    @csrf
                    <div class="mb-4">
                        <textarea name="comment" rows="3" placeholder="Write your comment..."
                                  class="w-full border rounded px-3 py-2 @error('comment') border-red-500 @enderror"></textarea>
                        @error('comment') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Post Comment</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
