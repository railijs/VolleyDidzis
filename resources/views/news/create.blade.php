<x-app-layout>
    <div class="max-w-3xl mx-auto mt-16 px-4 sm:px-6 lg:px-8" x-data="newsForm()">

        <!-- Header -->
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-6 sm:mb-8">
            Add News
        </h2>

        <!-- Form -->
        <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data"
            class="bg-white p-6 sm:p-8 shadow-md border border-gray-200 rounded-lg space-y-6">

            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block font-semibold text-gray-700 mb-2">Title <span
                        class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" x-model="title"
                    class="w-full border border-gray-300 rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                <template x-if="errors.title">
                    <p class="text-red-600 text-sm mt-1" x-text="errors.title"></p>
                </template>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block font-semibold text-gray-700 mb-2">Content <span
                        class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="6" x-model="content"
                    class="w-full border border-gray-300 rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition resize-none"></textarea>
                <template x-if="errors.content">
                    <p class="text-red-600 text-sm mt-1" x-text="errors.content"></p>
                </template>
            </div>

            <!-- Image Upload with Preview -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Image (optional)</label>
                <div class="flex items-center gap-4">
                    <label for="image"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 text-gray-700 rounded-md cursor-pointer hover:bg-gray-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M4 12l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                        Choose Image
                    </label>
                    <span class="text-gray-600 text-sm truncate max-w-xs" x-text="imageName"></span>
                </div>
                <input type="file" name="image" id="image" accept="image/*" class="hidden"
                    @change="handleImage($event)">
                <template x-if="errors.image">
                    <p class="text-red-600 text-sm mt-1" x-text="errors.image"></p>
                </template>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-md shadow-md transition text-sm sm:text-base">
                Publish News
            </button>

        </form>
    </div>

    <script>
        function newsForm() {
            return {
                title: @json(old('title')),
                content: @json(old('content')),
                imageName: '',

                errors: {
                    @error('title')
                        title: '{{ $message }}',
                    @enderror
                    @error('content')
                        content: '{{ $message }}',
                    @enderror
                    @error('image')
                        image: '{{ $message }}',
                    @enderror
                },

                handleImage(event) {
                    const file = event.target.files[0];
                    this.imageName = file ? file.name : '';
                }
            }
        }
    </script>
</x-app-layout>
