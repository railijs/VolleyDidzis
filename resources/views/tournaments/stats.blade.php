{{-- resources/views/tournaments/stats.blade.php --}}
<x-app-layout>
    @php
        $rounds = $matches->groupBy('round')->sortKeys();
        $finalRound = optional($rounds->keys())->max();
        $finalMatch = $matches->where('round', $finalRound)->first();
        $participants = $tournament->applications()->count();
        $matchCount = $matches->count();

        $aTeam = $finalMatch?->participantA?->team_name;
        $bTeam = $finalMatch?->participantB?->team_name;
        $aScr = $finalMatch?->score_a;
        $bScr = $finalMatch?->score_b;
        $finalDone = $finalMatch && $finalMatch->status === 'completed' && $finalMatch->winner_slot;
        $champion = $finalDone ? $finalMatch->winnerApplication()?->team_name : null;

        $isEditable = $tournament->status === 'active';
        $canManage = auth()->id() === $tournament->creator_id || auth()->user()?->isAdmin();

        function roundTitle(int $r, int $finalRound): string
        {
            if ($r === 0) {
                return 'Play-In';
            }
            if ($r === $finalRound) {
                return 'Final';
            }
            $dist = $finalRound - $r;
            return match ($dist) {
                1 => 'Semi-Final',
                2 => 'Quarter-Final',
                default => "Round {$r}",
            };
        }
        function statusMeta(string $status): array
        {
            return [
                'pending' => ['Gaida', 'st-badge--pending'],
                'in_progress' => ['Notiek', 'st-badge--live'],
                'completed' => ['Pabeigts', 'st-badge--done'],
            ][$status] ?? ['—', 'st-badge--pending'];
        }
    @endphp

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,600;0,700;0,900;1,700;1,900&family=Barlow:wght@300;400;500&family=DM+Sans:ital,wght@0,400;0,500;1,400&display=swap');

        /* ── Design tokens ── */
        .st * {
            box-sizing: border-box;
        }

        .st {
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
            --green: #1E6A3A;
            --green-tint: #EAF4EE;
            --blue: #1A4A8A;

            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 6rem;
        }

        /* ── Masthead ── */
        .st-header {
            background: var(--ink);
            padding: clamp(3.5rem, 8vh, 5.5rem) 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .st-header__bg {
            position: absolute;
            right: -0.02em;
            bottom: -0.1em;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-style: italic;
            font-size: clamp(5rem, 13vw, 10rem);
            color: rgba(255, 255, 255, 0.04);
            line-height: 1;
            pointer-events: none;
            letter-spacing: -0.03em;
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.05);
            text-transform: uppercase;
            white-space: nowrap;
        }

        .st-header__inner {
            max-width: 1200px;
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

        .st-header__eyebrow {
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

        .st-header__eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--red);
        }

        .st-header__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(2.2rem, 5.5vw, 4rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            color: var(--white);
            line-height: 0.95;
            margin: 0 0 1rem;
        }

        .st-header__stats {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-bottom: 0.5rem;
        }

        .st-stat-chip {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.68rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.25rem 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.07);
            color: rgba(255, 255, 255, 0.6);
            white-space: nowrap;
        }

        .st-stat-chip--red {
            border-color: rgba(197, 35, 27, 0.4);
            color: #FF8A84;
            background: rgba(197, 35, 27, 0.1);
        }

        .st-header__actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .st-btn-ghost {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.07);
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.45rem 1.1rem;
            cursor: pointer;
            border-radius: 0;
            text-decoration: none;
            transition: background 0.15s, border-color 0.15s;
            display: inline-flex;
            align-items: center;
        }

        .st-btn-ghost:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.35);
        }

        .st-btn-ghost--green {
            color: #5DBF85;
            border-color: rgba(93, 191, 133, 0.35);
        }

        .st-btn-ghost--green:hover {
            background: rgba(93, 191, 133, 0.1);
        }

        .st-btn-ghost--danger {
            color: #FF7A72;
            border-color: rgba(255, 122, 114, 0.3);
        }

        .st-btn-ghost--danger:hover {
            background: rgba(255, 122, 114, 0.1);
        }

        .st-bar {
            height: 3px;
            background: var(--red);
        }

        /* ── Wrap ── */
        .st-wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ── Alert ── */
        .st-alert {
            padding: 0.7rem 0.9rem;
            font-size: 0.82rem;
            font-weight: 500;
            border-left: 3px solid;
            margin: 1.5rem 0;
        }

        .st-alert--error {
            background: var(--red-tint);
            color: var(--red-dark);
            border-color: var(--red);
        }

        .st-alert--note {
            background: #FEF8EC;
            color: #7A5A10;
            border-color: #D4A82A;
        }

        .st-alert ul {
            list-style: none;
        }

        .st-alert li::before {
            content: '— ';
        }

        /* ── Winner banner ── */
        .st-champion {
            border: 1px solid var(--gold-rule);
            border-top: 3px solid var(--gold);
            background: var(--gold-tint);
            padding: 1.25rem 1.5rem;
            margin: 2rem 0;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .st-champion__icon {
            font-size: 2rem;
            line-height: 1;
            flex-shrink: 0;
        }

        .st-champion__label {
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.2rem;
        }

        .st-champion__name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--gold);
            line-height: 1;
        }

        .st-champion__score {
            margin-left: auto;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gold);
            opacity: 0.7;
        }

        /* ── Final (pending) banner ── */
        .st-final-pending {
            border: 1px solid var(--rule);
            background: var(--white);
            border-top: 3px solid var(--ink);
            margin: 2rem 0;
        }

        .st-final-pending__head {
            background: var(--ink);
            padding: 0.6rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .st-final-pending__label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.9rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--white);
            letter-spacing: 0.04em;
        }

        .st-final-pending__status {
            font-size: 0.62rem;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .st-final-pending__body {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
        }

        .st-final-team-a {
            text-align: right;
        }

        .st-final-team-b {
            text-align: left;
        }

        .st-final-team__name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            line-height: 1;
        }

        .st-final-team__score {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink-3);
            margin-top: 0.2rem;
        }

        .st-final-vs {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.7rem;
            font-weight: 900;
            letter-spacing: 0.15em;
            color: var(--ink-4);
            text-transform: uppercase;
            text-align: center;
        }

        /* ── Bracket canvas ── */
        .st-bracket-outer {
            position: relative;
            margin: 2rem 0;
            background:
                radial-gradient(circle at 1px 1px, rgba(0, 0, 0, 0.035) 1px, transparent 0) var(--paper);
            background-size: 20px 20px;
            border: 1px solid var(--rule);
            overflow: hidden;
        }

        .st-bracket-scroll {
            overflow-x: auto;
            overflow-y: visible;
            padding: 2rem 2.5rem 2.5rem;
            /* nice scrollbar */
        }

        .st-bracket-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .st-bracket-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .st-bracket-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
        }

        .st-bracket-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.25);
        }

        /* Fade edges */
        .st-bracket-outer::before,
        .st-bracket-outer::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 32px;
            pointer-events: none;
            z-index: 5;
        }

        .st-bracket-outer::before {
            left: 0;
            background: linear-gradient(to right, var(--paper), transparent);
        }

        .st-bracket-outer::after {
            right: 0;
            background: linear-gradient(to left, var(--paper), transparent);
        }

        .st-bracket-grid {
            display: grid;
            grid-auto-flow: column;
            grid-auto-columns: 260px;
            gap: 0;
            width: fit-content;
            min-width: 100%;
            align-items: stretch;
        }

        /* ── Round column ── */
        .st-round {
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* Vertical connector line between columns */
        .st-round:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            width: 1px;
            background: repeating-linear-gradient(to bottom,
                    var(--rule) 0px,
                    var(--rule) 10px,
                    transparent 10px,
                    transparent 18px);
            opacity: 0.7;
        }

        .st-round__head {
            padding: 0.75rem 1rem 0.6rem;
            border-bottom: 1px solid var(--rule);
            background: var(--white);
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            border-right: 1px solid var(--rule);
        }

        .st-round:last-child .st-round__head {
            border-right: none;
        }

        .st-round__dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .st-round__dot--final {
            background: var(--gold);
        }

        .st-round__dot--semi {
            background: var(--red);
        }

        .st-round__dot--playin {
            background: var(--ink-3);
        }

        .st-round__dot--normal {
            background: var(--ink-4);
        }

        .st-round__name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.85rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            letter-spacing: 0.03em;
        }

        .st-round__count {
            margin-left: auto;
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-4);
        }

        /* ── Match cards container inside column ── */
        .st-round__matches {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            padding: 1rem 0;
            gap: 0.75rem;
            border-right: 1px solid var(--rule);
        }

        .st-round:last-child .st-round__matches {
            border-right: none;
        }

        /* ── Match card ── */
        .st-match {
            margin: 0 1rem;
            background: var(--white);
            border: 1px solid var(--rule);
            position: relative;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
            /* left accent reacts to status */
        }

        .st-match::before {
            content: '';
            position: absolute;
            inset: 0 auto 0 0;
            width: 3px;
            background: var(--accent, var(--rule));
            transition: background 0.2s;
        }

        .st-match[data-status="pending"] {
            --accent: var(--ink-4);
        }

        .st-match[data-status="in_progress"] {
            --accent: var(--blue);
        }

        .st-match[data-status="completed"] {
            --accent: var(--green);
        }

        /* Connector stubs — horizontal lines poking out of cards to meet the dashed column separator */
        .st-match::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -1rem;
            width: 1rem;
            height: 1px;
            background: var(--rule);
            transform: translateY(-50%);
        }

        .st-round:last-child .st-match::after {
            display: none;
        }

        .st-match:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px -6px rgba(0, 0, 0, 0.18);
            z-index: 2;
        }

        .st-match.is-highlighted {
            transform: translateY(-1px) scale(1.015);
            box-shadow: 0 0 0 2px var(--red), 0 8px 24px -8px rgba(197, 35, 27, 0.3);
            z-index: 3;
        }

        /* ── Match header ── */
        .st-match__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.35rem 0.6rem;
            border-bottom: 1px solid var(--rule);
            background: var(--paper-2);
        }

        .st-match__head-left {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .st-match__id {
            font-size: 0.55rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            color: var(--ink-4);
            text-transform: uppercase;
        }

        /* Status badges */
        .st-badge {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.55rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.1rem 0.45rem;
            border: 1px solid;
        }

        .st-badge--pending {
            color: var(--ink-3);
            border-color: var(--rule);
            background: var(--paper);
        }

        .st-badge--live {
            color: var(--blue);
            border-color: rgba(26, 74, 138, 0.3);
            background: rgba(26, 74, 138, 0.06);
        }

        .st-badge--done {
            color: var(--green);
            border-color: rgba(30, 106, 58, 0.3);
            background: rgba(30, 106, 58, 0.06);
        }

        .st-winner-chip {
            font-size: 0.55rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--green);
        }

        /* ── Team rows ── */
        .st-match__row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            padding: 0.5rem 0.6rem;
            border-bottom: 1px solid var(--rule);
            transition: background 0.15s;
        }

        .st-match__row:last-of-type {
            border-bottom: none;
        }

        .st-match__row--winner {
            background: rgba(30, 106, 58, 0.07) !important;
        }

        .st-match__team {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.01em;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
            min-width: 0;
        }

        .st-match__team--winner {
            color: var(--green);
        }

        .st-match__team--tbd {
            color: var(--ink-4);
            font-style: italic;
            font-weight: 400;
            font-size: 0.78rem;
        }

        /* Score input */
        .st-score {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            width: 2.4rem;
            text-align: center;
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--rule);
            padding: 0.1rem 0.2rem;
            color: var(--ink);
            outline: none;
            flex-shrink: 0;
            transition: border-color 0.15s, background 0.15s;
            font-variant-numeric: tabular-nums;
        }

        .st-score:focus {
            border-bottom-color: var(--red);
            background: var(--red-tint);
        }

        .st-score:disabled {
            color: var(--ink-4);
            background: transparent;
            cursor: not-allowed;
            border-bottom-color: transparent;
        }

        .st-score::-webkit-outer-spin-button,
        .st-score::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .st-score[type=number] {
            -moz-appearance: textfield;
        }

        /* ── Match footer (save state + feed link) ── */
        .st-match__foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.3rem 0.6rem;
            background: var(--paper-2);
            border-top: 1px solid var(--rule);
            gap: 0.5rem;
            min-height: 1.8rem;
        }

        .st-save-dot {
            font-size: 0.58rem;
            color: var(--ink-3);
            display: none;
        }

        .st-save-dot.active {
            display: inline;
        }

        .st-save-dot::after {
            content: ' ···';
            animation: stDots 1s infinite steps(4, end);
        }

        @keyframes stDots {
            0% {
                opacity: 0
            }

            25% {
                opacity: 0.4
            }

            50% {
                opacity: 0.7
            }

            75% {
                opacity: 1
            }
        }

        .st-save-ok {
            font-size: 0.58rem;
            color: var(--green);
            display: none;
        }

        .st-save-ok.active {
            display: inline;
        }

        .st-save-err {
            font-size: 0.58rem;
            color: var(--red);
            display: none;
        }

        .st-save-err.active {
            display: inline;
        }

        .st-feed-link {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.58rem;
            color: var(--red);
            text-decoration: none;
            cursor: pointer;
            border-bottom: 1px dashed rgba(197, 35, 27, 0.4);
            white-space: nowrap;
            flex-shrink: 0;
            transition: border-color 0.15s;
        }

        .st-feed-link:hover {
            border-color: var(--red);
        }

        /* ── Empty state ── */
        .st-empty {
            text-align: center;
            border: 1px solid var(--rule);
            background: var(--white);
            padding: 4rem 2rem;
            margin: 2rem 0;
        }

        .st-empty__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.6rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 0.5rem;
        }

        .st-empty__sub {
            font-size: 0.85rem;
            color: var(--ink-3);
            font-weight: 300;
        }

        /* ── Modal ── */
        .st-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 10, 10, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .st-modal-overlay.open {
            display: flex;
        }

        .st-modal {
            background: var(--white);
            max-width: 420px;
            width: 100%;
            margin: 1rem;
            border-top: 4px solid var(--red);
            animation: stModalIn 0.22s ease both;
            position: relative;
        }

        @keyframes stModalIn {
            from {
                opacity: 0;
                transform: translateY(12px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        .st-modal__head {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--rule);
        }

        .st-modal__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
        }

        .st-modal__body {
            padding: 1.25rem 1.5rem;
            font-family: 'Barlow', sans-serif;
            font-size: 0.88rem;
            color: var(--ink-2);
            font-weight: 300;
            line-height: 1.6;
        }

        .st-modal__body strong {
            font-weight: 600;
            color: var(--ink);
        }

        .st-modal__foot {
            padding: 0.9rem 1.5rem;
            border-top: 1px solid var(--rule);
            background: var(--paper-2);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .st-modal__close {
            position: absolute;
            top: 0.9rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: var(--ink-3);
        }

        .st-btn-cancel {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            background: none;
            color: var(--ink-3);
            border: 1px solid var(--rule);
            padding: 0.5rem 1.1rem;
            cursor: pointer;
            border-radius: 0;
            transition: all 0.15s;
        }

        .st-btn-cancel:hover {
            background: var(--paper-2);
            color: var(--ink);
        }

        .st-btn-confirm {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            background: var(--red);
            color: var(--white);
            border: 1px solid var(--red);
            padding: 0.5rem 1.25rem;
            cursor: pointer;
            border-radius: 0;
            transition: background 0.15s;
        }

        .st-btn-confirm:hover {
            background: var(--red-dark);
            border-color: var(--red-dark);
        }

        /* ── Reveal ── */
        .st-reveal {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.45s ease, transform 0.45s ease;
        }

        .st-reveal.in {
            opacity: 1;
            transform: none;
        }
    </style>

    <div class="st">

        {{-- ── Masthead ── --}}
        <div class="st-header st-reveal" data-stagger="0">
            <div class="st-header__bg">BRAKETS</div>
            <div class="st-header__inner">
                <div>
                    <div class="st-header__eyebrow">VolleyLV · Turnīra tīklājs</div>
                    <h1 class="st-header__title">{{ $tournament->name }}</h1>
                    <div class="st-header__stats">
                        <span class="st-stat-chip">
                            {{ $tournament->status === 'active' ? '● Aktīvs' : ($tournament->status === 'completed' ? '○ Pabeigts' : '◌ Gaida') }}
                        </span>
                        <span class="st-stat-chip">👥 {{ $participants }} dalībnieki</span>
                        <span class="st-stat-chip">⚡ {{ $matchCount }} spēles</span>
                        @if (!$isEditable)
                            <span class="st-stat-chip st-stat-chip--red">Slēgts rediģēšanai</span>
                        @else
                            <span class="st-stat-chip"
                                style="color:#5DBF85;border-color:rgba(93,191,133,0.35);background:rgba(93,191,133,0.07);">✎
                                Rediģējams</span>
                        @endif
                    </div>
                </div>

                @if ($canManage)
                    <div class="st-header__actions">
                        @if ($tournament->status === 'pending')
                            <form action="{{ route('tournaments.start', $tournament) }}" method="POST">
                                @csrf
                                <button type="submit" class="st-btn-ghost st-btn-ghost--green">▶ Sākt turnīru</button>
                            </form>
                        @elseif($tournament->status === 'active')
                            <button type="button" class="st-btn-ghost st-btn-ghost--danger"
                                onclick="document.getElementById('stop-modal').classList.add('open')">
                                ⏹ Apturēt
                            </button>
                        @endif
                        <a href="{{ route('tournaments.show', $tournament) }}" class="st-btn-ghost">← Atpakaļ</a>
                    </div>
                @else
                    <a href="{{ route('tournaments.show', $tournament) }}" class="st-btn-ghost">← Atpakaļ</a>
                @endif
            </div>
        </div>
        <div class="st-bar"></div>

        <div class="st-wrap">

            {{-- Errors --}}
            @if ($errors->any())
                <div class="st-alert st-alert--error st-reveal" data-stagger="1">
                    <ul>
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <div style="margin-top:0.5rem;font-size:0.75rem;opacity:0.8;">
                        Sets tiek uzvarēts pie 25 ar +2. Ja 24–24, turpina līdz +2 (26–24, 27–25, …).
                    </div>
                </div>
            @endif

            {{-- Final banner --}}
            @if ($finalMatch)
                <div id="final-container" data-final-match-id="{{ $finalMatch->id }}" class="st-reveal"
                    data-stagger="1">
                    @if ($finalDone && $champion)
                        <div class="st-champion">
                            <div class="st-champion__icon">🏆</div>
                            <div>
                                <div class="st-champion__label">Turnīra uzvarētājs</div>
                                <div class="st-champion__name">{{ $champion }}</div>
                            </div>
                            @if (is_numeric($aScr) && is_numeric($bScr))
                                <div class="st-champion__score">{{ $aScr }} – {{ $bScr }}</div>
                            @endif
                        </div>
                    @else
                        <div class="st-final-pending">
                            <div class="st-final-pending__head">
                                <span class="st-final-pending__label">Fināls</span>
                                <span class="st-final-pending__status">⏳ Gaida / Notiek</span>
                            </div>
                            <div class="st-final-pending__body">
                                <div class="st-final-team-a">
                                    <div class="st-final-team__name">{{ $aTeam ?? '—' }}</div>
                                    <div class="st-final-team__score">{{ is_numeric($aScr) ? $aScr : '–' }}</div>
                                </div>
                                <div class="st-final-vs">VS</div>
                                <div class="st-final-team-b">
                                    <div class="st-final-team__name">{{ $bTeam ?? '—' }}</div>
                                    <div class="st-final-team__score">{{ is_numeric($bScr) ? $bScr : '–' }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- ── Bracket ── --}}
            @if ($matches->isEmpty())
                <div class="st-empty st-reveal" data-stagger="2">
                    <div class="st-empty__title">Nav spēļu</div>
                    <p class="st-empty__sub">Sāc turnīru, lai ģenerētu tīklāju.</p>
                </div>
            @else
                <div class="st-bracket-outer st-reveal" data-stagger="2" role="region" aria-label="Turnīra tīklājs">
                    <div class="st-bracket-scroll">
                        <div class="st-bracket-grid">

                            @foreach ($rounds as $roundNumber => $roundMatches)
                                @php
                                    $rTitle = roundTitle($roundNumber, $finalRound);
                                    $dotCls = match ($rTitle) {
                                        'Final' => 'st-round__dot--final',
                                        'Semi-Final' => 'st-round__dot--semi',
                                        'Play-In' => 'st-round__dot--playin',
                                        default => 'st-round__dot--normal',
                                    };
                                @endphp
                                <div class="st-round" data-round="{{ $roundNumber }}">
                                    <div class="st-round__head">
                                        <span class="st-round__dot {{ $dotCls }}"></span>
                                        <span class="st-round__name">{{ $rTitle }}</span>
                                        <span class="st-round__count">{{ $roundMatches->count() }} spēl.</span>
                                    </div>
                                    <div class="st-round__matches">
                                        @foreach ($roundMatches->sortBy('index_in_round') as $m)
                                            @php
                                                $hasA = (bool) $m->participant_a_application_id;
                                                $hasB = (bool) $m->participant_b_application_id;
                                                $disabled = !($hasA && $hasB) || !$isEditable;
                                                [$label, $badgeCls] = statusMeta($m->status);

                                                $aName = $m->participantA?->team_name;
                                                $bName = $m->participantB?->team_name;
                                                $aTbd = !$aName && $hasB ? 'Gaida pretinieku' : null;
                                                $bTbd = !$bName && $hasA ? 'Gaida pretinieku' : null;
                                            @endphp

                                            <article class="st-match" data-match-id="{{ $m->id }}"
                                                data-next-match-id="{{ $m->next_match_id ?? '' }}"
                                                data-next-slot="{{ $m->next_slot ?? '' }}"
                                                data-status="{{ $m->status }}"
                                                data-winner-slot="{{ $m->winner_slot ?? '' }}">

                                                {{-- Head --}}
                                                <div class="st-match__head">
                                                    <div class="st-match__head-left">
                                                        <span
                                                            class="st-badge {{ $badgeCls }}">{{ $label }}</span>
                                                        @if ($m->winner_slot)
                                                            <span class="st-winner-chip winner-chip">Uzv.:
                                                                {{ $m->winner_slot }}</span>
                                                        @else
                                                            <span class="st-winner-chip winner-chip"
                                                                style="display:none;"></span>
                                                        @endif
                                                        @unless ($isEditable)
                                                            <span
                                                                style="font-size:0.52rem;color:var(--ink-4);letter-spacing:0.06em;text-transform:uppercase;">slēgts</span>
                                                        @endunless
                                                    </div>
                                                    <span class="st-match__id">#{{ $m->id }}</span>
                                                </div>

                                                {{-- Row A --}}
                                                <div
                                                    class="st-match__row row-A {{ $m->winner_slot === 'A' ? 'st-match__row--winner' : '' }}">
                                                    <span
                                                        class="st-match__team {{ $m->winner_slot === 'A' ? 'st-match__team--winner' : ($aTbd ? 'st-match__team--tbd' : '') }}"
                                                        data-team="A">
                                                        {{ $aName ?? ($aTbd ?? '—') }}
                                                    </span>
                                                    <input type="number" inputmode="numeric" min="0"
                                                        max="{{ \App\Http\Controllers\TournamentMatchController::MAX_POINTS }}"
                                                        class="st-score score-input"
                                                        value="{{ is_numeric($m->score_a) ? $m->score_a : '' }}"
                                                        placeholder="—"
                                                        data-url="{{ route('tournaments.updateMatchScore', [$tournament, $m]) }}"
                                                        data-match-id="{{ $m->id }}" data-side="A"
                                                        {{ $disabled ? 'disabled' : '' }}
                                                        title="{{ $disabled ? ($isEditable ? 'Gaida pretinieku' : 'Turnīrs slēgts') : 'Ievadi punktus' }}" />
                                                </div>

                                                {{-- Row B --}}
                                                <div
                                                    class="st-match__row row-B {{ $m->winner_slot === 'B' ? 'st-match__row--winner' : '' }}">
                                                    <span
                                                        class="st-match__team {{ $m->winner_slot === 'B' ? 'st-match__team--winner' : ($bTbd ? 'st-match__team--tbd' : '') }}"
                                                        data-team="B">
                                                        {{ $bName ?? ($bTbd ?? '—') }}
                                                    </span>
                                                    <input type="number" inputmode="numeric" min="0"
                                                        max="{{ \App\Http\Controllers\TournamentMatchController::MAX_POINTS }}"
                                                        class="st-score score-input"
                                                        value="{{ is_numeric($m->score_b) ? $m->score_b : '' }}"
                                                        placeholder="—"
                                                        data-url="{{ route('tournaments.updateMatchScore', [$tournament, $m]) }}"
                                                        data-match-id="{{ $m->id }}" data-side="B"
                                                        {{ $disabled ? 'disabled' : '' }}
                                                        title="{{ $disabled ? ($isEditable ? 'Gaida pretinieku' : 'Turnīrs slēgts') : 'Ievadi punktus' }}" />
                                                </div>

                                                {{-- Footer --}}
                                                <div class="st-match__foot">
                                                    <div>
                                                        <span class="st-save-dot"
                                                            id="saving-{{ $m->id }}">Saglabā</span>
                                                        <span class="st-save-ok" id="saved-{{ $m->id }}">✓
                                                            Saglabāts</span>
                                                        <span class="st-save-err" id="error-{{ $m->id }}">✕
                                                            Kļūda</span>
                                                    </div>
                                                    @if ($m->next_match_id)
                                                        <span class="st-feed-link" data-from="{{ $m->id }}"
                                                            data-to="{{ $m->next_match_id }}"
                                                            data-slot="{{ $m->next_slot }}">
                                                            → #{{ $m->next_match_id }} ({{ $m->next_slot }})
                                                        </span>
                                                    @else
                                                        <span style="font-size:0.58rem;color:var(--ink-4);">—</span>
                                                    @endif
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            @endif

        </div>{{-- /.st-wrap --}}
    </div>{{-- /.st --}}

    {{-- Stop modal --}}
    @if ($tournament->status === 'active' && $canManage)
        <div id="stop-modal" class="st-modal-overlay">
            <div class="st-modal">
                <button class="st-modal__close"
                    onclick="document.getElementById('stop-modal').classList.remove('open')">✕</button>
                <div class="st-modal__head">
                    <div class="st-modal__title">Apturēt turnīru</div>
                </div>
                <div class="st-modal__body">
                    Vai tiešām apturēt <strong>{{ $tournament->name }}</strong>?
                    Pēc apturēšanas turnīrs tiks atzīmēts kā <strong>pabeigts</strong>.
                </div>
                <form action="{{ route('tournaments.stop', $tournament) }}" method="POST">
                    @csrf
                    <div class="st-modal__foot">
                        <button type="button" class="st-btn-cancel"
                            onclick="document.getElementById('stop-modal').classList.remove('open')">Atcelt</button>
                        <button type="submit" class="st-btn-confirm">Apturēt</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        (function() {
            'use strict';

            /* ── stagger reveals ── */
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.st-reveal').forEach(el => {
                    const i = parseInt(el.dataset.stagger || '0', 10);
                    setTimeout(() => el.classList.add('in'), 60 + i * 90);
                });
            });

            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const finalRoot = document.getElementById('final-container');
            const isEditable = {{ $isEditable ? 'true' : 'false' }};

            const STATUS_MAP = {
                pending: {
                    label: 'Gaida',
                    cls: 'st-badge--pending'
                },
                in_progress: {
                    label: 'Notiek',
                    cls: 'st-badge--live'
                },
                completed: {
                    label: 'Pabeigts',
                    cls: 'st-badge--done'
                },
            };

            /* ── Index all cards ── */
            const cards = Array.from(document.querySelectorAll('.st-match'));
            const byId = new Map(cards.map(c => [String(c.dataset.matchId), c]));

            /* ── Resolve final match ID (explicit attr → auto-detect fallback) ── */
            function resolveFinalId() {
                const explicit = finalRoot?.dataset?.finalMatchId?.trim();
                if (explicit) return explicit;
                // card with no next_match_id in the highest-numbered round
                const noNext = cards.filter(c => !c.dataset.nextMatchId?.trim());
                if (noNext.length === 1) return noNext[0].dataset.matchId;
                let best = null,
                    bestRound = -Infinity;
                (noNext.length ? noNext : cards).forEach(c => {
                    const r = parseInt(c.closest('[data-round]')?.dataset.round ?? 0, 10);
                    if (r > bestRound) {
                        bestRound = r;
                        best = c;
                    }
                });
                return best?.dataset.matchId ?? '';
            }
            const FINAL_ID = resolveFinalId();

            /* ── Helpers ── */
            const $ = (sel, root = document) => root.querySelector(sel);
            const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

            function clearHighlight() {
                cards.forEach(c => c.classList.remove('is-highlighted'));
            }

            function highlight(...ids) {
                clearHighlight();
                ids.forEach(id => {
                    const c = byId.get(String(id));
                    if (c) {
                        c.classList.add('is-highlighted');
                        c.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest',
                            inline: 'center'
                        });
                    }
                });
            }

            /* ── Click to highlight connected pairs ── */
            cards.forEach(card => {
                card.addEventListener('click', e => {
                    if (e.target.closest('input')) return;
                    const to = card.dataset.nextMatchId;
                    if (to) {
                        highlight(card.dataset.matchId, to);
                    } else {
                        highlight(card.dataset.matchId);
                    }
                });
            });

            document.addEventListener('click', e => {
                const feed = e.target.closest('.st-feed-link');
                if (!feed) return;
                e.stopPropagation();
                highlight(feed.dataset.from, feed.dataset.to);
            });

            /* click outside cards → clear */
            document.addEventListener('click', e => {
                if (!e.target.closest('.st-match') && !e.target.closest('.st-feed-link')) {
                    clearHighlight();
                }
            });

            /* ── DOM-driven final banner renderer ── */
            function renderFinalBanner() {
                if (!finalRoot || !FINAL_ID) return;
                const card = byId.get(FINAL_ID);
                if (!card) return;

                const aName = ($('[data-team="A"]', card)?.textContent ?? '—').trim();
                const bName = ($('[data-team="B"]', card)?.textContent ?? '—').trim();
                const aScore = $('input[data-side="A"]', card)?.value ?? '';
                const bScore = $('input[data-side="B"]', card)?.value ?? '';
                const winner = card.dataset.winnerSlot ?? '';
                const champ = winner === 'A' ? aName : winner === 'B' ? bName : '';

                if (winner && champ) {
                    finalRoot.innerHTML = `
                    <div class="st-champion">
                        <div class="st-champion__icon">🏆</div>
                        <div>
                            <div class="st-champion__label">Turnīra uzvarētājs</div>
                            <div class="st-champion__name">${champ}</div>
                        </div>
                        ${(aScore && bScore) ? `<div class="st-champion__score">${aScore} – ${bScore}</div>` : ''}
                    </div>`;
                } else if (aName !== '—' || bName !== '—') {
                    finalRoot.innerHTML = `
                    <div class="st-final-pending">
                        <div class="st-final-pending__head">
                            <span class="st-final-pending__label">Fināls</span>
                            <span class="st-final-pending__status">⏳ Gaida / Notiek</span>
                        </div>
                        <div class="st-final-pending__body">
                            <div class="st-final-team-a">
                                <div class="st-final-team__name">${aName}</div>
                                <div class="st-final-team__score">${aScore || '–'}</div>
                            </div>
                            <div class="st-final-vs">VS</div>
                            <div class="st-final-team-b">
                                <div class="st-final-team__name">${bName}</div>
                                <div class="st-final-team__score">${bScore || '–'}</div>
                            </div>
                        </div>
                    </div>`;
                } else {
                    finalRoot.innerHTML = `
                    <div class="st-final-pending">
                        <div class="st-final-pending__head">
                            <span class="st-final-pending__label">Fināls</span>
                            <span class="st-final-pending__status">Finālisti drīzumā…</span>
                        </div>
                    </div>`;
                }
            }

            /* ── UI updaters ── */
            function updateStatusBadge(card, status) {
                card.dataset.status = status ?? '';
                const chip = $('.st-badge', card);
                if (!chip) return;
                const meta = STATUS_MAP[status] ?? STATUS_MAP.pending;
                chip.className = `st-badge ${meta.cls}`;
                chip.textContent = meta.label;
            }

            function applyWinnerUI(card, slot) {
                const aRow = $('.row-A', card);
                const bRow = $('.row-B', card);
                const aName = $('[data-team="A"]', card);
                const bName = $('[data-team="B"]', card);

                [aRow, bRow].forEach(r => r?.classList.remove('st-match__row--winner'));
                [aName, bName].forEach(n => n?.classList.remove('st-match__team--winner'));

                card.dataset.winnerSlot = slot ?? '';
                let chip = $('.winner-chip', card);
                if (!chip) {
                    chip = document.createElement('span');
                    chip.className = 'st-winner-chip winner-chip';
                    $('.st-match__head-left', card)?.appendChild(chip);
                }
                if (slot === 'A' || slot === 'B') {
                    const row = slot === 'A' ? aRow : bRow;
                    const name = slot === 'A' ? aName : bName;
                    row?.classList.add('st-match__row--winner');
                    name?.classList.add('st-match__team--winner');
                    chip.textContent = `Uzv.: ${slot}`;
                    chip.style.display = '';
                } else {
                    chip.textContent = '';
                    chip.style.display = 'none';
                }
            }

            function setTeam(card, slot, name) {
                const el = $(`[data-team="${slot}"]`, card);
                if (!el) return;
                el.textContent = name ?? '—';
                el.classList.toggle('st-match__team--tbd', !name || name === '—');
            }

            function refreshInputs(card) {
                const aText = $('[data-team="A"]', card)?.textContent.trim() ?? '';
                const bText = $('[data-team="B"]', card)?.textContent.trim() ?? '';
                const valid = aText && aText !== '—' && aText !== 'Gaida pretinieku' &&
                    bText && bText !== '—' && bText !== 'Gaida pretinieku';
                const lock = !valid || !isEditable;
                const aInp = $('input[data-side="A"]', card);
                const bInp = $('input[data-side="B"]', card);
                if (aInp) aInp.disabled = lock;
                if (bInp) bInp.disabled = lock;
            }

            /* ── Save-state indicators ── */
            function setState(id, state) {
                const dot = document.getElementById(`saving-${id}`);
                const ok = document.getElementById(`saved-${id}`);
                const err = document.getElementById(`error-${id}`);
                [dot, ok, err].forEach(x => x?.classList.remove('active'));
                if (state === 'saving') dot?.classList.add('active');
                if (state === 'ok') ok?.classList.add('active');
                if (state === 'err') err?.classList.add('active');
            }

            /* ── Apply a match update object from server ── */
            function applyMatchUpdate(m) {
                const card = byId.get(String(m.id));
                if (!card) return;

                if (typeof m.a_name !== 'undefined') setTeam(card, 'A', m.a_name);
                if (typeof m.b_name !== 'undefined') setTeam(card, 'B', m.b_name);

                const aInp = $('input[data-side="A"]', card);
                const bInp = $('input[data-side="B"]', card);
                if (aInp && typeof m.score_a !== 'undefined') aInp.value = m.score_a ?? '';
                if (bInp && typeof m.score_b !== 'undefined') bInp.value = m.score_b ?? '';

                if (m.status) updateStatusBadge(card, m.status);
                applyWinnerUI(card, m.winner_slot ?? null);
                refreshInputs(card);

                /* propagate winner into the next match */
                if (m.winner_slot && m.next_match_id && m.next_slot) {
                    const nextCard = byId.get(String(m.next_match_id));
                    if (nextCard) {
                        const winnerName = m.winner_slot === 'A' ?
                            (m.a_name ?? $('[data-team="A"]', card)?.textContent?.trim()) :
                            (m.b_name ?? $('[data-team="B"]', card)?.textContent?.trim());
                        setTeam(nextCard, m.next_slot, winnerName || '—');
                        refreshInputs(nextCard);
                    }
                }

                if (String(m.id) === FINAL_ID) renderFinalBanner();
                if (m.next_match_id && String(m.next_match_id) === FINAL_ID) renderFinalBanner();
            }

            /* ── Sync full server response ── */
            function syncResponse(data) {
                if (Array.isArray(data.matches)) {
                    data.matches.forEach(applyMatchUpdate);
                } else if (data.match) {
                    applyMatchUpdate(data.match);
                } else if (typeof data.id !== 'undefined') {
                    applyMatchUpdate(data);
                }
                /* explicit final payload from server overrides DOM render */
                if (data.final?.done && data.final?.champion) {
                    const f = data.final;
                    finalRoot.innerHTML = `
                    <div class="st-champion">
                        <div class="st-champion__icon">🏆</div>
                        <div>
                            <div class="st-champion__label">Turnīra uzvarētājs</div>
                            <div class="st-champion__name">${f.champion}</div>
                        </div>
                        ${(f.a_scr != null && f.b_scr != null) ? `<div class="st-champion__score">${f.a_scr} – ${f.b_scr}</div>` : ''}
                    </div>`;
                } else {
                    renderFinalBanner();
                }
            }

            /* ── Autosave (debounced PATCH) ── */
            if (!isEditable) {
                renderFinalBanner();
                return;
            }

            const cache = new Map(); /* matchId -> { A, B } */
            const timers = new Map();

            /* seed cache from current DOM */
            $$('.score-input').forEach(inp => {
                const id = inp.dataset.matchId;
                const side = inp.dataset.side;
                const prev = cache.get(id) ?? {
                    A: null,
                    B: null
                };
                prev[side] = inp.value === '' ? null : Number(inp.value);
                cache.set(id, prev);
            });

            function pairReady(p) {
                return Number.isInteger(p.A) && Number.isInteger(p.B);
            }

            async function save(id, url, A, B) {
                setState(id, 'saving');
                try {
                    const res = await fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            Accept: 'application/json',
                        },
                        body: JSON.stringify({
                            score_a: A,
                            score_b: B
                        }),
                    });
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw data;
                    syncResponse(data);
                    setState(id, 'ok');
                    setTimeout(() => setState(id, 'idle'), 1200);
                } catch (err) {
                    setState(id, 'err');
                    if (err?.message) console.error('[bracket]', err.message);
                }
            }

            $$('.score-input').forEach(inp => {
                if (inp.disabled) return;
                const id = inp.dataset.matchId;
                const side = inp.dataset.side;
                const url = inp.dataset.url;

                function schedule() {
                    const pair = cache.get(id) ?? {
                        A: null,
                        B: null
                    };
                    if (!pairReady(pair)) return;
                    clearTimeout(timers.get(id));
                    timers.set(id, setTimeout(() => save(id, url, pair.A, pair.B), 380));
                }

                inp.addEventListener('input', e => {
                    const raw = e.currentTarget.value;
                    const val = raw === '' ? null : Number(raw);
                    const pair = cache.get(id) ?? {
                        A: null,
                        B: null
                    };
                    pair[side] = val;
                    cache.set(id, pair);
                    setState(id, 'saving');
                    schedule();
                });

                inp.addEventListener('keydown', e => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const pair = cache.get(id) ?? {
                            A: null,
                            B: null
                        };
                        clearTimeout(timers.get(id));
                        if (pairReady(pair)) save(id, url, pair.A, pair.B);
                    } else if (e.key === 'Escape') {
                        e.currentTarget.blur();
                    } else if (e.key === 'Tab') {
                        /* jump to the partner score in same card */
                        const partnerSide = side === 'A' ? 'B' : 'A';
                        const partner = document.querySelector(
                            `.score-input[data-match-id="${id}"][data-side="${partnerSide}"]`
                        );
                        if (partner && !partner.disabled) {
                            e.preventDefault();
                            partner.focus();
                            partner.select();
                        }
                    }
                });

                inp.addEventListener('focus', () => inp.select());
            });

            /* ── Watch final card for attr changes (MutationObserver) ── */
            const finalCard = byId.get(FINAL_ID);
            if (finalCard) {
                new MutationObserver(renderFinalBanner).observe(finalCard, {
                    attributes: true,
                    attributeFilter: ['data-winner-slot'],
                });
                new MutationObserver(renderFinalBanner).observe(finalCard, {
                    subtree: true,
                    characterData: true,
                    childList: true,
                });
                $$('input[data-side]', finalCard).forEach(inp => {
                    inp.addEventListener('input', renderFinalBanner);
                });
            }

            /* initial render */
            renderFinalBanner();

        })();
    </script>
</x-app-layout>
