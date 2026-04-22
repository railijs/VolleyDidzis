<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,600;0,700;0,900;1,700;1,900&family=Barlow:wght@300;400;500&family=DM+Sans:wght@400;500&display=swap');

        .ab * {
            box-sizing: border-box;
        }

        .ab {
            --ink: #0A0A0A;
            --ink-2: #2E2E2C;
            --ink-3: #6B6864;
            --ink-4: #B0ADA8;
            --paper: #F7F5F0;
            --paper-2: #EDEAE3;
            --rule: #D5D1C9;
            --red: #C5231B;
            --red-dark: #9E1C15;
            --red-tint: #FAF0EF;
            --white: #FFFFFF;

            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 6rem;
        }

        .ab-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ── Hero masthead ── */
        .ab-header {
            background: var(--ink);
            padding: clamp(4rem, 10vh, 7rem) 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .ab-header__bg-word {
            position: absolute;
            right: -0.02em;
            bottom: -0.15em;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-style: italic;
            font-size: clamp(6rem, 18vw, 14rem);
            color: rgba(255, 255, 255, 0.03);
            line-height: 1;
            pointer-events: none;
            letter-spacing: -0.03em;
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.04);
            text-transform: uppercase;
            white-space: nowrap;
        }

        .ab-header__inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem 3rem;
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: end;
        }

        @media (max-width: 720px) {
            .ab-header__inner {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        .ab-header__eyebrow {
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .ab-header__eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--red);
        }

        .ab-header__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -0.02em;
            color: var(--white);
            line-height: 0.9;
            margin: 0;
        }

        .ab-header__right {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            gap: 1rem;
            padding-bottom: 0.25rem;
        }

        .ab-header__tagline {
            font-family: 'Barlow', sans-serif;
            font-size: clamp(0.95rem, 1.8vw, 1.15rem);
            font-weight: 300;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.5);
            border-left: 2px solid var(--red);
            padding-left: 1rem;
        }

        .ab-header__stats {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .ab-header__stat {}

        .ab-header__stat strong {
            display: block;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.85);
            letter-spacing: 0;
            line-height: 1;
        }

        .ab-header__stat span {
            font-size: 0.62rem;
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .ab-bar {
            height: 3px;
            background: var(--red);
        }

        /* ── Hero image ── */
        .ab-hero-img {
            width: 100%;
            height: clamp(180px, 26vw, 360px);
            object-fit: cover;
            display: block;
            filter: brightness(0.85) contrast(1.05);
        }

        /* ── Story ── */
        .ab-story-section {
            padding: 3.5rem 0 3rem;
            border-bottom: 1px solid var(--rule);
        }

        .ab-story-grid {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 3rem;
            align-items: start;
        }

        @media (max-width: 680px) {
            .ab-story-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }
        }

        .ab-story-aside-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 3.2rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            line-height: 0.9;
            color: var(--paper-2);
            letter-spacing: -0.02em;
            -webkit-text-stroke: 1px var(--rule);
            user-select: none;
        }

        .ab-story-aside-label em {
            display: block;
            font-style: normal;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--red);
            -webkit-text-stroke: 0;
            margin-bottom: 0.4rem;
        }

        .ab-story-body {
            font-family: 'Barlow', sans-serif;
            font-size: 1.05rem;
            font-weight: 300;
            line-height: 1.85;
            color: var(--ink-2);
        }

        .ab-story-body p+p {
            margin-top: 1.1rem;
        }

        .ab-story-body p:first-child::first-letter {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 3.4rem;
            font-weight: 900;
            font-style: italic;
            float: left;
            line-height: 0.78;
            margin-right: 0.05em;
            margin-top: 0.1em;
            color: var(--ink);
        }

        /* ── Features ── */
        .ab-features-section {
            padding: 3rem 0;
            border-bottom: 1px solid var(--rule);
        }

        .ab-section-header {
            margin-bottom: 1.75rem;
        }

        .ab-eyebrow {
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--red);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.3rem;
        }

        .ab-eyebrow::before {
            content: '';
            display: block;
            width: 14px;
            height: 2px;
            background: var(--red);
        }

        .ab-section-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1.5rem, 3vw, 2.2rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            letter-spacing: -0.01em;
        }

        .ab-features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
            border: 1px solid var(--rule);
        }

        @media (max-width: 860px) {
            .ab-features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .ab-features-grid {
                grid-template-columns: 1fr;
            }
        }

        .ab-feature {
            padding: 1.5rem 1.25rem;
            border-right: 1px solid var(--rule);
            background: var(--white);
            position: relative;
            overflow: hidden;
        }

        .ab-feature:last-child {
            border-right: none;
        }

        @media (max-width: 860px) {
            .ab-feature:nth-child(2n) {
                border-right: none;
            }

            .ab-feature:nth-child(-n+2) {
                border-bottom: 1px solid var(--rule);
            }
        }

        @media (max-width: 480px) {
            .ab-feature {
                border-right: none;
                border-bottom: 1px solid var(--rule);
            }

            .ab-feature:last-child {
                border-bottom: none;
            }
        }

        .ab-feature__accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--red);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.25s ease;
        }

        .ab-feature:hover .ab-feature__accent {
            transform: scaleX(1);
        }

        .ab-feature__num {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 3rem;
            font-weight: 900;
            font-style: italic;
            color: var(--paper-2);
            line-height: 1;
            margin-bottom: 0.65rem;
            -webkit-text-stroke: 1px var(--rule);
            user-select: none;
        }

        .ab-feature__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 0.45rem;
        }

        .ab-feature__desc {
            font-family: 'Barlow', sans-serif;
            font-size: 0.8rem;
            font-weight: 300;
            line-height: 1.65;
            color: var(--ink-3);
        }

        /* ── Values ── */
        .ab-values-section {
            padding: 3rem 0;
            border-bottom: 1px solid var(--rule);
        }

        .ab-values-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;
        }

        @media (max-width: 720px) {
            .ab-values-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        .ab-value__line {
            width: 24px;
            height: 2px;
            background: var(--red);
            margin-bottom: 0.7rem;
        }

        .ab-value__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 0.45rem;
        }

        .ab-value__text {
            font-family: 'Barlow', sans-serif;
            font-size: 0.85rem;
            font-weight: 300;
            line-height: 1.7;
            color: var(--ink-3);
        }

        /* ── CTA ── */
        .ab-cta-section {
            padding: 3rem 0;
        }

        .ab-cta-inner {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: center;
            border: 1px solid var(--rule);
            border-top: 3px solid var(--red);
            background: var(--white);
            padding: 2rem 2rem;
        }

        @media (max-width: 600px) {
            .ab-cta-inner {
                grid-template-columns: 1fr;
            }
        }

        .ab-cta__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1.3rem, 2.8vw, 1.9rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 0.3rem;
        }

        .ab-cta__sub {
            font-family: 'Barlow', sans-serif;
            font-size: 0.88rem;
            font-weight: 300;
            color: var(--ink-3);
            line-height: 1.6;
        }

        .ab-cta__btns {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .ab-btn {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.6rem 1.4rem;
            border: 1px solid;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            border-radius: 0;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .ab-btn--solid {
            background: var(--ink);
            color: var(--white);
            border-color: var(--ink);
        }

        .ab-btn--solid:hover {
            background: var(--ink-2);
            border-color: var(--ink-2);
        }

        .ab-btn--outline {
            background: none;
            color: var(--red);
            border-color: rgba(197, 35, 27, 0.4);
        }

        .ab-btn--outline:hover {
            background: var(--red-tint);
            border-color: var(--red);
        }

        /* ── Contacts ── */
        .ab-contacts-section {
            padding: 2.5rem 0 0;
            border-top: 1px solid var(--rule);
        }

        .ab-contacts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            border: 1px solid var(--rule);
            background: var(--white);
            margin-top: 1rem;
        }

        @media (max-width: 640px) {
            .ab-contacts-grid {
                grid-template-columns: 1fr;
            }
        }

        .ab-contact-cell {
            padding: 1.25rem 1.25rem;
            border-right: 1px solid var(--rule);
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .ab-contact-cell:last-child {
            border-right: none;
        }

        @media (max-width: 640px) {
            .ab-contact-cell {
                border-right: none;
                border-bottom: 1px solid var(--rule);
            }

            .ab-contact-cell:last-child {
                border-bottom: none;
            }
        }

        .ab-contact-cell__label {
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-4);
            margin-bottom: 0.1rem;
        }

        .ab-contact-cell__value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
            text-decoration: none;
            transition: color 0.12s;
        }

        a.ab-contact-cell__value:hover {
            color: var(--red);
        }

        .ab-contact-cell__sub {
            font-size: 0.7rem;
            color: var(--ink-4);
            display: flex;
            align-items: center;
            gap: 0.35rem;
            margin-top: 0.1rem;
        }

        .ab-online-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #4ADE80;
            flex-shrink: 0;
        }

        /* ── Reveal ── */
        .ab-reveal {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.45s ease, transform 0.45s ease;
        }

        .ab-reveal.in {
            opacity: 1;
            transform: none;
        }
    </style>

    <div class="ab">

        <div class="ab-header ab-reveal" data-stagger="0">
            <div class="ab-header__bg-word">Par mums</div>
            <div class="ab-header__inner">
                <div>
                    <div class="ab-header__eyebrow">VolleyLV · Par mums</div>
                    <h1 class="ab-header__title">Par<br>VolleyLV</h1>
                </div>
                <div class="ab-header__right">
                    <p class="ab-header__tagline">
                        Turnīri, kalendārs un rezultāti vienuviet — lai spēlētāji, komandas un organizatori satiekas
                        ātrāk.
                    </p>
                    <div class="ab-header__stats">
                        <div class="ab-header__stat">
                            <strong>2024</strong>
                            <span>Dibināts</span>
                        </div>
                        <div class="ab-header__stat">
                            <strong>Latvija</strong>
                            <span>Valsts</span>
                        </div>
                        <div class="ab-header__stat">
                            <strong>Volejbols</strong>
                            <span>Sports</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ab-bar"></div>

        <img class="ab-hero-img ab-reveal" data-stagger="1"
            src="https://i.tiesraides.lv/1200x0s/pictures/2025-06-06/852c_volejbols_latvija.jpg"
            alt="Latvijas volejbols">

        <div class="ab-wrap">

            <section class="ab-story-section ab-reveal" data-stagger="2">
                <div class="ab-story-grid">
                    <div>
                        <div class="ab-story-aside-label">
                            <em>Mūsu stāsts</em>
                            Kā<br>tas<br>sākās
                        </div>
                    </div>
                    <div class="ab-story-body">
                        <p>
                            VolleyLV radās ar vienkāršu mērķi — apvienot Latvijas volejbola entuziastus vienā vietā.
                            Mēs noņēmām lieko troksni: meklē turnīrus, piesakies komandai, seko līdzi progresam bez
                            jucekļa.
                        </p>
                        <p>
                            Mūsu komanda tic, ka spēcīga kopiena sākas ar atklātību un vienkāršību. Tāpēc mēs
                            būvējam rīkus, kas ļauj koncentrēties uz spēli, nevis birokrātiju. Katrs turnīrs, katrs
                            pieteikums, katrs rezultāts — viss pieejams vienā, pārskatāmā vietā.
                        </p>
                    </div>
                </div>
            </section>

            <section class="ab-features-section ab-reveal" data-stagger="3">
                <div class="ab-section-header">
                    <div class="ab-eyebrow">Ko piedāvājam</div>
                    <div class="ab-section-title">Platformas iespējas</div>
                </div>
                <div class="ab-features-grid">
                    <div class="ab-feature">
                        <div class="ab-feature__accent"></div>
                        <div class="ab-feature__num">01</div>
                        <div class="ab-feature__title">Gudrs kalendārs</div>
                        <div class="ab-feature__desc">Tuvākie turnīri, vairāku dienu pasākumi un klikšķināmi ieraksti
                            vienā vietā.</div>
                    </div>
                    <div class="ab-feature">
                        <div class="ab-feature__accent"></div>
                        <div class="ab-feature__num">02</div>
                        <div class="ab-feature__title">Turnīru pārvaldība</div>
                        <div class="ab-feature__desc">Pieteikumi, komandas un norises statuss — pārskatāmi un droši.
                        </div>
                    </div>
                    <div class="ab-feature">
                        <div class="ab-feature__accent"></div>
                        <div class="ab-feature__num">03</div>
                        <div class="ab-feature__title">Komandas & pieteikumi</div>
                        <div class="ab-feature__desc">Viegla pieteikšanās, kapteiņi, komandu lielumi un nosacījumi.
                        </div>
                    </div>
                    <div class="ab-feature">
                        <div class="ab-feature__accent"></div>
                        <div class="ab-feature__num">04</div>
                        <div class="ab-feature__title">Ziņas & jaunumi</div>
                        <div class="ab-feature__desc">Aktualitātes no kopienas un turnīru organizatoriem.</div>
                    </div>
                </div>
            </section>

            <section class="ab-values-section ab-reveal" data-stagger="4">
                <div class="ab-section-header">
                    <div class="ab-eyebrow">Mūsu vērtības</div>
                    <div class="ab-section-title">Ko mēs ticam</div>
                </div>
                <div class="ab-values-grid">
                    <div>
                        <div class="ab-value__line"></div>
                        <div class="ab-value__title">Atklātība</div>
                        <div class="ab-value__text">Visi rezultāti, statistika un informācija ir pieejama ikvienam. Nav
                            slēptu maksu vai bloķēta satura.</div>
                    </div>
                    <div>
                        <div class="ab-value__line"></div>
                        <div class="ab-value__title">Vienkāršība</div>
                        <div class="ab-value__text">Mēs projektējam rīkus, kas ļauj koncentrēties uz spēli. Mazāk
                            klikšķu, vairāk volejbola.</div>
                    </div>
                    <div>
                        <div class="ab-value__line"></div>
                        <div class="ab-value__title">Kopiena</div>
                        <div class="ab-value__text">VolleyLV ir veidota spēlētājiem un organizatoriem. Jūsu atsauksmes
                            veido platformas attīstību.</div>
                    </div>
                </div>
            </section>

            <section class="ab-cta-section ab-reveal" data-stagger="5">
                <div class="ab-cta-inner">
                    <div>
                        <div class="ab-cta__title">Pievienojies VolleyLV kopienai</div>
                        <div class="ab-cta__sub">Atrast turnīru, pieteikties un sekot līdzi — tikai pāris klikšķi.</div>
                    </div>
                    <div class="ab-cta__btns">
                        <a href="{{ route('tournaments.calendar') }}" class="ab-btn ab-btn--solid">Skatīt kalendāru
                            →</a>
                        <a href="{{ route('news.index') }}" class="ab-btn ab-btn--outline">Lasīt ziņas</a>
                    </div>
                </div>
            </section>

            <section class="ab-contacts-section ab-reveal" data-stagger="6">
                <div class="ab-section-header">
                    <div class="ab-eyebrow">Sazināties</div>
                    <div class="ab-section-title">Kontakti</div>
                </div>
                <div class="ab-contacts-grid">
                    <div class="ab-contact-cell">
                        <div class="ab-contact-cell__label">Tālrunis</div>
                        <a href="tel:+37120001234" class="ab-contact-cell__value">+371 20 001 234</a>
                        <div class="ab-contact-cell__sub">
                            <span class="ab-online-dot"></span>
                            Pieejami 09:00–18:00
                        </div>
                    </div>
                    <div class="ab-contact-cell">
                        <div class="ab-contact-cell__label">E-pasts</div>
                        <a href="mailto:info@volleylv.example" class="ab-contact-cell__value">info@volleylv.example</a>
                        <div class="ab-contact-cell__sub">Atbildam darba dienās</div>
                    </div>
                    <div class="ab-contact-cell">
                        <div class="ab-contact-cell__label">Platforma</div>
                        <div class="ab-contact-cell__value">volleylv.lv</div>
                        <div class="ab-contact-cell__sub">© {{ date('Y') }} VolleyLV</div>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.ab-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 60 + i * 90);
            });
            const io = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('in');
                        io.unobserve(e.target);
                    }
                });
            }, {
                rootMargin: '0px 0px -8% 0px',
                threshold: 0.06
            });
            document.querySelectorAll('.ab-reveal:not(.in)').forEach(el => io.observe(el));
        });
    </script>
</x-app-layout>
