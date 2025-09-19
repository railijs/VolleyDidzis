<x-app-layout>
  <x-slot name="header">
    <h2 class="sr-only">{{ __('About VolleyLV') }}</h2>
  </x-slot>

  <div class="relative min-h-screen">
    <!-- Hero Section -->
    <div class="relative h-64 sm:h-96">
      <img src="https://volleycountry.com/wp-content/uploads/2020/11/olympics-volleyball-rio.jpg"
           alt="Volley background"
           class="absolute inset-0 w-full h-full object-cover brightness-75">
      <div class="absolute inset-0 bg-black/40"></div>
      <div class="relative h-full flex flex-col justify-center items-center text-center px-4 sm:px-6">
        <h1 class="text-2xl sm:text-4xl font-extrabold text-white mb-2 sm:mb-4">About VolleyLV</h1>
        <p class="max-w-xs sm:max-w-2xl text-sm sm:text-lg text-gray-200">
          Building Latvia’s volleyball community — tournaments, stats, connections.
        </p>
      </div>
    </div>

    <!-- Content Sections -->
    <!-- Content Sections -->
<div class="relative max-w-xl sm:max-w-4xl mx-auto my-8 space-y-8 px-4 sm:px-6 lg:px-8">
  <!-- Our Story -->
  <section class="space-y-3 sm:space-y-4">
    <h2 class="text-xl sm:text-3xl font-semibold text-gray-900">Our Story</h2>
    <p class="text-sm sm:text-base text-gray-700">
      VolleyLV was born from a mission to create a better way for volleyball players across Latvia to connect and collaborate.
    </p>
    <p class="text-sm sm:text-base text-gray-700">
      By simplifying the search for tournaments and building a stronger community, we aim to make volleyball more accessible and enjoyable for everyone.
    </p>
  </section>

  <!-- Mission & Vision -->
  <section class="space-y-3 sm:space-y-4">
    <h2 class="text-xl sm:text-3xl font-semibold text-gray-900">Mission & Vision</h2>
    <p class="text-sm sm:text-base text-gray-700">
      Our mission is to empower volleyball players across Latvia by making it easier to connect, collaborate, and discover tournaments—eliminating the hassle of searching and helping the community thrive.    
    </p>
  </section>
</div>
</x-app-layout>


<footer class="bg-gray-100 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Connect with us</h3>
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