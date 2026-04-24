<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Barlow+Condensed:wght@600;700;900&family=DM+Sans:wght@400;500&display=swap');

        .db * {
            box-sizing: border-box;
        }

        .db {
            --ink: #0F0F0E;
            --ink-2: #3A3935;
            --ink-3: #7A7770;
            --ink-4: #B8B5AF;
            --paper: #F8F6F1;
            --paper-2: #EFECE5;
            --rule: #D8D4CC;
            --red: #B8241C;
            --red-dark: #8A1A14;
            --red-tint: #F9EEEE;
            --red-hover: #961E17;
            --white: #FFFFFF;

            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            margin-top: 0;
        }

        /* ── Wrappers ── */
        .db-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        .db-wrap--wide {
            max-width: 1360px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        /* ── Page top rule + title ── */
        .db-masthead {
            border-top: 4px solid var(--ink);
            padding: 1.25rem 0 1rem;
            margin-top: 50px;
            margin-bottom: 0;
        }

        .db-masthead__eyebrow {
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.4rem;
        }

        .db-masthead__title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.9rem, 4vw, 2.8rem);
            font-weight: 900;
            letter-spacing: -0.025em;
            line-height: 1.05;
            color: var(--ink);
            margin: 0;
        }

        /* ── Divider ── */
        .db-rule {
            border: none;
            border-top: 1px solid var(--rule);
            margin: 0;
        }

        /* ── Flash ── */
        .db-flash {
            padding: 0.7rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            border-left: 3px solid;
            margin: 1rem 0 0;
        }

        .db-flash--ok {
            background: #EAF4EE;
            color: #1E6A3A;
            border-color: #1E6A3A;
        }

        /* ── Section headers ── */
        .db-section-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .db-section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
        }

        .db-section-link {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--red);
            text-decoration: none;
            transition: color 0.15s;
        }

        .db-section-link:hover {
            color: var(--red-hover);
        }

        /* ── Hero featured news ── */
        .db-hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border: 1px solid var(--rule);
            overflow: hidden;
            background: var(--white);
            margin: 2rem 0;
        }

        @media (max-width: 760px) {
            .db-hero {
                grid-template-columns: 1fr;
            }
        }

        .db-hero__img {
            position: relative;
            overflow: hidden;
            min-height: 280px;
        }

        .db-hero__img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.6s ease;
        }

        .db-hero:hover .db-hero__img img {
            transform: scale(1.03);
        }

        .db-hero__body {
            padding: 2rem 1.75rem 1.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-left: 1px solid var(--rule);
        }

        @media (max-width: 760px) {
            .db-hero__body {
                border-left: none;
                border-top: 1px solid var(--rule);
            }
        }

        .db-hero__kicker {
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.6rem;
        }

        .db-hero__title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.3rem, 2.8vw, 2rem);
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
            color: var(--ink);
            text-decoration: none;
            display: block;
            margin-bottom: 0.6rem;
        }

        .db-hero__title:hover {
            color: var(--red);
        }

        .db-hero__date {
            font-size: 0.72rem;
            color: var(--ink-3);
            margin-bottom: 0.9rem;
        }

        .db-hero__excerpt {
            font-size: 0.9rem;
            line-height: 1.7;
            color: var(--ink-2);
            flex: 1;
            font-weight: 300;
        }

        .db-hero__cta {
            display: inline-flex;
            align-items: center;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--red);
            text-decoration: none;
            margin-top: 1.25rem;
            border-bottom: 1px solid var(--red);
            padding-bottom: 1px;
            transition: color 0.15s, border-color 0.15s;
        }

        .db-hero__cta:hover {
            color: var(--red-hover);
            border-color: var(--red-hover);
        }

        .db-hero__cta::after {
            content: ' →';
        }

        /* ── Main 2-col layout ── */
        .db-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 0;
            border-top: 1px solid var(--rule);
            margin-bottom: 0;
        }

        @media (max-width: 960px) {
            .db-layout {
                grid-template-columns: 1fr;
            }
        }

        .db-main {
            border-right: 1px solid var(--rule);
            padding: 2rem 2rem 2rem 0;
        }

        @media (max-width: 960px) {
            .db-main {
                border-right: none;
                padding-right: 0;
                border-bottom: 1px solid var(--rule);
                padding-bottom: 2rem;
            }
        }

        .db-aside {
            padding: 2rem 0 2rem 2rem;
        }

        @media (max-width: 960px) {
            .db-aside {
                padding-left: 0;
                padding-top: 2rem;
            }
        }

        /* ── Tournament cards ── */
        .db-tourn-list {
            display: flex;
            flex-direction: column;
        }

        .db-tourn {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.1rem 0;
            border-bottom: 1px solid var(--rule);
            transition: background 0.12s;
        }

        .db-tourn:first-child {
            border-top: 1px solid var(--rule);
        }

        .db-tourn:hover {
            background: var(--paper-2);
            margin: 0 -0.5rem;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .db-tourn__date {
            flex-shrink: 0;
            width: 52px;
            height: 52px;
            background: var(--ink);
            color: var(--white);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Barlow Condensed', sans-serif;
        }

        .db-tourn__date--red {
            background: var(--red);
        }

        .db-tourn__date__day {
            font-size: 1.3rem;
            font-weight: 900;
            line-height: 1;
        }

        .db-tourn__date__mon {
            font-size: 0.58rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            opacity: 0.75;
        }

        .db-tourn__body {
            flex: 1;
            min-width: 0;
        }

        .db-tourn__name {
            font-family: 'Playfair Display', serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--ink);
            text-decoration: none;
            display: block;
            line-height: 1.25;
            margin-bottom: 0.3rem;
        }

        .db-tourn__name:hover {
            color: var(--red);
        }

        .db-tourn__meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            font-size: 0.7rem;
            color: var(--ink-3);
        }

        .db-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.15rem 0.55rem;
            border-radius: 999px;
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .db-badge--men {
            background: #EBF1F9;
            color: #1A4F8A;
        }

        .db-badge--women {
            background: #FCEEF5;
            color: #8A1A5E;
        }

        .db-badge--mix {
            background: #F0EBF9;
            color: #4A1A8A;
        }

        .db-badge--other {
            background: var(--paper-2);
            color: var(--ink-3);
        }

        .db-badge--active {
            background: #EAF4EE;
            color: #1E6A3A;
        }

        .db-badge--pending {
            background: #FEF8EC;
            color: #7A5A10;
        }

        .db-badge--done {
            background: var(--paper-2);
            color: var(--ink-3);
        }

        .db-badge--full {
            background: var(--red);
            color: var(--white);
        }

        .db-tourn__progress {
            margin-top: 0.5rem;
        }

        .db-tourn__bar {
            height: 3px;
            background: var(--paper-2);
            overflow: hidden;
            width: 100%;
            max-width: 160px;
        }

        .db-tourn__bar__fill {
            height: 100%;
            background: var(--ink-2);
            transition: width 0.3s;
        }

        .db-tourn__bar__fill--warn {
            background: #B87A10;
        }

        .db-tourn__bar__fill--full {
            background: var(--red);
        }

        .db-tourn__bar__label {
            font-size: 0.62rem;
            color: var(--ink-4);
            margin-top: 0.2rem;
        }

        .db-tourn__cta {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.68rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--ink-2);
            text-decoration: none;
            border: 1px solid var(--rule);
            padding: 0.3rem 0.7rem;
            transition: all 0.15s;
        }

        .db-tourn__cta:hover {
            background: var(--ink);
            color: var(--white);
            border-color: var(--ink);
        }

        /* ── News sidebar cards ── */
        .db-news-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.9rem 0;
            border-bottom: 1px solid var(--rule);
            text-decoration: none;
            color: inherit;
            transition: background 0.12s;
        }

        .db-news-item:first-child {
            border-top: 1px solid var(--rule);
        }

        .db-news-item:hover {
            background: var(--paper-2);
            margin: 0 -0.5rem;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .db-news-item__img {
            flex-shrink: 0;
            width: 64px;
            height: 64px;
            overflow: hidden;
            border: 1px solid var(--rule);
        }

        .db-news-item__img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .db-news-item__title {
            font-family: 'Playfair Display', serif;
            font-size: 0.9rem;
            font-weight: 700;
            line-height: 1.3;
            color: var(--ink);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.3rem;
        }

        .db-news-item:hover .db-news-item__title {
            color: var(--red);
        }

        .db-news-item__date {
            font-size: 0.65rem;
            color: var(--ink-4);
        }

        /* ── Calendar ── */
        .db-cal {
            border: 1px solid var(--rule);
            background: var(--white);
            margin-top: 2rem;
        }

        .db-cal__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.9rem 1rem;
            border-bottom: 1px solid var(--rule);
            background: var(--paper-2);
        }

        .db-cal__nav {
            background: none;
            border: 1px solid var(--rule);
            padding: 0.25rem 0.6rem;
            cursor: pointer;
            font-size: 0.75rem;
            color: var(--ink-2);
            transition: all 0.15s;
            font-family: 'DM Sans', sans-serif;
        }

        .db-cal__nav:hover {
            background: var(--ink);
            color: var(--white);
            border-color: var(--ink);
        }

        .db-cal__month {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--ink);
        }

        .db-cal__grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .db-cal__wd {
            padding: 0.4rem 0;
            text-align: center;
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-3);
            border-bottom: 1px solid var(--rule);
        }

        .db-cal__cell {
            min-height: 60px;
            padding: 0.35rem 0.3rem;
            border-bottom: 1px solid var(--rule);
            border-right: 1px solid var(--rule);
            font-size: 0.7rem;
            transition: background 0.12s;
            overflow: hidden;
        }

        .db-cal__cell:nth-child(7n) {
            border-right: none;
        }

        .db-cal__cell:hover {
            background: var(--paper-2);
        }

        .db-cal__cell__day {
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--ink-3);
            margin-bottom: 0.2rem;
        }

        .db-cal__cell__ev {
            display: block;
            font-size: 0.55rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: var(--white);
            background: var(--red);
            padding: 0.1rem 0.25rem;
            margin-bottom: 0.15rem;
            cursor: pointer;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: background 0.12s;
        }

        .db-cal__cell__ev:hover {
            background: var(--red-hover);
        }

        .db-cal__cell__ev--active {
            background: #1E6A3A;
        }

        .db-cal__cell__ev--done {
            background: var(--ink-3);
        }

        .db-cal__cell__more {
            font-size: 0.6rem;
            color: var(--red);
            font-weight: 600;
            cursor: pointer;
        }

        .db-cal__legend {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--rule);
            font-size: 0.65rem;
            color: var(--ink-3);
        }

        .db-cal__legend-dot {
            width: 8px;
            height: 8px;
            flex-shrink: 0;
        }

        /* ── Mobile agenda ── */
        .db-agenda-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--rule);
            align-items: flex-start;
        }

        .db-agenda-item:first-child {
            border-top: 1px solid var(--rule);
        }

        .db-agenda-item__dow {
            flex-shrink: 0;
            width: 44px;
            font-family: 'Barlow Condensed', sans-serif;
            text-align: center;
        }

        .db-agenda-item__dow__label {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--red);
        }

        .db-agenda-item__dow__num {
            font-size: 1.3rem;
            font-weight: 900;
            color: var(--ink);
            line-height: 1;
        }

        .db-agenda-item__chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
            flex: 1;
            padding-top: 0.2rem;
        }

        /* ── Login card (footer) ── */
        .db-footer {
            background: var(--ink);
            color: var(--white);
            margin-top: 0;
        }

        .db-footer__inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            padding: 3.5rem 0;
        }

        @media (max-width: 760px) {
            .db-footer__inner {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }
        }

        .db-footer__title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 3.5vw, 2.4rem);
            font-weight: 900;
            letter-spacing: -0.02em;
            line-height: 1.1;
            margin-bottom: 0.75rem;
        }

        .db-footer__sub {
            font-size: 0.9rem;
            color: rgba(245, 244, 240, 0.6);
            font-weight: 300;
            line-height: 1.6;
        }

        /* Login form */
        .db-login {
            background: var(--white);
            color: var(--ink);
            padding: 2rem;
        }

        .db-login__title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.25rem;
        }

        .db-login__sub {
            font-size: 0.8rem;
            color: var(--ink-3);
            margin-bottom: 1.5rem;
        }

        .db-input-label {
            display: block;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-2);
            margin-bottom: 0.35rem;
        }

        .db-input {
            width: 100%;
            border: none;
            border-bottom: 1px solid var(--rule);
            padding: 0.5rem 0;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            color: var(--ink);
            background: transparent;
            outline: none;
            margin-bottom: 1.25rem;
            transition: border-color 0.2s;
        }

        .db-input:focus {
            border-bottom-color: var(--ink);
        }

        .db-input::placeholder {
            color: var(--ink-4);
        }

        .db-login__footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .db-login__link {
            font-size: 0.75rem;
            color: var(--ink-3);
            text-decoration: none;
            border-bottom: 1px solid var(--rule);
            padding-bottom: 1px;
            transition: color 0.15s;
        }

        .db-login__link:hover {
            color: var(--ink);
        }

        .db-btn-submit {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            background: var(--red);
            color: var(--white);
            border: 1px solid var(--red);
            padding: 0.55rem 1.5rem;
            cursor: pointer;
            transition: background 0.15s;
            border-radius: 0;
        }

        .db-btn-submit:hover {
            background: var(--red-hover);
            border-color: var(--red-hover);
        }

        .db-btn-guest {
            display: block;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            background: none;
            color: var(--ink-3);
            border: 1px solid var(--rule);
            padding: 0.55rem 1.5rem;
            cursor: pointer;
            transition: all 0.15s;
            border-radius: 0;
            margin-top: 0.75rem;
            text-align: center;
            text-decoration: none;
        }

        .db-btn-guest:hover {
            background: var(--paper-2);
            color: var(--ink);
        }

        .db-error-box {
            background: var(--red-tint);
            color: var(--red-dark);
            border-left: 3px solid var(--red);
            padding: 0.6rem 0.75rem;
            font-size: 0.78rem;
            margin-bottom: 1rem;
        }

        .db-success-box {
            background: #EAF4EE;
            color: #1E6A3A;
            border-left: 3px solid #1E6A3A;
            padding: 0.6rem 0.75rem;
            font-size: 0.78rem;
            margin-bottom: 1rem;
        }

        /* ── Reveal ── */
        .db-reveal {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .db-reveal.in {
            opacity: 1;
            transform: none;
        }

        /* ── Modal — mirrors calendar.blade exactly (hard-coded hex, outside .db scope) ── */
        .db-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 15, 14, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(3px);
        }

        .db-modal-overlay.open {
            display: flex;
        }

        .db-modal {
            background: #FFFFFF;
            max-width: 480px;
            width: calc(100% - 2rem);
            margin: 1rem;
            border-top: 4px solid #B8241C;
            position: relative;
            box-shadow: 0 32px 80px rgba(0, 0, 0, .4), 0 8px 24px rgba(0, 0, 0, .25);
            animation: dbModalIn 0.22s cubic-bezier(.16, 1, .3, 1) both;
        }

        @keyframes dbModalIn {
            from {
                opacity: 0;
                transform: translateY(14px) scale(.98);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .db-modal__header {
            padding: 1.25rem 1.5rem 1rem;
            border-bottom: 1px solid #D8D4CC;
        }

        .db-modal__date-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #B8241C;
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .db-modal__date-label::before {
            content: '';
            display: block;
            width: 14px;
            height: 2px;
            background: #B8241C;
        }

        .db-modal__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 0.01em;
            color: #0F0F0E;
            margin: 0;
        }

        .db-modal__subtitle {
            font-size: 0.72rem;
            color: #7A7770;
            margin-top: 0.25rem;
        }

        .db-modal__close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #B8B5AF;
            line-height: 1;
            width: 1.75rem;
            height: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.15s, background 0.15s;
            border-radius: 50%;
        }

        .db-modal__close:hover {
            color: #0F0F0E;
            background: #EFECE5;
        }

        .db-modal__list {
            list-style: none;
            margin: 0;
            padding: 0.4rem 0;
            max-height: 400px;
            overflow-y: auto;
        }

        .db-modal__list::-webkit-scrollbar {
            width: 4px;
        }

        .db-modal__list::-webkit-scrollbar-thumb {
            background: #D8D4CC;
        }

        .db-modal__item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid #EFECE5;
            cursor: pointer;
            transition: background 0.12s;
            position: relative;
        }

        .db-modal__item:last-child {
            border-bottom: none;
        }

        .db-modal__item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: #B8241C;
            transition: width 0.18s;
        }

        .db-modal__item:hover {
            background: #F8F6F1;
        }

        .db-modal__item:hover::before {
            width: 3px;
        }

        .db-modal__item-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #0F0F0E;
            flex: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .db-modal__item:hover .db-modal__item-name {
            color: #B8241C;
        }

        .db-modal__item-badge {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.15rem 0.5rem;
            border: 1px solid;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .db-mbadge--generic {
            color: #B8241C;
            border-color: rgba(184, 36, 28, .35);
            background: #F9EEEE;
        }

        .db-mbadge--men {
            color: #1A4F8A;
            border-color: #B8CDE8;
            background: #EBF1F9;
        }

        .db-mbadge--women {
            color: #8A1A5E;
            border-color: #E8B8D4;
            background: #FCEEF5;
        }

        .db-mbadge--mix {
            color: #4A1A8A;
            border-color: #C8B8E8;
            background: #F0EBF9;
        }

        .db-mbadge--full {
            color: #FFFFFF;
            border-color: #B8241C;
            background: #B8241C;
        }

        .db-modal__item-arrow {
            font-size: 0.75rem;
            color: #B8B5AF;
            flex-shrink: 0;
            transition: color 0.15s, transform 0.15s;
        }

        .db-modal__item:hover .db-modal__item-arrow {
            color: #B8241C;
            transform: translateX(2px);
        }

        .db-modal__footer {
            padding: 0.75rem 1.5rem;
            border-top: 1px solid #D8D4CC;
            background: #F8F6F1;
            font-size: 0.68rem;
            color: #B8B5AF;
            text-align: center;
        }
    </style>

    <div class="db">

        @php
            $calendarEvents = ($tournaments ?? collect())
                ->map(function ($t) {
                    $appsCount = method_exists($t, 'applications') ? $t->applications()->count() : 0;
                    $isFull = $t->max_teams ? $appsCount >= (int) $t->max_teams : false;
                    return [
                        'title' => $t->name,
                        'start' => \Carbon\Carbon::parse($t->start_date)->toDateString(),
                        'end' => \Carbon\Carbon::parse($t->end_date ?? $t->start_date)->toDateString(),
                        'gender_type' => $t->gender_type,
                        'status' => $t->status,
                        'is_full' => $isFull,
                        'url' => route('tournaments.show', $t),
                    ];
                })
                ->values();

            $featured = $news->first();
            $newsBar = $news->skip(1)->take(8);
            $closestTournaments = $tournaments->sortBy('start_date')->take(4);
        @endphp

        {{-- Masthead --}}
        <div class="db-masthead db-reveal" data-stagger="0">
            <div class="db-wrap">
                <div class="db-masthead__eyebrow">VolleyLV</div>
                <h1 class="db-masthead__title">Sākumlapa</h1>
            </div>
        </div>
        <hr class="db-rule">

        @if (session('success'))
            <div class="db-wrap">
                <div class="db-flash db-flash--ok db-reveal" data-stagger="1">{{ session('success') }}</div>
            </div>
        @endif

        @if ($news->isNotEmpty())

            {{-- Featured hero --}}
            <div class="db-wrap db-reveal" data-stagger="1">
                <div class="db-section-head" style="margin-top:1.75rem;margin-bottom:0.75rem;">
                    <span class="db-section-title"
                        style="font-size:0.65rem;font-family:'DM Sans',sans-serif;font-weight:500;letter-spacing:0.14em;text-transform:uppercase;color:var(--red);">Galvenā
                        ziņa</span>
                </div>
                <article class="db-hero">
                    <a href="{{ route('news.show', $featured) }}" class="db-hero__img">
                        @if ($featured->image_url)
                            <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}"
                                onerror="this.src='https://images.unsplash.com/photo-1541494800-b7672acb4c5e?w=1200&auto=format&fit=crop'">
                        @else
                            <img src="https://images.unsplash.com/photo-1541494800-b7672acb4c5e?w=1200&auto=format&fit=crop"
                                alt="">
                        @endif
                    </a>
                    <div class="db-hero__body">
                        <div>
                            <div class="db-hero__kicker">Jaunākais</div>
                            <a href="{{ route('news.show', $featured) }}"
                                class="db-hero__title">{{ $featured->title }}</a>
                            <div class="db-hero__date">{{ $featured->created_at->format('d.m.Y') }}</div>
                            <p class="db-hero__excerpt">{{ Str::limit(strip_tags($featured->content), 200) }}</p>
                        </div>
                        <a href="{{ route('news.show', $featured) }}" class="db-hero__cta">Lasīt vairāk</a>
                    </div>
                </article>
            </div>

            {{-- Main 2-col layout --}}
            <div class="db-wrap">
                <div class="db-layout db-reveal" data-stagger="2">

                    {{-- Left: Tournaments --}}
                    <div class="db-main">
                        @if ($closestTournaments->isNotEmpty())
                            <div class="db-section-head">
                                <span class="db-section-title">Tuvākie Turnīri</span>
                                <a href="{{ route('tournaments.index') }}" class="db-section-link">Visi turnīri →</a>
                            </div>

                            <div class="db-tourn-list">
                                @foreach ($closestTournaments as $t)
                                    @php
                                        $gender = $t->gender_type ?? 'other';
                                        $appsCount = method_exists($t, 'applications')
                                            ? $t->applications()->count()
                                            : 0;
                                        $isFull = $t->max_teams ? $appsCount >= (int) $t->max_teams : false;
                                        $status = $t->status;
                                        $pct = $t->max_teams
                                            ? min(100, round(($appsCount / max(1, (int) $t->max_teams)) * 100))
                                            : null;
                                        $barCls =
                                            $pct >= 100
                                                ? 'db-tourn__bar__fill--full'
                                                : ($pct >= 80
                                                    ? 'db-tourn__bar__fill--warn'
                                                    : '');
                                        $statusCls = match ($status) {
                                            'active' => 'db-badge--active',
                                            'completed' => 'db-badge--done',
                                            default => 'db-badge--pending',
                                        };
                                        $statusLbl = match ($status) {
                                            'active' => 'Aktīvs',
                                            'completed' => 'Pabeigts',
                                            default => 'Gaida',
                                        };
                                        $genderCls = match ($gender) {
                                            'men' => 'db-badge--men',
                                            'women' => 'db-badge--women',
                                            'mix' => 'db-badge--mix',
                                            default => 'db-badge--other',
                                        };
                                        $genderLbl = match ($gender) {
                                            'men' => 'Vīrieši',
                                            'women' => 'Sievietes',
                                            'mix' => 'Mix',
                                            default => ucfirst($gender),
                                        };
                                        $start = \Carbon\Carbon::parse($t->start_date);
                                        $isUpcoming = $start->isFuture();
                                    @endphp
                                    <div class="db-tourn">
                                        <div class="db-tourn__date {{ $isUpcoming ? 'db-tourn__date--red' : '' }}">
                                            <div class="db-tourn__date__day">{{ $start->format('d') }}</div>
                                            <div class="db-tourn__date__mon">{{ strtoupper($start->format('M')) }}
                                            </div>
                                        </div>
                                        <div class="db-tourn__body">
                                            <a href="{{ route('tournaments.show', $t) }}"
                                                class="db-tourn__name">{{ $t->name }}</a>
                                            <div class="db-tourn__meta">
                                                @if ($t->location)
                                                    <span>{{ $t->location }}</span>
                                                @endif
                                                <span class="db-badge {{ $genderCls }}">{{ $genderLbl }}</span>
                                                <span class="db-badge {{ $statusCls }}">{{ $statusLbl }}</span>
                                                @if ($isFull)
                                                    <span class="db-badge db-badge--full">Pilns</span>
                                                @endif
                                            </div>
                                            @if (!is_null($pct))
                                                <div class="db-tourn__progress">
                                                    <div class="db-tourn__bar">
                                                        <div class="db-tourn__bar__fill {{ $barCls }}"
                                                            style="width:{{ $pct }}%"></div>
                                                    </div>
                                                    <div class="db-tourn__bar__label">
                                                        {{ $appsCount }}/{{ (int) $t->max_teams }}
                                                        ({{ $pct }}%)</div>
                                                </div>
                                            @endif
                                        </div>
                                        <a href="{{ route('tournaments.show', $t) }}" class="db-tourn__cta">Skatīt</a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Calendar --}}
                        <div class="db-reveal" data-stagger="3" style="margin-top:2.5rem;">
                            <div class="db-section-head">
                                <span class="db-section-title">Turnīru Kalendārs</span>
                            </div>
                            <div class="db-cal">
                                <div class="db-cal__head">
                                    <button id="prevMonth" class="db-cal__nav">←</button>
                                    <div id="monthYear" class="db-cal__month"></div>
                                    <button id="nextMonth" class="db-cal__nav">→</button>
                                </div>
                                <div class="db-cal__grid">
                                    @foreach (['Sv', 'Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se'] as $wd)
                                        <div class="db-cal__wd">{{ $wd }}</div>
                                    @endforeach
                                </div>
                                <div id="calendarGrid" class="db-cal__grid hidden md:grid"></div>
                                <div id="mobileAgenda" class="md:hidden" style="padding:1rem;"></div>
                                <div class="db-cal__legend">
                                    <span style="display:flex;align-items:center;gap:4px;"><span
                                            class="db-cal__legend-dot" style="background:var(--red)"></span>
                                        Gaida</span>
                                    <span style="display:flex;align-items:center;gap:4px;"><span
                                            class="db-cal__legend-dot" style="background:#1E6A3A"></span> Aktīvs</span>
                                    <span style="display:flex;align-items:center;gap:4px;"><span
                                            class="db-cal__legend-dot" style="background:var(--ink-3)"></span>
                                        Pabeigts</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: News sidebar --}}
                    <div class="db-aside">
                        <div class="db-section-head">
                            <span class="db-section-title">Ziņas</span>
                            <a href="{{ route('news.index') }}" class="db-section-link">Visas →</a>
                        </div>
                        @foreach ($newsBar as $item)
                            <a href="{{ route('news.show', $item) }}" class="db-news-item">
                                <div class="db-news-item__img">
                                    @if ($item->image_url)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                            onerror="this.parentElement.style.display='none'">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?w=200&auto=format&fit=crop"
                                            alt="">
                                    @endif
                                </div>
                                <div>
                                    <div class="db-news-item__title">{{ $item->title }}</div>
                                    <div class="db-news-item__date">{{ $item->created_at->format('d.m.Y') }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                </div>
            </div>
        @endif

        {{-- Footer / Login --}}
        <div class="db-footer" style="margin-top:3rem;">
            <div class="db-wrap">
                @guest
                    <div class="db-footer__inner">
                        <div>
                            <div class="db-footer__title">Laipni lūdzam atpakaļ</div>
                            <p class="db-footer__sub">Ienāc, lai sekotu turnīriem, pārvaldītu komandas un lasītu jaunākās
                                ziņas.</p>
                        </div>
                        <div>
                            <div class="db-login">
                                <div class="db-login__title">Ienākt</div>
                                <div class="db-login__sub">Ievadi savus datus zemāk.</div>

                                @if ($errors->any())
                                    <div class="db-error-box">
                                        @foreach ($errors->all() as $e)
                                            <div>{{ $e }}</div>
                                        @endforeach
                                    </div>
                                @endif
                                @if (session('status'))
                                    <div class="db-success-box">{{ session('status') }}</div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <label class="db-input-label" for="email">E-pasts</label>
                                    <input class="db-input" id="email" type="email" name="email"
                                        value="{{ old('email') }}" required placeholder="you@example.com">
                                    <label class="db-input-label" for="password">Parole</label>
                                    <input class="db-input" id="password" type="password" name="password" required
                                        placeholder="••••••••">
                                    <label
                                        style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.75rem;color:var(--ink-3);cursor:pointer;">
                                        <input type="checkbox" name="remember"> Atcerēties mani
                                    </label>
                                    <div class="db-login__footer">
                                        <a href="{{ route('register') }}" class="db-login__link">Nav konta?
                                            Reģistrējies</a>
                                        <button type="submit" class="db-btn-submit">Ienākt</button>
                                    </div>
                                </form>
                                @if (Route::has('guest.login'))
                                    <form method="POST" action="{{ route('guest.login') }}">
                                        @csrf
                                        <button type="submit" class="db-btn-guest">Turpināt kā viesim</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endguest
                <div
                    style="padding:1.25rem 0;border-top:1px solid rgba(245,244,240,0.1);text-align:center;font-size:0.75rem;color:rgba(245,244,240,0.35);">
                    © {{ now()->year }} VolleyLV — Visas tiesības aizsargātas
                </div>
            </div>
        </div>
    </div>

    {{-- Modal — identical structure to calendar.blade --}}
    <div id="modalOverlay" class="db-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="db-modal">
            <button id="closeModal" class="db-modal__close" aria-label="Aizvērt">✕</button>
            <div class="db-modal__header">
                <div class="db-modal__date-label">Turnīri</div>
                <h3 id="modalTitle" class="db-modal__title"></h3>
                <div id="modalSubtitle" class="db-modal__subtitle"></div>
            </div>
            <ul id="modalTournaments" class="db-modal__list"></ul>
            <div class="db-modal__footer">Klikšķini uz turnīra, lai skatītu sīkāk</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.db-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 50 + i * 80);
            });
        });

        const tournamentsData = @json($calendarEvents);
        let currentDate = new Date();

        const monthNames = ["Janvāris", "Februāris", "Marts", "Aprīlis", "Maijs", "Jūnijs", "Jūlijs", "Augusts",
            "Septembris", "Oktobris", "Novembris", "Decembris"
        ];

        const parseYMD = ymd => {
            const [y, m, d] = ymd.split('-').map(Number);
            return new Date(y, m - 1, d);
        };
        const evClass = s => s === 'active' ? 'db-cal__cell__ev--active' : (s === 'completed' ? 'db-cal__cell__ev--done' :
            '');

        function buildMonthMap(year, month) {
            const first = new Date(year, month, 1);
            const last = new Date(year, month + 1, 0);
            const map = Object.create(null);
            for (const ev of tournamentsData) {
                const sRaw = parseYMD(ev.start),
                    eRaw = parseYMD(ev.end || ev.start);
                if (eRaw < first || sRaw > last) continue;
                const s = sRaw < first ? first : sRaw;
                const e = eRaw > last ? last : eRaw;
                for (let d = new Date(s); d <= e; d.setDate(d.getDate() + 1)) {
                    const key = d.toISOString().slice(0, 10);
                    (map[key] ||= []).push(ev);
                }
            }
            return map;
        }

        function renderCalendar(date) {
            const grid = document.getElementById('calendarGrid');
            if (!grid) return;
            grid.innerHTML = '';
            const y = date.getFullYear(),
                m = date.getMonth();
            document.getElementById('monthYear').textContent = `${monthNames[m]} ${y}`;
            const firstDay = new Date(y, m, 1).getDay();
            const lastDate = new Date(y, m + 1, 0).getDate();
            const map = buildMonthMap(y, m);

            for (let i = 0; i < firstDay; i++) {
                const s = document.createElement('div');
                s.className = 'db-cal__cell';
                s.style.background = 'var(--paper)';
                grid.appendChild(s);
            }
            for (let d = 1; d <= lastDate; d++) {
                const cell = document.createElement('div');
                cell.className = 'db-cal__cell';
                const key = new Date(y, m, d).toISOString().slice(0, 10);
                const evs = map[key] || [];
                cell.innerHTML = `<div class="db-cal__cell__day">${d}</div>`;
                if (evs.length <= 2) {
                    evs.forEach(ev => {
                        const span = document.createElement('span');
                        span.className = `db-cal__cell__ev ${evClass(ev.status)}`;
                        span.textContent = ev.title;
                        span.title = ev.title;
                        span.onclick = () => ev.url && (window.location.href = ev.url);
                        cell.appendChild(span);
                    });
                } else {
                    const more = document.createElement('span');
                    more.className = 'db-cal__cell__more';
                    more.textContent = `+${evs.length}`;
                    more.onclick = () => openModal(new Date(y, m, d), evs);
                    cell.appendChild(more);
                }
                grid.appendChild(cell);
            }
        }

        function renderAgenda(date) {
            const agenda = document.getElementById('mobileAgenda');
            if (!agenda) return;
            agenda.innerHTML = '';
            const y = date.getFullYear(),
                m = date.getMonth();
            const lastDate = new Date(y, m + 1, 0).getDate();
            const map = buildMonthMap(y, m);
            const wds = ['Sv', 'Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se'];
            let any = false;
            for (let d = 1; d <= lastDate; d++) {
                const dObj = new Date(y, m, d);
                const key = dObj.toISOString().slice(0, 10);
                const evs = map[key] || [];
                if (!evs.length) continue;
                any = true;
                const row = document.createElement('div');
                row.className = 'db-agenda-item';
                const left = document.createElement('div');
                left.className = 'db-agenda-item__dow';
                left.innerHTML =
                    `<div class="db-agenda-item__dow__label">${wds[dObj.getDay()]}</div><div class="db-agenda-item__dow__num">${String(d).padStart(2,'0')}</div>`;
                const chips = document.createElement('div');
                chips.className = 'db-agenda-item__chips';
                evs.forEach(ev => {
                    const c = document.createElement('button');
                    c.type = 'button';
                    c.className = `db-cal__cell__ev ${evClass(ev.status)}`;
                    c.style.cssText =
                        'display:inline-block;max-width:200px;font-size:0.65rem;padding:0.2rem 0.4rem;cursor:pointer;';
                    c.textContent = ev.title;
                    c.onclick = () => ev.url && (window.location.href = ev.url);
                    chips.appendChild(c);
                });
                row.append(left, chips);
                agenda.appendChild(row);
            }
            if (!any) {
                agenda.innerHTML =
                    '<div style="text-align:center;font-size:0.8rem;color:var(--ink-4);padding:1rem 0;">Šajā mēnesī nav turnīru.</div>';
            }
        }

        function openModal(dateObj, items) {
            const mnms = ["Janvāris", "Februāris", "Marts", "Aprīlis", "Maijs", "Jūnijs", "Jūlijs", "Augusts", "Septembris",
                "Oktobris", "Novembris", "Decembris"
            ];
            document.getElementById('modalTitle').textContent =
                `${String(dateObj.getDate()).padStart(2,'0')}. ${mnms[dateObj.getMonth()]} ${dateObj.getFullYear()}`;
            document.getElementById('modalSubtitle').textContent =
                `${items.length} turnīr${items.length === 1 ? 's' : 'i'}`;

            const list = document.getElementById('modalTournaments');
            list.innerHTML = '';

            function badgeCls(g) {
                const v = (g || '').toLowerCase();
                if (v === 'men') return 'db-mbadge--men';
                if (v === 'women') return 'db-mbadge--women';
                if (v === 'mix') return 'db-mbadge--mix';
                return 'db-mbadge--generic';
            }

            function genderLabel(g) {
                const v = (g || '').toLowerCase();
                if (v === 'men') return 'Vīrieši';
                if (v === 'women') return 'Sievietes';
                if (v === 'mix') return 'Mix';
                return 'Turnīrs';
            }

            items.forEach(ev => {
                const li = document.createElement('li');
                li.className = 'db-modal__item';

                const name = document.createElement('span');
                name.className = 'db-modal__item-name';
                name.textContent = ev.title;
                name.title = ev.title;

                const badge = document.createElement('span');
                badge.className =
                    `db-modal__item-badge ${ev.is_full ? 'db-mbadge--full' : badgeCls(ev.gender_type)}`;
                badge.textContent = ev.is_full ? 'Pilns' : genderLabel(ev.gender_type);

                const arrow = document.createElement('span');
                arrow.className = 'db-modal__item-arrow';
                arrow.textContent = '→';
                arrow.setAttribute('aria-hidden', 'true');

                li.append(name, badge, arrow);
                li.onclick = () => ev.url && (window.location.href = ev.url);
                list.appendChild(li);
            });

            document.getElementById('modalOverlay').classList.add('open');
            document.getElementById('closeModal').focus();
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('open');
        }

        function renderAll() {
            renderCalendar(currentDate);
            renderAgenda(currentDate);
        }

        document.getElementById('prevMonth')?.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderAll();
        });
        document.getElementById('nextMonth')?.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderAll();
        });
        document.getElementById('closeModal')?.addEventListener('click', closeModal);
        document.getElementById('modalOverlay')?.addEventListener('click', e => {
            if (e.target === document.getElementById('modalOverlay')) closeModal();
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        }, {
            passive: true
        });

        let rTO;
        window.addEventListener('resize', () => {
            clearTimeout(rTO);
            rTO = setTimeout(renderAll, 100);
        });
        renderAll();

        // Prefetch
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
    </script>
</x-app-layout>
