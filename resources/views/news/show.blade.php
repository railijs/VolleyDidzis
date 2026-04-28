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

        /* ── Breadcrumb ── */
        .ns-breadcrumb {
            padding: 1.5rem 0 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--ink-3);
            border-bottom: 1px solid var(--rule);
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

        /* ── Admin bar ── */
        .ns-admin-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--rule);
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

        /* ── Article header ── */
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
            flex-wrap: wrap;
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

        /* ── Read time ── */
        .ns-meta__read {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.72rem;
            color: var(--ink-4);
        }

        /* ── Hero image ── */
        .ns-hero-img-wrap {
            position: relative;
            overflow: hidden;
            margin: 2rem 0 0;
            cursor: zoom-in;
            /* subtle bottom fade to ground the image */
        }

        .ns-hero-img-wrap img {
            width: 100%;
            aspect-ratio: 16 / 7;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .ns-hero-img-wrap:hover img {
            transform: scale(1.015);
        }

        /* Caption bar shown on hover */
        .ns-hero-img-wrap__expand {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(15, 15, 14, 0.55));
            padding: 2rem 1rem 0.6rem;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .ns-hero-img-wrap:hover .ns-hero-img-wrap__expand {
            opacity: 1;
        }

        .ns-expand-hint {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .ns-expand-hint svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
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

        /* ── Lightbox ── */
        .ns-lightbox {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(10, 10, 10, 0.93);
            display: none;
            align-items: center;
            justify-content: center;
            cursor: zoom-out;
            padding: 1.5rem;
        }

        .ns-lightbox.open {
            display: flex;
        }

        .ns-lightbox__img {
            max-width: 100%;
            max-height: 90dvh;
            object-fit: contain;
            display: block;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.6);
            animation: lbIn 0.22s ease both;
        }

        @keyframes lbIn {
            from {
                opacity: 0;
                transform: scale(0.96);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .ns-lightbox__close {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1rem;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s;
        }

        .ns-lightbox__close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .ns-lightbox__esc {
            position: absolute;
            bottom: 1.25rem;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
        }

        /* ── Article body ── */
        .ns-body {
            padding: 2rem 0 2rem;
            border-bottom: 1px solid var(--rule);
        }

        /* Drop cap */
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

        /* ── Progress bar (reading indicator) ── */
        .ns-progress {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: transparent;
            z-index: 200;
            pointer-events: none;
        }

        .ns-progress__fill {
            height: 100%;
            background: var(--red);
            width: 0%;
            transition: width 0.1s linear;
        }

        /* ── TOC / pull quote ── */
        .ns-pull {
            border-left: 3px solid var(--red);
            margin: 1.5rem 0;
            padding: 0.5rem 0 0.5rem 1.25rem;
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-style: italic;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.35;
        }

        /* ── Copy link toast ── */
        .ns-toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: var(--ink);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            padding: 0.55rem 1.25rem;
            opacity: 0;
            transition: opacity 0.25s, transform 0.25s;
            pointer-events: none;
            z-index: 999;
            white-space: nowrap;
        }

        .ns-toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* ── Footer row ── */
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
            flex-wrap: wrap;
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
            cursor: pointer;
            transition: all 0.15s;
        }

        .ns-share-btn:hover {
            background: var(--ink);
            color: var(--white);
            border-color: var(--ink);
        }

        /* ── More news ── */
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
            transition: opacity 0.2s;
        }

        .ns-more-card:hover .ns-more-card__img {
            opacity: 0.88;
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

        /* ── Reveal ── */
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

    {{-- Reading progress bar ── sits outside .ns so fixed positioning works reliably --}}
    <div class="ns-progress" aria-hidden="true">
        <div class="ns-progress__fill" id="nsProgress"></div>
    </div>

    {{-- Lightbox ── outside .ns so it isn't clipped by any overflow --}}
    @if ($news->image_url)
        <div id="nsLightbox" class="ns-lightbox" role="dialog" aria-modal="true" aria-label="Pilna izmēra attēls">
            <button class="ns-lightbox__close" id="nsLightboxClose" aria-label="Aizvērt">✕</button>
            <img class="ns-lightbox__img" src="{{ $news->image_url }}" alt="{{ $news->title }}">
            <span class="ns-lightbox__esc">Esc — aizvērt</span>
        </div>
    @endif

    {{-- Copy link toast --}}
    <div id="nsToast" class="ns-toast" role="status" aria-live="polite">Saite nokopēta ✓</div>

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
                    <span>{{ $news->created_at->format('d. m. Y') }}</span>
                    <span class="ns-meta__dot"></span>
                    <span>{{ $news->created_at->locale('lv')->diffForHumans() }}</span>
                    <span class="ns-meta__dot"></span>
                    {{-- Estimated reading time: ~200 words/min --}}
                    <span class="ns-meta__read">
                        <svg viewBox="0 0 24 24"
                            style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        {{ max(1, (int) ceil(str_word_count(strip_tags($news->content)) / 200)) }} min lasīšana
                    </span>
                </div>
            </header>

        </div>

        {{-- Hero image --}}
        <div class="ns-wrap ns-reveal" data-stagger="3">
            @if ($news->image_url)
                <div class="ns-hero-img-wrap" id="nsHeroWrap" title="Klikšķini, lai skatītu pilnā izmērā">
                    <img src="{{ $news->image_url }}" alt="{{ $news->title }}"
                        onerror="this.parentElement.style.display='none'">
                    <div class="ns-hero-img-wrap__expand">
                        <span class="ns-expand-hint">
                            <svg viewBox="0 0 24 24">
                                <polyline points="15 3 21 3 21 9" />
                                <polyline points="9 21 3 21 3 15" />
                                <line x1="21" y1="3" x2="14" y2="10" />
                                <line x1="3" y1="21" x2="10" y2="14" />
                            </svg>
                            Pilnā izmērā
                        </span>
                    </div>
                </div>
            @else
                <div class="ns-hero-placeholder">
                    <span>{{ Str::limit($news->title, 30) }}</span>
                </div>
            @endif
        </div>

        <div class="ns-wrap">

            {{-- Article body --}}
            <div class="ns-body ns-reveal" data-stagger="4" id="nsBody">
                {!! nl2br(e($news->content)) !!}
            </div>

            {{-- Footer --}}
            <div class="ns-footer ns-reveal" data-stagger="5">
                <a href="{{ route('news.index') }}" class="ns-back">Atpakaļ uz ziņām</a>
                <div class="ns-share">
                    <span class="ns-share__label">Dalīties</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                        target="_blank" rel="noopener" class="ns-share-btn">Facebook</a>
                    <button type="button" class="ns-share-btn" id="nsCopyLink">Kopēt saiti</button>
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
        /* ── Reveal stagger ── */
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.ns-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 50 + i * 70);
            });
        });

        /* ── Reading progress bar ── */
        const progressFill = document.getElementById('nsProgress');
        const body = document.getElementById('nsBody');
        if (progressFill && body) {
            window.addEventListener('scroll', () => {
                const rect = body.getBoundingClientRect();
                const total = body.offsetHeight + rect.top + window.scrollY - window.innerHeight;
                const pct = Math.min(100, Math.max(0, (window.scrollY / total) * 100));
                progressFill.style.width = pct + '%';
            }, {
                passive: true
            });
        }

        /* ── Lightbox ── */
        const lightbox = document.getElementById('nsLightbox');
        const heroWrap = document.getElementById('nsHeroWrap');
        const lbClose = document.getElementById('nsLightboxClose');

        function openLightbox() {
            lightbox?.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox?.classList.remove('open');
            document.body.style.overflow = '';
        }

        heroWrap?.addEventListener('click', openLightbox);
        lbClose?.addEventListener('click', e => {
            e.stopPropagation();
            closeLightbox();
        });
        lightbox?.addEventListener('click', e => {
            if (e.target === lightbox) closeLightbox();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeLightbox();
        });

        /* ── Copy link ── */
        const copyBtn = document.getElementById('nsCopyLink');
        const toast = document.getElementById('nsToast');
        let toastTimer;

        copyBtn?.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(window.location.href);
            } catch {
                /* fallback for older browsers */
                const ta = document.createElement('textarea');
                ta.value = window.location.href;
                ta.style.cssText = 'position:fixed;opacity:0';
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
            }
            toast.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => toast.classList.remove('show'), 2200);
        });
    </script>
</x-app-layout>
