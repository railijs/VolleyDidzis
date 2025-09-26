<x-app-layout>
    <div class="max-w-4xl mx-auto mt-28 mb-20 px-4 sm:px-6 lg:px-8">

        {{-- Page-load / reveal --}}
        <style>
            @media (prefers-reduced-motion: no-preference) {
                .fade-up {
                    opacity: 0;
                    transform: translateY(12px);
                    transition: opacity .6s ease, transform .6s ease
                }

                .loaded .fade-up {
                    opacity: 1;
                    transform: none
                }
            }
        </style>

        {{-- Header --}}
        <div class="fade-up text-center sm:text-left">
            <p class="uppercase tracking-[0.2em] text-xs text-red-600/80">Ziņas</p>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Rediģēt ziņu</h1>
        </div>

        {{-- Form Card --}}
        <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data"
            class="fade-up mt-8 bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/60 shadow-sm p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Nosaukums --}}
            <div>
                <label for="title" class="block text-[12px] font-bold uppercase tracking-wider text-gray-700 mb-2">
                    Nosaukums
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-gray-900 shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                    placeholder="Ieraksti ziņas virsrakstu">
                @error('title')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Saturs --}}
            <div>
                <label for="content" class="block text-[12px] font-bold uppercase tracking-wider text-gray-700 mb-2">
                    Saturs
                </label>
                <textarea name="content" id="content" rows="10" required
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition resize-y"
                    placeholder="Ziņas teksts…">{{ old('content', $news->content) }}</textarea>
                <div class="mt-1 text-xs text-gray-500"><span id="charCount">0</span> rakstzīmes</div>
                @error('content')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pašreizējais attēls --}}
            @if ($news->image)
                <div>
                    <span class="block text-[12px] font-bold uppercase tracking-wider text-gray-700 mb-2">
                        Pašreizējais attēls
                    </span>
                    <div class="overflow-hidden rounded-xl border border-gray-200/70 shadow-sm">
                        <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}"
                            class="w-full max-h-64 object-cover">
                    </div>
                </div>
            @endif

            {{-- Jauns attēls (drag & drop + preview) --}}
            <div>
                <label class="block text-[12px] font-bold uppercase tracking-wider text-gray-700 mb-2">
                    Nomainīt attēlu (pēc izvēles)
                </label>

                <div id="dropzone"
                    class="relative rounded-xl border-2 border-dashed border-gray-300 hover:border-red-300 bg-white/70
                            transition p-6 text-center cursor-pointer">
                    <input type="file" name="image" id="image" accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="space-y-1.5 pointer-events-none">
                        <p class="font-semibold text-gray-800">Ievelc attēlu šeit vai izvēlies failu</p>
                        <p class="text-xs text-gray-500">Atbalstītie formāti: JPG, PNG, WEBP</p>
                    </div>
                </div>

                {{-- Live preview (hidden until file chosen) --}}
                <div id="previewWrap" class="hidden mt-3">
                    <div class="overflow-hidden rounded-xl border border-gray-200/70 shadow-sm">
                        <img id="previewImg" src="#" alt="Priekšskatījums" class="w-full max-h-64 object-cover">
                    </div>
                </div>

                @error('image')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Darbības --}}
            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-2">
                <a href="{{ route('news.show', $news) }}"
                    class="inline-flex items-center justify-center rounded-full border border-gray-300 text-gray-700
                          hover:bg-gray-50 px-5 py-2.5 font-semibold transition">
                    Atcelt
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700
                               text-white px-6 py-2.5 font-semibold shadow-sm transition">
                    Atjaunot ziņu
                </button>
            </div>
        </form>
    </div>

    {{-- Small helpers: page-load class, char counter, drag&drop with preview --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');

            // Char counter for content
            const content = document.getElementById('content');
            const charCount = document.getElementById('charCount');
            if (content && charCount) {
                const updateCount = () => charCount.textContent = content.value.length.toString();
                updateCount();
                content.addEventListener('input', updateCount);
            }

            // Drag & drop + preview
            const dz = document.getElementById('dropzone');
            const fileInput = document.getElementById('image');
            const previewWrap = document.getElementById('previewWrap');
            const previewImg = document.getElementById('previewImg');

            const setPreview = (file) => {
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => {
                    previewImg.src = e.target.result;
                    previewWrap.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            };

            ['dragenter', 'dragover'].forEach(evt =>
                dz.addEventListener(evt, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dz.classList.add('border-red-400', 'bg-red-50/40');
                })
            );
            ['dragleave', 'drop'].forEach(evt =>
                dz.addEventListener(evt, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dz.classList.remove('border-red-400', 'bg-red-50/40');
                })
            );
            dz.addEventListener('drop', (e) => {
                const file = e.dataTransfer.files?.[0];
                if (file) {
                    fileInput.files = e.dataTransfer.files;
                    setPreview(file);
                }
            });
            fileInput.addEventListener('change', (e) => {
                const file = e.target.files?.[0];
                setPreview(file);
            });
        });
    </script>
</x-app-layout>
