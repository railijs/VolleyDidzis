<x-app-layout>
    <div class="relative min-h-screen pt-24 pb-16 bg-gradient-to-b from-white via-red-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @php
                $q = isset($q) ? trim($q) : trim(request('q', ''));

                if ($news instanceof \Illuminate\Pagination\AbstractPaginator) {
                    $items = $news->getCollection();
                    $totalNews = $news->total();
                } elseif ($news instanceof \Illuminate\Support\Collection) {
                    $items = $news;
                    $totalNews = $items->count();
                } else {
                    $items = collect($news);
                    $totalNews = $items->count();
                }

                $hasResults = $items->count() > 0;
            @endphp

            <!-- Header -->
            <div data-animate data-stagger="0"
                class="opacity-0 translate-y-3
                       motion-safe:transition-all motion-safe:duration-700 motion-safe:ease-out
                       motion-reduce:transition-none motion-reduce:transform-none
                       data-[animate=in]:opacity-100 data-[animate=in]:translate-y-0
                       flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
                <div>
                    <p class="uppercase tracking-[0.2em] text-xs text-red-600/80">Ziņas</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Visas ziņas</h1>
                    @if ($q !== '')
                        <p class="mt-1 text-sm text-gray-600">
                            Meklēts pēc: <span class="font-semibold">“{{ $q }}”</span> • Atrastas:
                            {{ $totalNews }}
                        </p>
                    @endif
                </div>

                @if (auth()->user()?->isAdmin())
                    <a href="{{ route('news.create') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 shadow transition">
                        + Pievienot ziņu
                    </a>
                @endif
            </div>

            <!-- Search -->
            <div data-animate data-stagger="1"
                class="opacity-0 translate-y-3
                       motion-safe:transition-all motion-safe:duration-700 motion-safe:ease-out
                       motion-reduce:transition-none motion-reduce:transform-none
                       data-[animate=in]:opacity-100 data-[animate=in]:translate-y-0">
                <form method="GET" action="{{ route('news.index') }}" class="relative group">
                    <input type="search" name="q" value="{{ $q }}"
                        placeholder="Meklēt ziņas vai atslēgvārdus…"
                        class="w-full rounded-full bg-white/80 backdrop-blur-sm border border-gray-200/70 shadow-sm px-5 sm:px-6 py-3 sm:py-3.5 pr-24 text-sm sm:text-base
                               focus:outline-none focus:ring-4 focus:ring-red-200/60 focus:border-red-300 transition" />
                    @if ($q !== '')
                        <button type="button" id="clearSearch"
                            class="absolute right-24 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-sm px-2 py-1">
                            Notīrīt
                        </button>
                    @endif
                    <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 shadow">
                        Meklēt
                    </button>
                </form>
            </div>

            @if ($hasResults)
                <!-- Featured -->
                @php $featured = $items->first(); @endphp
                @if ($featured)
                    <section data-animate data-stagger="2"
                        class="opacity-0 translate-y-3
                               motion-safe:transition-all motion-safe:duration-700 motion-safe:ease-out
                               motion-reduce:transition-none motion-reduce:transform-none
                               data-[animate=in]:opacity-100 data-[animate=in]:translate-y-0
                               relative overflow-hidden rounded-2xl shadow-xl mt-8 mb-8 group">
                        <div class="absolute inset-0">
                            @if ($featured->image_url)
                                <a href="{{ route('news.show', $featured) }}">
                                    <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}"
                                        class="w-full h-[18rem] sm:h-[22rem] object-cover transition duration-700 ease-out group-hover:scale-[1.03]"
                                        onerror="this.style.display='none'">
                                </a>
                            @else
                                <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=1600&auto=format&fit=crop"
                                    alt="Vietturis" class="w-full h-[18rem] sm:h-[22rem] object-cover">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/35 to-black/10"></div>
                        </div>

                        <div class="relative z-10 p-5 sm:p-8 max-w-3xl">
                            <h2 class="mt-1 text-white font-extrabold leading-tight text-2xl sm:text-4xl">
                                <a href="{{ route('news.show', $featured) }}" class="hover:text-red-200 transition">
                                    {{ $featured->title }}
                                </a>
                            </h2>
                            <p class="text-white/80 text-xs mt-1">{{ $featured->created_at->format('d.m.Y') }}</p>
                            <p class="mt-3 text-white/90 text-sm sm:text-base max-w-2xl">
                                {{ Str::limit(strip_tags($featured->content), 180) }}
                            </p>
                            <div class="mt-5">
                                <a href="{{ route('news.show', $featured) }}"
                                    class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 shadow transition">
                                    Lasīt vairāk
                                </a>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Grid -->
                @php $rest = $items->slice(1); @endphp
                @if ($rest->count())
                    <section>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                            @foreach ($rest as $item)
                                <article data-animate data-stagger="{{ 3 + $loop->index }}"
                                    class="opacity-0 translate-y-3
                                           motion-safe:transition-all motion-safe:duration-700 motion-safe:ease-out
                                           motion-reduce:transition-none motion-reduce:transform-none
                                           data-[animate=in]:opacity-100 data-[animate=in]:translate-y-0
                                           bg-white/80 backdrop-blur-sm rounded-xl border border-gray-200/60 shadow-sm overflow-hidden transition hover:shadow-lg hover:border-gray-300">
                                    @if ($item->image_url)
                                        <a href="{{ route('news.show', $item) }}" class="block overflow-hidden">
                                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                                class="w-full h-40 sm:h-44 object-cover transition duration-500 hover:scale-[1.03]"
                                                onerror="this.style.display='none'">
                                        </a>
                                    @endif

                                    <div class="p-4 sm:p-5 flex flex-col h-full">
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1 line-clamp-2">
                                            <a href="{{ route('news.show', $item) }}"
                                                class="hover:text-red-600 transition">
                                                {{ $item->title }}
                                            </a>
                                        </h3>

                                        <p class="text-[11px] sm:text-xs text-gray-500 mb-3">
                                            {{ $item->created_at->format('d.m.Y') }}
                                        </p>

                                        <p class="text-gray-700 text-sm line-clamp-3 mb-3 flex-1">
                                            {{ Str::limit(strip_tags($item->content), 140) }}
                                        </p>

                                        <div class="flex items-center justify-between">
                                            <a href="{{ route('news.show', $item) }}"
                                                class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 text-sm font-semibold transition">
                                                Lasīt vairāk →
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Pagination -->
                <div data-animate data-stagger="{{ 3 + max(0, $rest->count()) + 1 }}"
                    class="opacity-0 translate-y-3
                           motion-safe:transition-all motion-safe:duration-700 motion-safe:ease-out
                           motion-reduce:transition-none motion-reduce:transform-none
                           data-[animate=in]:opacity-100 data-[animate=in]:translate-y-0 mt-8">
                    {{ $news->links() }}
                </div>
            @else
                <!-- Empty state -->
                <div data-animate data-stagger="2"
                    class="opacity-0 translate-y-3
                           motion-safe:transition-all motion-safe:duration-700 motion-safe:ease-out
                           motion-reduce:transition-none motion-reduce:transform-none
                           data-[animate=in]:opacity-100 data-[animate=in]:translate-y-0
                           mt-8 bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl p-8 text-center">
                    <h3 class="text-xl font-extrabold text-gray-900">Nav atrastu ziņu</h3>
                    @if ($q !== '')
                        <p class="mt-1 text-gray-600">Meklējām pēc “{{ $q }}”, bet rezultātu nav.</p>
                        <div class="mt-4">
                            <a href="{{ route('news.index') }}"
                                class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 shadow transition">
                                Notīrīt meklēšanu
                            </a>
                        </div>
                    @else
                        <p class="mt-1 text-gray-600">Šobrīd nav pieejamu ziņu.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const els = Array.from(document.querySelectorAll('[data-animate]'));
            els.forEach(el => {
                const idx = parseInt(el.getAttribute('data-stagger') || '0', 10);
                const delay = Math.max(0, idx) * 80;
                setTimeout(() => el.setAttribute('data-animate', 'in'), delay);
            });

            const clearBtn = document.getElementById('clearSearch');
            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('q');
                    window.location.href = url.toString();
                });
            }
        });
    </script>
</x-app-layout>
