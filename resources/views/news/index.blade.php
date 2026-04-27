<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;1,8..60,300&family=DM+Sans:wght@400;500&display=swap');

        .nws * {
            box-sizing: border-box;
        }

        .nws {
            --ink: #0F0F0E;
            --ink-2: #3A3935;
            --ink-3: #7A7770;
            --ink-4: #B8B5AF;
            --paper: #F8F6F1;
            --paper-2: #EFECE5;
            --rule: #D8D4CC;
            --red: #B8241C;
            --red-hover: #961E17;
            --white: #FFFFFF;

            font-family: 'Source Serif 4', Georgia, serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 5rem;
        }

        /* ── Masthead ── */
        .nws-masthead {
            margin-top: 50px;
            border-top: 4px solid var(--ink);
            padding: 1.25rem 0 1.1rem;
            text-align: center;
        }

        .nws-masthead__date {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-3);
            margin-bottom: 0.3rem;
        }

        .nws-masthead__flag {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 6vw, 3.6rem);
            font-weight: 900;
            letter-spacing: -0.03em;
            color: var(--ink);
            line-height: 1;
        }

        .nws-masthead__flag em {
            color: var(--red);
            font-style: italic;
        }

        .nws-masthead__sub {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.68rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-3);
            margin-top: 0.6rem;
        }

        /* ── Layout wrapper ── */
        .nws-wrap {
            max-width: 1160px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        /* ── Single divider separating masthead from content ── */
        .nws-divider {
            border: none;
            border-top: 1px solid var(--rule);
            margin: 0;
        }

        /* ── Toolbar — no bottom border, breathing room via padding ── */
        .nws-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.25rem 0 1.5rem;
            flex-wrap: wrap;
        }

        .nws-toolbar__meta {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            color: var(--ink-3);
        }

        .nws-toolbar__meta strong {
            color: var(--ink-2);
        }

        /* Search */
        .nws-search-form {
            display: flex;
            align-items: center;
            position: relative;
        }

        .nws-search-input {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            background: var(--white);
            border: 1px solid var(--rule);
            border-right: none;
            padding: 0.45rem 2rem 0.45rem 0.9rem;
            color: var(--ink);
            outline: none;
            width: 220px;
            border-radius: 0;
            transition: border-color 0.2s;
        }

        .nws-search-input:focus {
            border-color: var(--ink-3);
        }

        .nws-search-input::placeholder {
            color: var(--ink-4);
        }

        .nws-search-clear {
            position: absolute;
            right: 52px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.7rem;
            color: var(--ink-3);
            padding: 4px 6px;
            font-family: 'DM Sans', sans-serif;
        }

        .nws-search-clear:hover {
            color: var(--ink);
        }

        .nws-search-btn {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            background: var(--ink);
            color: var(--white);
            border: 1px solid var(--ink);
            padding: 0.45rem 0.9rem;
            cursor: pointer;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-radius: 0;
            white-space: nowrap;
            transition: background 0.15s;
        }

        .nws-search-btn:hover {
            background: var(--ink-2);
        }

        .nws-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-decoration: none;
            background: var(--red);
            color: var(--white);
            padding: 0.45rem 1rem;
            border: 1px solid var(--red);
            transition: background 0.15s;
            white-space: nowrap;
        }

        .nws-add-btn:hover {
            background: var(--red-hover);
            border-color: var(--red-hover);
        }

        /* ── Section kicker — plain text, no trailing line ── */
        .nws-kicker {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.75rem;
        }

        /* ── Featured hero ── */
        .nws-hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border: 1px solid var(--rule);
            overflow: hidden;
            background: var(--white);
            margin-bottom: 3rem;
        }

        @media (max-width: 700px) {
            .nws-hero {
                grid-template-columns: 1fr;
            }
        }

        .nws-hero__img-wrap {
            position: relative;
            overflow: hidden;
            min-height: 300px;
        }

        .nws-hero__img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.6s ease;
        }

        .nws-hero:hover .nws-hero__img-wrap img {
            transform: scale(1.03);
        }

        .nws-hero__img-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 15, 14, 0.15) 0%, transparent 60%);
        }

        .nws-hero__body {
            padding: 2rem 2rem 1.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-left: 1px solid var(--rule);
        }

        @media (max-width: 700px) {
            .nws-hero__body {
                border-left: none;
                border-top: 1px solid var(--rule);
            }
        }

        .nws-hero__label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.75rem;
        }

        .nws-hero__title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 3.5vw, 2.4rem);
            font-weight: 700;
            line-height: 1.18;
            letter-spacing: -0.02em;
            color: var(--ink);
            margin: 0 0 0.75rem;
            text-decoration: none;
            display: block;
        }

        .nws-hero__title:hover {
            color: var(--red);
        }

        .nws-hero__date {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            color: var(--ink-3);
            margin-bottom: 1rem;
        }

        .nws-hero__excerpt {
            font-size: 0.95rem;
            line-height: 1.7;
            color: var(--ink-2);
            flex: 1;
            font-weight: 300;
        }

        .nws-hero__cta {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--red);
            margin-top: 1.5rem;
            border-bottom: 1px solid var(--red);
            padding-bottom: 1px;
            transition: color 0.15s, border-color 0.15s;
        }

        .nws-hero__cta:hover {
            color: var(--red-hover);
            border-color: var(--red-hover);
        }

        .nws-hero__cta::after {
            content: '→';
        }

        /* ── Grid ── */
        .nws-grid-head {
            margin-bottom: 1.25rem;
        }

        .nws-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border-top: 1px solid var(--rule);
            border-left: 1px solid var(--rule);
        }

        @media (max-width: 900px) {
            .nws-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 560px) {
            .nws-grid {
                grid-template-columns: 1fr;
            }
        }

        .nws-card {
            border-right: 1px solid var(--rule);
            border-bottom: 1px solid var(--rule);
            background: var(--white);
            display: flex;
            flex-direction: column;
            transition: background 0.15s;
        }

        .nws-card:hover {
            background: var(--paper);
        }

        .nws-card__img-wrap {
            overflow: hidden;
            aspect-ratio: 16/9;
            flex-shrink: 0;
        }

        .nws-card__img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .nws-card:hover .nws-card__img-wrap img {
            transform: scale(1.04);
        }

        .nws-card__body {
            padding: 1.1rem 1.25rem 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .nws-card__kicker {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.4rem;
        }

        .nws-card__title {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.3;
            color: var(--ink);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }

        .nws-card__title:hover {
            color: var(--red);
        }

        .nws-card__date {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.68rem;
            color: var(--ink-4);
            margin-bottom: 0.65rem;
        }

        .nws-card__excerpt {
            font-size: 0.83rem;
            line-height: 1.65;
            color: var(--ink-2);
            flex: 1;
            font-weight: 300;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .nws-card__footer {
            margin-top: 1rem;
            padding-top: 0.75rem;
            border-top: 1px solid var(--rule);
            display: flex;
            justify-content: flex-end;
        }

        .nws-card__link {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--red);
            text-decoration: none;
            transition: color 0.15s;
        }

        .nws-card__link:hover {
            color: var(--red-hover);
        }

        /* ── Empty state ── */
        .nws-empty {
            text-align: center;
            padding: 5rem 2rem;
            border: 1px solid var(--rule);
            margin-top: 2rem;
            background: var(--white);
        }

        .nws-empty__title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.5rem;
        }

        .nws-empty__sub {
            font-size: 0.9rem;
            color: var(--ink-3);
            font-weight: 300;
            margin-bottom: 1.5rem;
        }

        .nws-empty__q {
            color: var(--ink);
            font-style: italic;
        }

        .nws-clear-link {
            display: inline-block;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--white);
            background: var(--red);
            padding: 0.5rem 1.25rem;
            transition: background 0.15s;
        }

        .nws-clear-link:hover {
            background: var(--red-hover);
        }

        /* ── Pagination ── */
        .nws-pagination {
            margin-top: 2.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--rule);
        }

        /* ── Reveal ── */
        .nws-reveal {
            opacity: 0;
            transform: translateY(12px);
            transition: opacity 0.55s ease, transform 0.55s ease;
        }

        .nws-reveal.in {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <div class="nws">

        {{-- Masthead — thick top rule, nothing below it --}}
        <div class="nws-masthead nws-reveal" data-stagger="0">
            <div class="nws-wrap">
                <div class="nws-masthead__date">
                    {{ now()->locale('lv')->isoFormat('dddd, D. MMMM YYYY') }}
                </div>
                <div class="nws-masthead__flag">Sporta<em>Ziņas</em></div>
                <div class="nws-masthead__sub">Jaunākās sporta ziņas</div>
            </div>
        </div>

        {{-- One clean rule between masthead and content --}}
        <hr class="nws-divider">

        <div class="nws-wrap">

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

            {{-- Toolbar — borderless, just padded --}}
            <div class="nws-toolbar nws-reveal" data-stagger="1">
                <div class="nws-toolbar__meta">
                    @if ($q !== '')
                        Rezultāti meklējumam: <strong>"{{ $q }}"</strong> — {{ $totalNews }}
                    @else
                        Kopā ziņu: <strong>{{ $totalNews }}</strong>
                    @endif
                </div>
                <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
                    <form method="GET" action="{{ route('news.index') }}" class="nws-search-form">
                        <input type="search" name="q" value="{{ $q }}" placeholder="Meklēt ziņas…"
                            class="nws-search-input">
                        @if ($q !== '')
                            <button type="button" id="clearSearch" class="nws-search-clear">✕</button>
                        @endif
                        <button type="submit" class="nws-search-btn">Meklēt</button>
                    </form>
                    @if (auth()->user()?->isAdmin())
                        <a href="{{ route('news.create') }}" class="nws-add-btn">+ Pievienot</a>
                    @endif
                </div>
            </div>

            @if ($hasResults)

                {{-- Featured --}}
                @php $featured = $items->first(); @endphp
                @if ($featured)
                    <div class="nws-reveal" data-stagger="2">
                        <div class="nws-kicker">Jaunākās ziņa</div>
                        <article class="nws-hero">
                            <a href="{{ route('news.show', $featured) }}" class="nws-hero__img-wrap">
                                @if ($featured->image_url)
                                    <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}"
                                        onerror="this.src='https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800&auto=format&fit=crop'">
                                @else
                                    <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800&auto=format&fit=crop"
                                        alt="Sporta ziņas">
                                @endif
                            </a>
                            <div class="nws-hero__body">
                                <div>
                                    <div class="nws-hero__label">Jaunākais</div>
                                    <a href="{{ route('news.show', $featured) }}" class="nws-hero__title">
                                        {{ $featured->title }}
                                    </a>
                                    <div class="nws-hero__date">{{ $featured->created_at->format('d.m.Y') }}</div>
                                    <p class="nws-hero__excerpt">
                                        {{ Str::limit(strip_tags($featured->content), 220) }}
                                    </p>
                                </div>
                                <a href="{{ route('news.show', $featured) }}" class="nws-hero__cta">Lasīt vairāk</a>
                            </div>
                        </article>
                    </div>
                @endif

                {{-- Grid --}}
                @php $rest = $items->slice(1); @endphp
                @if ($rest->count())
                    <div class="nws-grid-head nws-reveal" data-stagger="3">
                        <div class="nws-kicker">Visas ziņas</div>
                    </div>
                    <div class="nws-grid">
                        @foreach ($rest as $item)
                            <article class="nws-card nws-reveal" data-stagger="{{ 4 + $loop->index }}">
                                @if ($item->image_url)
                                    <a href="{{ route('news.show', $item) }}" class="nws-card__img-wrap">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                            onerror="this.parentElement.style.display='none'">
                                    </a>
                                @endif
                                <div class="nws-card__body">
                                    <div class="nws-card__kicker">Ziņas</div>
                                    <a href="{{ route('news.show', $item) }}" class="nws-card__title">
                                        {{ $item->title }}
                                    </a>
                                    <div class="nws-card__date">{{ $item->created_at->format('d.m.Y') }}</div>
                                    <p class="nws-card__excerpt">
                                        {{ Str::limit(strip_tags($item->content), 140) }}
                                    </p>
                                    <div class="nws-card__footer">
                                        <a href="{{ route('news.show', $item) }}" class="nws-card__link">Lasīt →</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

                {{-- Pagination --}}
                <div class="nws-pagination nws-reveal" data-stagger="{{ 4 + max(0, $rest->count()) }}">
                    {{ $news->links() }}
                </div>
            @else
                {{-- Empty state --}}
                <div class="nws-empty nws-reveal" data-stagger="2">
                    <div class="nws-empty__title">Nav atrastu ziņu</div>
                    @if ($q !== '')
                        <p class="nws-empty__sub">
                            Meklēšana pēc <span class="nws-empty__q">"{{ $q }}"</span> neatgrieza
                            rezultātus.
                        </p>
                        <a href="{{ route('news.index') }}" class="nws-clear-link">Notīrīt meklēšanu</a>
                    @else
                        <p class="nws-empty__sub">Šobrīd nav pieejamu ziņu. Pievieno pirmo!</p>
                    @endif
                </div>

            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.nws-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 60 + i * 75);
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
