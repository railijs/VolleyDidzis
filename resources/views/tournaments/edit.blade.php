<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,600;0,700;0,900;1,700;1,900&family=Barlow:wght@300;400;500&family=DM+Sans:wght@400;500&display=swap');

        .ct * {
            box-sizing: border-box;
        }

        .ct {
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
            --green: #1E6A3A;
            --green-tint: #EAF4EE;

            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 6rem;
        }

        /* ── Masthead ── */
        .ct-header {
            background: var(--ink);
            padding: clamp(3.5rem, 8vh, 5.5rem) 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .ct-header__bg {
            position: absolute;
            right: -0.02em;
            bottom: -0.12em;
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

        .ct-header__inner {
            max-width: 900px;
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

        .ct-header__eyebrow {
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

        .ct-header__eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--red);
        }

        .ct-header__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(2.4rem, 6vw, 4.5rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            color: var(--white);
            line-height: 0.95;
            margin: 0;
        }

        .ct-header__name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1rem, 2vw, 1.4rem);
            font-weight: 700;
            font-style: italic;
            text-transform: uppercase;
            color: var(--red);
            margin-top: 0.4rem;
            letter-spacing: 0.01em;
            opacity: 0.85;
        }

        .ct-header__sub {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, .35);
            margin-top: 0.4rem;
        }

        .ct-header__actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-self: flex-end;
            margin-bottom: 0.5rem;
        }

        /* Delete button in header */
        .ct-btn-delete {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: rgba(197, 35, 27, .12);
            color: #FF7A72;
            border: 1px solid rgba(197, 35, 27, .35);
            padding: 0.45rem 1.1rem;
            cursor: pointer;
            border-radius: 0;
            transition: all .15s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .ct-btn-delete:hover {
            background: rgba(197, 35, 27, .22);
            border-color: rgba(197, 35, 27, .6);
        }

        .ct-bar {
            height: 3px;
            background: var(--red);
        }

        /* ── Wrap ── */
        .ct-wrap {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ── Alert boxes ── */
        .ct-alert {
            padding: 0.7rem 0.9rem;
            font-size: 0.82rem;
            font-weight: 500;
            border-left: 3px solid;
            margin-bottom: 1.25rem;
        }

        .ct-alert--error {
            background: var(--red-tint);
            color: var(--red-dark);
            border-color: var(--red);
        }

        .ct-alert--success {
            background: var(--green-tint);
            color: var(--green);
            border-color: var(--green);
        }

        .ct-alert ul {
            list-style: none;
        }

        .ct-alert li::before {
            content: '— ';
        }

        /* ── Form ── */
        .ct-form {
            margin-top: 2rem;
        }

        /* ── Section block ── */
        .ct-section {
            border: 1px solid var(--rule);
            background: var(--white);
            margin-bottom: 1.5rem;
        }

        .ct-section__head {
            background: var(--ink);
            padding: 0.7rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .ct-section__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--white);
        }

        .ct-section__hint {
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .3);
        }

        .ct-section__body {
            padding: 1.5rem 1.25rem;
        }

        /* ── Fields ── */
        .ct-field {
            margin-bottom: 1.5rem;
        }

        .ct-field:last-child {
            margin-bottom: 0;
        }

        .ct-label {
            display: block;
            font-size: 0.62rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-2);
            margin-bottom: 0.45rem;
        }

        .ct-label em {
            color: var(--red);
            font-style: normal;
        }

        .ct-input,
        .ct-select,
        .ct-textarea {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.92rem;
            color: var(--ink);
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--rule);
            padding: 0.55rem 0;
            outline: none;
            border-radius: 0;
            transition: border-color 0.2s;
        }

        .ct-input::placeholder,
        .ct-textarea::placeholder {
            color: var(--ink-4);
        }

        .ct-input:focus,
        .ct-select:focus,
        .ct-textarea:focus {
            border-bottom-color: var(--ink);
        }

        .ct-input:disabled {
            color: var(--ink-4);
            cursor: not-allowed;
        }

        .ct-input[type=number]::-webkit-inner-spin-button,
        .ct-input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }

        .ct-input[type=number] {
            -moz-appearance: textfield;
        }

        .ct-input[type=date] {
            cursor: pointer;
        }

        .ct-textarea {
            resize: vertical;
            min-height: 90px;
        }

        .ct-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23888' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0 center;
            padding-right: 1.25rem;
            cursor: pointer;
        }

        .ct-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 560px) {
            .ct-row {
                grid-template-columns: 1fr;
            }
        }

        .ct-hint {
            font-size: 0.68rem;
            color: var(--ink-4);
            margin-top: 0.3rem;
        }

        .ct-error {
            font-size: 0.72rem;
            color: var(--red);
            margin-top: 0.3rem;
            font-weight: 500;
        }

        .ct-counter {
            font-size: 0.65rem;
            color: var(--ink-4);
            margin-top: 0.3rem;
            text-align: right;
        }

        .ct-counter--warn {
            color: var(--red);
        }

        .ct-mix-warn {
            background: var(--red-tint);
            border-left: 3px solid var(--red);
            padding: 0.55rem 0.75rem;
            font-size: 0.78rem;
            color: var(--red-dark);
            font-weight: 500;
            margin-top: 0.75rem;
        }

        /* ── Actions bar ── */
        .ct-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            border-top: 1px solid var(--rule);
            padding-top: 1.5rem;
            margin-top: 0.25rem;
        }

        .ct-btn-cancel {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            background: none;
            color: var(--ink-3);
            border: 1px solid var(--rule);
            padding: 0.6rem 1.25rem;
            cursor: pointer;
            border-radius: 0;
            text-decoration: none;
            transition: all .15s;
            display: inline-flex;
            align-items: center;
        }

        .ct-btn-cancel:hover {
            background: var(--paper-2);
            color: var(--ink);
        }

        .ct-btn-submit {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--ink);
            color: var(--white);
            border: 1px solid var(--ink);
            padding: 0.6rem 2rem;
            cursor: pointer;
            border-radius: 0;
            transition: background .15s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .ct-btn-submit:hover:not(:disabled) {
            background: var(--ink-2);
            border-color: var(--ink-2);
        }

        .ct-btn-submit:disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }

        @keyframes ctSpin {
            to {
                transform: rotate(360deg);
            }
        }

        .ct-spin {
            animation: ctSpin .8s linear infinite;
        }

        /* ── Delete modal ── */
        .ct-del-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 10, 10, .6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(3px);
        }

        .ct-del-overlay.open {
            display: flex;
        }

        .ct-del-modal {
            background: #FFFFFF;
            max-width: 420px;
            width: calc(100% - 2rem);
            margin: 1rem;
            border-top: 4px solid #C5231B;
            position: relative;
            box-shadow: 0 32px 80px rgba(0, 0, 0, .4), 0 8px 24px rgba(0, 0, 0, .25);
            animation: ctDelIn .22s cubic-bezier(.16, 1, .3, 1) both;
        }

        @keyframes ctDelIn {
            from {
                opacity: 0;
                transform: translateY(14px) scale(.98)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        .ct-del-modal__head {
            padding: 1.25rem 1.5rem 1rem;
            border-bottom: 1px solid #D5D1C9;
        }

        .ct-del-modal__eyebrow {
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #C5231B;
            margin-bottom: .3rem;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .ct-del-modal__eyebrow::before {
            content: '';
            width: 14px;
            height: 2px;
            background: #C5231B;
        }

        .ct-del-modal__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: #0A0A0A;
            margin: 0;
        }

        .ct-del-modal__body {
            padding: 1.25rem 1.5rem;
            font-family: 'Barlow', sans-serif;
            font-size: 0.88rem;
            color: #2E2E2C;
            font-weight: 300;
            line-height: 1.65;
        }

        .ct-del-modal__body strong {
            color: #0A0A0A;
            font-weight: 600;
        }

        .ct-del-modal__foot {
            padding: .9rem 1.5rem;
            border-top: 1px solid #D5D1C9;
            background: #F7F5F0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: .5rem;
        }

        .ct-del-modal__close {
            position: absolute;
            top: .9rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #B0ADA8;
            line-height: 1;
            width: 1.75rem;
            height: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: color .15s, background .15s;
        }

        .ct-del-modal__close:hover {
            color: #0A0A0A;
            background: #EDEAE3;
        }

        .ct-del-btn-cancel {
            font-family: 'DM Sans', sans-serif;
            font-size: .75rem;
            font-weight: 500;
            letter-spacing: .07em;
            text-transform: uppercase;
            background: none;
            color: #6B6864;
            border: 1px solid #D5D1C9;
            padding: .5rem 1.1rem;
            cursor: pointer;
            border-radius: 0;
            transition: all .15s;
        }

        .ct-del-btn-cancel:hover {
            background: #EDEAE3;
            color: #0A0A0A;
        }

        .ct-del-btn-confirm {
            font-family: 'DM Sans', sans-serif;
            font-size: .75rem;
            font-weight: 500;
            letter-spacing: .07em;
            text-transform: uppercase;
            background: #C5231B;
            color: #fff;
            border: 1px solid #C5231B;
            padding: .5rem 1.25rem;
            cursor: pointer;
            border-radius: 0;
            transition: background .15s;
        }

        .ct-del-btn-confirm:hover {
            background: #9E1C15;
            border-color: #9E1C15;
        }

        /* ── Reveal ── */
        .ct-reveal {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity .45s ease, transform .45s ease;
        }

        .ct-reveal.in {
            opacity: 1;
            transform: none;
        }
    </style>

    <div class="ct" x-data="tournamentEditForm()">

        {{-- Masthead --}}
        <div class="ct-header ct-reveal" data-stagger="0">
            <div class="ct-header__bg">LABOT</div>
            <div class="ct-header__inner">
                <div>
                    <div class="ct-header__eyebrow">VolleyLV · Turnīri</div>
                    <h1 class="ct-header__title">Labot turnīru</h1>
                    <div class="ct-header__name">{{ $tournament->name }}</div>
                    <div class="ct-header__sub">Lauki atzīmēti ar <span style="color:var(--red);">*</span> ir obligāti.
                    </div>
                </div>
                @if (auth()->user()?->isAdmin())
                    <div class="ct-header__actions">
                        <button type="button" class="ct-btn-delete" @click="showDelete = true">
                            <svg width="12" height="12" viewBox="0 0 14 14" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round">
                                <path d="M2 3h10M5 3V2h4v1M6 6v4M8 6v4M3 3l1 8h6l1-8" />
                            </svg>
                            Dzēst turnīru
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <div class="ct-bar"></div>

        <div class="ct-wrap">

            {{-- Alerts --}}
            @if (session('success'))
                <div class="ct-alert ct-alert--success ct-reveal" data-stagger="1">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="ct-alert ct-alert--error ct-reveal" data-stagger="1">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="ct-alert ct-alert--error ct-reveal" data-stagger="1">
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('tournaments.update', $tournament) }}" class="ct-form ct-reveal"
                data-stagger="1" @submit="handleSubmit($event)" novalidate>
                @csrf
                @method('PUT')

                {{-- ── 1. Pamatinformācija ── --}}
                <div class="ct-section">
                    <div class="ct-section__head">
                        <span class="ct-section__title">Pamatinformācija</span>
                        <span class="ct-section__hint">1 / 4</span>
                    </div>
                    <div class="ct-section__body">
                        <div class="ct-field">
                            <label class="ct-label" for="name">Nosaukums <em>*</em></label>
                            <input class="ct-input" id="name" name="name" type="text" x-model="name"
                                placeholder="Piem., Rīgas pludmales volejbola kauss" maxlength="100" autocomplete="off">
                            <div class="ct-counter" :class="name.length > 90 ? 'ct-counter--warn' : ''"
                                x-text="name.length + ' / 100'"></div>
                            @error('name')
                                <div class="ct-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="ct-field">
                            <label class="ct-label" for="description">Apraksts</label>
                            <textarea class="ct-textarea" id="description" name="description" x-model="desc" rows="4"
                                placeholder="Īss turnīra apraksts, norises kārtība, noteikumi…" maxlength="2000"></textarea>
                            <div class="ct-counter" :class="descNearMax ? 'ct-counter--warn' : ''"
                                x-text="descCount + ' / ' + descLimit"></div>
                            @error('description')
                                <div class="ct-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ── 2. Datumi un vieta ── --}}
                <div class="ct-section">
                    <div class="ct-section__head">
                        <span class="ct-section__title">Datumi un vieta</span>
                        <span class="ct-section__hint">2 / 4</span>
                    </div>
                    <div class="ct-section__body">
                        <div class="ct-row ct-field">
                            <div>
                                <label class="ct-label" for="start_date">Sākuma datums <em>*</em></label>
                                <input class="ct-input" id="start_date" name="start_date" type="date"
                                    value="{{ old('start_date', $tournament->start_date) }}">
                                @error('start_date')
                                    <div class="ct-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="ct-label" for="end_date">Beigu datums <em>*</em></label>
                                <input class="ct-input" id="end_date" name="end_date" type="date"
                                    value="{{ old('end_date', $tournament->end_date) }}">
                                @error('end_date')
                                    <div class="ct-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="ct-field">
                            <label class="ct-label" for="location">Norises vieta <em>*</em></label>
                            <input class="ct-input" id="location" name="location" type="text"
                                value="{{ old('location', $tournament->location) }}"
                                placeholder="Piem., Rīga, Mežaparks">
                            <div class="ct-hint">Jābūt reālai vietai (ne tikai cipari).</div>
                            @error('location')
                                <div class="ct-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ── 3. Komandas un dalībnieki ── --}}
                <div class="ct-section">
                    <div class="ct-section__head">
                        <span class="ct-section__title">Komandas un dalībnieki</span>
                        <span class="ct-section__hint">3 / 4</span>
                    </div>
                    <div class="ct-section__body">
                        <div class="ct-row ct-field">
                            <div>
                                <label class="ct-label" for="max_teams">Maks. komandu skaits <em>*</em></label>
                                <input class="ct-input" id="max_teams" name="max_teams" type="number"
                                    min="2" max="100" x-model.number="maxTeams">
                                @error('max_teams')
                                    <div class="ct-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="ct-label" for="team_size">Spēlētāji komandā <em>*</em></label>
                                <input class="ct-input" id="team_size" name="team_size" type="number"
                                    min="4" max="12" x-model.number="teamSize"
                                    @input="onTeamSizeChanged()">
                                <div class="ct-hint">Tipiski 4–6 laukuma spēlētāji.</div>
                                @error('team_size')
                                    <div class="ct-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="ct-row ct-field">
                            <div>
                                <label class="ct-label" for="min_age">Minimālais vecums</label>
                                <input class="ct-input" id="min_age" name="min_age" type="number" min="0"
                                    max="100" x-model.number="minAge" @input="validateAge()"
                                    placeholder="Nav ierobežojuma">
                                @error('min_age')
                                    <div class="ct-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="ct-label" for="max_age">Maksimālais vecums</label>
                                <input class="ct-input" id="max_age" name="max_age" type="number" min="0"
                                    max="100" x-model.number="maxAge" @input="validateAge()"
                                    placeholder="Nav ierobežojuma">
                                @error('max_age')
                                    <div class="ct-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="ct-field">
                            <label class="ct-label" for="gender_type">Dzimuma tips <em>*</em></label>
                            <select class="ct-select" id="gender_type" name="gender_type" x-model="gender">
                                <option value="men" :selected="gender === 'men'">Vīrieši</option>
                                <option value="women" :selected="gender === 'women'">Sievietes</option>
                                <option value="mix" :selected="gender === 'mix'">Mix</option>
                            </select>
                            @error('gender_type')
                                <div class="ct-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div x-show="gender === 'mix'" x-transition>
                            <div class="ct-row ct-field" style="margin-bottom:0;">
                                <div>
                                    <label class="ct-label" for="min_boys">Min. puiši laukumā <em>*</em></label>
                                    <input class="ct-input" id="min_boys" name="min_boys" type="number"
                                        min="1" :max="teamSize" x-model.number="minBoys"
                                        @input="clampMix('boys')">
                                    @error('min_boys')
                                        <div class="ct-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="ct-label" for="min_girls">Min. meitenes laukumā <em>*</em></label>
                                    <input class="ct-input" id="min_girls" name="min_girls" type="number"
                                        min="1" :max="teamSize" x-model.number="minGirls"
                                        @input="clampMix('girls')">
                                    @error('min_girls')
                                        <div class="ct-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div x-show="mixOverflow" class="ct-mix-warn">
                                Min. puiši + min. meitenes (<span x-text="mixSum"></span>)
                                nedrīkst pārsniegt spēlētāju skaitu komandā
                                (<span x-text="teamSize"></span>).
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── 4. Papildinformācija ── --}}
                <div class="ct-section">
                    <div class="ct-section__head">
                        <span class="ct-section__title">Papildinformācija</span>
                        <span class="ct-section__hint">4 / 4</span>
                    </div>
                    <div class="ct-section__body">
                        <div class="ct-field">
                            <label class="ct-label" for="recommendations">Ieteikumi / noteikumi</label>
                            <textarea class="ct-textarea" id="recommendations" name="recommendations" x-model="recs" rows="3"
                                placeholder="Apģērba noteikumi, punktu skaitīšana, sākuma laiks u.c." maxlength="2000"></textarea>
                            <div class="ct-counter" :class="recsNearMax ? 'ct-counter--warn' : ''"
                                x-text="recsCount + ' / ' + recsLimit"></div>
                            @error('recommendations')
                                <div class="ct-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="ct-actions">
                    <a href="{{ route('tournaments.show', $tournament) }}" class="ct-btn-cancel">← Atpakaļ</a>
                    <button type="submit" class="ct-btn-submit" :disabled="!canSubmit">
                        <template x-if="!submitting"><span>Saglabāt izmaiņas →</span></template>
                        <template x-if="submitting">
                            <span style="display:inline-flex;align-items:center;gap:.5rem;">
                                <svg class="ct-spin" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="3" opacity=".25" />
                                    <path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" />
                                </svg>
                                Tiek saglabāts…
                            </span>
                        </template>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete confirm modal --}}
    @if (auth()->user()?->isAdmin())
        <div id="deleteOverlay" class="ct-del-overlay" :class="showDelete ? 'open' : ''"
            @click.self="showDelete = false" x-data>
            <div class="ct-del-modal">
                <button class="ct-del-modal__close" @click="$dispatch('close-delete')"
                    aria-label="Aizvērt">✕</button>
                <div class="ct-del-modal__head">
                    <div class="ct-del-modal__eyebrow">Neatgriezeniska darbība</div>
                    <h3 class="ct-del-modal__title">Dzēst turnīru</h3>
                </div>
                <div class="ct-del-modal__body">
                    Vai tiešām dzēst <strong>{{ $tournament->name }}</strong>?
                    Šī darbība ir neatgriezeniska un dzēsīs arī visus pieteikumus un spēles.
                </div>
                <form action="{{ route('tournaments.destroy', $tournament) }}" method="POST">
                    @csrf @method('DELETE')
                    <div class="ct-del-modal__foot">
                        <button type="button" class="ct-del-btn-cancel" @click="showDelete = false">Atcelt</button>
                        <button type="submit" class="ct-del-btn-confirm">Dzēst</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.ct-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 60 + i * 90);
            });

            const startInp = document.getElementById('start_date');
            const endInp = document.getElementById('end_date');
            if (startInp && endInp) {
                startInp.addEventListener('change', () => {
                    if (!endInp.value || endInp.value < startInp.value) {
                        endInp.value = startInp.value;
                    }
                    endInp.min = startInp.value;
                });
                if (startInp.value) endInp.min = startInp.value;
            }
        });

        function tournamentEditForm() {
            return {
                name: @json(old('name', $tournament->name)),
                desc: @json(old('description', $tournament->description ?? '')),
                recs: @json(old('recommendations', $tournament->recommendations ?? '')),
                gender: @json(old('gender_type', $tournament->gender_type)),
                teamSize: @json(old('team_size', $tournament->team_size ?? 6)),
                maxTeams: @json(old('max_teams', $tournament->max_teams ?? 8)),
                minBoys: @json(old('min_boys', $tournament->min_boys ?? 1)),
                minGirls: @json(old('min_girls', $tournament->min_girls ?? 1)),
                minAge: @json(old('min_age', $tournament->min_age ?? null)),
                maxAge: @json(old('max_age', $tournament->max_age ?? null)),
                descLimit: 2000,
                recsLimit: 2000,
                submitting: false,
                showDelete: false,

                get descCount() {
                    return (this.desc || '').length;
                },
                get recsCount() {
                    return (this.recs || '').length;
                },
                get descNearMax() {
                    return this.descCount > this.descLimit * 0.9;
                },
                get recsNearMax() {
                    return this.recsCount > this.recsLimit * 0.9;
                },
                get mixSum() {
                    return (Number(this.minBoys) || 0) + (Number(this.minGirls) || 0);
                },
                get mixOverflow() {
                    return this.gender === 'mix' && this.mixSum > (Number(this.teamSize) || 0);
                },
                get canSubmit() {
                    return !this.submitting && !this.mixOverflow;
                },

                clampMix(side) {
                    const size = Number(this.teamSize) || 0;
                    if (side === 'boys') this.minBoys = Math.max(1, Math.min(Number(this.minBoys) || 1, size));
                    if (side === 'girls') this.minGirls = Math.max(1, Math.min(Number(this.minGirls) || 1, size));
                },
                onTeamSizeChanged() {
                    this.clampMix('boys');
                    this.clampMix('girls');
                },
                validateAge() {
                    if (this.minAge && this.maxAge && this.maxAge < this.minAge) this.maxAge = this.minAge;
                },
                handleSubmit(ev) {
                    if (!this.canSubmit) {
                        ev.preventDefault();
                        return;
                    }
                    this.submitting = true;
                }
            };
        }
    </script>
</x-app-layout>
