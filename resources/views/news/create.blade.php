<x-app-layout>
    <div class="max-w-4xl mx-auto mt-28 mb-20 px-4 sm:px-6 lg:px-8" x-data="newsCreateForm()">

        {{-- Header (unchanged) --}}
        <div class="fade-up text-center sm:text-left">
            <p class="uppercase tracking-[0.2em] text-xs text-red-600/80">Ziņas</p>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Pievienot ziņu</h1>
        </div>

        <form method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data"
            @submit.prevent="if (hasImage) $el.submit()"
            class="fade-up mt-8 bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/60 shadow-sm p-6 sm:p-8 space-y-6">
            @csrf

            {{-- Nosaukums --}}
            <div>
                <label for="title" class="block text-[12px] font-bold uppercase tracking-wider text-gray-700 mb-2">
                    Nosaukums <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" x-model="title" required
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
                    Saturs <span class="text-red-500">*</span>
                </label>
                <textarea name="content" id="content" rows="10" x-model="content" required
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 shadow-sm
                                 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition resize-y"
                    placeholder="Ziņas teksts…"></textarea>
                <div class="mt-1 text-xs text-gray-500"><span x-text="content.length">0</span> rakstzīmes</div>
                @error('content')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Attēls: obligāts --}}
            <div>
                <label class="block text-[12px] font-bold uppercase tracking-wider text-gray-700 mb-2">
                    Attēls <span class="text-red-500">*</span>
                </label>

                <div id="dropzone" @dragenter.prevent="dragOver = true" @dragover.prevent="dragOver = true"
                    @dragleave.prevent="dragOver = false" @drop.prevent="onDrop($event)"
                    :class="dragOver ? 'border-red-400 bg-red-50/40' : ''"
                    class="relative rounded-xl border-2 border-dashed border-gray-300 bg-white/70
                            transition p-6 text-center cursor-pointer">
                    <input type="file" name="image" id="image" accept="image/*" required
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="handleImage($event)">
                    <div class="space-y-1.5 pointer-events-none">
                        <p class="font-semibold text-gray-800">
                            Ievelc attēlu šeit vai izvēlies failu
                        </p>
                        <p class="text-xs text-gray-500">Atbalstītie formāti: JPG, PNG, WEBP</p>
                        <p class="text-xs" :class="hasImage ? 'text-green-700' : 'text-red-600'">
                            <template x-if="!hasImage">Obligāts laukums</template>
                            <template x-if="hasImage">Fails izvēlēts</template>
                        </p>
                        <p class="text-xs text-gray-600 truncate" x-show="imageName" x-text="imageName"></p>
                    </div>
                </div>

                {{-- Live preview --}}
                <div class="mt-3" x-show="previewUrl" x-cloak>
                    <div class="overflow-hidden rounded-xl border border-gray-200/70 shadow-sm">
                        <img :src="previewUrl" alt="Priekšskatījums" class="w-full max-h-64 object-cover">
                    </div>
                </div>

                @error('image')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Darbības --}}
            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-2">
                <a href="{{ route('news.index') }}"
                    class="inline-flex items-center justify-center rounded-full border border-gray-300 text-gray-700
                          hover:bg-gray-50 px-5 py-2.5 font-semibold transition">
                    Atcelt
                </a>
                <button type="submit" :disabled="!hasImage" :class="!hasImage ? 'opacity-60 cursor-not-allowed' : ''"
                    class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700
                               text-white px-6 py-2.5 font-semibold shadow-sm transition">
                    Publicēt ziņu
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');
        });

        function newsCreateForm() {
            return {
                title: @json(old('title', '')),
                content: @json(old('content', '')),
                imageName: '',
                previewUrl: '',
                dragOver: false,
                get hasImage() {
                    return !!this.imageName;
                },

                handleImage(e) {
                    const file = e.target.files?.[0];
                    this.setPreview(file);
                },
                onDrop(e) {
                    this.dragOver = false;
                    const file = e.dataTransfer.files?.[0];
                    if (!file) return;
                    const input = document.getElementById('image');
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    input.files = dt.files;
                    this.setPreview(file);
                },
                setPreview(file) {
                    if (!file) return;
                    this.imageName = file.name;
                    const reader = new FileReader();
                    reader.onload = (ev) => this.previewUrl = ev.target.result;
                    reader.readAsDataURL(file);
                },
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
                }
            }
        }
    </script>
</x-app-layout>
