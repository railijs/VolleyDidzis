{{-- resources/views/tournaments/statistics.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,600;0,700;0,900;1,700;1,900&family=Barlow:wght@300;400;500&family=DM+Sans:wght@400;500&display=swap');

        .ts2 * {
            box-sizing: border-box;
        }

        .ts2 {
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
            --gold: #B8860B;
            --gold-tint: #FBF5E6;
            --gold-rule: #E8D08A;
            --silver: #708090;
            --silver-tint: #F0F3F5;
            --bronze: #8B5E3C;
            --bronze-tint: #F7F1EB;
            --green: #1E6A3A;
            --green-tint: #EAF4EE;

            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 6rem;
        }

        /* ── Header ── */
        .ts2-header {
            background: var(--ink);
            padding: clamp(3.5rem, 8vh, 5.5rem) 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .ts2-header__bg-word {
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
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            max-width: 100%;
        }

        .ts2-header__inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem 2rem;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .ts2-header__eyebrow {
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

        .ts2-header__eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--red);
        }

        .ts2-header__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(2rem, 5.5vw, 4rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            color: var(--white);
            line-height: 0.95;
            margin: 0 0 0.75rem;
        }

        .ts2-header__pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
        }

        .ts2-header__pill {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.2rem 0.65rem;
            border: 1px solid;
            color: rgba(255, 255, 255, .5);
            border-color: rgba(255, 255, 255, .15);
            background: rgba(255, 255, 255, .05);
        }

        .ts2-header__actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-self: flex-end;
            margin-bottom: 0.5rem;
        }

        .ts2-btn-ghost {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: rgba(255, 255, 255, .08);
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, .2);
            padding: 0.45rem 1.1rem;
            text-decoration: none;
            transition: background .15s, border-color .15s;
            display: inline-flex;
            align-items: center;
        }

        .ts2-btn-ghost:hover {
            background: rgba(255, 255, 255, .15);
            border-color: rgba(255, 255, 255, .4);
        }

        .ts2-bar {
            height: 3px;
            background: var(--red);
        }

        /* ── Wrap ── */
        .ts2-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ── Section heading ── */
        .ts2-section-head {
            margin: 2rem 0 1rem;
        }

        .ts2-eyebrow {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .ts2-eyebrow::before {
            content: '';
            display: block;
            width: 14px;
            height: 2px;
            background: var(--red);
        }

        .ts2-section-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1.3rem, 2.5vw, 1.8rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            letter-spacing: -0.01em;
        }

        /* ── Winner banner ── */
        .ts2-winner {
            background: var(--gold-tint);
            border: 1px solid var(--gold-rule);
            border-top: 3px solid var(--gold);
            padding: 1.5rem 1.5rem;
            margin: 2rem 0 0;
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .ts2-winner__trophy {
            font-size: 2rem;
            line-height: 1;
            flex-shrink: 0;
            margin-top: .1rem;
        }

        .ts2-winner__body {
            flex: 1;
            min-width: 0;
        }

        .ts2-winner__label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.3rem;
        }

        .ts2-winner__name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            line-height: 1;
            color: var(--gold);
            margin-bottom: 0.75rem;
        }

        .ts2-winner__chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
        }

        .ts2-winner__chip {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 500;
            padding: 0.25rem 0.65rem;
            border: 1px solid var(--gold-rule);
            color: var(--gold);
            background: rgba(184, 134, 11, .08);
        }

        .ts2-winner__actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-self: center;
        }

        .ts2-btn-gold {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--gold);
            color: var(--white);
            border: 1px solid var(--gold);
            padding: 0.5rem 1.25rem;
            text-decoration: none;
            transition: background .15s;
            display: inline-flex;
            align-items: center;
        }

        .ts2-btn-gold:hover {
            background: #9A700A;
            border-color: #9A700A;
        }

        .ts2-btn-outline-gold {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: none;
            color: var(--gold);
            border: 1px solid var(--gold-rule);
            padding: 0.5rem 1.25rem;
            text-decoration: none;
            transition: background .15s;
            display: inline-flex;
            align-items: center;
        }

        .ts2-btn-outline-gold:hover {
            background: rgba(184, 134, 11, .1);
        }

        /* Final match inside winner banner */
        .ts2-final {
            border: 1px solid var(--gold-rule);
            background: var(--white);
            margin-top: 1.25rem;
            width: 100%;
        }

        .ts2-final__teams {
            display: grid;
            grid-template-columns: 1fr auto;
            padding: 1rem 1.25rem;
            gap: 1rem;
            align-items: center;
        }

        .ts2-final__a {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--ink);
        }

        .ts2-final__b {
            font-size: 0.8rem;
            color: var(--ink-3);
            margin-top: 0.1rem;
        }

        .ts2-final__score {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            font-style: italic;
            color: var(--gold);
            text-align: right;
            line-height: 1;
        }

        .ts2-final__score span {
            font-size: 0.8rem;
            font-weight: 400;
            font-style: normal;
            color: var(--ink-3);
            display: block;
        }

        .ts2-final__foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 1.25rem;
            border-top: 1px solid var(--gold-rule);
            background: rgba(184, 134, 11, .06);
        }

        .ts2-final__round {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--gold);
        }

        .ts2-win-badge {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            background: var(--green);
            color: var(--white);
            padding: 0.15rem 0.55rem;
        }

        /* ── Stats grid ── */
        .ts2-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
            border: 1px solid var(--rule);
            background: var(--white);
            margin-top: 2rem;
        }

        @media (max-width: 720px) {
            .ts2-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 400px) {
            .ts2-stats {
                grid-template-columns: 1fr;
            }
        }

        .ts2-stat {
            padding: 1.25rem 1.25rem;
            border-right: 1px solid var(--rule);
            position: relative;
        }

        .ts2-stat:last-child {
            border-right: none;
        }

        @media (max-width: 720px) {
            .ts2-stat:nth-child(2n) {
                border-right: none;
            }

            .ts2-stat:nth-child(-n+2) {
                border-bottom: 1px solid var(--rule);
            }
        }

        @media (max-width: 400px) {
            .ts2-stat {
                border-right: none;
                border-bottom: 1px solid var(--rule);
            }

            .ts2-stat:last-child {
                border-bottom: none;
            }
        }

        .ts2-stat__label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-4);
            margin-bottom: 0.35rem;
        }

        .ts2-stat__value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 900;
            font-style: italic;
            color: var(--ink);
            line-height: 1;
        }

        .ts2-stat__sub {
            font-size: 0.68rem;
            color: var(--ink-3);
            margin-top: 0.25rem;
        }

        .ts2-stat__accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--red);
        }

        /* ── Podium ── */
        .ts2-podium {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            border: 1px solid var(--rule);
        }

        @media (max-width: 640px) {
            .ts2-podium {
                grid-template-columns: 1fr;
            }
        }

        .ts2-podium-card {
            padding: 1.5rem 1.25rem;
            border-right: 1px solid var(--rule);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .ts2-podium-card:last-child {
            border-right: none;
        }

        @media (max-width: 640px) {
            .ts2-podium-card {
                border-right: none;
                border-bottom: 1px solid var(--rule);
            }

            .ts2-podium-card:last-child {
                border-bottom: none;
            }
        }

        .ts2-podium-card--gold {
            background: var(--gold-tint);
            border-top: 3px solid var(--gold);
        }

        .ts2-podium-card--silver {
            background: var(--silver-tint);
            border-top: 3px solid var(--silver);
        }

        .ts2-podium-card--bronze {
            background: var(--bronze-tint);
            border-top: 3px solid var(--bronze);
        }

        .ts2-podium__rank {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .ts2-podium-card--gold .ts2-podium__rank {
            color: var(--gold);
        }

        .ts2-podium-card--silver .ts2-podium__rank {
            color: var(--silver);
        }

        .ts2-podium-card--bronze .ts2-podium__rank {
            color: var(--bronze);
        }

        .ts2-podium__team {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1.1rem, 2.5vw, 1.6rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            line-height: 1.05;
            color: var(--ink);
            margin-bottom: 0.75rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ts2-podium__wins {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2.8rem;
            font-weight: 900;
            font-style: italic;
            line-height: 1;
            margin-bottom: 0.2rem;
        }

        .ts2-podium-card--gold .ts2-podium__wins {
            color: var(--gold);
        }

        .ts2-podium-card--silver .ts2-podium__wins {
            color: var(--silver);
        }

        .ts2-podium-card--bronze .ts2-podium__wins {
            color: var(--bronze);
        }

        .ts2-podium__wins-label {
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-4);
            margin-bottom: 1rem;
        }

        .ts2-podium__bar {
            height: 2px;
            background: rgba(0, 0, 0, .08);
            margin-top: auto;
        }

        .ts2-podium-card--gold .ts2-podium__bar-fill {
            background: var(--gold);
        }

        .ts2-podium-card--silver .ts2-podium__bar-fill {
            background: var(--silver);
        }

        .ts2-podium-card--bronze .ts2-podium__bar-fill {
            background: var(--bronze);
        }

        .ts2-podium__bar-fill {
            height: 2px;
        }

        /* ── Records ── */
        .ts2-records {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border: 1px solid var(--rule);
            background: var(--white);
        }

        @media (max-width: 640px) {
            .ts2-records {
                grid-template-columns: 1fr;
            }
        }

        .ts2-record {
            padding: 1.5rem 1.25rem;
            border-right: 1px solid var(--rule);
        }

        .ts2-record:last-child {
            border-right: none;
        }

        @media (max-width: 640px) {
            .ts2-record {
                border-right: none;
                border-bottom: 1px solid var(--rule);
            }

            .ts2-record:last-child {
                border-bottom: none;
            }
        }

        .ts2-record__label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .ts2-record__label::before {
            content: '';
            width: 12px;
            height: 1.5px;
            background: var(--red);
        }

        .ts2-record__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.05rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 0.75rem;
        }

        .ts2-record__match {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--ink);
            line-height: 1.3;
        }

        .ts2-record__meta {
            font-size: 0.72rem;
            color: var(--ink-3);
            margin-top: 0.4rem;
        }

        .ts2-record__empty {
            font-size: 0.82rem;
            color: var(--ink-4);
            font-style: italic;
        }

        /* ── Wins table ── */
        .ts2-table-wrap {
            border: 1px solid var(--rule);
            background: var(--white);
            overflow: hidden;
        }

        .ts2-table-head {
            padding: 0.65rem 1rem;
            border-bottom: 1px solid var(--rule);
            background: var(--paper-2);
        }

        .ts2-table-head__label {
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--red);
        }

        .ts2-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ts2-table thead tr {
            background: var(--ink);
        }

        .ts2-table thead th {
            padding: 0.6rem 1rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .45);
            text-align: left;
            white-space: nowrap;
        }

        .ts2-table thead th:last-child {
            text-align: right;
            color: rgba(255, 255, 255, .7);
        }

        .ts2-table thead th:first-child {
            color: rgba(255, 255, 255, .3);
            width: 3rem;
        }

        .ts2-table tbody tr {
            border-bottom: 1px solid var(--rule);
            transition: background .1s;
        }

        .ts2-table tbody tr:last-child {
            border-bottom: none;
        }

        .ts2-table tbody tr:hover {
            background: var(--paper);
        }

        .ts2-table tbody tr:nth-child(even) {
            background: #FAFAF8;
        }

        .ts2-table tbody tr:nth-child(even):hover {
            background: var(--paper);
        }

        .ts2-table td {
            padding: 0.75rem 1rem;
            font-size: 0.82rem;
            color: var(--ink-2);
            vertical-align: middle;
        }

        .ts2-table td:first-child {
            text-align: right;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            font-style: italic;
            color: var(--ink-4);
            width: 3rem;
        }

        .ts2-table td:nth-child(2) {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--ink);
        }

        .ts2-table td:last-child {
            text-align: right;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 900;
            font-style: italic;
            color: var(--red);
        }

        .ts2-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: var(--red-tint);
            color: var(--red);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.75rem;
            font-weight: 900;
            flex-shrink: 0;
            margin-right: 0.65rem;
            vertical-align: middle;
        }

        /* ── Timeline ── */
        .ts2-timeline {
            display: flex;
            flex-direction: column;
        }

        .ts2-timeline-item {
            display: flex;
            gap: 1.25rem;
            align-items: flex-start;
            padding: 1.1rem 0;
            border-bottom: 1px solid var(--rule);
            position: relative;
        }

        .ts2-timeline-item:first-child {
            border-top: 1px solid var(--rule);
        }

        .ts2-timeline-item__left {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 40px;
        }

        .ts2-timeline-item__round {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--red);
        }

        .ts2-timeline-item__num {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            font-weight: 900;
            font-style: italic;
            color: var(--ink);
            line-height: 1;
        }

        .ts2-timeline-item__body {
            flex: 1;
            min-width: 0;
            border: 1px solid var(--rule);
            background: var(--white);
            padding: 0.9rem 1.1rem;
            position: relative;
            overflow: hidden;
            transition: background .12s;
        }

        .ts2-timeline-item__body::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: var(--red);
            transition: width .2s;
        }

        .ts2-timeline-item__body:hover {
            background: var(--paper);
        }

        .ts2-timeline-item__body:hover::before {
            width: 3px;
        }

        .ts2-timeline-item__teams {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--ink);
            line-height: 1.2;
        }

        .ts2-timeline-item__score {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.88rem;
            color: var(--ink-3);
            margin-top: 0.25rem;
        }

        .ts2-timeline-item__right {
            flex-shrink: 0;
            align-self: center;
        }

        /* ── Reveal ── */
        .ts2-reveal {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .ts2-reveal.in {
            opacity: 1;
            transform: none;
        }
    </style>

    @php
        $winsFor = (int) ($champion->wins_for ?? 0);
        $winsAgainst = (int) ($champion->wins_against ?? 0);
        $pointDiff = (int) ($champion->points_diff ?? 0);
        $finalMatch =
            isset($championPath) && $championPath->isNotEmpty() ? $championPath->sortByDesc('round')->first() : null;
        $maxWins = max(1, (int) ($winsTable->max('wins') ?? 1));
        $podiumColors = ['gold', 'silver', 'bronze'];
        $podiumLabels = ['Čempions', '2. vieta', '3. vieta'];
        $medals = ['🏆', '🥈', '🥉'];
    @endphp

    <div class="ts2">

        {{-- ── Header ── --}}
        <div class="ts2-header ts2-reveal" data-stagger="0">
            <div class="ts2-header__bg-word">{{ Str::upper(Str::limit($tournament->name, 10, '')) }}</div>
            <div class="ts2-header__inner">
                <div>
                    <div class="ts2-header__eyebrow">VolleyLV · Turnīrs · Statistika</div>
                    <h1 class="ts2-header__title">{{ $tournament->name }}</h1>
                    <div class="ts2-header__pills">
                        <span class="ts2-header__pill">Statistika</span>
                        <span class="ts2-header__pill">{{ $tournament->applications()->count() }} dalībnieki</span>
                        <span class="ts2-header__pill">{{ $totalMatches }} spēles</span>
                    </div>
                </div>
                <div class="ts2-header__actions">
                    <a href="{{ route('tournaments.show', $tournament) }}" class="ts2-btn-ghost">← Pārskats</a>
                    <a href="{{ route('tournaments.stats', $tournament) }}" class="ts2-btn-ghost">Brakets →</a>
                </div>
            </div>
        </div>
        <div class="ts2-bar"></div>

        <div class="ts2-wrap">

            {{-- ── Winner banner ── --}}
            @if ($champion)
                <div class="ts2-winner ts2-reveal" data-stagger="1">
                    <div class="ts2-winner__trophy">🏆</div>
                    <div class="ts2-winner__body">
                        <div class="ts2-winner__label">Turnīra uzvarētājs</div>
                        <div class="ts2-winner__name">{{ $champion->team_name }}</div>
                        <div class="ts2-winner__chips">
                            @if ($winsFor || $winsAgainst)
                                <span class="ts2-winner__chip">{{ $winsFor }}–{{ $winsAgainst }}</span>
                            @endif
                            <span class="ts2-winner__chip">
                                Diff: {{ $pointDiff >= 0 ? '+' : '' }}{{ $pointDiff }}
                            </span>
                            <span class="ts2-winner__chip">{{ $totalMatches }} spēles</span>
                        </div>

                        @if ($finalMatch)
                            <div class="ts2-final">
                                <div class="ts2-final__teams">
                                    <div>
                                        <div class="ts2-final__a">{{ $finalMatch->participantA?->team_name ?? '—' }}
                                        </div>
                                        <div class="ts2-final__b">pret
                                            {{ $finalMatch->participantB?->team_name ?? '—' }}</div>
                                    </div>
                                    <div class="ts2-final__score">
                                        {{ $finalMatch->score_a ?? '–' }}:{{ $finalMatch->score_b ?? '–' }}
                                        <span>Rezultāts</span>
                                    </div>
                                </div>
                                <div class="ts2-final__foot">
                                    <span class="ts2-final__round">Fināls · Round {{ $finalMatch->round }}</span>
                                    <span class="ts2-win-badge">Uzvara</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="ts2-winner__actions">
                        <a href="{{ route('tournaments.stats', $tournament) }}" class="ts2-btn-gold">Brakets →</a>
                        <a href="{{ route('tournaments.show', $tournament) }}" class="ts2-btn-outline-gold">←
                            Pārskats</a>
                    </div>
                </div>
            @endif

            {{-- ── Stats grid ── --}}
            <div class="ts2-reveal" data-stagger="2">
                <div class="ts2-section-head">
                    <div class="ts2-eyebrow">Kopsavilkums</div>
                    <div class="ts2-section-title">Turnīra skaitļi</div>
                </div>
                <div class="ts2-stats">
                    <div class="ts2-stat">
                        <div class="ts2-stat__accent"></div>
                        <div class="ts2-stat__label">Kopējās spēles</div>
                        <div class="ts2-stat__value">{{ $totalMatches }}</div>
                    </div>
                    <div class="ts2-stat">
                        <div class="ts2-stat__label">Noslēgtās</div>
                        <div class="ts2-stat__value">{{ $completedMatches }}</div>
                        <div class="ts2-stat__sub">{{ $completionPct }}% pabeigts</div>
                    </div>
                    <div class="ts2-stat">
                        <div class="ts2-stat__label">Koppunkti</div>
                        <div class="ts2-stat__value">{{ $totPoints }}</div>
                    </div>
                    <div class="ts2-stat">
                        <div class="ts2-stat__label">Vid. punkti/spēlē</div>
                        <div class="ts2-stat__value">{{ $avgPoints }}</div>
                    </div>
                </div>
            </div>

            {{-- ── Podium ── --}}
            @if ($topThree->isNotEmpty())
                <div class="ts2-reveal" data-stagger="3">
                    <div class="ts2-section-head">
                        <div class="ts2-eyebrow">Komandas</div>
                        <div class="ts2-section-title">Top 3 komandas</div>
                    </div>
                    <div class="ts2-podium">
                        @foreach ($topThree->take(3) as $idx => $r)
                            @php
                                $val = (int) ($r['wins'] ?? 0);
                                $pct = min(100, (int) round(($val / $maxWins) * 100));
                                $clr = $podiumColors[$idx] ?? 'bronze';
                            @endphp
                            <div class="ts2-podium-card ts2-podium-card--{{ $clr }}">
                                <div class="ts2-podium__rank">{{ $podiumLabels[$idx] }}</div>
                                <div class="ts2-podium__team" title="{{ $r['team'] ?? '—' }}">{{ $r['team'] ?? '—' }}
                                </div>
                                <div class="ts2-podium__wins">{{ $val }}</div>
                                <div class="ts2-podium__wins-label">Uzvaras</div>
                                <div class="ts2-podium__bar">
                                    <div class="ts2-podium__bar-fill" style="width:{{ $pct }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── Records ── --}}
            <div class="ts2-reveal" data-stagger="4">
                <div class="ts2-section-head">
                    <div class="ts2-eyebrow">Rekordi</div>
                    <div class="ts2-section-title">Spēļu rekordi</div>
                </div>
                <div class="ts2-records">
                    <div class="ts2-record">
                        <div class="ts2-record__label">Augstākā punktu summa</div>
                        <div class="ts2-record__title">Vislielākais kopvērtējums</div>
                        @if ($highestScoring)
                            @php $hs = (int)($highestScoring->score_a ?? 0) + (int)($highestScoring->score_b ?? 0); @endphp
                            <div class="ts2-record__match">
                                {{ $highestScoring->participantA?->team_name ?? '—' }}
                                {{ $highestScoring->score_a ?? '-' }}
                                :
                                {{ $highestScoring->score_b ?? '-' }}
                                {{ $highestScoring->participantB?->team_name ?? '—' }}
                            </div>
                            <div class="ts2-record__meta">Kopsumma: {{ $hs }} · Round
                                {{ $highestScoring->round }}</div>
                        @else
                            <div class="ts2-record__empty">Nav noslēgtu spēļu.</div>
                        @endif
                    </div>
                    <div class="ts2-record">
                        <div class="ts2-record__label">Lielākā uzvara</div>
                        <div class="ts2-record__title">Pēc punktu starpības</div>
                        @if ($biggestWin)
                            @php $diff = abs((int)($biggestWin->score_a ?? 0) - (int)($biggestWin->score_b ?? 0)); @endphp
                            <div class="ts2-record__match">
                                {{ $biggestWin->participantA?->team_name ?? '—' }}
                                {{ $biggestWin->score_a ?? '-' }}
                                :
                                {{ $biggestWin->score_b ?? '-' }}
                                {{ $biggestWin->participantB?->team_name ?? '—' }}
                            </div>
                            <div class="ts2-record__meta">Starpība: {{ $diff }} · Round
                                {{ $biggestWin->round }}</div>
                        @else
                            <div class="ts2-record__empty">Nav noslēgtu spēļu.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Wins table ── --}}
            @if ($winsTable->isNotEmpty())
                <div class="ts2-reveal" data-stagger="5">
                    <div class="ts2-section-head">
                        <div class="ts2-eyebrow">Rezultāti</div>
                        <div class="ts2-section-title">Komandu uzvaras</div>
                    </div>
                    <div class="ts2-table-wrap">
                        <div class="ts2-table-head">
                            <span class="ts2-table-head__label">Pilnais saraksts</span>
                        </div>
                        <div style="overflow-x:auto;">
                            <table class="ts2-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="text-align:left;">Komanda</th>
                                        <th>Uzvaras</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($winsTable as $i => $row)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                <span
                                                    class="ts2-avatar">{{ Str::upper(Str::substr($row['team'], 0, 1)) }}</span>{{ $row['team'] }}
                                            </td>
                                            <td>{{ $row['wins'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ── Champion path ── --}}
            @if ($champion && isset($championPath) && $championPath->isNotEmpty())
                <div class="ts2-reveal" data-stagger="6">
                    <div class="ts2-section-head">
                        <div class="ts2-eyebrow">Ceļš</div>
                        <div class="ts2-section-title">Ceļš līdz titulam — <span
                                style="color:var(--gold);">{{ $champion->team_name }}</span></div>
                    </div>
                    <div class="ts2-timeline">
                        @foreach ($championPath->sortBy('round') as $m)
                            <div class="ts2-timeline-item">
                                <div class="ts2-timeline-item__left">
                                    <div class="ts2-timeline-item__round">R</div>
                                    <div class="ts2-timeline-item__num">{{ $m->round }}</div>
                                </div>
                                <div class="ts2-timeline-item__body">
                                    <div class="ts2-timeline-item__teams">
                                        {{ $m->participantA?->team_name ?? '—' }}
                                        <span style="color:var(--ink-3);font-weight:400;"> ({{ $m->score_a ?? '-' }})
                                            — </span>
                                        {{ $m->participantB?->team_name ?? '—' }}
                                        <span style="color:var(--ink-3);font-weight:400;">
                                            ({{ $m->score_b ?? '-' }})</span>
                                    </div>
                                </div>
                                <div class="ts2-timeline-item__right">
                                    <span class="ts2-win-badge">Uzvara</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.ts2-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 60 + i * 90);
            });
        });
    </script>
</x-app-layout>
