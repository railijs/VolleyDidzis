<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,600;0,700;0,900;1,700;1,900&family=Barlow:wght@300;400;500&family=DM+Sans:wght@400;500&display=swap');

        .lb * {
            box-sizing: border-box;
        }

        .lb {
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
            /* ← paper background on the .lb scope */
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 6rem;
        }

        /* ── Masthead (self-contained dark block) ── */
        .lb-header {
            background: var(--ink);
            padding: clamp(3.5rem, 8vh, 5.5rem) 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .lb-header__bg {
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

        .lb-header__inner {
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

        .lb-header__eyebrow {
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

        .lb-header__eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--red);
        }

        .lb-header__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(2.4rem, 6vw, 4.5rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            color: var(--white);
            line-height: 0.95;
            margin: 0 0 0.6rem;
        }

        .lb-header__sub {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.35);
        }

        .lb-header__sub strong {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
        }

        /* The 3px red bar lives INSIDE the header, at the bottom — not outside it */
        .lb-bar {
            height: 3px;
            background: var(--red);
        }

        /* ── Content wrap ── */
        .lb-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ── Search active banner ── */
        .lb-search-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            flex-wrap: wrap;
            background: var(--red-tint);
            border: 1px solid rgba(197, 35, 27, 0.2);
            border-left: 3px solid var(--red);
            padding: 0.65rem 1rem;
            margin: 1.75rem 0 1rem;
            font-size: 0.82rem;
            color: var(--red-dark);
        }

        .lb-search-banner strong {
            font-weight: 600;
        }

        .lb-search-clear {
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--red);
            text-decoration: none;
            border-bottom: 1px solid rgba(197, 35, 27, 0.3);
            padding-bottom: 1px;
            white-space: nowrap;
            flex-shrink: 0;
            transition: border-color 0.15s;
        }

        .lb-search-clear:hover {
            border-color: var(--red);
        }

        /* ── Filter bar ── */
        .lb-filters {
            border: 1px solid var(--rule);
            background: var(--white);
            padding: 1.25rem;
            margin-top: 1.75rem;
            margin-bottom: 1.75rem;
        }

        .lb-filters form {
            display: grid;
            grid-template-columns: 1fr 180px 140px;
            gap: 1rem;
            align-items: end;
        }

        @media (max-width: 720px) {
            .lb-filters form {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .lb-filters form {
                grid-template-columns: 1fr;
            }
        }

        .lb-filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .lb-filter-label {
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-3);
        }

        .lb-filter-input,
        .lb-filter-select {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            color: var(--ink);
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--rule);
            padding: 0.45rem 0;
            outline: none;
            width: 100%;
            border-radius: 0;
            transition: border-color 0.2s;
        }

        .lb-filter-input::placeholder {
            color: var(--ink-4);
        }

        .lb-filter-input:focus,
        .lb-filter-select:focus {
            border-bottom-color: var(--ink);
        }

        .lb-filter-actions {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            flex-wrap: wrap;
            padding-top: 0.5rem;
            border-top: 1px solid var(--rule);
            margin-top: 0.25rem;
        }

        .lb-btn-submit {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
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

        .lb-btn-submit:hover {
            background: var(--ink-2);
            border-color: var(--ink-2);
        }

        .lb-per-page {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.72rem;
            color: var(--ink-3);
        }

        .lb-per-page select {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            color: var(--ink);
            border: 1px solid var(--rule);
            background: var(--white);
            padding: 0.3rem 0.6rem;
            border-radius: 0;
            outline: none;
            cursor: pointer;
            transition: border-color 0.15s;
        }

        .lb-per-page select:focus {
            border-color: var(--ink-3);
        }

        /* ── Podium ── */
        .lb-podium {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border: 1px solid var(--rule);
            margin-bottom: 1.75rem;
        }

        @media (max-width: 640px) {
            .lb-podium {
                grid-template-columns: 1fr;
            }
        }

        .lb-podium-card {
            padding: 1.5rem 1.25rem 1.25rem;
            border-right: 1px solid var(--rule);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .lb-podium-card:last-child {
            border-right: none;
        }

        @media (max-width: 640px) {
            .lb-podium-card {
                border-right: none;
                border-bottom: 1px solid var(--rule);
            }

            .lb-podium-card:last-child {
                border-bottom: none;
            }
        }

        .lb-podium-card--gold {
            background: var(--gold-tint);
            border-top: 3px solid var(--gold);
        }

        .lb-podium-card--silver {
            background: var(--silver-tint);
            border-top: 3px solid var(--silver);
        }

        .lb-podium-card--bronze {
            background: var(--bronze-tint);
            border-top: 3px solid var(--bronze);
        }

        .lb-podium__rank {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .lb-podium-card--gold .lb-podium__rank {
            color: var(--gold);
        }

        .lb-podium-card--silver .lb-podium__rank {
            color: var(--silver);
        }

        .lb-podium-card--bronze .lb-podium__rank {
            color: var(--bronze);
        }

        .lb-podium__team {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1.2rem, 2.5vw, 1.7rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            line-height: 1.05;
            color: var(--ink);
            margin-bottom: 0.75rem;
        }

        .lb-podium__titles {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 3rem;
            font-weight: 900;
            font-style: italic;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .lb-podium-card--gold .lb-podium__titles {
            color: var(--gold);
        }

        .lb-podium-card--silver .lb-podium__titles {
            color: var(--silver);
        }

        .lb-podium-card--bronze .lb-podium__titles {
            color: var(--bronze);
        }

        .lb-podium__titles-label {
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--ink-4);
            margin-bottom: 0.85rem;
        }

        .lb-podium__stats {
            display: flex;
            gap: 1.25rem;
            font-size: 0.72rem;
            color: var(--ink-3);
            margin-top: auto;
        }

        .lb-podium__stat strong {
            color: var(--ink-2);
            font-weight: 600;
            display: block;
            font-size: 0.88rem;
        }

        .lb-podium__bar {
            height: 2px;
            background: rgba(0, 0, 0, 0.08);
            margin-top: 1rem;
            overflow: hidden;
        }

        .lb-podium__bar-fill {
            height: 100%;
        }

        .lb-podium-card--gold .lb-podium__bar-fill {
            background: var(--gold);
        }

        .lb-podium-card--silver .lb-podium__bar-fill {
            background: var(--silver);
        }

        .lb-podium-card--bronze .lb-podium__bar-fill {
            background: var(--bronze);
        }

        /* ── Table ── */
        .lb-table-wrap {
            border: 1px solid var(--rule);
            background: var(--white);
            overflow: hidden;
        }

        .lb-table-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7rem 1rem;
            border-bottom: 1px solid var(--rule);
            background: var(--paper-2);
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .lb-table-head__eyebrow {
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--red);
        }

        .lb-table-head__count {
            font-size: 0.72rem;
            color: var(--ink-3);
        }

        .lb-table-head__count strong {
            color: var(--ink-2);
        }

        .lb-table {
            width: 100%;
            border-collapse: collapse;
        }

        .lb-table thead tr {
            background: var(--ink);
        }

        .lb-table thead th {
            padding: 0.6rem 0.9rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.45);
            text-align: right;
            white-space: nowrap;
        }

        .lb-table thead th:first-child {
            text-align: right;
            color: rgba(255, 255, 255, 0.3);
            width: 3rem;
        }

        .lb-table thead th:nth-child(2) {
            text-align: left;
            color: rgba(255, 255, 255, 0.7);
        }

        .lb-table tbody tr {
            border-bottom: 1px solid var(--rule);
            transition: background 0.1s;
        }

        .lb-table tbody tr:last-child {
            border-bottom: none;
        }

        .lb-table tbody tr:hover {
            background: var(--paper) !important;
        }

        .lb-table tbody tr:nth-child(even) {
            background: #FAFAF8;
        }

        .lb-table td {
            padding: 0.75rem 0.9rem;
            font-size: 0.82rem;
            color: var(--ink-2);
            text-align: right;
            vertical-align: middle;
        }

        .lb-table td:first-child {
            text-align: right;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            font-style: italic;
            color: var(--ink-4);
            width: 3rem;
        }

        .lb-table td:nth-child(2) {
            text-align: left;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--ink);
            max-width: 260px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .lb-table td:nth-child(3) {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 900;
            font-style: italic;
            color: var(--red);
        }

        /* Highlight a searched-for team row */
        .lb-table tbody tr.lb-row--match {
            background: rgba(197, 35, 27, 0.04) !important;
        }

        .lb-table tbody tr.lb-row--match td:nth-child(2) {
            color: var(--red);
        }

        .lb-table tbody tr.lb-row--match td:first-child {
            color: var(--red);
        }

        .lb-diff-pos {
            color: var(--green);
        }

        .lb-diff-neg {
            color: var(--red);
        }

        /* ── Table footer / pagination ── */
        .lb-table-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--rule);
            background: var(--paper-2);
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .lb-table-foot__info {
            font-size: 0.72rem;
            color: var(--ink-3);
        }

        .lb-table-foot__info strong {
            color: var(--ink-2);
        }

        .lb-pagination {
            display: flex;
            align-items: center;
            gap: 0.2rem;
        }

        .lb-pagination a,
        .lb-pagination span {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 0.3rem 0.55rem;
            border: 1px solid transparent;
            text-decoration: none;
            color: var(--ink-3);
            transition: all 0.12s;
            display: inline-flex;
            align-items: center;
        }

        .lb-pagination a:hover {
            color: var(--ink);
            border-color: var(--rule);
        }

        .lb-pagination .current {
            background: var(--red);
            color: var(--white);
            border-color: var(--red);
        }

        .lb-pagination .disabled {
            color: var(--ink-4);
            cursor: default;
        }

        /* ── Empty ── */
        .lb-empty {
            padding: 3rem 1rem;
            text-align: center;
            font-family: 'Barlow', sans-serif;
            font-size: 0.9rem;
            font-weight: 300;
            color: var(--ink-3);
        }

        /* ── Reveal ── */
        .lb-reveal {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.45s ease, transform 0.45s ease;
        }

        .lb-reveal.in {
            opacity: 1;
            transform: none;
        }
    </style>

    @php
        /*
         * Podium always shows the global top-3 (from $globalTop3).
         * Table shows the paginated filtered results ($rows).
         * Each table row has its true global rank via $globalRanks[teamKey].
         */
        $podiumLabels = ['Čempions', '2. vieta', '3. vieta'];
        $podiumCls = ['lb-podium-card--gold', 'lb-podium-card--silver', 'lb-podium-card--bronze'];

        $isSearching = $q !== '';
    @endphp

    <div class="lb">

        {{-- ── Masthead (self-contained — has its own closing div) ── --}}
        <div class="lb-header lb-reveal" data-stagger="0">
            <div class="lb-header__bg">Kopvērtējums</div>
            <div class="lb-header__inner">
                <div>
                    <div class="lb-header__eyebrow">VolleyLV · Statistika</div>
                    <h1 class="lb-header__title">Kopvērtējums</h1>
                    <div class="lb-header__sub">
                        Uzvaras = <strong>turnīra tituli</strong> · {{ $allTeams }} komandas
                    </div>
                </div>
            </div>
        </div>{{-- /.lb-header — CLOSED HERE before the red bar and content --}}

        <div class="lb-bar"></div>{{-- red bar sits outside the dark header --}}

        {{-- ── Everything below is on the paper background ── --}}
        <div class="lb-wrap">

            {{-- Search active banner ── --}}
            @if ($isSearching)
                <div class="lb-search-banner lb-reveal" data-stagger="0">
                    <span>
                        Meklēšanas rezultāts: <strong>"{{ $q }}"</strong>
                        — atrasta(-s) <strong>{{ $totalTeams }}</strong> komanda(-s).
                        Topa 3 podijs rāda <em>globālo</em> sarakstu.
                    </span>
                    <a href="{{ route('leaderboard', array_filter(['sort' => $sort, 'dir' => $dir, 'per_page' => request('per_page')])) }}"
                        class="lb-search-clear">✕ Dzēst meklēšanu</a>
                </div>
            @endif

            {{-- Filters ── --}}
            <div class="lb-filters lb-reveal" data-stagger="1">
                <form method="GET" action="{{ route('leaderboard') }}">
                    <div class="lb-filter-group">
                        <label class="lb-filter-label">Meklēt komandu</label>
                        <input class="lb-filter-input" type="text" name="q" value="{{ $q }}"
                            placeholder="Komandas nosaukums…">
                    </div>
                    <div class="lb-filter-group">
                        <label class="lb-filter-label">Kārtot pēc</label>
                        <select class="lb-filter-select" name="sort">
                            <option value="wins" {{ $sort === 'wins' ? 'selected' : '' }}>Tituli</option>
                            <option value="finals" {{ $sort === 'finals' ? 'selected' : '' }}>Fināli</option>
                            <option value="win_rate" {{ $sort === 'win_rate' ? 'selected' : '' }}>Uzvaru %</option>
                            <option value="diff" {{ $sort === 'diff' ? 'selected' : '' }}>Pt. starpība</option>
                            <option value="pf_avg" {{ $sort === 'pf_avg' ? 'selected' : '' }}>Vid. punkti (par)
                            </option>
                            <option value="pa_avg" {{ $sort === 'pa_avg' ? 'selected' : '' }}>Vid. punkti (pret)
                            </option>
                            <option value="played" {{ $sort === 'played' ? 'selected' : '' }}>Spēles</option>
                        </select>
                    </div>
                    <div class="lb-filter-group">
                        <label class="lb-filter-label">Secība</label>
                        <select class="lb-filter-select" name="dir">
                            <option value="desc" {{ $dir === 'desc' ? 'selected' : '' }}>Dilstoši</option>
                            <option value="asc" {{ $dir === 'asc' ? 'selected' : '' }}>Augoši</option>
                        </select>
                    </div>
                    <div class="lb-filter-actions">
                        <button type="submit" class="lb-btn-submit">Rādīt →</button>
                        <div class="lb-per-page">
                            <span>Rādīt:</span>
                            <select name="per_page" onchange="this.form.submit()">
                                @foreach ([10, 20, 50, 100] as $size)
                                    <option value="{{ $size }}"
                                        {{ request('per_page', 20) == $size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Podium — always global top 3, never affected by search ── --}}
            @if ($globalTop3->isNotEmpty())
                <div class="lb-podium lb-reveal" data-stagger="2">
                    @foreach ($globalTop3 as $idx => $r)
                        @php
                            $val = (int) ($r['titles'] ?? 0);
                            $pct = min(100, $maxTitles > 0 ? (int) round(($val / $maxTitles) * 100) : 0);
                            $diff = (int) $r['diff'];
                        @endphp
                        <div class="lb-podium-card {{ $podiumCls[$idx] }}">
                            <div class="lb-podium__rank">{{ $podiumLabels[$idx] }}</div>
                            <div class="lb-podium__team">{{ $r['team'] }}</div>
                            <div class="lb-podium__titles">{{ $val }}</div>
                            <div class="lb-podium__titles-label">Tituli</div>
                            <div class="lb-podium__stats">
                                <div class="lb-podium__stat"><strong>{{ $r['finals'] ?? 0 }}</strong>Fināli</div>
                                <div class="lb-podium__stat">
                                    <strong>{{ number_format((float) $r['win_rate'], 0) }}%</strong>Uzvaras
                                </div>
                                <div class="lb-podium__stat {{ $diff >= 0 ? 'lb-diff-pos' : 'lb-diff-neg' }}">
                                    <strong>{{ $diff >= 0 ? '+' : '' }}{{ $diff }}</strong>Diff
                                </div>
                            </div>
                            <div class="lb-podium__bar">
                                <div class="lb-podium__bar-fill" style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Table ── --}}
            <div class="lb-table-wrap lb-reveal" data-stagger="3">
                <div class="lb-table-head">
                    <span class="lb-table-head__eyebrow">
                        {{ $isSearching ? 'Meklēšanas rezultāti' : 'Pilnais saraksts' }}
                    </span>
                    @if ($isSearching)
                        <span class="lb-table-head__count">
                            <strong>{{ $totalTeams }}</strong> / {{ $allTeams }} komandas
                        </span>
                    @endif
                </div>

                <div style="overflow-x:auto;">
                    <table class="lb-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="text-align:left;">Komanda</th>
                                <th>Tituli</th>
                                <th>Fināli</th>
                                <th>Uzv.%</th>
                                <th>Spēles</th>
                                <th>Diff</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $r)
                                @php
                                    $tkey = app(App\Http\Controllers\LeaderboardController::class)->teamKeyPublic(
                                        $r['team'],
                                    );
                                    $rank = $globalRanks[$tkey] ?? '—';
                                    $titles = (int) ($r['titles'] ?? 0);
                                    $diff = (int) $r['diff'];
                                    $isMatch = $isSearching; // every visible row is a match when searching
                                @endphp
                                <tr class="{{ $isMatch ? 'lb-row--match' : '' }}">
                                    <td>{{ $rank }}</td>
                                    <td title="{{ $r['team'] }}">{{ $r['team'] }}</td>
                                    <td>{{ $titles }}</td>
                                    <td>{{ (int) ($r['finals'] ?? 0) }}</td>
                                    <td>{{ number_format((float) $r['win_rate'], 0) }}%</td>
                                    <td>{{ (int) $r['played'] }}</td>
                                    <td class="{{ $diff >= 0 ? 'lb-diff-pos' : 'lb-diff-neg' }}">
                                        {{ $diff >= 0 ? '+' : '' }}{{ $diff }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center;">
                                        <div class="lb-empty">Nav datu atbilstoši filtriem.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination ── --}}
                @if ($rows->total() > 0)
                    <div class="lb-table-foot">
                        <div class="lb-table-foot__info">
                            Rāda <strong>{{ $rows->firstItem() ?? 0 }}–{{ $rows->lastItem() ?? 0 }}</strong>
                            no <strong>{{ $rows->total() }}</strong>
                            {{ $isSearching ? 'atrast' : 'kopēj' }}ām komandām
                        </div>

                        @if ($rows->hasPages())
                            <div class="lb-pagination">
                                @if ($rows->onFirstPage())
                                    <span class="disabled">«</span>
                                @else
                                    <a href="{{ $rows->url(1) }}">«</a>
                                    <a href="{{ $rows->previousPageUrl() }}">‹</a>
                                @endif

                                @foreach (range(1, $rows->lastPage()) as $pn)
                                    @if ($pn == $rows->currentPage())
                                        <span class="current">{{ $pn }}</span>
                                    @elseif($pn == 1 || $pn == $rows->lastPage() || abs($pn - $rows->currentPage()) <= 2)
                                        <a href="{{ $rows->url($pn) }}">{{ $pn }}</a>
                                    @elseif(abs($pn - $rows->currentPage()) == 3)
                                        <span class="disabled">…</span>
                                    @endif
                                @endforeach

                                @if ($rows->hasMorePages())
                                    <a href="{{ $rows->nextPageUrl() }}">›</a>
                                    <a href="{{ $rows->url($rows->lastPage()) }}">»</a>
                                @else
                                    <span class="disabled">›</span>
                                    <span class="disabled">»</span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>

        </div>{{-- /.lb-wrap --}}
    </div>{{-- /.lb --}}

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.lb-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 60 + i * 90);
            });
        });
    </script>
</x-app-layout>
