<x-app-layout>
    <div class="max-w-7xl mx-auto mt-24 px-4 sm:px-6 lg:px-8">

        <!-- Header with Title and Add News Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 sm:mb-12 gap-4">
            <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900">Latest News</h1>

            @if (auth()->user()?->isAdmin())
                <a href="{{ route('news.create') }}"
                    class="w-full sm:w-auto inline-flex justify-center items-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 sm:px-6 py-2 shadow-md rounded-md transition text-sm sm:text-base">
                    + Add News
                </a>
            @endif
        </div>

        <!-- Featured Article -->
        @if ($news->count() > 0)
            @php $featured = $news->first(); @endphp
            <div class="mb-8 sm:mb-12 rounded-lg shadow-lg overflow-hidden relative group">
                @if ($featured->image)
                    <a href="{{ route('news.show', $featured) }}">
                        <img src="{{ Storage::url($featured->image) }}" alt="{{ $featured->title }}"
                            class="w-full h-64 sm:h-96 object-cover transition-transform duration-300 group-hover:scale-105">
                    </a>
                @endif
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 sm:p-6">
                    @if ($featured->category)
                        <span class="text-xs sm:text-sm uppercase tracking-wide text-indigo-400 font-semibold">
                            {{ $featured->category }}
                        </span>
                    @endif
                    <h2 class="text-xl sm:text-3xl font-bold text-white mt-1 sm:mt-2 mb-2">
                        <a href="{{ route('news.show', $featured) }}" class="hover:text-indigo-300">
                            {{ $featured->title }}
                        </a>
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-200 mb-2">
                        {{ $featured->created_at->format('F j, Y') }}
                    </p>
                    <p class="text-gray-100 text-sm line-clamp-3 max-w-full sm:max-w-3xl">
                        {{ Str::limit(strip_tags($featured->content), 180) }}
                    </p>
                </div>
            </div>
        @endif

        <!-- News Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach ($news->skip(1) as $item)
                <div class="flex flex-col bg-white shadow-md hover:shadow-xl transition overflow-hidden rounded-lg">
                    @if ($item->image)
                        <a href="{{ route('news.show', $item) }}">
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}"
                                class="w-full h-48 sm:h-56 object-cover transition-transform duration-300 hover:scale-105">
                        </a>
                    @endif
                    <div class="flex flex-col flex-1 p-4 sm:p-6">
                        @if ($item->category)
                            <span
                                class="text-xs sm:text-sm uppercase tracking-wide text-indigo-600 font-semibold mb-1 sm:mb-2">
                                {{ $item->category }}
                            </span>
                        @endif

                        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-1 sm:mb-2 line-clamp-2">
                            <a href="{{ route('news.show', $item) }}" class="hover:text-indigo-600 transition">
                                {{ $item->title }}
                            </a>
                        </h3>

                        <p class="text-xs sm:text-sm text-gray-500 mb-2 sm:mb-4">
                            {{ $item->created_at->format('F j, Y') }}
                        </p>

                        <p class="text-gray-700 flex-1 mb-2 sm:mb-4 text-sm sm:text-base line-clamp-3">
                            {{ Str::limit(strip_tags($item->content), 150) }}
                        </p>

                        <a href="{{ route('news.show', $item) }}"
                            class="inline-block text-indigo-600 hover:text-indigo-800 text-sm sm:text-base font-medium transition">
                            Read More →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 sm:mt-12">
            {{ $news->links() }}
        </div>
    </div>
</x-app-layout>

<footer class="bg-gray-100 dark:bg-gray-900 py-6 sm:py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center">
        <h3 class="text-sm sm:text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Connect with us</h3>
        <div class="flex flex-wrap justify-center gap-4 sm:gap-6">
            <a href="https://www.facebook.com/" target="_blank"
                class="text-gray-700 dark:text-gray-300 hover:text-blue-600 transition">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 inline-block" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M22.675 0h-21.35c-.734 0-1.325.591-1.325 1.325v21.351c0 .734.591 1.324 1.325 1.324h11.495v-9.294h-3.124v-3.622h3.124v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.464.099 2.795.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 1.763v2.312h3.587l-.467 3.622h-3.12v9.293h6.116c.733 0 1.324-.59 1.324-1.324v-21.35c0-.734-.591-1.325-1.324-1.325z" />
                </svg>
            </a>
            <a href="https://twitter.com/" target="_blank"
                class="text-gray-700 dark:text-gray-300 hover:text-blue-400 transition">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 inline-block" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M24 4.557a9.83 9.83 0 01-2.828.775 4.932 4.932 0 002.165-2.724 9.864 9.864 0 01-3.127 1.195 4.916 4.916 0 00-8.38 4.482c-4.083-.195-7.702-2.16-10.126-5.134a4.822 4.822 0 00-.664 2.475c0 1.708.87 3.216 2.188 4.099a4.904 4.904 0 01-2.228-.616c-.054 1.982 1.381 3.833 3.415 4.247a4.936 4.936 0 01-2.224.084 4.923 4.923 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.396 0-.788-.023-1.175-.068a13.945 13.945 0 007.557 2.212c9.054 0 14.001-7.496 14.001-13.986 0-.21-.005-.423-.014-.634a9.936 9.936 0 002.457-2.548l.002-.003z" />
                </svg>
            </a>
            <a href="https://www.instagram.com/" target="_blank"
                class="text-gray-700 dark:text-gray-300 hover:text-pink-500 transition">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 inline-block" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.336 3.608 1.311.975.975 1.249 2.242 1.311 3.608.058 1.266.07 1.646.07 4.851s-.012 3.584-.07 4.85c-.062 1.366-.336 2.633-1.311 3.608-.975.975-2.242 1.249-3.608 1.311-1.266.058-1.646.07-4.85.07s-3.584-.012-4.851-.07c-1.366-.062-2.633-.336-3.608-1.311-.975-.975-1.249-2.242-1.311-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.851c.062-1.366.336-2.633 1.311-3.608.975-.975 2.242-1.249 3.608-1.311 1.266-.058 1.646-.07 4.851-.07zm0-2.163c-3.259 0-3.667.012-4.947.072-1.523.066-2.874.35-3.905 1.382-1.031 1.03-1.315 2.382-1.382 3.905-.06 1.28-.072 1.688-.072 4.947s.012 3.667.072 4.947c.066 1.523.35 2.874 1.382 3.905 1.03 1.031 2.382 1.315 3.905 1.382 1.28.06 1.688.072 4.947.072s3.667-.012 4.947-.072c1.523-.066 2.874-.35 3.905-1.382 1.031-1.03 1.315-2.382 1.382-3.905.06-1.28.072-1.688.072-4.947s-.012-3.667-.072-4.947c-.066-1.523-.35-2.874-1.382-3.905-1.03-1.031-2.382-1.315-3.905-1.382-1.28-.06-1.688-.072-4.947-.072zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a3.999 3.999 0 110-7.998 3.999 3.999 0 010 7.998zm6.406-11.845a1.44 1.44 0 11-2.879 0 1.44 1.44 0 012.879 0z" />
                </svg>
            </a>
        </div>
        <p class="mt-4 sm:mt-6 text-xs sm:text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }}
            VolleyLV. All rights reserved.</p>
    </div>
</footer>
