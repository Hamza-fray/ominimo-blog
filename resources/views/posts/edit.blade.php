<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Post</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('posts.update', $post) }}">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $post->title) }}"
                               class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
                        @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Content</label>
                        <textarea name="content" rows="6"
                                  class="w-full border rounded px-3 py-2 @error('content') border-red-500 @enderror">{{ old('content', $post->content) }}</textarea>
                        @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                    <a href="{{ route('posts.show', $post) }}" class="ml-4 text-gray-600">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
