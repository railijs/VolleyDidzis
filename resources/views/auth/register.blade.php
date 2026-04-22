<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reģistrēties — VolleyLV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,900&family=Barlow+Condensed:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="prefetch" href="{{ route('login') }}" as="document">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
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
            --white: #F5F4F0;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--ink);
            color: var(--white);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Thin red top rule ── */
        .page-rule {
            height: 3px;
            background: linear-gradient(to right, var(--red) 0%, rgba(184, 36, 28, 0.3) 50%, transparent 100%);
        }

        /* ── Layout ── */
        .page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        @media (max-width: 860px) {
            .page {
                grid-template-columns: 1fr;
            }

            .page__left {
                padding-bottom: 0;
            }
        }

        /* ── Left panel ── */
        .page__left {
            padding: clamp(2.5rem, 6vw, 5rem) clamp(1.5rem, 5vw, 4rem);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid rgba(245, 244, 240, 0.07);
        }

        .brand {
            margin-bottom: 3rem;
        }

        .brand__logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 900;
            font-style: italic;
            letter-spacing: -0.02em;
            color: var(--white);
            text-decoration: none;
        }

        .brand__logo em {
            color: var(--red);
            font-style: normal;
        }

        .brand__rule {
            width: 32px;
            height: 2px;
            background: var(--red);
            margin-top: 0.9rem;
        }

        .hero-head {
            margin-bottom: 2rem;
        }

        .hero-head__eyebrow {
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(245, 244, 240, 0.35);
            margin-bottom: 0.75rem;
        }

        .hero-head__title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.4rem, 5vw, 3.8rem);
            font-weight: 900;
            font-style: italic;
            line-height: 1.05;
            letter-spacing: -0.025em;
            color: var(--white);
        }

        .hero-head__title em {
            color: var(--red);
            font-style: normal;
        }

        .hero-copy {
            font-size: 0.95rem;
            font-weight: 300;
            line-height: 1.75;
            color: rgba(245, 244, 240, 0.5);
            max-width: 380px;
            margin-bottom: 2.5rem;
        }

        .login-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(245, 244, 240, 0.4);
            text-decoration: none;
            border-bottom: 1px solid rgba(245, 244, 240, 0.15);
            padding-bottom: 1px;
            transition: color 0.15s, border-color 0.15s;
        }

        .login-link:hover {
            color: var(--white);
            border-color: rgba(245, 244, 240, 0.4);
        }

        .login-link::after {
            content: '→';
        }

        /* Contacts block */
        .contacts {
            margin-top: auto;
            padding-top: 3rem;
        }

        .contacts__label {
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(245, 244, 240, 0.25);
            margin-bottom: 0.75rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.82rem;
            color: rgba(245, 244, 240, 0.45);
            margin-bottom: 0.5rem;
            text-decoration: none;
            transition: color 0.15s;
        }

        .contact-item:hover {
            color: rgba(245, 244, 240, 0.8);
        }

        .contact-item svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            flex-shrink: 0;
        }

        .contact-item__status {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.65rem;
            color: rgba(245, 244, 240, 0.25);
            letter-spacing: 0.04em;
            margin-top: 0.25rem;
        }

        .contact-item__status__dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #4ADE80;
        }

        .page-footer {
            font-size: 0.65rem;
            color: rgba(245, 244, 240, 0.2);
            letter-spacing: 0.06em;
            margin-top: 2rem;
        }

        /* ── Right panel (form) ── */
        .page__right {
            background: var(--paper);
            padding: clamp(2.5rem, 6vw, 5rem) clamp(1.5rem, 5vw, 4rem);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 2.5rem;
        }

        .form-header__title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 900;
            letter-spacing: -0.02em;
            color: var(--ink);
            margin-bottom: 0.3rem;
        }

        .form-header__sub {
            font-size: 0.82rem;
            color: var(--ink-3);
            font-weight: 300;
        }

        /* Alerts */
        .alert {
            padding: 0.65rem 0.85rem;
            font-size: 0.8rem;
            font-weight: 500;
            border-left: 3px solid;
            margin-bottom: 1.5rem;
        }

        .alert--error {
            background: var(--red-tint);
            color: #8A1A14;
            border-color: var(--red);
        }

        .alert ul {
            list-style: none;
        }

        .alert li::before {
            content: '— ';
        }

        /* Form fields */
        .field {
            margin-bottom: 1.75rem;
        }

        .field:last-of-type {
            margin-bottom: 0;
        }

        .field-label {
            display: block;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-2);
            margin-bottom: 0.45rem;
        }

        .field-input {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            color: var(--ink);
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--rule);
            padding: 0.55rem 0;
            outline: none;
            transition: border-color 0.2s;
        }

        .field-input::placeholder {
            color: var(--ink-4);
        }

        .field-input:focus {
            border-bottom-color: var(--ink);
        }

        /* Side-by-side password fields */
        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.75rem;
        }

        @media (max-width: 520px) {
            .field-row {
                grid-template-columns: 1fr;
            }
        }

        .field-row .field {
            margin-bottom: 0;
        }

        .form-separator {
            border: none;
            border-top: 1px solid var(--rule);
            margin: 2rem 0;
        }

        /* Actions */
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .form-link {
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--ink-3);
            text-decoration: none;
            border-bottom: 1px solid var(--rule);
            padding-bottom: 1px;
            transition: color 0.15s, border-color 0.15s;
        }

        .form-link:hover {
            color: var(--ink);
            border-color: var(--ink-3);
        }

        .btn-submit {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--ink);
            color: var(--white);
            border: 1px solid var(--ink);
            padding: 0.65rem 2rem;
            cursor: pointer;
            border-radius: 0;
            transition: background 0.15s, border-color 0.15s;
        }

        .btn-submit:hover {
            background: var(--ink-2);
            border-color: var(--ink-2);
        }

        .btn-submit:focus-visible {
            outline: 2px solid var(--red);
            outline-offset: 2px;
        }

        /* ── Reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .reveal.in {
            opacity: 1;
            transform: none;
        }

        @media (max-width: 860px) {
            .contacts {
                display: none;
            }

            .page__right {
                min-height: 100vh;
            }
        }
    </style>
</head>

<body>

    <div class="page-rule"></div>

    <div class="page" id="pageRoot" style="opacity:0;transition:opacity 0.3s ease;">

        {{-- Left panel --}}
        <div class="page__left">
            <div>
                <div class="brand reveal" data-stagger="0">
                    <a href="{{ route('dashboard') }}" class="brand__logo">Volley<em>LV</em></a>
                    <div class="brand__rule"></div>
                </div>

                <div class="hero-head reveal" data-stagger="1">
                    <div class="hero-head__eyebrow">Latvijas volejbols</div>
                    <h1 class="hero-head__title">Pievienojies<br><em>VolleyLV</em><br>komandai</h1>
                </div>

                <p class="hero-copy reveal" data-stagger="2">
                    Izveido kontu un seko saviem turnīriem, pārvaldi komandas un lasi jaunākās ziņas.
                </p>

                <a href="{{ route('login') }}" class="login-link reveal" data-stagger="3">
                    Jau ir konts? Ienākt
                </a>
            </div>

            <div class="contacts reveal" data-stagger="4">
                <div class="contacts__label">Kontakti</div>
                <a href="tel:+37120001234" class="contact-item">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.09a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
                    </svg>
                    +371 20001234
                </a>
                <a href="mailto:info@volleylv.example" class="contact-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    info@volleylv.example
                </a>
                <div class="contact-item__status">
                    <div class="contact-item__status__dot"></div>
                    Atbildam darba dienās 09:00–18:00
                </div>
                <div class="page-footer">© {{ date('Y') }} VolleyLV</div>
            </div>
        </div>

        {{-- Right panel (form) --}}
        <div class="page__right">
            <div style="max-width:460px; width:100%; margin:0 auto;">

                <div class="form-header reveal" data-stagger="0">
                    <div class="form-header__title">Reģistrēties</div>
                    <div class="form-header__sub">Aizpildi datus, lai izveidotu kontu.</div>
                </div>

                @if ($errors->any())
                    <div class="alert alert--error reveal" data-stagger="1">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="reveal" data-stagger="1">
                    @csrf

                    <div class="field">
                        <label class="field-label" for="name">Vārds</label>
                        <input class="field-input" id="name" type="text" name="name"
                            value="{{ old('name') }}" required autofocus placeholder="Tavs vārds">
                    </div>

                    <hr class="form-separator">

                    <div class="field">
                        <label class="field-label" for="email">E-pasts</label>
                        <input class="field-input" id="email" type="email" name="email"
                            value="{{ old('email') }}" required placeholder="you@example.com">
                    </div>

                    <hr class="form-separator">

                    <div class="field-row">
                        <div class="field">
                            <label class="field-label" for="password">Parole</label>
                            <input class="field-input" id="password" type="password" name="password" required
                                placeholder="••••••••">
                        </div>

                        <div class="field">
                            <label class="field-label" for="password_confirmation">Apstiprini paroli</label>
                            <input class="field-input" id="password_confirmation" type="password"
                                name="password_confirmation" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('login') }}" class="form-link">Jau ir konts? Ienākt</a>
                        <button type="submit" class="btn-submit">Reģistrēties →</button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <script>
        const root = document.getElementById('pageRoot');
        requestAnimationFrame(() => root.style.opacity = '1');

        document.querySelectorAll('.page__right .reveal, .page__left .reveal').forEach(el => {
            const i = parseInt(el.dataset.stagger || '0', 10);
            setTimeout(() => el.classList.add('in'), 80 + i * 90);
        });

        document.addEventListener('mouseover', e => {
            const a = e.target.closest('a[data-prefetch]');
            if (!a || a.dataset.prefetched) return;
            const l = document.createElement('link');
            l.rel = 'prefetch';
            l.as = 'document';
            l.href = a.href;
            document.head.appendChild(l);
            a.dataset.prefetched = '1';
        }, {
            passive: true
        });

        document.addEventListener('click', e => {
            const a = e.target.closest('a[data-transition]');
            if (!a || !document.startViewTransition) return;
            e.preventDefault();
            document.startViewTransition(() => {
                window.location.href = a.href;
            });
        });
    </script>
</body>

</html>
