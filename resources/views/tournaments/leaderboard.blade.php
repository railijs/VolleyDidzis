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
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 6rem;
        }

        /* ── Header ── */
        .lb-header {
            background: var(--ink);
            padding: clamp(3.5rem, 8vh, 5.5rem) 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .lb-header__bg-word {
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

        .lb-header__left {}

        .lb-header__eyebrow {
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
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.35);
        }

        .lb-header__sub strong {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
        }

        .lb-btn-back {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.08);
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.45rem 1.1rem;
            text-decoration: none;
            transition: background 0.15s, border-color 0.15s;
            display: inline-flex;
            align-items: center;
        }

        .lb-btn-back:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .lb-bar {
            height: 3px;
            background: var(--red);
        }

        /* ── Wrap ── */
        .lb-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ── Filter bar ── */
        .lb-filters {
            border: 1px solid var(--rule);
            background: var(--white);
            padding: 1.25rem 1.25rem;
            margin-top: 2rem;
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
            transition: border-color 0.2s;
            width: 100%;
            border-radius: 0;
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
            transition: border-color 0.15s;
            cursor: pointer;
        }

        .lb-per-page select:focus {
            border-color: var(--ink-3);
        }

        /* ── Podium (top 3) ── */
        .lb-podium {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
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
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
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
            color: var(--ink);
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
        }

        .lb-table-head__eyebrow {
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--red);
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
            text-align: left;
            white-space: nowrap;
        }

        .lb-table thead th:not(:first-child) {
            text-align: right;
        }

        .lb-table thead th:first-child {
            color: rgba(255, 255, 255, 0.3);
            width: 3rem;
        }

        .lb-table thead th:nth-child(2) {
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
            background: var(--paper);
        }

        .lb-table tbody tr:nth-child(even) {
            background: #FAFAF8;
        }

        .lb-table tbody tr:nth-child(even):hover {
            background: var(--paper);
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
        $ranked = $rows->values();
        $top3 = $ranked->take(3);
        $restAll = $ranked->slice(3)->values();

        $perPage = (int) max(1, min(100, request('per_page', 20)));
        $page = (int) max(1, request('page', 1));
        $total = $restAll->count();
        $lastPage = (int) ceil($total / $perPage);
        $page = min($page, max(1, $lastPage ?: 1));
        $items = $restAll->forPage($page, $perPage)->values();

        $restPage = new \Illuminate\Pagination\LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
            'query' => request()->query(),
            'pageName' => 'page',
        ]);
        $restPage->appends(request()->except('page'));

        $maxTitles = max(1, (int) ($rows->max('titles') ?? ($rows->max('wins') ?? 1)));
        $podiumLabels = ['Čempions', '2. vieta', '3. vieta'];
        $podiumCls = ['lb-podium-card--gold', 'lb-podium-card--silver', 'lb-podium-card--bronze'];
    @endphp

    <div class="lb">

        {{-- Header ── --}}
        <div class="lb-header lb-reveal" data-stagger="0">
            <div class="lb-header__bg-word">Leaderboard</div>
            <div class="lb-header__inner">
                <div class="lb-header__left">
                    <div class="lb-header__eyebrow">VolleyLV · Statistika</div>
                    <h1 class="lb-header__title">Kopvērtējums</h1>
                    <div class="lb-header__sub">
                        Uzvaras = <strong>turnīra tituli</strong>
                    </div>

                </div>
                <div class="lb-bar"></div>

                <div class="lb-wrap">

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
                                    <option value="win_rate" {{ $sort === 'win_rate' ? 'selected' : '' }}>Uzvaru %
                                    </option>
                                    <option value="diff" {{ $sort === 'diff' ? 'selected' : '' }}>Pt. starpība
                                    </option>
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

                    {{-- Podium top 3 ── --}}
                    @if ($top3->isNotEmpty())
                        <div class="lb-podium lb-reveal" data-stagger="2">
                            @foreach ($top3 as $idx => $r)
                                @php
                                    $val = (int) ($r['titles'] ?? ($r['wins'] ?? 0));
                                    $pct = min(100, (int) round(($val / $maxTitles) * 100));
                                @endphp
                                <div class="lb-podium-card {{ $podiumCls[$idx] }}">
                                    <div class="lb-podium__rank">{{ $podiumLabels[$idx] }}</div>
                                    <div class="lb-podium__team">{{ $r['team'] }}</div>
                                    <div class="lb-podium__titles">{{ $val }}</div>
                                    <div class="lb-podium__titles-label">Tituli</div>
                                    <div class="lb-podium__stats">
                                        <div><strong>{{ $r['finals'] ?? 0 }}</strong>Fināli</div>
                                        <div><strong>{{ number_format((float) $r['win_rate'], 0) }}%</strong>Uzvaras
                                        </div>
                                        <div class="{{ (int) $r['diff'] >= 0 ? 'lb-diff-pos' : 'lb-diff-neg' }}">
                                            <strong>{{ $r['diff'] }}</strong>Diff
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
                            <span class="lb-table-head__eyebrow">Pilnais saraksts</span>
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
                                        <th>Diff</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($restPage as $i => $r)
                                        @php
                                            $rank =
                                                3 + ($restPage->currentPage() - 1) * $restPage->perPage() + ($i + 1);
                                            $titles = (int) ($r['titles'] ?? ($r['wins'] ?? 0));
                                            $diff = (int) $r['diff'];
                                        @endphp
                                        <tr>
                                            <td>{{ $rank }}</td>
                                            <td title="{{ $r['team'] }}">{{ $r['team'] }}</td>
                                            <td>{{ $titles }}</td>
                                            <td>{{ (int) ($r['finals'] ?? 0) }}</td>
                                            <td>{{ number_format((float) $r['win_rate'], 0) }}%</td>
                                            <td class="{{ $diff >= 0 ? 'lb-diff-pos' : 'lb-diff-neg' }}">
                                                {{ $diff }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" style="text-align:center;">
                                                <div class="lb-empty">Nav datu atbilstoši filtriem.</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination footer ── --}}
                        @if ($restPage->total() > 0)
                            <div class="lb-table-foot">
                                <div class="lb-table-foot__info">
                                    @php
                                        $from = 3 + ($restPage->currentPage() - 1) * $restPage->perPage() + 1;
                                        $to = min(
                                            3 + $restPage->total(),
                                            3 +
                                                ($restPage->currentPage() - 1) * $restPage->perPage() +
                                                $restPage->count(),
                                        );
                                    @endphp
                                    Rāda <strong>{{ $from }}–{{ $to }}</strong> no
                                    <strong>{{ 3 + $restPage->total() }}</strong> komandām
                                </div>

                                @if ($restPage->hasPages())
                                    <div class="lb-pagination">
                                        @if ($restPage->onFirstPage())
                                            <span class="disabled">«</span>
                                        @else
                                            <a href="{{ $restPage->url(1) }}">«</a>
                                            <a href="{{ $restPage->previousPageUrl() }}">‹</a>
                                        @endif

                                        @foreach (range(1, $restPage->lastPage()) as $pn)
                                            @if ($pn == $restPage->currentPage())
                                                <span class="current">{{ $pn }}</span>
                                            @elseif ($pn == 1 || $pn == $restPage->lastPage() || abs($pn - $restPage->currentPage()) <= 2)
                                                <a href="{{ $restPage->url($pn) }}">{{ $pn }}</a>
                                            @elseif (abs($pn - $restPage->currentPage()) == 3)
                                                <span class="disabled">…</span>
                                            @endif
                                        @endforeach

                                        @if ($restPage->hasMorePages())
                                            <a href="{{ $restPage->nextPageUrl() }}">›</a>
                                            <a href="{{ $restPage->url($restPage->lastPage()) }}">»</a>
                                        @else
                                            <span class="disabled">›</span>
                                            <span class="disabled">»</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelectorAll('.lb-reveal').forEach(el => {
                        const i = parseInt(el.dataset.stagger || '0', 10);
                        setTimeout(() => el.classList.add('in'), 60 + i * 90);
                    });
                });
            </script>
</x-app-layout>
