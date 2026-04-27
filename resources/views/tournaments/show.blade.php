{{-- resources/views/tournaments/show.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,600;0,700;0,900;1,700;1,900&family=Barlow:wght@300;400;500&family=DM+Sans:wght@400;500&display=swap');

        .ts * {
            box-sizing: border-box;
        }

        .ts {
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

            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 6rem;
        }

        /* ── Masthead hero ── */
        .ts-header {
            background: var(--ink);
            padding: clamp(3.5rem, 8vh, 5.5rem) 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .ts-header__bg-word {
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
        }

        .ts-header__inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem 2rem;
            position: relative;
            z-index: 1;
        }

        .ts-header__eyebrow {
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

        .ts-header__eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--red);
        }

        .ts-header__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(2.4rem, 6vw, 4.5rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            color: var(--white);
            line-height: 0.95;
            margin: 0 0 1.25rem;
        }

        /* Meta row in header */
        .ts-header__meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.4rem 1.25rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 1.25rem;
        }

        .ts-header__meta__item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .ts-header__meta__item svg {
            width: 12px;
            height: 12px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            flex-shrink: 0;
        }

        /* Pills in header */
        .ts-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.45rem;
            margin-bottom: 1.5rem;
        }

        .ts-pill {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.2rem 0.65rem;
            border: 1px solid;
            white-space: nowrap;
        }

        .ts-pill--men {
            color: #6BA3D6;
            border-color: rgba(107, 163, 214, 0.4);
            background: rgba(107, 163, 214, 0.1);
        }

        .ts-pill--women {
            color: #D68BB3;
            border-color: rgba(214, 139, 179, 0.4);
            background: rgba(214, 139, 179, 0.1);
        }

        .ts-pill--mix {
            color: #B3A0D6;
            border-color: rgba(179, 160, 214, 0.4);
            background: rgba(179, 160, 214, 0.1);
        }

        .ts-pill--other {
            color: rgba(255, 255, 255, 0.5);
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.05);
        }

        .ts-pill--active {
            color: #5DBF85;
            border-color: rgba(93, 191, 133, 0.4);
            background: rgba(93, 191, 133, 0.1);
        }

        .ts-pill--pending {
            color: #D4B86A;
            border-color: rgba(212, 184, 106, 0.4);
            background: rgba(212, 184, 106, 0.1);
        }

        .ts-pill--done {
            color: rgba(255, 255, 255, 0.4);
            border-color: rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.05);
        }

        .ts-pill--full {
            color: #FF7A72;
            border-color: rgba(255, 122, 114, 0.4);
            background: rgba(255, 122, 114, 0.1);
        }

        /* Admin actions */
        .ts-header__actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            padding-top: 0.25rem;
        }

        .ts-btn-ghost {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.08);
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

        .ts-btn-ghost:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .ts-btn-ghost--danger {
            color: #FF7A72;
            border-color: rgba(255, 122, 114, 0.3);
        }

        .ts-btn-ghost--danger:hover {
            background: rgba(255, 122, 114, 0.1);
            border-color: rgba(255, 122, 114, 0.5);
        }

        .ts-bar {
            height: 3px;
            background: var(--red);
        }

        /* ── Content wrap ── */
        .ts-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ── Winner banner ── */
        .ts-winner {
            background: var(--gold-tint);
            border: 1px solid var(--gold-rule);
            border-top: 3px solid var(--gold);
            padding: 1.25rem 1.5rem;
            margin: 2rem 0;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .ts-winner__trophy {
            font-size: 1.75rem;
            line-height: 1;
            flex-shrink: 0;
        }

        .ts-winner__label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.2rem;
        }

        .ts-winner__name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.8rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--gold);
            line-height: 1;
        }

        /* ── Control bar (start/stop) ── */
        .ts-controls {
            margin: 1.5rem 0;
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .ts-btn {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.6rem 1.5rem;
            cursor: pointer;
            border-radius: 0;
            border: 1px solid;
            transition: background 0.15s, border-color 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .ts-btn--green {
            background: var(--green);
            color: var(--white);
            border-color: var(--green);
        }

        .ts-btn--green:hover {
            background: #17562f;
            border-color: #17562f;
        }

        .ts-btn--red {
            background: var(--red);
            color: var(--white);
            border-color: var(--red);
        }

        .ts-btn--red:hover {
            background: var(--red-dark);
            border-color: var(--red-dark);
        }

        /* ── 2-col layout ── */
        .ts-layout {
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 0;
            border-top: 1px solid var(--rule);
            margin-top: 2rem;
        }

        @media (max-width: 860px) {
            .ts-layout {
                grid-template-columns: 1fr;
            }
        }

        .ts-main {
            border-right: 1px solid var(--rule);
            padding: 2rem 2rem 2rem 0;
        }

        @media (max-width: 860px) {
            .ts-main {
                border-right: none;
                padding-right: 0;
                border-bottom: 1px solid var(--rule);
            }
        }

        .ts-aside {
            padding: 2rem 0 2rem 2rem;
        }

        @media (max-width: 860px) {
            .ts-aside {
                padding-left: 0;
            }
        }

        /* ── Section header ── */
        .ts-section-head {
            margin-bottom: 1rem;
        }

        .ts-section-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.2rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 0.01em;
            color: var(--ink);
        }

        .ts-section-eyebrow {
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

        .ts-section-eyebrow::before {
            content: '';
            display: block;
            width: 14px;
            height: 2px;
            background: var(--red);
        }

        /* ── Description block ── */
        .ts-desc {
            font-family: 'Barlow', sans-serif;
            font-size: 0.92rem;
            font-weight: 300;
            line-height: 1.75;
            color: var(--ink-2);
            margin-bottom: 1.75rem;
        }

        /* ── Info grid ── */
        .ts-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border: 1px solid var(--rule);
            background: var(--white);
            margin-bottom: 1.75rem;
        }

        @media (max-width: 560px) {
            .ts-info-grid {
                grid-template-columns: 1fr;
            }
        }

        .ts-info-cell {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--rule);
            border-right: 1px solid var(--rule);
        }

        .ts-info-cell:nth-child(2n) {
            border-right: none;
        }

        .ts-info-cell--wide {
            grid-column: 1 / -1;
            border-right: none;
        }

        .ts-info-cell:last-child,
        .ts-info-cell:nth-last-child(2):not(.ts-info-cell--wide) {
            border-bottom: none;
        }

        .ts-info-cell--wide:last-child {
            border-bottom: none;
        }

        .ts-info-cell__label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-4);
            margin-bottom: 0.2rem;
        }

        .ts-info-cell__value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink);
        }

        /* ── Progress ── */
        .ts-progress {
            margin-bottom: 1.5rem;
        }

        .ts-progress__track {
            height: 3px;
            background: var(--rule);
            position: relative;
            overflow: hidden;
        }

        .ts-progress__fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            transition: width 0.5s;
        }

        .ts-progress__fill--ok {
            background: var(--green);
        }

        .ts-progress__fill--warn {
            background: #B87A10;
        }

        .ts-progress__fill--full {
            background: var(--red);
        }

        .ts-progress__label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.68rem;
            color: var(--ink-4);
            margin-top: 0.35rem;
        }

        .ts-progress__label strong {
            color: var(--ink-2);
        }

        /* ── Alert boxes ── */
        .ts-alert {
            padding: 0.7rem 0.9rem;
            font-size: 0.82rem;
            font-weight: 500;
            border-left: 3px solid;
            margin-bottom: 1.25rem;
        }

        .ts-alert--warn {
            background: #FEF8EC;
            color: #7A5A10;
            border-color: #D4A82A;
        }

        .ts-alert--error {
            background: var(--red-tint);
            color: var(--red-dark);
            border-color: var(--red);
        }

        .ts-alert--success {
            background: var(--green-tint);
            color: var(--green);
            border-color: var(--green);
        }

        /* ── Quick-facts sidebar ── */
        .ts-facts {
            border: 1px solid var(--rule);
            background: var(--white);
        }

        .ts-facts__head {
            background: var(--ink);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--rule);
        }

        .ts-facts__head-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
            margin-bottom: 0.15rem;
        }

        .ts-facts__head-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--white);
        }

        .ts-facts__row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.7rem 1rem;
            border-bottom: 1px solid var(--rule);
            font-size: 0.8rem;
        }

        .ts-facts__row:last-child {
            border-bottom: none;
        }

        .ts-facts__key {
            color: var(--ink-3);
            flex-shrink: 0;
        }

        .ts-facts__val {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--ink);
            text-align: right;
        }

        /* ── Applicants collapsible ── */
        .ts-collapsible {
            border: 1px solid var(--rule);
            background: var(--white);
            margin-bottom: 1.75rem;
        }

        .ts-collapsible__btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.9rem 1rem;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            border-bottom: 1px solid transparent;
            transition: background 0.12s;
        }

        .ts-collapsible__btn:hover {
            background: var(--paper-2);
        }

        .ts-collapsible--open .ts-collapsible__btn {
            border-bottom-color: var(--rule);
        }

        .ts-collapsible__btn-left {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
        }

        .ts-collapsible__eyebrow {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--red);
        }

        .ts-collapsible__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
        }

        .ts-collapsible__btn-right {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-shrink: 0;
        }

        .ts-count-badge {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.75rem;
            font-weight: 900;
            color: var(--white);
            background: var(--red);
            padding: 0.1rem 0.5rem;
            min-width: 1.5rem;
            text-align: center;
        }

        .ts-arrow {
            width: 14px;
            height: 14px;
            stroke: var(--ink-3);
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: transform 0.2s;
        }

        .ts-collapsible--open .ts-arrow {
            transform: rotate(180deg);
        }

        .ts-collapsible__panel {
            display: none;
        }

        .ts-collapsible--open .ts-collapsible__panel {
            display: block;
        }

        /* Applicant rows */
        .ts-applicant {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.8rem 1rem;
            border-bottom: 1px solid var(--rule);
            transition: background 0.12s;
            position: relative;
        }

        .ts-applicant:last-child {
            border-bottom: none;
        }

        .ts-applicant:hover {
            background: var(--paper);
        }

        .ts-applicant::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: var(--red);
            transition: width 0.18s;
        }

        .ts-applicant:hover::before {
            width: 2px;
        }

        .ts-applicant__num {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 900;
            font-style: italic;
            color: var(--ink-4);
            min-width: 1.5rem;
            flex-shrink: 0;
        }

        .ts-applicant__team {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--ink);
            line-height: 1.1;
        }

        .ts-applicant__captain {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.7rem;
            color: var(--ink-3);
            margin-top: 0.1rem;
        }

        .ts-btn-withdraw {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--red);
            background: none;
            border: 1px solid rgba(197, 35, 27, 0.3);
            padding: 0.3rem 0.75rem;
            cursor: pointer;
            border-radius: 0;
            white-space: nowrap;
            flex-shrink: 0;
            transition: all 0.15s;
        }

        .ts-btn-withdraw:hover {
            background: var(--red-tint);
            border-color: var(--red);
        }

        /* ── Join form ── */
        .ts-join {
            border: 1px solid var(--rule);
            background: var(--white);
            border-top: 3px solid var(--red);
            margin-bottom: 1.75rem;
        }

        .ts-join__head {
            padding: 0.9rem 1rem;
            border-bottom: 1px solid var(--rule);
            background: var(--paper-2);
        }

        .ts-join__body {
            padding: 1.5rem 1rem;
        }

        .ts-field {
            margin-bottom: 1.25rem;
        }

        .ts-field:last-of-type {
            margin-bottom: 0;
        }

        .ts-label {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-2);
            margin-bottom: 0.4rem;
        }

        .ts-input {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.92rem;
            color: var(--ink);
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--rule);
            padding: 0.5rem 0;
            outline: none;
            transition: border-color 0.2s;
        }

        .ts-input::placeholder {
            color: var(--ink-4);
        }

        .ts-input:focus {
            border-bottom-color: var(--ink);
        }

        .ts-field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 500px) {
            .ts-field-row {
                grid-template-columns: 1fr;
            }
        }

        .ts-join__footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0.9rem 1rem;
            border-top: 1px solid var(--rule);
            background: var(--paper-2);
        }

        .ts-btn-submit {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--ink);
            color: var(--white);
            border: 1px solid var(--ink);
            padding: 0.6rem 1.75rem;
            cursor: pointer;
            border-radius: 0;
            transition: background 0.15s;
        }

        .ts-btn-submit:hover {
            background: var(--ink-2);
            border-color: var(--ink-2);
        }

        .ts-btn-submit:focus-visible {
            outline: 2px solid var(--red);
            outline-offset: 2px;
        }

        /* ── Bottom action strip ── */
        .ts-action-strip {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            border-top: 1px solid var(--rule);
            padding-top: 2rem;
            margin-top: 2rem;
        }

        .ts-action-link {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            text-decoration: none;
            padding: 0.55rem 1.25rem;
            border: 1px solid;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
        }

        .ts-action-link--outline {
            color: var(--red);
            border-color: rgba(197, 35, 27, 0.4);
            background: none;
        }

        .ts-action-link--outline:hover {
            background: var(--red-tint);
            border-color: var(--red);
        }

        .ts-action-link--solid {
            color: var(--white);
            border-color: var(--ink);
            background: var(--ink);
        }

        .ts-action-link--solid:hover {
            background: var(--ink-2);
            border-color: var(--ink-2);
        }

        /* ── Modal ── */
        .ts-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 10, 10, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .ts-modal-overlay.open {
            display: flex;
        }

        .ts-modal {
            background: var(--white);
            max-width: 420px;
            width: 100%;
            margin: 1rem;
            border-top: 4px solid var(--red);
            animation: tsModalIn 0.22s ease both;
            position: relative;
        }

        .ts-modal--danger {
            border-top-color: var(--red);
        }

        @keyframes tsModalIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .ts-modal__head {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--rule);
        }

        .ts-modal__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
        }

        .ts-modal__body {
            padding: 1.25rem 1.5rem;
            font-family: 'Barlow', sans-serif;
            font-size: 0.88rem;
            color: var(--ink-2);
            font-weight: 300;
            line-height: 1.6;
        }

        .ts-modal__body strong {
            font-weight: 600;
            color: var(--ink);
        }

        .ts-modal__foot {
            padding: 0.9rem 1.5rem;
            border-top: 1px solid var(--rule);
            background: var(--paper-2);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
        }

        .ts-modal__close-bg {
            position: absolute;
            top: 0.9rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: var(--ink-3);
            line-height: 1;
        }

        .ts-btn-cancel {
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

        .ts-btn-cancel:hover {
            background: var(--paper-2);
            color: var(--ink);
        }

        .ts-btn-confirm {
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

        .ts-btn-confirm:hover {
            background: var(--red-dark);
            border-color: var(--red-dark);
        }

        /* ── Reveal ── */
        .ts-reveal {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.45s ease, transform 0.45s ease;
        }

        .ts-reveal.in {
            opacity: 1;
            transform: none;
        }
    </style>

    @php
        $start = \Carbon\Carbon::parse($tournament->start_date);
        $end = \Carbon\Carbon::parse($tournament->end_date ?? $tournament->start_date);
        $showRange = $end && $end->ne($start);

        $apps = $tournament->applications->count();
        $max = $tournament->max_teams;
        $remaining = $max ? max(0, $max - $apps) : null;
        $isFull = $max ? $apps >= $max : false;
        $pct = $max ? min(100, round(($apps / max(1, $max)) * 100)) : null;
        $fillCls =
            $pct >= 100
                ? 'ts-progress__fill--full'
                : ($pct >= 80
                    ? 'ts-progress__fill--warn'
                    : 'ts-progress__fill--ok');

        $gender = $tournament->gender_type;
        $genderPill = match ($gender) {
            'men' => 'ts-pill--men',
            'women' => 'ts-pill--women',
            'mix' => 'ts-pill--mix',
            default => 'ts-pill--other',
        };
        $genderLabel = match ($gender) {
            'men' => 'Vīrieši',
            'women' => 'Sievietes',
            'mix' => 'Mix',
            default => 'Turnīrs',
        };

        $status = $tournament->status;
        $statusPill = match ($status) {
            'active' => 'ts-pill--active',
            'completed' => 'ts-pill--done',
            default => 'ts-pill--pending',
        };
        $statusLabel = match ($status) {
            'active' => 'Aktīvs',
            'completed' => 'Pabeigts',
            default => 'Gaida sākumu',
        };

        $finalMatch = $tournament->matches()->orderByDesc('round')->first();
        $winnerName = $finalMatch?->winnerApplication()?->team_name;

        $isOwner = auth()->id() === $tournament->creator_id;
        $isAdmin = auth()->user()?->isAdmin();
        $canManage = $isOwner || $isAdmin;
    @endphp

    <div class="ts">

        {{-- ── Hero masthead ── --}}
        <div class="ts-header ts-reveal" data-stagger="0">
            <div class="ts-header__bg-word">{{ Str::upper(Str::limit($tournament->name, 12, '')) }}</div>
            <div class="ts-header__inner">
                <div class="ts-header__eyebrow">VolleyLV · Turnīrs</div>
                <h1 class="ts-header__title">{{ $tournament->name }}</h1>

                <div class="ts-header__meta">
                    <span class="ts-header__meta__item">
                        <svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                        {{ $start->format('d.m.Y') }}@if ($showRange)
                            – {{ $end->format('d.m.Y') }}
                        @endif
                    </span>
                    @if ($tournament->location)
                        <span class="ts-header__meta__item">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 22s-8-6.686-8-12a8 8 0 0116 0c0 5.314-8 12-8 12z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            {{ $tournament->location }}
                        </span>
                    @endif
                    @if ($tournament->team_size)
                        <span class="ts-header__meta__item">
                            <svg viewBox="0 0 24 24">
                                <circle cx="9" cy="7" r="4" />
                                <path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                                <path d="M16 3.13a4 4 0 010 7.75" />
                                <path d="M21 21v-2a4 4 0 00-3-3.87" />
                            </svg>
                            {{ $tournament->team_size }} spēlētāji
                        </span>
                    @endif
                </div>

                <div class="ts-pills">
                    <span class="ts-pill {{ $statusPill }}">{{ $statusLabel }}</span>
                    <span class="ts-pill {{ $genderPill }}">{{ $genderLabel }}</span>
                    @if ($isFull)
                        <span class="ts-pill ts-pill--full">Pilns</span>
                    @endif
                </div>

                @if ($canManage)
                    <div class="ts-header__actions">
                        <a href="{{ route('tournaments.edit', $tournament) }}" class="ts-btn-ghost">Rediģēt</a>
                        <button type="button" class="ts-btn-ghost ts-btn-ghost--danger"
                            onclick="tsModal('delete-modal')">Dzēst</button>
                    </div>
                @endif
            </div>
        </div>
        <div class="ts-bar"></div>

        <div class="ts-wrap">

            {{-- Winner banner --}}
            @if (!empty($winnerName))
                <div class="ts-winner ts-reveal" data-stagger="1">
                    <div class="ts-winner__trophy">🏆</div>
                    <div>
                        <div class="ts-winner__label">Turnīra uzvarētājs</div>
                        <div class="ts-winner__name">{{ $winnerName }}</div>
                    </div>
                </div>
            @endif

            {{-- Admin control buttons --}}
            @if ($tournament->status === 'pending' && $canManage)
                <div class="ts-controls ts-reveal" data-stagger="1">
                    <form action="{{ route('tournaments.start', $tournament) }}" method="POST">
                        @csrf
                        <button type="submit" class="ts-btn ts-btn--green">▶ Sākt turnīru</button>
                    </form>
                </div>
            @endif

            @if ($tournament->status === 'active' && $canManage)
                <div class="ts-controls ts-reveal" data-stagger="1">
                    <button type="button" class="ts-btn ts-btn--red" onclick="tsModal('stop-modal')">⏹ Apturēt
                        turnīru</button>
                </div>
            @endif

            {{-- ── 2-col layout ── --}}
            <div class="ts-layout ts-reveal" data-stagger="2">

                {{-- Main column --}}
                <div class="ts-main">

                    {{-- Description --}}
                    <div class="ts-section-head">
                        <div class="ts-section-eyebrow">Par turnīru</div>
                        <div class="ts-section-title">Apraksts</div>
                    </div>
                    <p class="ts-desc">{{ $tournament->description ?? 'Apraksts nav pievienots.' }}</p>

                    {{-- Info grid --}}
                    <div class="ts-info-grid">
                        <div class="ts-info-cell">
                            <div class="ts-info-cell__label">Atrašanās vieta</div>
                            <div class="ts-info-cell__value">{{ $tournament->location ?? 'TBA' }}</div>
                        </div>
                        <div class="ts-info-cell">
                            <div class="ts-info-cell__label">Spēlētāji laukumā</div>
                            <div class="ts-info-cell__value">{{ $tournament->team_size ?? '—' }}</div>
                        </div>
                        <div class="ts-info-cell">
                            <div class="ts-info-cell__label">Dzimums</div>
                            <div class="ts-info-cell__value">
                                {{ $genderLabel }}
                                @if ($gender === 'mix' && ($tournament->min_boys || $tournament->min_girls))
                                    <span style="font-size:0.75rem;font-weight:400;color:var(--ink-3);">
                                        (min {{ $tournament->min_boys ?? 0 }}M / {{ $tournament->min_girls ?? 0 }}S)
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="ts-info-cell">
                            <div class="ts-info-cell__label">Pieteikumi</div>
                            <div class="ts-info-cell__value">
                                {{ $apps }} / {{ $max ?? '∞' }}
                                @if ($remaining > 0)
                                    <span style="font-size:0.75rem;font-weight:400;color:var(--ink-3);">(brīvas
                                        {{ $remaining }})</span>
                                @elseif($isFull)
                                    <span style="font-size:0.75rem;font-weight:700;color:var(--red);">Pilns</span>
                                @endif
                            </div>
                        </div>
                        <div class="ts-info-cell ts-info-cell--wide">
                            <div class="ts-info-cell__label">Vecuma ierobežojums</div>
                            <div class="ts-info-cell__value">
                                @if ($tournament->min_age && $tournament->max_age)
                                    {{ $tournament->min_age }}–{{ $tournament->max_age }} gadi
                                @elseif($tournament->min_age)
                                    Min. {{ $tournament->min_age }} gadi
                                @elseif($tournament->max_age)
                                    Maks. {{ $tournament->max_age }} gadi
                                @else
                                    Nav
                                @endif
                            </div>
                        </div>
                        @if ($tournament->recommendations)
                            <div class="ts-info-cell ts-info-cell--wide">
                                <div class="ts-info-cell__label">Ieteikumi</div>
                                <div class="ts-info-cell__value"
                                    style="font-size:0.88rem;font-weight:400;font-family:'Barlow',sans-serif;color:var(--ink-2);">
                                    {{ $tournament->recommendations }}</div>
                            </div>
                        @endif
                    </div>

                    {{-- Progress --}}
                    @if (!is_null($pct))
                        <div class="ts-progress">
                            <div class="ts-progress__track">
                                <div class="ts-progress__fill {{ $fillCls }}" style="width:{{ $pct }}%">
                                </div>
                            </div>
                            <div class="ts-progress__label">
                                Aizpildījums: <strong>{{ $apps }}/{{ $max }}</strong>
                                ({{ $pct }}%)
                                @if ($isFull)
                                    — <strong style="color:var(--red);">Maksimālais skaits sasniegts</strong>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($isFull && $tournament->status === 'pending')
                        <div class="ts-alert ts-alert--error">
                            Pieteikumi <strong>slēgti</strong> — sasniegts maksimālais komandu skaits.
                        </div>
                    @endif

                    {{-- Applicants collapsible --}}
                    @if ($tournament->applications->count())
                        @php $startOpen = $tournament->status !== 'completed'; @endphp
                        <div id="apps-collapsible"
                            class="ts-collapsible {{ $startOpen ? 'ts-collapsible--open' : '' }}">
                            <button type="button" class="ts-collapsible__btn" onclick="tsToggle('apps-collapsible')">
                                <div class="ts-collapsible__btn-left">
                                    <span class="ts-collapsible__eyebrow">Komandas</span>
                                    <span class="ts-collapsible__title">Pieteikušās komandas</span>
                                </div>
                                <div class="ts-collapsible__btn-right">
                                    <span class="ts-count-badge">{{ $tournament->applications->count() }}</span>
                                    <svg class="ts-arrow" viewBox="0 0 24 24">
                                        <polyline points="6 9 12 15 18 9" />
                                    </svg>
                                </div>
                            </button>
                            <div class="ts-collapsible__panel">
                                @foreach ($tournament->applications as $i => $applicant)
                                    @php
                                        $canWithdraw =
                                            $tournament->status === 'pending' &&
                                            auth()->check() &&
                                            ($applicant->user_id === auth()->id() || $isAdmin);
                                    @endphp
                                    <div class="ts-applicant">
                                        <div class="ts-applicant__num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div style="flex:1;min-width:0;">
                                            <div class="ts-applicant__team">{{ $applicant->team_name }}</div>
                                            <div class="ts-applicant__captain">
                                                Kap. {{ $applicant->captain_name }}
                                                @if ($applicant->email)
                                                    · {{ $applicant->email }}
                                                @endif
                                            </div>
                                        </div>
                                        @if ($canWithdraw)
                                            <button type="button" class="ts-btn-withdraw"
                                                onclick="tsOpenWithdraw('{{ route('tournaments.applications.destroy', [$tournament, $applicant]) }}')">
                                                Atteikt
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Join form --}}
                    @if ($tournament->status === 'pending' && !$isFull)
                        <div class="ts-join" id="join">
                            <div class="ts-join__head">
                                <div class="ts-section-eyebrow" style="margin-bottom:0.2rem;">Reģistrācija</div>
                                <div class="ts-section-title">Pieteikties</div>
                            </div>
                            <div class="ts-join__body">
                                @if (session('success'))
                                    <div class="ts-alert ts-alert--success">{{ session('success') }}</div>
                                @endif
                                @if ($errors->any())
                                    <div class="ts-alert ts-alert--error">
                                        <ul style="list-style:none;">
                                            @foreach ($errors->all() as $e)
                                                <li>— {{ $e }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('tournaments.join', $tournament) }}" novalidate
                                    onsubmit="window.__rememberScroll()">
                                    @csrf
                                    <div class="ts-field">
                                        <label class="ts-label" for="team_name">Komandas nosaukums</label>
                                        <input class="ts-input" id="team_name" name="team_name" type="text"
                                            required value="{{ old('team_name') }}" placeholder="Komandas vārds">
                                    </div>
                                    <div class="ts-field-row">
                                        <div class="ts-field">
                                            <label class="ts-label" for="captain_name">Kapteiņa vārds</label>
                                            <input class="ts-input" id="captain_name" name="captain_name"
                                                type="text" required value="{{ old('captain_name') }}"
                                                placeholder="Vārds Uzvārds">
                                        </div>
                                        <div class="ts-field">
                                            <label class="ts-label" for="email">E-pasts</label>
                                            <input class="ts-input" id="email" name="email" type="email"
                                                required value="{{ old('email') }}" placeholder="you@example.com">
                                        </div>
                                    </div>
                            </div>
                            <div class="ts-join__footer">
                                <button type="submit" class="ts-btn-submit">Iesniegt pieteikumu →</button>
                            </div>
                            </form>
                        </div>
                    @elseif($tournament->status === 'pending' && $isFull)
                        <div class="ts-alert ts-alert--warn">
                            Maksimālais komandu skaits ir sasniegts — pieteikumi <strong>slēgti</strong>.
                        </div>
                    @else
                        <div class="ts-alert ts-alert--warn">
                            Turnīrs ir sācies vai beidzies — pieteikumi <strong>slēgti</strong>.
                        </div>
                    @endif

                    {{-- Bottom actions --}}
                    <div class="ts-action-strip">
                        <a href="{{ route('tournaments.stats', $tournament) }}"
                            class="ts-action-link ts-action-link--outline">Brakets →</a>
                        <a href="{{ route('tournaments.statistics', $tournament) }}"
                            class="ts-action-link ts-action-link--outline">Statistika →</a>
                        <a href="{{ route('tournaments.index') }}" class="ts-action-link ts-action-link--solid">←
                            Turnīri</a>
                    </div>

                </div>

                {{-- Sidebar: quick facts --}}
                <div class="ts-aside">
                    <div class="ts-facts">
                        <div class="ts-facts__head">
                            <div class="ts-facts__head-label">Kopsavilkums</div>
                            <div class="ts-facts__head-title">Ātrāis info</div>
                        </div>
                        <div class="ts-facts__row">
                            <span class="ts-facts__key">Datums</span>
                            <span class="ts-facts__val">
                                {{ $start->format('d.m.Y') }}@if ($showRange)
                                    <br>{{ $end->format('d.m.Y') }}
                                @endif
                            </span>
                        </div>
                        <div class="ts-facts__row">
                            <span class="ts-facts__key">Statuss</span>
                            <span class="ts-facts__val">{{ $statusLabel }}</span>
                        </div>
                        @if (!empty($winnerName))
                            <div class="ts-facts__row" style="background:var(--gold-tint);">
                                <span class="ts-facts__key" style="color:var(--gold);">Uzvarētājs</span>
                                <span class="ts-facts__val" style="color:var(--gold);">{{ $winnerName }}</span>
                            </div>
                        @endif
                        <div class="ts-facts__row">
                            <span class="ts-facts__key">Dzimums</span>
                            <span class="ts-facts__val">{{ $genderLabel }}</span>
                        </div>
                        @if ($tournament->location)
                            <div class="ts-facts__row">
                                <span class="ts-facts__key">Vieta</span>
                                <span class="ts-facts__val">{{ $tournament->location }}</span>
                            </div>
                        @endif
                        <div class="ts-facts__row">
                            <span class="ts-facts__key">Komandas</span>
                            <span class="ts-facts__val">{{ $apps }} / {{ $max ?? '∞' }}</span>
                        </div>
                        @if ($tournament->team_size)
                            <div class="ts-facts__row">
                                <span class="ts-facts__key">Laukumā</span>
                                <span class="ts-facts__val">{{ $tournament->team_size }}</span>
                            </div>
                        @endif
                    </div>
                </div>

            </div>{{-- /.ts-layout --}}
        </div>{{-- /.ts-wrap --}}

    </div>{{-- /.ts --}}

    {{-- ── Modals ── --}}

    {{-- Withdraw --}}
    <div id="withdraw-modal" class="ts-modal-overlay">
        <div class="ts-modal ts-modal--danger">
            <button class="ts-modal__close-bg" onclick="tsModalClose('withdraw-modal')">✕</button>
            <div class="ts-modal__head">
                <div class="ts-modal__title">Apstiprināt atteikšanos</div>
            </div>
            <div class="ts-modal__body">Vai tiešām <strong>atteikt</strong> šo pieteikumu? Šo darbību nevar atsaukt.
            </div>
            <form id="withdraw-form" method="POST" action="#" onsubmit="window.__rememberScroll()">
                @csrf @method('DELETE')
                <div class="ts-modal__foot">
                    <button type="button" class="ts-btn-cancel"
                        onclick="tsModalClose('withdraw-modal')">Atcelt</button>
                    <button type="submit" class="ts-btn-confirm">Atteikt</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete tournament --}}
    @if ($isAdmin)
        <div id="delete-modal" class="ts-modal-overlay">
            <div class="ts-modal ts-modal--danger">
                <button class="ts-modal__close-bg" onclick="tsModalClose('delete-modal')">✕</button>
                <div class="ts-modal__head">
                    <div class="ts-modal__title">Apstiprināt dzēšanu</div>
                </div>
                <div class="ts-modal__body">Vai tiešām dzēst <strong>{{ $tournament->name }}</strong>? Šī darbība ir
                    neatgriezeniska.</div>
                <form action="{{ route('tournaments.destroy', $tournament) }}" method="POST">
                    @csrf @method('DELETE')
                    <div class="ts-modal__foot">
                        <button type="button" class="ts-btn-cancel"
                            onclick="tsModalClose('delete-modal')">Atcelt</button>
                        <button type="submit" class="ts-btn-confirm">Dzēst</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Stop tournament --}}
    @if ($tournament->status === 'active' && $canManage)
        <div id="stop-modal" class="ts-modal-overlay">
            <div class="ts-modal ts-modal--danger">
                <button class="ts-modal__close-bg" onclick="tsModalClose('stop-modal')">✕</button>
                <div class="ts-modal__head">
                    <div class="ts-modal__title">Apturēt turnīru</div>
                </div>
                <div class="ts-modal__body">Vai tiešām apturēt <strong>{{ $tournament->name }}</strong>? Turnīrs tiks
                    atzīmēts kā <strong>pabeigts</strong>.</div>
                <form action="{{ route('tournaments.stop', $tournament) }}" method="POST">
                    @csrf
                    <div class="ts-modal__foot">
                        <button type="button" class="ts-btn-cancel"
                            onclick="tsModalClose('stop-modal')">Atcelt</button>
                        <button type="submit" class="ts-btn-confirm">Apturēt</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        // Reveal stagger
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.ts-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 60 + i * 90);
            });
        });

        // Collapsible toggle
        function tsToggle(id) {
            document.getElementById(id).classList.toggle('ts-collapsible--open');
        }

        // Modal helpers
        function tsModal(id) {
            document.getElementById(id).classList.add('open');
        }

        function tsModalClose(id) {
            document.getElementById(id).classList.remove('open');
        }

        // Close on overlay click
        document.querySelectorAll('.ts-modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', e => {
                if (e.target === overlay) overlay.classList.remove('open');
            });
        });

        // Withdraw modal with dynamic action URL
        function tsOpenWithdraw(url) {
            document.getElementById('withdraw-form').setAttribute('action', url);
            tsModal('withdraw-modal');
        }

        // Scroll preservation
        window.__rememberScroll = function() {
            try {
                sessionStorage.setItem('scrollY', String(window.scrollY || 0));
            } catch (e) {}
        };
        document.addEventListener('DOMContentLoaded', () => {
            try {
                const y = sessionStorage.getItem('scrollY');
                if (y !== null) {
                    window.scrollTo({
                        top: parseInt(y, 10) || 0,
                        behavior: 'instant'
                    });
                    sessionStorage.removeItem('scrollY');
                }
            } catch (e) {}
        });
    </script>
</x-app-layout>
