<x-app-layout>
    <div class="max-w-4xl mx-auto mt-24 mb-12 px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 text-center sm:text-left">
            {{ $news->title }}
        </h1>

        <!-- Edit/Delete Buttons (Admin Only) -->
        @if(auth()->user()?->isAdmin())
        <div class="flex flex-col sm:flex-row sm:space-x-3 mb-6 justify-center sm:justify-start space-y-2 sm:space-y-0">
            <!-- Edit Button -->
            <a href="{{ route('news.edit', $news) }}"
               class="inline-flex items-center justify-center text-gray-700 hover:text-gray-900 border border-gray-300 hover:border-gray-400 px-4 py-2 rounded-md text-sm font-medium transition w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M16.5 3.5l4 4L7 21H3v-4L16.5 3.5z"/>
                </svg>
                Edit
            </a>

            <!-- Delete Button -->
            <form action="{{ route('news.destroy', $news) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this news item?');" class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center justify-center text-gray-700 hover:text-red-600 border border-gray-300 hover:border-red-400 px-4 py-2 rounded-md text-sm font-medium transition w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Delete
                </button>
            </form>
        </div>
        @endif

        <!-- Publication Date -->
        <p class="text-sm text-gray-600 mb-6 text-center sm:text-left">
            Published on {{ $news->created_at->format('F j, Y') }}
        </p>

        <!-- News Image -->
        @if($news->image)
            <div class="mb-8 flex justify-center overflow-hidden rounded-lg shadow-lg">
                <img src="{{ Storage::url($news->image) }}"
                     alt="{{ $news->title }}"
                     class="w-full max-h-[400px] sm:max-h-[500px] object-cover transition-transform duration-300 hover:scale-105 rounded-lg">
            </div>
        @endif

        <!-- News Content -->
        <div class="prose prose-sm sm:prose lg:prose-lg max-w-full text-gray-900 leading-relaxed space-y-6">
            {!! nl2br(e($news->content)) !!}
        </div>

        <!-- Back Button -->
        <div class="mt-10 text-center">
            <a href="{{ route('news.index') }}"
               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-md shadow-md transition text-sm sm:text-base">
                ← Back to News
            </a>
        </div>
    </div>
</x-app-layout>

<!-- Footer -->
<footer class="bg-gray-50 dark:bg-gray-900 py-8 mt-12">
    <div class="max-w-6xl mx-auto px-6 text-center space-y-6">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Connect with us</h3>
        <div class="flex justify-center gap-6">
            <a href="https://www.facebook.com/" target="_blank" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 transition">
                <svg class="w-6 h-6 inline-block" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.675 0h-21.35c-.734 0-1.325.591-1.325 1.325v21.351c0 .734.591 1.324 1.325 1.324h11.495v-9.294h-3.124v-3.622h3.124v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.464.099 2.795.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 1.763v2.312h3.587l-.467 3.622h-3.12v9.293h6.116c.733 0 1.324-.59 1.324-1.324v-21.35c0-.734-.591-1.325-1.324-1.325z"/>
                </svg>
            </a>
            <a href="https://twitter.com/" target="_blank" class="text-gray-700 dark:text-gray-300 hover:text-blue-400 transition">
                <svg class="w-6 h-6 inline-block" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 4.557a9.83 9.83 0 01-2.828.775 4.932 4.932 0 002.165-2.724 9.864 9.864 0 01-3.127 1.195 4.916 4.916 0 00-8.38 4.482c-4.083-.195-7.702-2.16-10.126-5.134a4.822 4.822 0 00-.664 2.475c0 1.708.87 3.216 2.188 4.099a4.904 4.904 0 01-2.228-.616c-.054 1.982 1.381 3.833 3.415 4.247a4.936 4.936 0 01-2.224.084 4.923 4.923 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.396 0-.788-.023-1.175-.068a13.945 13.945 0 007.557 2.212c9.054 0 14.001-7.496 14.001-13.986 0-.21-.005-.423-.014-.634a9.936 9.936 0 002.457-2.548l.002-.003z"/>
                </svg>
            </a>
            <a href="https://www.instagram.com/" target="_blank" class="text-gray-700 dark:text-gray-300 hover:text-pink-500 transition">
                <svg class="w-6 h-6 inline-block" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.336 3.608 1.311.975.975 1.249 2.242 1.311 3.608.058 1.266.07 1.646.07 4.851s-.012 3.584-.07 4.85c-.062 1.366-.336 2.633-1.311 3.608-.975.975-2.242 1.249-3.608 1.311-1.266.058-1.646.07-4.85.07s-3.584-.012-4.851-.07c-1.366-.062-2.633-.336-3.608-1.311-.975-.975-1.249-2.242-1.311-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.851c.062-1.366.336-2.633 1.311-3.608.975-.975 2.242-1.249 3.608-1.311 1.266-.058 1.646-.07 4.851-.07zm0-2.163c-3.259 0-3.667.012-4.947.072-1.523.066-2.874.35-3.905 1.382-1.031 1.03-1.315 2.382-1.382 3.905-.06 1.28-.072 1.688-.072 4.947s.012 3.667.072 4.947c.066 1.523.35 2.874 1.382 3.905 1.03 1.031 2.382 1.315 3.905 1.382 1.28.06 1.688.072 4.947.072s3.667-.012 4.947-.072c1.523-.066 2.874-.35 3.905-1.382 1.031-1.03 1.315-2.382 1.382-3.905.06-1.28.072-1.688.072-4.947s-.012-3.667-.072-4.947c-.066-1.523-.35-2.874-1.382-3.905-1.03-1.031-2.382-1.315-3.905-1.382-1.28-.06-1.688-.072-4.947-.072zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a3.999 3.999 0 110-7.998 3.999 3.999 0 010 7.998zm6.406-11.845a1.44 1.44 0 11-2.879 0 1.44 1.44 0 012.879 0z"/>
                </svg>
            </a>
        </div>
        <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} VolleyLV. All rights reserved.</p>
    </div>
</footer>
