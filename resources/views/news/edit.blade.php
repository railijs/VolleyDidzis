<x-app-layout>
    <div class="max-w-4xl mx-auto mt-32 mb-20 px-4 sm:px-6 lg:px-8"> {{-- Added mb-20 for bottom spacing --}}

        <h1 class="text-3xl font-bold text-gray-900 mb-12 text-center">
            Edit News
        </h1>

        <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data"
              class="bg-gray-50 shadow-md p-8 rounded-lg space-y-6 border border-gray-200"> {{-- Slightly darker background --}}
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition bg-white">
                @error('title')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-gray-700 font-semibold mb-2">Content</label>
                <textarea name="content" id="content" rows="8" required
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition bg-white">{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image -->
            @if($news->image)
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Current Image</label>
                    <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}"
                         class="w-full max-h-64 object-cover rounded-lg shadow-md mb-4">
                </div>
            @endif

            <!-- Upload New Image -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Replace Image (optional)</label>
                <label for="image"
                       class="flex items-center justify-center space-x-2 cursor-pointer px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M4 12l4-4m0 0l4 4m-4-4v12"/>
                    </svg>
                    <span class="text-gray-700">Choose File</span>
                </label>
                <input type="file" name="image" id="image" accept="image/*" class="hidden">
                @error('image')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('news.show', $news) }}"
                   class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                    Update News
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
