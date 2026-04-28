<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,600;0,700;0,900;1,700;1,900&family=Barlow:wght@300;400;500&family=DM+Sans:wght@400;500&display=swap');

        .db * {
            box-sizing: border-box;
        }

        .db {
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

        /* ── Page masthead (same pattern as tournaments) ── */
        .db-header {
            background: var(--ink);
            padding: clamp(3.5rem, 8vh, 5.5rem) 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .db-header::after {
            content: 'SĀKUMS';
            position: absolute;
            right: -0.02em;
            bottom: -0.15em;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-style: italic;
            font-size: clamp(5rem, 14vw, 11rem);
            color: rgba(255, 255, 255, 0.04);
            line-height: 1;
            pointer-events: none;
            letter-spacing: -0.03em;
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.05);
        }

        .db-header__inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem 2rem;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .db-header__eyebrow {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .db-header__eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--red);
        }

        .db-header__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(2.8rem, 7vw, 5rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            color: var(--white);
            line-height: 0.95;
            margin: 0;
        }

        .db-bar {
            height: 3px;
            background: var(--red);
        }

        /* ── Wrap ── */
        .db-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ── Flash ── */
        .db-flash {
            background: #EAF4EE;
            border-left: 3px solid #1E7E34;
            color: #1E7E34;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            margin: 1.5rem 0 0;
        }

        /* ── Section header (same as ti-header__eyebrow feel) ── */
        .db-section-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-top: 2rem;
        }

        .db-section-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.35rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 0.01em;
            color: var(--ink);
        }

        .db-section-link {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--red);
            text-decoration: none;
            border-bottom: 1px solid rgba(197, 35, 27, 0.3);
            padding-bottom: 1px;
            transition: border-color 0.15s;
        }

        .db-section-link:hover {
            border-color: var(--red);
        }

        /* ── Main 2-col layout ── */
        .db-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 0;
            border-top: 1px solid var(--rule);
        }

        @media (max-width: 960px) {
            .db-layout {
                grid-template-columns: 1fr;
            }
        }

        .db-main {
            border-right: 1px solid var(--rule);
            padding-right: 2rem;
            padding-bottom: 2rem;
        }

        @media (max-width: 960px) {
            .db-main {
                border-right: none;
                padding-right: 0;
                border-bottom: 1px solid var(--rule);
            }
        }

        .db-aside {
            padding-left: 2rem;
            padding-bottom: 2rem;
        }

        @media (max-width: 960px) {
            .db-aside {
                padding-left: 0;
            }
        }

        /* ── Featured hero news (full-bleed dark) ── */
        .db-hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            background: var(--ink);
            margin: 2rem 0;
            position: relative;
        }

        @media (max-width: 700px) {
            .db-hero {
                grid-template-columns: 1fr;
            }
        }

        .db-hero__img {
            position: relative;
            overflow: hidden;
            min-height: 260px;
        }

        .db-hero__img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            filter: brightness(0.8);
            transition: transform 0.6s ease, filter 0.4s;
        }

        .db-hero:hover .db-hero__img img {
            transform: scale(1.04);
            filter: brightness(0.65);
        }

        /* Red diagonal accent on image */
        .db-hero__img::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            right: -1px;
            width: 60px;
            background: linear-gradient(to right, transparent, var(--ink));
        }

        @media (max-width: 700px) {
            .db-hero__img::after {
                display: none;
            }
        }

        .db-hero__body {
            padding: 2rem 1.75rem 1.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: var(--white);
        }

        .db-hero__kicker {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .db-hero__kicker::before {
            content: '';
            display: block;
            width: 16px;
            height: 2px;
            background: var(--red);
        }

        .db-hero__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            color: var(--white);
            text-decoration: none;
            line-height: 1.0;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.15s;
        }

        .db-hero__title:hover {
            color: var(--red);
        }

        .db-hero__date {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.35);
            margin-bottom: 1rem;
            letter-spacing: 0.04em;
        }

        .db-hero__excerpt {
            font-family: 'Barlow', sans-serif;
            font-size: 0.88rem;
            line-height: 1.65;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 300;
            flex: 1;
        }

        .db-hero__cta {
            display: inline-flex;
            align-items: center;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--white);
            text-decoration: none;
            margin-top: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 0.5rem 1.1rem;
            transition: background 0.15s, border-color 0.15s;
        }

        .db-hero__cta:hover {
            background: var(--red);
            border-color: var(--red);
        }

        .db-hero__cta::after {
            content: '  →';
        }

        /* ── Tournament rows (same as ti-row) ── */
        .db-tourn-list {
            display: flex;
            flex-direction: column;
        }

        .db-tourn {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 0 1rem;
            align-items: center;
            background: var(--white);
            border: 1px solid var(--rule);
            border-top: none;
            padding: 1rem 1.25rem;
            transition: background 0.15s;
            position: relative;
        }

        .db-tourn:first-child {
            border-top: 1px solid var(--rule);
        }

        .db-tourn:hover {
            background: var(--paper-2);
        }

        .db-tourn::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: var(--red);
            transition: width 0.2s;
        }

        .db-tourn:hover::before {
            width: 3px;
        }

        .db-tourn__date {
            flex-shrink: 0;
            text-align: center;
            min-width: 48px;
        }

        .db-tourn__date__day {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.9rem;
            font-weight: 900;
            font-style: italic;
            line-height: 1;
            color: var(--ink);
        }

        .db-tourn__date__mon {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--red);
        }

        .db-tourn__date--red .db-tourn__date__day {
            color: var(--red);
        }

        .db-tourn__body {
            min-width: 0;
        }

        .db-tourn__name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.01em;
            color: var(--ink);
            text-decoration: none;
            display: block;
            line-height: 1.1;
            margin-bottom: 0.3rem;
        }

        .db-tourn:hover .db-tourn__name {
            color: var(--red);
        }

        .db-tourn__meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem 0.9rem;
            font-size: 0.72rem;
            color: var(--ink-3);
            align-items: center;
        }

        /* Progress */
        .db-tourn__progress {
            margin-top: 0.5rem;
            max-width: 200px;
        }

        .db-tourn__bar {
            height: 2px;
            background: var(--rule);
            position: relative;
            overflow: hidden;
        }

        .db-tourn__bar__fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: var(--ink-2);
            transition: width 0.4s;
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
            margin-top: 0.25rem;
        }

        /* CTA */
        .db-tourn__cta {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--red);
            border: 1px solid var(--red);
            padding: 0.45rem 1rem;
            white-space: nowrap;
            flex-shrink: 0;
            transition: background 0.15s, color 0.15s;
        }

        .db-tourn__cta:hover {
            background: var(--red);
            color: var(--white);
        }

        @media (max-width: 560px) {
            .db-tourn {
                grid-template-columns: auto 1fr;
            }

            .db-tourn__cta {
                grid-column: 2;
                justify-self: start;
                margin-top: 0.5rem;
            }
        }

        /* ── Badges / pills ── */
        .db-pill {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.15rem 0.5rem;
            border: 1px solid;
            white-space: nowrap;
        }

        .db-pill--men {
            color: #1A4A8A;
            border-color: #B8CDE8;
            background: #EEF3FA;
        }

        .db-pill--women {
            color: #8A1A5A;
            border-color: #E8B8D4;
            background: #FAEEF5;
        }

        .db-pill--mix {
            color: #4A2A8A;
            border-color: #C8B8E8;
            background: #F4EEFC;
        }

        .db-pill--other {
            color: var(--ink-3);
            border-color: var(--rule);
            background: var(--paper);
        }

        .db-pill--active {
            color: #1E6A3A;
            border-color: #A8D9B8;
            background: #EAF4EE;
        }

        .db-pill--pending {
            color: #7A5A10;
            border-color: #E0C87A;
            background: #FEF8EC;
        }

        .db-pill--done {
            color: var(--ink-3);
            border-color: var(--rule);
            background: var(--paper-2);
        }

        .db-pill--full {
            color: var(--white);
            border-color: var(--red);
            background: var(--red);
        }

        /* ── Sidebar news items ── */
        .db-news-item {
            display: grid;
            grid-template-columns: 60px 1fr;
            gap: 0.75rem;
            padding: 0.9rem 0;
            border-bottom: 1px solid var(--rule);
            text-decoration: none;
            color: inherit;
            transition: background 0.12s;
            position: relative;
        }

        .db-news-item:first-child {
            border-top: 1px solid var(--rule);
        }

        .db-news-item::before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 0;
            bottom: 0;
            width: 0;
            background: var(--red);
            transition: width 0.18s;
        }

        .db-news-item:hover::before {
            width: 2px;
        }

        .db-news-item:hover {
            background: var(--paper-2);
            margin: 0 -0.5rem;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .db-news-item__img {
            width: 60px;
            height: 60px;
            overflow: hidden;
            border: 1px solid var(--rule);
            flex-shrink: 0;
        }

        .db-news-item__img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .db-news-item__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.01em;
            color: var(--ink);
            line-height: 1.2;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.25rem;
        }

        .db-news-item:hover .db-news-item__title {
            color: var(--red);
        }

        .db-news-item__date {
            font-size: 0.63rem;
            color: var(--ink-4);
            letter-spacing: 0.04em;
        }

        /* ── Calendar ── */
        .db-cal {
            border: 1px solid var(--rule);
            background: var(--white);
            margin-top: 1.5rem;
        }

        .db-cal__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--rule);
            background: var(--ink);
        }

        .db-cal__nav {
            background: none;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.7rem;
            cursor: pointer;
            font-size: 0.8rem;
            color: var(--white);
            transition: all 0.15s;
            font-family: 'DM Sans', sans-serif;
        }

        .db-cal__nav:hover {
            background: var(--red);
            border-color: var(--red);
        }

        .db-cal__month {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 900;
            font-style: italic;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--white);
        }

        .db-cal__grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .db-cal__wd {
            padding: 0.4rem 0;
            text-align: center;
            font-size: 0.58rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-3);
            border-bottom: 1px solid var(--rule);
        }

        .db-cal__cell {
            min-height: 56px;
            padding: 0.3rem;
            border-bottom: 1px solid var(--rule);
            border-right: 1px solid var(--rule);
            font-size: 0.68rem;
            transition: background 0.12s;
        }

        .db-cal__cell:nth-child(7n) {
            border-right: none;
        }

        .db-cal__cell:hover {
            background: var(--paper-2);
        }

        .db-cal__cell__day {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--ink-3);
            margin-bottom: 0.15rem;
        }

        .db-cal__cell__ev {
            display: block;
            font-size: 0.52rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--white);
            background: var(--red);
            padding: 0.1rem 0.25rem;
            margin-bottom: 0.12rem;
            cursor: pointer;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: background 0.12s;
        }

        .db-cal__cell__ev:hover {
            background: var(--red-dark);
        }

        .db-cal__cell__ev--active {
            background: #1E6A3A;
        }

        .db-cal__cell__ev--done {
            background: var(--ink-3);
        }

        .db-cal__cell__more {
            font-size: 0.58rem;
            color: var(--red);
            font-weight: 700;
            cursor: pointer;
        }

        .db-cal__legend {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding: 0.6rem 0.85rem;
            border-top: 1px solid var(--rule);
            font-size: 0.62rem;
            color: var(--ink-3);
        }

        .db-cal__legend-dot {
            width: 7px;
            height: 7px;
            flex-shrink: 0;
        }

        /* Agenda (mobile) */
        .db-agenda-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.7rem 0;
            border-bottom: 1px solid var(--rule);
            align-items: flex-start;
        }

        .db-agenda-item:first-child {
            border-top: 1px solid var(--rule);
        }

        .db-agenda-item__dow {
            flex-shrink: 0;
            width: 40px;
            font-family: 'Barlow Condensed', sans-serif;
            text-align: center;
        }

        .db-agenda-item__dow__label {
            font-size: 0.58rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--red);
        }

        .db-agenda-item__dow__num {
            font-size: 1.3rem;
            font-weight: 900;
            font-style: italic;
            color: var(--ink);
            line-height: 1;
        }

        .db-agenda-item__chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem;
            flex: 1;
            padding-top: 0.2rem;
        }

        /* ── Login footer (dark panel) ── */
        .db-footer-band {
            background: var(--ink);
            color: var(--white);
            margin-top: 4rem;
            position: relative;
            overflow: hidden;
        }

        .db-footer-band::before {
            content: 'LOGIN';
            position: absolute;
            left: -0.02em;
            bottom: -0.1em;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-style: italic;
            font-size: clamp(5rem, 14vw, 11rem);
            color: rgba(255, 255, 255, 0.03);
            line-height: 1;
            pointer-events: none;
        }

        .db-footer-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            padding: 3.5rem 0;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 700px) {
            .db-footer-inner {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }

        .db-footer-left__eyebrow {
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--red);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 0.75rem;
        }

        .db-footer-left__eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--red);
        }

        .db-footer-left__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            line-height: 0.95;
            color: var(--white);
            margin-bottom: 1rem;
        }

        .db-footer-left__sub {
            font-family: 'Barlow', sans-serif;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.45);
            font-weight: 300;
            line-height: 1.65;
        }

        /* Login form inside dark band */
        .db-login {
            background: var(--white);
            color: var(--ink);
            padding: 2rem;
            border-top: 3px solid var(--red);
        }

        .db-login__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.5rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 0.2rem;
        }

        .db-login__sub {
            font-size: 0.78rem;
            color: var(--ink-3);
            margin-bottom: 1.25rem;
            font-weight: 300;
        }

        .db-input-label {
            display: block;
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.12em;
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

        .db-login__actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1.25rem;
        }

        .db-login__link {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.7rem;
            color: var(--ink-3);
            text-decoration: none;
            border-bottom: 1px solid var(--rule);
            padding-bottom: 1px;
            letter-spacing: 0.03em;
            transition: color 0.15s;
        }

        .db-login__link:hover {
            color: var(--ink);
        }

        .db-btn-submit {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--ink);
            color: var(--white);
            border: 1px solid var(--ink);
            padding: 0.55rem 1.5rem;
            cursor: pointer;
            border-radius: 0;
            transition: background 0.15s;
        }

        .db-btn-submit:hover {
            background: var(--ink-2);
            border-color: var(--ink-2);
        }

        .db-btn-guest {
            display: block;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: none;
            color: var(--ink-3);
            border: 1px solid var(--rule);
            padding: 0.5rem;
            cursor: pointer;
            border-radius: 0;
            margin-top: 0.75rem;
            text-align: center;
            transition: all 0.15s;
        }

        .db-btn-guest:hover {
            background: var(--paper-2);
            color: var(--ink);
            border-color: var(--ink-4);
        }

        .db-error-box {
            background: var(--red-tint);
            color: var(--red-dark);
            border-left: 3px solid var(--red);
            padding: 0.55rem 0.75rem;
            font-size: 0.78rem;
            margin-bottom: 1rem;
        }

        .db-success-box {
            background: #EAF4EE;
            color: #1E6A3A;
            border-left: 3px solid #1E6A3A;
            padding: 0.55rem 0.75rem;
            font-size: 0.78rem;
            margin-bottom: 1rem;
        }

        /* footer bar */
        .db-footer-bar {
            padding: 1.25rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            text-align: center;
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.25);
            letter-spacing: 0.05em;
        }

        /* ── Modal ── */
        /*
         * Modals sit OUTSIDE .db — CSS vars from .db do NOT apply here.
         * All colors are hard-coded hex so the white card always renders.
         */
        .db-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 10, 10, 0.65);
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
            /* hard-coded — NOT var(--white) */
            max-width: 440px;
            width: calc(100% - 2rem);
            margin: 1rem;
            padding: 1.75rem;
            border-top: 4px solid #C5231B;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.4), 0 8px 24px rgba(0, 0, 0, 0.2);
            animation: dbModalIn 0.22s cubic-bezier(.16, 1, .3, 1) both;
            position: relative;
        }

        @keyframes dbModalIn {
            from {
                opacity: 0;
                transform: translateY(14px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .db-modal__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: #0A0A0A;
            margin-bottom: 1rem;
        }

        .db-modal__list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            max-height: 320px;
            overflow-y: auto;
        }

        .db-modal__item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.55rem 0.75rem;
            border: 1px solid #D5D1C9;
            cursor: pointer;
            transition: background 0.12s;
            gap: 0.75rem;
            font-size: 0.85rem;
            color: #0A0A0A;
        }

        .db-modal__item:hover {
            background: #EDEAE3;
        }

        .db-modal__close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            color: #6B6864;
            line-height: 1;
            transition: color 0.15s;
        }

        .db-modal__close:hover {
            color: #0A0A0A;
        }

        /* ── Reveal ── */
        .db-reveal {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.45s ease, transform 0.45s ease;
        }

        .db-reveal.in {
            opacity: 1;
            transform: none;
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

        {{-- ── Masthead ── --}}
        <div class="db-header db-reveal" data-stagger="0">
            <div class="db-header__inner">
                <div>
                    <div class="db-header__eyebrow">VolleyLV</div>
                    <h1 class="db-header__title">Sākumlapa</h1>
                </div>
                @if ($tournaments->count())
                    <div
                        style="font-family:'Barlow Condensed',sans-serif;font-size:0.75rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.35);border:1px solid rgba(255,255,255,0.12);padding:0.35rem 0.9rem;align-self:flex-end;margin-bottom:0.5rem;white-space:nowrap;">
                        {{ $tournaments->count() }} turnīri
                    </div>
                @endif
            </div>
        </div>
        <div class="db-bar"></div>

        <div class="db-wrap">

            {{-- Flash --}}
            @if (session('success'))
                <div class="db-flash db-reveal" data-stagger="1">{{ session('success') }}</div>
            @endif

            @if ($news->isNotEmpty())

                {{-- ── Featured hero ── --}}
                <div class="db-reveal" data-stagger="1">
                    <div class="db-section-head" style="margin-bottom:0.75rem;">
                        <span class="db-section-title">Galvenā Ziņa</span>
                        <a href="{{ route('news.index') }}" class="db-section-link">Visas ziņas →</a>
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
                                <p class="db-hero__excerpt">{{ Str::limit(strip_tags($featured->content), 220) }}</p>
                            </div>
                            <a href="{{ route('news.show', $featured) }}" class="db-hero__cta">Lasīt vairāk</a>
                        </div>
                    </article>
                </div>

                {{-- ── 2-col layout ── --}}
                <div class="db-layout db-reveal" data-stagger="2">

                    {{-- Left: tournaments + calendar --}}
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
                                        $pct = $t->max_teams
                                            ? min(100, round(($appsCount / max(1, (int) $t->max_teams)) * 100))
                                            : null;
                                        $barCls =
                                            $pct >= 100
                                                ? 'db-tourn__bar__fill--full'
                                                : ($pct >= 80
                                                    ? 'db-tourn__bar__fill--warn'
                                                    : '');
                                        $status = $t->status;
                                        $statusCls = match ($status) {
                                            'active' => 'db-pill--active',
                                            'completed' => 'db-pill--done',
                                            default => 'db-pill--pending',
                                        };
                                        $statusLbl = match ($status) {
                                            'active' => 'Aktīvs',
                                            'completed' => 'Pabeigts',
                                            default => 'Gaida',
                                        };
                                        $genderCls = match ($gender) {
                                            'men' => 'db-pill--men',
                                            'women' => 'db-pill--women',
                                            'mix' => 'db-pill--mix',
                                            default => 'db-pill--other',
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
                                                <span class="db-pill {{ $genderCls }}">{{ $genderLbl }}</span>
                                                <span class="db-pill {{ $statusCls }}">{{ $statusLbl }}</span>
                                                @if ($isFull)
                                                    <span class="db-pill db-pill--full">Pilns</span>
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
                                        <a href="{{ route('tournaments.show', $t) }}" class="db-tourn__cta">Skatīt
                                            →</a>
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
                                <div id="calendarGrid" class="db-cal__grid"></div>
                                <div id="mobileAgenda" style="padding:1rem;display:none;"></div>
                                <div class="db-cal__legend">
                                    <span style="display:flex;align-items:center;gap:4px;">
                                        <span class="db-cal__legend-dot" style="background:var(--red)"></span>Gaida
                                    </span>
                                    <span style="display:flex;align-items:center;gap:4px;">
                                        <span class="db-cal__legend-dot" style="background:#1E6A3A"></span>Aktīvs
                                    </span>
                                    <span style="display:flex;align-items:center;gap:4px;">
                                        <span class="db-cal__legend-dot" style="background:var(--ink-3)"></span>Pabeigts
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: news sidebar --}}
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
            @endif
        </div>

        {{-- ── Dark login footer band ── --}}
        @guest
            <div class="db-footer-band" style="margin-top:3rem;">
                <div class="db-wrap">
                    <div class="db-footer-inner">
                        <div>
                            <div class="db-footer-left__eyebrow">VolleyLV</div>
                            <div class="db-footer-left__title">Laipni<br>lūdzam<br>atpakaļ</div>
                            <p class="db-footer-left__sub">Ienāc, lai sekotu turnīriem, pārvaldītu komandas un lasītu
                                jaunākās ziņas.</p>
                        </div>
                        <div>
                            <div class="db-login">
                                <div class="db-login__title">Ienākt</div>
                                <div class="db-login__sub">Ievadi savus pieejas datus.</div>

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
                                    <div class="db-login__actions">
                                        <a href="{{ route('register') }}" class="db-login__link">Nav konta?
                                            Reģistrēties</a>
                                        <button type="submit" class="db-btn-submit">Ienākt →</button>
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
                </div>
                <div class="db-wrap">
                    <div class="db-footer-bar">&copy; {{ now()->year }} VolleyLV — Visas tiesības aizsargātas</div>
                </div>
            </div>
        @else
            <div class="db-wrap">
                <div class="db-footer-bar" style="margin-top:2rem;border-top:1px solid var(--rule);color:var(--ink-4);">
                    &copy; {{ now()->year }} VolleyLV
                </div>
            </div>
        @endguest

    </div>

    {{-- Modal --}}
    <div id="modalOverlay" class="db-modal-overlay">
        <div class="db-modal">
            <button id="closeModal" class="db-modal__close" aria-label="Aizvērt">✕</button>
            <h3 id="modalDate" class="db-modal__title"></h3>
            <ul id="modalTournaments" class="db-modal__list"></ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.db-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 60 + i * 90);
            });
        });

        const tournamentsData = @json($calendarEvents);
        let currentDate = new Date();

        const monthNames = ["Janvāris", "Februāris", "Marts", "Aprīlis", "Maijs", "Jūnijs",
            "Jūlijs", "Augusts", "Septembris", "Oktobris", "Novembris", "Decembris"
        ];

        const parseYMD = ymd => {
            const [y, m, d] = ymd.split('-').map(Number);
            return new Date(y, m - 1, d);
        };
        const evCls = s => s === 'active' ? 'db-cal__cell__ev--active' : (s === 'completed' ? 'db-cal__cell__ev--done' :
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
                        span.className = `db-cal__cell__ev ${evCls(ev.status)}`;
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
                    c.className = `db-cal__cell__ev ${evCls(ev.status)}`;
                    c.style.cssText =
                        'display:inline-block;max-width:200px;font-size:0.62rem;padding:0.2rem 0.4rem;cursor:pointer;';
                    c.textContent = ev.title;
                    c.onclick = () => ev.url && (window.location.href = ev.url);
                    chips.appendChild(c);
                });
                row.append(left, chips);
                agenda.appendChild(row);
            }
            if (!any) agenda.innerHTML =
                '<div style="text-align:center;font-size:0.8rem;color:var(--ink-4);padding:1rem 0;">Šajā mēnesī nav turnīru.</div>';
        }

        function openModal(dateObj, items) {
            document.getElementById('modalDate').textContent =
                `${String(dateObj.getDate()).padStart(2,'0')}.${String(dateObj.getMonth()+1).padStart(2,'0')}.${dateObj.getFullYear()}`;
            const list = document.getElementById('modalTournaments');
            list.innerHTML = '';
            items.forEach(ev => {
                const li = document.createElement('li');
                li.className = 'db-modal__item';
                li.innerHTML =
                    `<span>${ev.title}</span>${ev.is_full ? '<span class="db-pill db-pill--full">Pilns</span>' : ''}`;
                li.onclick = () => ev.url && (window.location.href = ev.url);
                list.appendChild(li);
            });
            document.getElementById('modalOverlay').classList.add('open');
        }

        function renderAll() {
            renderCalendar(currentDate);
        }

        document.getElementById('prevMonth')?.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderAll();
        });
        document.getElementById('nextMonth')?.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderAll();
        });
        document.getElementById('closeModal')?.addEventListener('click', () => {
            document.getElementById('modalOverlay').classList.remove('open');
        });

        renderAll();

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
