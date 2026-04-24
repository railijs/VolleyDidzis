<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');

        .ap-root * {
            font-family: 'DM Sans', sans-serif;
            box-sizing: border-box;
        }

        .ap-root code,
        .ap-mono {
            font-family: 'DM Mono', monospace;
        }

        .ap-root {
            --ap-red: #C0392B;
            --ap-red-light: #FDECEA;
            --ap-red-mid: #F5B7B1;
            --ap-red-dark: #922B21;
            --ap-ink: #1A1A1A;
            --ap-ink-2: #4A4A4A;
            --ap-ink-3: #888;
            --ap-line: #E8E8E8;
            --ap-surface: #F9F8F7;
            --ap-white: #FFFFFF;
            --ap-success: #1E7E34;
            --ap-success-bg: #EAF6ED;
            --ap-danger-bg: #FDECEA;
            min-height: 100vh;
            background: var(--ap-surface);
            padding: 2rem 1.5rem 4rem;
        }

        .ap-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ── Header ─────────────────────────────── */
        .ap-header {
            margin-bottom: 2.5rem;
            margin-top: 45px;
        }

        .ap-eyebrow {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ap-red);
            margin-bottom: 0.4rem;
        }

        .ap-title {
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--ap-ink);
            letter-spacing: -0.03em;
            line-height: 1.15;
            margin: 0 0 0.35rem;
        }

        .ap-subtitle {
            font-size: 0.9rem;
            color: var(--ap-ink-3);
        }

        /* ── Flash ───────────────────────────────── */
        .ap-flash {
            margin-top: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            border-left: 3px solid;
        }

        .ap-flash--success {
            background: var(--ap-success-bg);
            color: var(--ap-success);
            border-color: var(--ap-success);
        }

        .ap-flash--error {
            background: var(--ap-danger-bg);
            color: var(--ap-red-dark);
            border-color: var(--ap-red);
        }

        /* ── Stats row ───────────────────────────── */
        .ap-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 900px) {
            .ap-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .ap-stats {
                grid-template-columns: 1fr;
            }
        }

        .ap-stat {
            background: var(--ap-white);
            border: 1px solid var(--ap-line);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.2s;
        }

        .ap-stat:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.07);
        }

        .ap-stat__label {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--ap-ink-3);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.5rem;
        }

        .ap-stat__value {
            font-size: 2rem;
            font-weight: 600;
            color: var(--ap-ink);
            letter-spacing: -0.04em;
            line-height: 1;
        }

        .ap-stat__sub {
            font-size: 0.75rem;
            color: var(--ap-ink-3);
            margin-top: 0.3rem;
        }

        .ap-stat__accent {
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var(--ap-line);
            border-radius: 0 12px 12px 0;
        }

        .ap-stat--primary .ap-stat__accent {
            background: var(--ap-red);
        }

        /* ── Actions grid ────────────────────────── */
        .ap-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2.5rem;
        }

        @media (max-width: 900px) {
            .ap-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .ap-actions {
                grid-template-columns: 1fr;
            }
        }

        .ap-action {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            background: var(--ap-white);
            border: 1px solid var(--ap-line);
            border-radius: 12px;
            padding: 1.25rem;
            text-decoration: none;
            color: inherit;
            transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s;
        }

        .ap-action:hover {
            border-color: #C0C0C0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
        }

        .ap-action__icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--ap-red-light);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ap-action__icon svg {
            width: 16px;
            height: 16px;
            stroke: var(--ap-red);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .ap-action__title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ap-ink);
            margin-bottom: 0.2rem;
        }

        .ap-action__desc {
            font-size: 0.78rem;
            color: var(--ap-ink-3);
            line-height: 1.4;
        }

        /* ── Users section ───────────────────────── */
        .ap-section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .ap-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--ap-ink);
            letter-spacing: -0.02em;
        }

        .ap-toolbar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .ap-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.3rem 0.8rem;
            border-radius: 999px;
            border: 1px solid var(--ap-line);
            background: var(--ap-white);
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--ap-ink-2);
            cursor: pointer;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .ap-pill:hover {
            border-color: #B0B0B0;
        }

        .ap-pill--active {
            background: var(--ap-red);
            color: #fff;
            border-color: var(--ap-red);
        }

        .ap-btn-export {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.3rem 0.9rem;
            border-radius: 999px;
            background: var(--ap-ink);
            color: #fff;
            border: none;
            font-size: 0.78rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
            white-space: nowrap;
        }

        .ap-btn-export:hover {
            background: #333;
        }

        .ap-btn-export svg {
            width: 12px;
            height: 12px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Search */
        .ap-search-wrap {
            position: relative;
            margin-bottom: 1rem;
        }

        .ap-search-wrap svg.ap-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            stroke: var(--ap-ink-3);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            pointer-events: none;
        }

        .ap-search {
            width: 100%;
            padding: 0.6rem 2.5rem 0.6rem 2.25rem;
            border: 1px solid var(--ap-line);
            border-radius: 8px;
            background: var(--ap-white);
            font-size: 0.875rem;
            color: var(--ap-ink);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .ap-search:focus {
            border-color: var(--ap-red);
            box-shadow: 0 0 0 3px rgba(192, 57, 43, 0.1);
        }

        .ap-search::placeholder {
            color: var(--ap-ink-3);
        }

        .ap-search-clear {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.78rem;
            color: var(--ap-ink-3);
            background: none;
            border: none;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .ap-search-clear:hover {
            color: var(--ap-ink);
            background: var(--ap-line);
        }

        /* Table */
        .ap-table-wrap {
            background: var(--ap-white);
            border: 1px solid var(--ap-line);
            border-radius: 12px;
            overflow: hidden;
            overflow-y: auto;
            max-height: 65vh;
        }

        .ap-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ap-table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .ap-table thead th {
            background: var(--ap-surface);
            padding: 0.7rem 1rem;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--ap-ink-3);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            border-bottom: 1px solid var(--ap-line);
            cursor: pointer;
            user-select: none;
            white-space: nowrap;
        }

        .ap-table thead th:hover {
            color: var(--ap-ink);
        }

        .ap-table thead th:last-child {
            text-align: right;
            cursor: default;
        }

        .ap-table .sort-ind {
            margin-left: 4px;
            font-size: 10px;
            opacity: 0.6;
        }

        .ap-table tbody tr {
            border-bottom: 1px solid var(--ap-line);
            transition: background 0.1s;
        }

        .ap-table tbody tr:last-child {
            border-bottom: none;
        }

        .ap-table tbody tr:hover {
            background: #FAFAFA;
        }

        .ap-table tbody tr.ap-row--self {
            background: #FFFBF0;
        }

        .ap-table tbody tr.ap-row--self:hover {
            background: #FFF8E8;
        }

        .ap-table td {
            padding: 0.8rem 1rem;
            font-size: 0.875rem;
            color: var(--ap-ink-2);
            vertical-align: middle;
        }

        .ap-id {
            font-family: 'DM Mono', monospace;
            font-size: 0.78rem;
            color: var(--ap-ink-3);
        }

        .ap-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--ap-red-light);
            color: var(--ap-red-dark);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            flex-shrink: 0;
            border: 1px solid var(--ap-red-mid);
        }

        .ap-name-cell {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .ap-name-text {
            font-weight: 500;
            color: var(--ap-ink);
        }

        .ap-copy-email {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            color: var(--ap-ink-2);
            font-size: 0.875rem;
            border-bottom: 1px dashed var(--ap-line);
            transition: color 0.15s, border-color 0.15s;
        }

        .ap-copy-email:hover {
            color: var(--ap-ink);
            border-color: var(--ap-ink-3);
        }

        /* Role badge / select */
        .ap-role-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .ap-role-badge--admin {
            background: var(--ap-red-light);
            color: var(--ap-red-dark);
        }

        .ap-role-badge--user {
            background: #F0F0F0;
            color: #555;
        }

        .ap-role-select {
            appearance: none;
            padding: 0.25rem 1.75rem 0.25rem 0.65rem;
            border-radius: 999px;
            border: 1px solid var(--ap-line);
            background: #F9F9F9 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' fill='none'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23888' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 8px center;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--ap-ink-2);
            cursor: pointer;
            outline: none;
            transition: border-color 0.15s;
        }

        .ap-role-select:focus {
            border-color: var(--ap-red);
        }

        .ap-role-select:hover {
            border-color: #B0B0B0;
        }

        /* Delete button */
        .ap-btn-delete {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.7rem;
            border-radius: 6px;
            background: none;
            border: 1px solid var(--ap-line);
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--ap-ink-3);
            cursor: pointer;
            transition: all 0.15s;
        }

        .ap-btn-delete svg {
            width: 12px;
            height: 12px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
        }

        .ap-btn-delete:hover {
            background: var(--ap-red-light);
            color: var(--ap-red-dark);
            border-color: var(--ap-red-mid);
        }

        .ap-actions-cell {
            text-align: right;
        }

        /* Footer info */
        .ap-table-footer {
            margin-top: 0.6rem;
            font-size: 0.78rem;
            color: var(--ap-ink-3);
        }

        /* Divider between stats and actions */
        .ap-divider {
            height: 1px;
            background: var(--ap-line);
            margin: 0.5rem 0 1.5rem;
        }

        /* Density compact */
        .ap-table.ap-compact td,
        .ap-table.ap-compact thead th {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        /* Fade-up */
        .fade-up {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <div class="ap-root">
        <div class="ap-container">

            {{-- Header --}}
            <header class="ap-header fade-up">
                <div class="ap-eyebrow">Vadības panelis</div>
                <h1 class="ap-title">Administrācija</h1>
                <p class="ap-subtitle">Pārvaldi lietotājus, turnīrus un ziņas vienuviet.</p>

                @foreach (['success' => 'success', 'error' => 'error'] as $type => $mod)
                    @if (session($type))
                        <div class="ap-flash ap-flash--{{ $mod }}">{{ session($type) }}</div>
                    @endif
                @endforeach
            </header>

            @php
                $totalUsers = $users->count();
                $adminsCount = $users->where('role', 'admin')->count();
                try {
                    $newsCount = \App\Models\News::count();
                } catch (\Throwable $e) {
                    $newsCount = null;
                }
                try {
                    $tournCount = \App\Models\Tournament::count();
                } catch (\Throwable $e) {
                    $tournCount = null;
                }
            @endphp

            {{-- Stats --}}
            <section class="ap-stats fade-up">
                <div class="ap-stat ap-stat--primary">
                    <div class="ap-stat__label">Lietotāji</div>
                    <div class="ap-stat__value">{{ $totalUsers }}</div>
                    <div class="ap-stat__sub">reģistrēti</div>
                    <div class="ap-stat__accent"></div>
                </div>
                <div class="ap-stat">
                    <div class="ap-stat__label">Administratori</div>
                    <div class="ap-stat__value">{{ $adminsCount }}</div>
                    <div class="ap-stat__sub">aktīvi</div>
                    <div class="ap-stat__accent"></div>
                </div>
                <div class="ap-stat">
                    <div class="ap-stat__label">Turnīri</div>
                    <div class="ap-stat__value">{{ $tournCount ?? '—' }}</div>
                    <div class="ap-stat__sub">{{ $tournCount !== null ? 'kopā' : 'nav datu' }}</div>
                    <div class="ap-stat__accent"></div>
                </div>
                <div class="ap-stat">
                    <div class="ap-stat__label">Ziņas</div>
                    <div class="ap-stat__value">{{ $newsCount ?? '—' }}</div>
                    <div class="ap-stat__sub">{{ $newsCount !== null ? 'publicētas' : 'nav datu' }}</div>
                    <div class="ap-stat__accent"></div>
                </div>
            </section>

            <div class="ap-divider fade-up"></div>

            {{-- Quick Actions --}}
            <section class="ap-actions fade-up">
                @php
                    $cards = [
                        [
                            'route' => 'tournaments.create',
                            'title' => 'Izveidot turnīru',
                            'desc' => 'Pievieno jaunu sacensību.',
                            'icon' => '<path d="M12 2l3 6 7 1-5 5 1 7-6-3-6 3 1-7L2 9l7-1 3-6z"/>',
                        ],
                        [
                            'route' => 'tournaments.index',
                            'title' => 'Turnīru saraksts',
                            'desc' => 'Pārbaudi progresu.',
                            'icon' =>
                                '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>',
                        ],
                        [
                            'route' => 'news.create',
                            'title' => 'Izveidot ziņu',
                            'desc' => 'Publicē jaunumus.',
                            'icon' =>
                                '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>',
                        ],
                        [
                            'route' => 'news.index',
                            'title' => 'Ziņu pārvaldība',
                            'desc' => 'Labot vai dzēst ziņas.',
                            'icon' => '<path d="M4 6h16M4 12h16M4 18h7"/>',
                        ],
                    ];
                @endphp
                @foreach ($cards as $card)
                    <a href="{{ route($card['route']) }}" class="ap-action">
                        <div class="ap-action__icon">
                            <svg viewBox="0 0 24 24">{!! $card['icon'] !!}</svg>
                        </div>
                        <div>
                            <div class="ap-action__title">{{ $card['title'] }}</div>
                            <div class="ap-action__desc">{{ $card['desc'] }}</div>
                        </div>
                    </a>
                @endforeach
            </section>

            {{-- Users section --}}
            <section class="fade-up">
                <div class="ap-section-head">
                    <h2 class="ap-section-title">Lietotāji</h2>
                    <div class="ap-toolbar">
                        <button id="filterAll" class="ap-pill ap-pill--active">Visi</button>
                        <button id="filterAdmin" class="ap-pill">Admini</button>
                        <button id="filterUser" class="ap-pill">Lietotāji</button>
                        <button id="toggleDensity" class="ap-pill">Kompakts</button>
                        <button id="exportCsv" class="ap-btn-export">
                            <svg viewBox="0 0 14 14">
                                <path d="M7 1v8M3.5 6.5L7 10l3.5-3.5M2 11h10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Eksportēt
                        </button>
                    </div>
                </div>

                <div class="ap-search-wrap">
                    <svg class="ap-search-icon" viewBox="0 0 20 20">
                        <circle cx="8.5" cy="8.5" r="5.5" />
                        <path d="M14 14l4 4" />
                    </svg>
                    <input id="userSearch" class="ap-search" type="text" placeholder="Meklēt pēc vārda vai e-pasta…">
                    <button id="clearSearch" class="ap-search-clear" style="display:none;">✕ notīrīt</button>
                </div>

                <div class="ap-table-wrap">
                    <table id="usersTable" class="ap-table">
                        <thead>
                            <tr>
                                <th data-key="id">ID<span class="sort-ind"></span></th>
                                <th data-key="name">Vārds<span class="sort-ind"></span></th>
                                <th data-key="email">E-pasts<span class="sort-ind"></span></th>
                                <th data-key="role">Loma<span class="sort-ind"></span></th>
                                <th>Darbības</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr data-role="{{ $user->role }}"
                                    class="{{ auth()->id() === $user->id ? 'ap-row--self' : '' }}">
                                    <td data-id>
                                        <span class="ap-id">#{{ $user->id }}</span>
                                    </td>
                                    <td data-name>
                                        <div class="ap-name-cell">
                                            <div class="ap-avatar">{{ strtoupper(mb_substr($user->name, 0, 2)) }}</div>
                                            <span class="ap-name-text">{{ $user->name }}</span>
                                            @if (auth()->id() === $user->id)
                                                <span class="ap-role-badge ap-role-badge--user"
                                                    style="font-size:0.65rem;opacity:.7;">tu</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td data-email>
                                        <button type="button" class="ap-copy-email" data-addr="{{ $user->email }}">
                                            {{ $user->email }}
                                        </button>
                                    </td>
                                    <td data-role>
                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST"
                                                style="display:inline">
                                                @csrf @method('PATCH')
                                                <select name="role" onchange="this.form.submit()"
                                                    class="ap-role-select"
                                                    aria-label="Mainīt {{ $user->name }} lomu">
                                                    <option value="user" @selected($user->role === 'user')>User</option>
                                                    <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                                </select>
                                            </form>
                                        @else
                                            <span
                                                class="ap-role-badge ap-role-badge--{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                                        @endif
                                    </td>
                                    <td class="ap-actions-cell">
                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Dzēst šo lietotāju?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="ap-btn-delete">
                                                    <svg viewBox="0 0 14 14">
                                                        <path d="M2 3h10M5 3V2h4v1M6 6v4M8 6v4M3 3l1 8h6l1-8" />
                                                    </svg>
                                                    Dzēst
                                                </button>
                                            </form>
                                        @else
                                            <span style="color:var(--ap-ink-3);font-size:.8rem;">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="ap-table-footer">
                    Rādīti <span id="shownCount">{{ $users->count() }}</span> no {{ $users->count() }} lietotājiem
                </div>
            </section>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Staggered reveal
            document.querySelectorAll('.fade-up').forEach((el, i) => {
                setTimeout(() => el.classList.add('visible'), 60 * i);
            });

            const $ = (sel, ctx = document) => ctx.querySelector(sel);
            const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

            const table = $('#usersTable');
            const tbody = table.tBodies[0];
            const rows = $$('tbody tr', table);
            const searchInput = $('#userSearch');
            const clearBtn = $('#clearSearch');
            const shownCount = $('#shownCount');

            let activeFilter = 'all';

            // ── Filters ──────────────────────────────
            const filterMap = {
                all: $('#filterAll'),
                admin: $('#filterAdmin'),
                user: $('#filterUser')
            };

            function setFilter(which) {
                activeFilter = which;
                Object.entries(filterMap).forEach(([k, btn]) => {
                    if (!btn) return;
                    btn.classList.toggle('ap-pill--active', k === which);
                });
                refresh();
            }

            Object.entries(filterMap).forEach(([k, btn]) => {
                if (btn) btn.addEventListener('click', () => setFilter(k));
            });

            // ── Search ────────────────────────────────
            let debounce;
            searchInput.addEventListener('input', () => {
                clearTimeout(debounce);
                debounce = setTimeout(refresh, 100);
            });
            clearBtn.addEventListener('click', () => {
                searchInput.value = '';
                refresh();
            });

            function refresh() {
                const q = searchInput.value.trim().toLowerCase();
                clearBtn.style.display = q ? '' : 'none';
                let shown = 0;
                rows.forEach(row => {
                    const role = row.dataset.role;
                    const text = row.innerText.toLowerCase();
                    const visible = (activeFilter === 'all' || role === activeFilter) && (!q || text
                        .includes(q));
                    row.style.display = visible ? '' : 'none';
                    if (visible) shown++;
                });
                shownCount.textContent = shown;
            }

            // ── Sorting ───────────────────────────────
            const headers = $$('thead th[data-key]', table);
            let sortKey = null,
                sortDir = 'asc';

            function cellVal(row, key) {
                switch (key) {
                    case 'id':
                        return parseInt(row.querySelector('[data-id]').textContent, 10) || 0;
                    case 'name':
                        return row.querySelector('[data-name]').innerText.toLowerCase();
                    case 'email':
                        return row.querySelector('[data-email]').innerText.toLowerCase();
                    case 'role':
                        return row.dataset.role || '';
                }
                return '';
            }

            headers.forEach(h => h.addEventListener('click', () => {
                const key = h.dataset.key;
                sortDir = (sortKey === key && sortDir === 'asc') ? 'desc' : 'asc';
                sortKey = key;

                headers.forEach(th => th.querySelector('.sort-ind').textContent = '');
                h.querySelector('.sort-ind').textContent = sortDir === 'asc' ? ' ↑' : ' ↓';

                const visible = rows.filter(r => r.style.display !== 'none');
                const hidden = rows.filter(r => r.style.display === 'none');
                visible.sort((a, b) => {
                    const va = cellVal(a, key),
                        vb = cellVal(b, key);
                    if (va < vb) return sortDir === 'asc' ? -1 : 1;
                    if (va > vb) return sortDir === 'asc' ? 1 : -1;
                    return 0;
                });
                [...visible, ...hidden].forEach(r => tbody.appendChild(r));
            }));

            // ── Copy email ────────────────────────────
            tbody.addEventListener('click', e => {
                const btn = e.target.closest('.ap-copy-email');
                if (!btn) return;
                navigator.clipboard?.writeText(btn.dataset.addr).then(() => {
                    const orig = btn.textContent;
                    btn.textContent = '✓ Nokopēts';
                    setTimeout(() => btn.textContent = orig, 900);
                });
            });

            // ── Export CSV ────────────────────────────
            $('#exportCsv').addEventListener('click', () => {
                const data = [
                    ['ID', 'Vārds', 'E-pasts', 'Loma']
                ];
                rows.forEach(tr => {
                    if (tr.style.display === 'none') return;
                    data.push([
                        tr.querySelector('[data-id]').textContent.trim(),
                        tr.querySelector('[data-name]').innerText.trim(),
                        tr.querySelector('[data-email]').innerText.trim(),
                        tr.dataset.role
                    ]);
                });
                const csv = data.map(r => r.map(v => `"${String(v).replace(/"/g,'""')}"`).join(',')).join(
                    '\n');
                const blob = new Blob([csv], {
                    type: 'text/csv;charset=utf-8;'
                });
                const a = Object.assign(document.createElement('a'), {
                    href: URL.createObjectURL(blob),
                    download: 'lietotaji.csv'
                });
                document.body.appendChild(a);
                a.click();
                a.remove();
            });

            // ── Density ───────────────────────────────
            let compact = false;
            $('#toggleDensity').addEventListener('click', function() {
                compact = !compact;
                table.classList.toggle('ap-compact', compact);
                this.classList.toggle('ap-pill--active', compact);
            });

            // init
            setFilter('all');
        });
    </script>
</x-app-layout>
