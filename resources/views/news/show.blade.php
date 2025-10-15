<x-app-layout>
    <div class="max-w-5xl mx-auto mt-24 mb-12 px-4 sm:px-6 lg:px-8">

        {{-- ========== HERO ========== --}}
        <section data-animate data-stagger="0"
            class="opacity-0 translate-y-3
                   motion-safe:transition-all motion-safe:duration-700 motion-safe:ease-out
                   motion-reduce:transition-none motion-reduce:transform-none
                   data-[animate=in]:opacity-100 data-[animate=in]:translate-y-0
                   relative overflow-hidden rounded-2xl shadow-2xl mb-8">
            @if ($news->image_url)
                <img src="{{ $news->image_url }}" alt="{{ $news->title }}"
                    class="absolute inset-0 w-full h-full object-cover pointer-events-none"
                    onerror="this.style.display='none'">
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-600 pointer-events-none"></div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/35 to-transparent pointer-events-none">
            </div>

            @if (auth()->user()?->isAdmin())
                <div class="absolute top-4 right-4 z-20 flex gap-2">
                    <a href="{{ route('news.edit', $news) }}"
                        class="rounded-full bg-white/90 hover:bg-white text-gray-900 px-3 py-1.5 text-xs font-semibold shadow">
                        Rediģēt
                    </a>
                    <form action="{{ route('news.destroy', $news) }}" method="POST"
                        onsubmit="return confirm('Tiešām dzēst šo ziņu?');">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="rounded-full bg-white/90 hover:bg-white text-red-700 px-3 py-1.5 text-xs font-semibold shadow">
                            Dzēst
                        </button>
                    </form>
                </div>
            @endif

            <div class="relative z-10 p-6 sm:p-10">
                <div class="max-w-3xl">
                    <p class="text-red-300/90 text-[11px] tracking-[0.18em] font-bold uppercase">Ziņa</p>
                    <h1 class="mt-2 text-white font-extrabold leading-[1.02] text-3xl sm:text-5xl">
                        {{ $news->title }}
                    </h1>
                    <p class="mt-3 text-white/80 text-sm">
                        Publicēts {{ $news->created_at->format('d.m.Y') }}
                    </p>
                </div>
            </div>
        </section>

        {{-- ========== ARTICLE CARD ========== --}}
        <article data-animate data-stagger="1"
            class="opacity-0 translate-y-3
                   motion-safe:transition-all motion-safe:duration-700 motion-safe:ease-out
                   motion-reduce:transition-none motion-reduce:transform-none
                   data-[animate=in]:opacity-100 data-[animate=in]:translate-y-0
                   bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/60 shadow-sm p-6 sm:p-10">
            <div class="prose prose-sm sm:prose lg:prose-lg max-w-none text-gray-900">
                {!! nl2br(e($news->content)) !!}
            </div>

            <div class="mt-8 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                <a href="{{ route('news.index') }}"
                    class="inline-flex items-center justify-center rounded-full border border-red-200 text-red-700 hover:bg-red-50 px-5 py-2 font-semibold transition">
                    ← Atpakaļ uz ziņām
                </a>

                <div class="flex gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                        target="_blank"
                        class="rounded-full bg-gray-100 hover:bg-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 transition">
                        Dalīties Facebook
                    </a>
                </div>
            </div>
        </article>

        {{-- ========== “Vēl ziņas” (compact) ========== --}}
        @if (isset($more) && $more->count())
            <section data-animate data-stagger="2"
                class="opacity-0 translate-y-3
                       motion-safe:transition-all motion-safe:duration-700 motion-safe:ease-out
                       motion-reduce:transition-none motion-reduce:transform-none
                       data-[animate=in]:opacity-100 data-[animate=in]:translate-y-0
                       mt-10">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">Vēl ziņas</h2>
                    <a href="{{ route('news.index') }}"
                        class="text-sm font-semibold text-red-600 hover:text-red-800">Visas ziņas →</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach ($more as $n)
                        <a href="{{ route('news.show', $n) }}" data-animate data-stagger="{{ 3 + $loop->index }}"
                            class="opacity-0 translate-y-3
                                  motion-safe:transition-all motion-safe:duration-700 motion-safe:ease-out
                                  motion-reduce:transition-none motion-reduce:transform-none
                                  data-[animate=in]:opacity-100 data-[animate=in]:translate-y-0
                                  bg-white/80 backdrop-blur-sm rounded-xl border border-gray-200/60 shadow-sm overflow-hidden hover:shadow-lg hover:border-gray-300 transition">
                            @if ($n->image_url)
                                <img src="{{ $n->image_url }}" alt="{{ $n->title }}"
                                    class="w-full h-36 object-cover" onerror="this.style.display='none'">
                            @endif
                            <div class="p-4">
                                <h3 class="text-base font-semibold text-gray-900 line-clamp-2 hover:text-red-600">
                                    {{ $n->title }}
                                </h3>
                                <p class="text-[11px] text-gray-500 mt-1">{{ $n->created_at->format('d.m.Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const els = Array.from(document.querySelectorAll('[data-animate]'));
            els.forEach(el => {
                const idx = parseInt(el.getAttribute('data-stagger') || '0', 10);
                const delay = Math.max(0, idx) * 90;
                setTimeout(() => el.setAttribute('data-animate', 'in'), delay);
            });
        });
    </script>
</x-app-layout>
