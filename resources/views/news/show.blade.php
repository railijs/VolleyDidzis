<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;1,8..60,300;1,8..60,400&family=DM+Sans:wght@400;500&display=swap');

        .ns * {
            box-sizing: border-box;
        }

        .ns {
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
            padding-bottom: 6rem;
            margin-top: 50px;
        }

        .ns-wrap {
            max-width: 820px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        .ns-wrap--wide {
            max-width: 1060px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        /* ── Breadcrumb ──────────────────────────────── */
        .ns-breadcrumb {
            padding: 1.5rem 0 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--ink-3);
            border-bottom: 1px solid var(--rule);
            padding-bottom: 1rem;
        }

        .ns-breadcrumb a {
            color: var(--ink-3);
            text-decoration: none;
            transition: color 0.15s;
        }

        .ns-breadcrumb a:hover {
            color: var(--red);
        }

        .ns-breadcrumb__sep {
            color: var(--ink-4);
        }

        .ns-breadcrumb__current {
            color: var(--ink-2);
        }

        /* ── Admin actions ───────────────────────────── */
        .ns-admin-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--rule);
            margin-bottom: 0;
        }

        .ns-admin-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-4);
            margin-right: 0.25rem;
        }

        .ns-admin-btn {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            text-decoration: none;
            padding: 0.3rem 0.8rem;
            border: 1px solid var(--rule);
            background: var(--white);
            color: var(--ink-2);
            cursor: pointer;
            transition: all 0.15s;
        }

        .ns-admin-btn:hover {
            border-color: var(--ink-3);
            color: var(--ink);
        }

        .ns-admin-btn--danger {
            color: var(--red);
        }

        .ns-admin-btn--danger:hover {
            background: var(--red);
            color: var(--white);
            border-color: var(--red);
        }

        /* ── Article header ──────────────────────────── */
        .ns-header {
            padding: 2.5rem 0 0;
        }

        .ns-kicker {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.9rem;
        }

        .ns-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -0.025em;
            color: var(--ink);
            margin: 0 0 1.25rem;
        }

        .ns-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            color: var(--ink-3);
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--ink);
        }

        .ns-meta__dot {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--ink-4);
            flex-shrink: 0;
        }

        /* ── Hero image ──────────────────────────────── */
        .ns-hero-img {
            width: 100%;
            aspect-ratio: 16 / 7;
            object-fit: cover;
            display: block;
            margin: 2rem 0 0;
        }

        .ns-hero-img-wrap {
            position: relative;
            overflow: hidden;
            margin: 2rem 0 0;
        }

        .ns-hero-img-wrap img {
            width: 100%;
            aspect-ratio: 16 / 7;
            object-fit: cover;
            display: block;
        }

        .ns-hero-placeholder {
            width: 100%;
            aspect-ratio: 16 / 7;
            background: var(--paper-2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2rem 0 0;
        }

        .ns-hero-placeholder span {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-style: italic;
            color: var(--ink-4);
        }

        /* ── Article body ────────────────────────────── */
        .ns-body {
            padding: 2rem 0 2rem;
            border-bottom: 1px solid var(--rule);
        }

        /* Drop cap on first paragraph */
        .ns-body p:first-of-type::first-letter {
            font-family: 'Playfair Display', serif;
            font-size: 3.8rem;
            font-weight: 900;
            line-height: 0.8;
            float: left;
            margin-right: 0.08em;
            margin-top: 0.08em;
            color: var(--ink);
        }

        .ns-body p {
            font-size: 1.05rem;
            line-height: 1.85;
            color: var(--ink-2);
            margin: 0 0 1.4em;
            font-weight: 300;
        }

        .ns-body p:last-child {
            margin-bottom: 0;
        }

        /* ── Footer row ──────────────────────────────── */
        .ns-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            padding: 1.5rem 0 0;
        }

        .ns-back {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--ink-2);
            border-bottom: 1px solid var(--rule);
            padding-bottom: 1px;
            transition: color 0.15s, border-color 0.15s;
        }

        .ns-back::before {
            content: '←';
        }

        .ns-back:hover {
            color: var(--red);
            border-color: var(--red);
        }

        .ns-share {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .ns-share__label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-4);
        }

        .ns-share-btn {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            text-decoration: none;
            color: var(--ink-2);
            border: 1px solid var(--rule);
            padding: 0.3rem 0.8rem;
            background: var(--white);
            transition: all 0.15s;
        }

        .ns-share-btn:hover {
            background: var(--ink);
            color: var(--white);
            border-color: var(--ink);
        }

        /* ── More news ───────────────────────────────── */
        .ns-more {
            margin-top: 3.5rem;
        }

        .ns-more__head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            border-top: 3px solid var(--ink);
            border-bottom: 1px solid var(--rule);
            padding: 0.6rem 0;
            margin-bottom: 0;
        }

        .ns-more__title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
        }

        .ns-more__all {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--red);
            text-decoration: none;
            transition: color 0.15s;
        }

        .ns-more__all:hover {
            color: var(--red-hover);
        }

        .ns-more-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            border-left: 1px solid var(--rule);
        }

        @media (max-width: 560px) {
            .ns-more-grid {
                grid-template-columns: 1fr;
            }
        }

        .ns-more-card {
            border-right: 1px solid var(--rule);
            border-bottom: 1px solid var(--rule);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            background: var(--white);
            transition: background 0.15s;
        }

        .ns-more-card:hover {
            background: var(--paper);
        }

        .ns-more-card__img {
            width: 100%;
            aspect-ratio: 16 / 7;
            object-fit: cover;
            display: block;
            border-bottom: 1px solid var(--rule);
        }

        .ns-more-card__body {
            padding: 1rem 1.25rem 1.25rem;
        }

        .ns-more-card__kicker {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.4rem;
        }

        .ns-more-card__title {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.3;
            color: var(--ink);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ns-more-card:hover .ns-more-card__title {
            color: var(--red);
        }

        .ns-more-card__date {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            color: var(--ink-4);
            margin-top: 0.5rem;
        }

        /* ── Reveal animation ────────────────────────── */
        .ns-reveal {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.55s ease, transform 0.55s ease;
        }

        .ns-reveal.in {
            opacity: 1;
            transform: none;
        }
    </style>

    <div class="ns">
        <div class="ns-wrap">

            {{-- Breadcrumb --}}
            <div class="ns-breadcrumb ns-reveal" data-stagger="0">
                <a href="{{ route('news.index') }}">Ziņas</a>
                <span class="ns-breadcrumb__sep">/</span>
                <span class="ns-breadcrumb__current">{{ Str::limit($news->title, 48) }}</span>
            </div>

            {{-- Admin bar --}}
            @if (auth()->user()?->isAdmin())
                <div class="ns-admin-bar ns-reveal" data-stagger="1">
                    <span class="ns-admin-label">Admin:</span>
                    <a href="{{ route('news.edit', $news) }}" class="ns-admin-btn">Rediģēt</a>
                    <form action="{{ route('news.destroy', $news) }}" method="POST" style="display:inline"
                        onsubmit="return confirm('Tiešām dzēst šo ziņu?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="ns-admin-btn ns-admin-btn--danger">Dzēst</button>
                    </form>
                </div>
            @endif

            {{-- Article header --}}
            <header class="ns-header ns-reveal" data-stagger="2">
                <div class="ns-kicker">Ziņa</div>
                <h1 class="ns-title">{{ $news->title }}</h1>
                <div class="ns-meta">
                    <span>Publicēts {{ $news->created_at->format('d. m. Y') }}</span>
                    <span class="ns-meta__dot"></span>
                    <span>{{ $news->created_at->locale('lv')->diffForHumans() }}</span>
                </div>
            </header>

        </div>

        {{-- Hero image — full width relative to wrap --}}
        <div class="ns-wrap ns-reveal" data-stagger="3">
            @if ($news->image_url)
                <div class="ns-hero-img-wrap">
                    <img src="{{ $news->image_url }}" alt="{{ $news->title }}"
                        onerror="this.parentElement.style.display='none'">
                </div>
            @else
                <div class="ns-hero-placeholder">
                    <span>{{ Str::limit($news->title, 30) }}</span>
                </div>
            @endif
        </div>

        <div class="ns-wrap">

            {{-- Article body --}}
            <div class="ns-body ns-reveal" data-stagger="4">
                {!! nl2br(e($news->content)) !!}
            </div>

            {{-- Footer --}}
            <div class="ns-footer ns-reveal" data-stagger="5">
                <a href="{{ route('news.index') }}" class="ns-back">Atpakaļ uz ziņām</a>
                <div class="ns-share">
                    <span class="ns-share__label">Dalīties</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                        target="_blank" class="ns-share-btn">Facebook</a>
                </div>
            </div>

        </div>

        {{-- More news --}}
        @if (isset($more) && $more->count())
            <div class="ns-more ns-wrap--wide ns-reveal" data-stagger="6">
                <div class="ns-more__head">
                    <span class="ns-more__title">Vēl ziņas</span>
                    <a href="{{ route('news.index') }}" class="ns-more__all">Visas ziņas →</a>
                </div>
                <div class="ns-more-grid">
                    @foreach ($more as $n)
                        <a href="{{ route('news.show', $n) }}" class="ns-more-card ns-reveal"
                            data-stagger="{{ 7 + $loop->index }}">
                            @if ($n->image_url)
                                <img src="{{ $n->image_url }}" alt="{{ $n->title }}" class="ns-more-card__img"
                                    onerror="this.style.display='none'">
                            @endif
                            <div class="ns-more-card__body">
                                <div class="ns-more-card__kicker">Ziņas</div>
                                <div class="ns-more-card__title">{{ $n->title }}</div>
                                <div class="ns-more-card__date">{{ $n->created_at->format('d.m.Y') }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.ns-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 50 + i * 70);
            });
        });
    </script>
</x-app-layout>
