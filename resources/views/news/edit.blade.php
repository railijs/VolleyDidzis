<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;1,8..60,300&family=DM+Sans:wght@400;500&display=swap');

        .ncf * {
            box-sizing: border-box;
        }

        .ncf {
            --ink: #0F0F0E;
            --ink-2: #3A3935;
            --ink-3: #7A7770;
            --ink-4: #B8B5AF;
            --paper: #F8F6F1;
            --paper-2: #EFECE5;
            --rule: #D8D4CC;
            --red: #B8241C;
            --red-hover: #961E17;
            --red-tint: #F9EEEE;
            --white: #FFFFFF;
            --green: #1E6A3A;
            --green-tint: #EAF4EE;

            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 6rem;
            margin-top: 50px;
        }

        .ncf-wrap {
            max-width: 780px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        /* ── Page header ── */
        .ncf-header {
            border-top: 4px solid var(--ink);
            padding: 1.5rem 0 1.25rem;
        }

        .ncf-eyebrow {
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.5rem;
        }

        .ncf-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 900;
            letter-spacing: -0.025em;
            line-height: 1.1;
            color: var(--ink);
            margin: 0;
        }

        .ncf-subtitle {
            font-size: 0.85rem;
            color: var(--ink-3);
            font-family: 'Source Serif 4', serif;
            font-weight: 300;
            margin-top: 0.4rem;
        }

        .ncf-rule {
            border: none;
            border-top: 1px solid var(--rule);
            margin: 0;
        }

        /* ── Form ── */
        .ncf-form {
            padding: 2rem 0 0;
        }

        .ncf-field {
            margin-bottom: 1.75rem;
        }

        .ncf-field:last-of-type {
            margin-bottom: 0;
        }

        .ncf-label {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .ncf-label__text {
            font-size: 0.68rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-2);
        }

        .ncf-label__req {
            color: var(--red);
            margin-left: 0.2rem;
        }

        .ncf-label__hint {
            font-size: 0.72rem;
            color: var(--ink-4);
        }

        .ncf-input,
        .ncf-textarea {
            width: 100%;
            font-family: 'Source Serif 4', serif;
            font-size: 1rem;
            font-weight: 400;
            color: var(--ink);
            background: var(--white);
            border: none;
            border-bottom: 1px solid var(--rule);
            padding: 0.6rem 0;
            outline: none;
            border-radius: 0;
            transition: border-color 0.2s;
            display: block;
        }

        .ncf-input::placeholder,
        .ncf-textarea::placeholder {
            color: var(--ink-4);
            font-style: italic;
        }

        .ncf-input:focus,
        .ncf-textarea:focus {
            border-bottom-color: var(--ink);
        }

        .ncf-input.has-error,
        .ncf-textarea.has-error {
            border-bottom-color: var(--red);
        }

        .ncf-textarea {
            resize: vertical;
            min-height: 200px;
            line-height: 1.8;
        }

        .ncf-error {
            font-size: 0.75rem;
            color: var(--red);
            margin-top: 0.35rem;
        }

        /* ── Current image ── */
        .ncf-current-img {
            border: 1px solid var(--rule);
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .ncf-current-img img {
            width: 100%;
            max-height: 280px;
            object-fit: cover;
            display: block;
        }

        .ncf-current-img__label {
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-4);
            padding: 0.5rem 0.75rem;
            border-top: 1px solid var(--rule);
            background: var(--paper-2);
        }

        /* ── Dropzone ── */
        .ncf-dropzone {
            position: relative;
            border: 1px solid var(--rule);
            background: var(--white);
            padding: 2.5rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            margin-top: 0.5rem;
        }

        .ncf-dropzone.drag-over {
            border-color: var(--red);
            background: var(--red-tint);
        }

        .ncf-dropzone.has-file {
            border-color: var(--green);
            background: var(--green-tint);
        }

        .ncf-dropzone input[type="file"] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .ncf-dropzone__icon {
            width: 36px;
            height: 36px;
            margin: 0 auto 0.75rem;
            color: var(--ink-4);
        }

        .ncf-dropzone__icon svg {
            width: 100%;
            height: 100%;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .ncf-dropzone.drag-over .ncf-dropzone__icon {
            color: var(--red);
        }

        .ncf-dropzone.has-file .ncf-dropzone__icon {
            color: var(--green);
        }

        .ncf-dropzone__main {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--ink-2);
            margin-bottom: 0.3rem;
        }

        .ncf-dropzone__sub {
            font-size: 0.75rem;
            color: var(--ink-4);
        }

        .ncf-dropzone__status {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .ncf-dropzone__status--empty {
            color: var(--ink-4);
            font-style: italic;
        }

        .ncf-dropzone__status--ok {
            color: var(--green);
        }

        .ncf-dropzone__filename {
            font-size: 0.75rem;
            color: var(--ink-3);
            margin-top: 0.25rem;
        }

        /* ── New image preview ── */
        .ncf-preview {
            margin-top: 1rem;
            overflow: hidden;
            border: 1px solid var(--rule);
        }

        .ncf-preview img {
            width: 100%;
            max-height: 280px;
            object-fit: cover;
            display: block;
        }

        .ncf-separator {
            border: none;
            border-top: 1px solid var(--rule);
            margin: 2rem 0;
        }

        /* ── Actions ── */
        .ncf-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding-top: 2rem;
            border-top: 1px solid var(--rule);
            flex-wrap: wrap;
        }

        .ncf-cancel {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--ink-3);
            border-bottom: 1px solid var(--rule);
            padding-bottom: 1px;
            transition: color 0.15s, border-color 0.15s;
        }

        .ncf-cancel:hover {
            color: var(--ink);
            border-color: var(--ink);
        }

        .ncf-submit {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            background: var(--ink);
            color: var(--white);
            border: 1px solid var(--ink);
            padding: 0.6rem 1.75rem;
            cursor: pointer;
            border-radius: 0;
            transition: background 0.15s, border-color 0.15s;
        }

        .ncf-submit:hover {
            background: var(--ink-2);
            border-color: var(--ink-2);
        }

        .ncf-submit--ready {
            background: var(--red);
            border-color: var(--red);
        }

        .ncf-submit--ready:hover {
            background: var(--red-hover);
            border-color: var(--red-hover);
        }

        /* ── Reveal ── */
        .ncf-reveal {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .ncf-reveal.in {
            opacity: 1;
            transform: none;
        }
    </style>

    <div class="ncf" x-data="newsEditForm()">
        <div class="ncf-wrap">

            <header class="ncf-header ncf-reveal" data-stagger="0">
                <div class="ncf-eyebrow">Ziņas</div>
                <h1 class="ncf-title">Rediģēt ziņu</h1>
                <p class="ncf-subtitle">Maini laukus un saglabā izmaiņas.</p>
            </header>

            <hr class="ncf-rule">

            <form method="POST" action="{{ route('news.update', $news) }}" enctype="multipart/form-data"
                class="ncf-form">
                @csrf
                @method('PUT')

                {{-- Nosaukums --}}
                <div class="ncf-field ncf-reveal" data-stagger="1">
                    <div class="ncf-label">
                        <span class="ncf-label__text">Nosaukums<span class="ncf-label__req">*</span></span>
                    </div>
                    <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}"
                        required class="ncf-input {{ $errors->has('title') ? 'has-error' : '' }}"
                        placeholder="Ieraksti ziņas virsrakstu…">
                    @error('title')
                        <div class="ncf-error">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="ncf-separator">

                {{-- Saturs --}}
                <div class="ncf-field ncf-reveal" data-stagger="2">
                    <div class="ncf-label">
                        <span class="ncf-label__text">Saturs<span class="ncf-label__req">*</span></span>
                        <span class="ncf-label__hint" x-text="content.length + ' rakstzīmes'">0 rakstzīmes</span>
                    </div>
                    <textarea name="content" id="content" rows="10" x-model="content" required
                        class="ncf-textarea {{ $errors->has('content') ? 'has-error' : '' }}" placeholder="Ziņas teksts…">{{ old('content', $news->content) }}</textarea>
                    @error('content')
                        <div class="ncf-error">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="ncf-separator">

                {{-- Attēls --}}
                <div class="ncf-field ncf-reveal" data-stagger="3">
                    <div class="ncf-label">
                        <span class="ncf-label__text">Attēls</span>
                        <span class="ncf-label__hint">JPG, PNG, WEBP · Neobligāts aizstājums</span>
                    </div>

                    {{-- Current image --}}
                    @if ($news->image)
                        <div class="ncf-current-img">
                            <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}">
                            <div class="ncf-current-img__label">Pašreizējais attēls</div>
                        </div>
                    @endif

                    {{-- New image dropzone --}}
                    <div class="ncf-dropzone" :class="{ 'drag-over': dragOver, 'has-file': hasImage }"
                        @dragenter.prevent="dragOver = true" @dragover.prevent="dragOver = true"
                        @dragleave.prevent="dragOver = false" @drop.prevent="onDrop($event)">

                        <input type="file" name="image" id="image" accept="image/*"
                            @change="handleImage($event)">

                        <div class="ncf-dropzone__icon">
                            <svg viewBox="0 0 24 24">
                                <template x-if="!hasImage">
                                    <g>
                                        <rect x="3" y="3" width="18" height="18" rx="1" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <path d="M21 15l-5-5L5 21" />
                                    </g>
                                </template>
                                <template x-if="hasImage">
                                    <path d="M20 6L9 17l-5-5" />
                                </template>
                            </svg>
                        </div>

                        <div class="ncf-dropzone__main"
                            x-text="hasImage ? 'Jauns attēls pievienots' : 'Ievelc attēlu vai izvēlies failu'"></div>
                        <div class="ncf-dropzone__sub" x-show="!hasImage">Noklikšķini vai ievelc šeit</div>
                        <div class="ncf-dropzone__status"
                            :class="hasImage ? 'ncf-dropzone__status--ok' : 'ncf-dropzone__status--empty'"
                            x-text="hasImage ? 'Attēls gatavs augšupielādei' : '{{ $news->image ? 'Pašreizējais attēls tiks saglabāts' : 'Nav attēla' }}'">
                        </div>
                        <div class="ncf-dropzone__filename" x-show="imageName" x-text="imageName"></div>
                    </div>

                    {{-- New image preview --}}
                    <div class="ncf-preview" x-show="previewUrl" x-cloak>
                        <img :src="previewUrl" alt="Priekšskatījums">
                    </div>

                    @error('image')
                        <div class="ncf-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="ncf-actions ncf-reveal" data-stagger="4">
                    <a href="{{ route('news.show', $news) }}" class="ncf-cancel">← Atcelt</a>
                    <button type="submit" class="ncf-submit ncf-submit--ready">
                        Saglabāt izmaiņas
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.ncf-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 50 + i * 70);
            });
        });

        function newsEditForm() {
            return {
                content: @json(old('content', $news->content)),
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
                    reader.onload = ev => this.previewUrl = ev.target.result;
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
</x-app-layout>
