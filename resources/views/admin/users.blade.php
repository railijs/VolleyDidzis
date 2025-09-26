<x-app-layout>
    <div class="relative min-h-screen pt-28 pb-16 bg-gradient-to-b from-white via-red-50 to-white">
        <style>
            /* Page-load reveal (no libs) */
            @media (prefers-reduced-motion: no-preference) {
                .fade-up {
                    opacity: 0;
                    transform: translateY(12px);
                    transition: opacity .55s ease, transform .55s ease;
                }

                .loaded .fade-up {
                    opacity: 1;
                    transform: none;
                }
            }

            /* Pills */
            .pill {
                @apply inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold;
            }

            /* Badge */
            .role-badge {
                @apply inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold;
            }

            .role-badge.admin {
                @apply bg-red-100 text-red-700;
            }

            .role-badge.user {
                @apply bg-gray-100 text-gray-700;
            }

            /* Table header sort indicator */
            th.sortable {
                position: relative;
                cursor: pointer;
                user-select: none;
            }

            th.sortable .indicator {
                position: absolute;
                right: .5rem;
                opacity: .5;
                font-size: .85em;
            }

            th.sortable[data-dir="asc"] .indicator::after {
                content: "▲";
            }

            th.sortable[data-dir="desc"] .indicator::after {
                content: "▼";
            }

            /* Sticky header container */
            .table-wrap {
                max-height: 70vh;
                overflow: auto;
            }

            thead.sticky th {
                position: sticky;
                top: 0;
                background: rgba(249, 250, 251, .9);
                backdrop-filter: blur(4px);
            }

            /* Compact density toggle */
            .compact td,
            .compact th {
                padding-top: .5rem !important;
                padding-bottom: .5rem !important;
            }
        </style>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <!-- Header -->
            <header class="fade-up">
                <div class="flex items-center gap-3 mb-2">
                    <span class="h-6 w-1.5 bg-red-600 rounded"></span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Administrācijas panelis</h1>
                </div>
                <p class="text-gray-600">Pārvaldi lietotājus, turnīrus un ziņas vienuviet.</p>

                <!-- Flash messages -->
                <div class="mt-4 space-y-3">
                    @foreach (['success' => 'green', 'error' => 'red'] as $type => $color)
                        @if (session($type))
                            <div
                                class="rounded-lg border border-{{ $color }}-200 bg-{{ $color }}-50 text-{{ $color }}-800 px-4 py-3">
                                {{ session($type) }}
                            </div>
                        @endif
                    @endforeach
                </div>
            </header>

            @php
                // Quick stats (safe defaults if models not present)
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

            <!-- Quick Stats -->
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 fade-up">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200 shadow-sm p-5">
                    <div class="text-sm text-gray-600">Lietotāji</div>
                    <div class="mt-1 flex items-baseline gap-2">
                        <div class="text-3xl font-extrabold text-gray-900">{{ $totalUsers }}</div>
                        <span class="text-xs text-gray-500">kopā</span>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200 shadow-sm p-5">
                    <div class="text-sm text-gray-600">Administratori</div>
                    <div class="mt-1 flex items-baseline gap-2">
                        <div class="text-3xl font-extrabold text-gray-900">{{ $adminsCount }}</div>
                        <span class="text-xs text-gray-500">aktīvi</span>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200 shadow-sm p-5">
                    <div class="text-sm text-gray-600">Turnīri</div>
                    <div class="mt-1 flex items-baseline gap-2">
                        <div class="text-3xl font-extrabold text-gray-900">{{ $tournCount ?? '—' }}</div>
                        <span class="text-xs text-gray-500">{{ $tournCount !== null ? 'kopā' : 'nav datu' }}</span>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200 shadow-sm p-5">
                    <div class="text-sm text-gray-600">Ziņas</div>
                    <div class="mt-1 flex items-baseline gap-2">
                        <div class="text-3xl font-extrabold text-gray-900">{{ $newsCount ?? '—' }}</div>
                        <span class="text-xs text-gray-500">{{ $newsCount !== null ? 'kopā' : 'nav datu' }}</span>
                    </div>
                </div>
            </section>

            <!-- Quick Actions -->
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 fade-up">
                @php
                    $cards = [
                        [
                            'route' => 'tournaments.create',
                            'title' => 'Izveidot turnīru',
                            'desc' => 'Ātri izveido jaunu turnīru.',
                        ],
                        [
                            'route' => 'tournaments.index',
                            'title' => 'Pārvaldīt turnīrus',
                            'desc' => 'Labot, sākt/beigt, skatīt progresu.',
                        ],
                        ['route' => 'news.create', 'title' => 'Izveidot ziņu', 'desc' => 'Publicē jaunumus mājaslapā.'],
                        [
                            'route' => 'news.index',
                            'title' => 'Pārvaldīt ziņas',
                            'desc' => 'Labot vai dzēst esošās ziņas.',
                        ],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <a href="{{ route($card['route']) }}"
                        class="block bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200 shadow-sm p-5 hover:shadow-lg hover:border-gray-300 transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $card['title'] }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $card['desc'] }}</p>
                            </div>
                            <span
                                class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-red-600 text-white text-sm">→</span>
                        </div>
                    </a>
                @endforeach
            </section>

            <!-- Users -->
            <section class="space-y-4 fade-up">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h2 class="text-2xl font-extrabold text-gray-900">Lietotāji</h2>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Filters -->
                        <div class="flex items-center gap-2">
                            <button id="filterAll"
                                class="pill border-gray-300 text-gray-700 hover:bg-gray-50">Visi</button>
                            <button id="filterAdmin"
                                class="pill border-red-300 text-red-700 hover:bg-red-50">Admini</button>
                            <button id="filterUser"
                                class="pill border-gray-300 text-gray-700 hover:bg-gray-50">Lietotāji</button>
                        </div>

                        <!-- Density -->
                        <button id="toggleDensity" class="pill border-gray-300 text-gray-700 hover:bg-gray-50">
                            Kompakts
                        </button>

                        <!-- Export -->
                        <button id="exportCsv"
                            class="inline-flex items-center rounded-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm font-semibold shadow transition">
                            Eksportēt CSV
                        </button>
                    </div>
                </div>

                <!-- Search -->
                <div class="relative">
                    <input id="userSearch" type="text" placeholder="Meklēt lietotājus…"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-gray-900 shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-200">
                    <button id="clearSearch"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-sm text-gray-500 hover:text-gray-700 hidden">Notīrīt</button>
                </div>

                <!-- Table -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200 shadow-md table-wrap">
                    <table id="usersTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 sortable"
                                    data-key="id">
                                    ID <span class="indicator"></span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 sortable"
                                    data-key="name">
                                    Vārds <span class="indicator"></span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 sortable"
                                    data-key="email">
                                    E-pasts <span class="indicator"></span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 sortable"
                                    data-key="role">
                                    Loma <span class="indicator"></span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-sm font-semibold text-gray-700">
                                    Darbības
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr data-role="{{ $user->role }}"
                                    class="{{ auth()->id() === $user->id ? 'bg-yellow-50/70' : 'bg-white' }}">
                                    <td class="px-6 py-4 text-sm text-gray-900" data-id>{{ $user->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900" data-name>
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">
                                                {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                            </span>
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900" data-email>
                                        <button type="button" class="copy-email hover:underline"
                                            data-addr="{{ $user->email }}" title="Kopēt e-pastu">
                                            {{ $user->email }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900" data-role>
                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('PATCH')

                                                <select name="role" onchange="this.form.submit()"
                                                    class="rounded border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-900
               focus:border-red-500 focus:ring-1 focus:ring-red-200">
                                                    <option value="user"
                                                        {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                    <option value="admin"
                                                        {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </form>
                                        @else
                                            <span
                                                class="role-badge {{ $user->role }}">{{ ucfirst($user->role) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Vai tiešām dzēst šo lietotāju?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-md bg-red-600 px-4 py-2 text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                    Dzēst
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer line: counts -->
                <div class="text-sm text-gray-600" id="tableInfo">
                    Rādīti <span id="shownCount">{{ $users->count() }}</span> no {{ $users->count() }}
                </div>
            </section>
        </div>
    </div>

    <script>
        // Page-load animation
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');
        });

        // Helpers
        const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
        const $ = (sel, ctx = document) => ctx.querySelector(sel);

        // Search + filters + info
        const searchInput = $('#userSearch');
        const clearSearch = $('#clearSearch');
        const table = $('#usersTable');
        const tbody = table.tBodies[0];
        const rows = $$('tbody tr', table);
        const infoShown = $('#shownCount');
        const totalCount = rows.length;
        const filterBtns = {
            all: $('#filterAll'),
            admin: $('#filterAdmin'),
            user: $('#filterUser')
        };
        let activeRoleFilter = 'all';
        let compactOn = false;

        function updateTableVisibility() {
            const q = (searchInput.value || '').trim().toLowerCase();
            let shown = 0;

            rows.forEach(row => {
                const role = row.getAttribute('data-role');
                const text = row.innerText.toLowerCase();
                const matchRole = (activeRoleFilter === 'all') || (role === activeRoleFilter);
                const matchText = q === '' || text.includes(q);

                const show = matchRole && matchText;
                row.style.display = show ? '' : 'none';
                if (show) shown++;
            });

            infoShown.textContent = shown;
            clearSearch.classList.toggle('hidden', !q);
        }

        function setRoleFilter(which) {
            activeRoleFilter = which;
            Object.entries(filterBtns).forEach(([k, btn]) => {
                if (k === which) {
                    btn.classList.add('border-red-300', 'text-red-700', 'bg-red-50');
                    btn.classList.remove('border-gray-300', 'text-gray-700');
                } else {
                    btn.classList.remove('border-red-300', 'text-red-700', 'bg-red-50');
                    btn.classList.add('border-gray-300', 'text-gray-700');
                }
            });
            updateTableVisibility();
        }

        filterBtns.all.addEventListener('click', () => setRoleFilter('all'));
        filterBtns.admin.addEventListener('click', () => setRoleFilter('admin'));
        filterBtns.user.addEventListener('click', () => setRoleFilter('user'));

        // Debounced search
        let t;
        searchInput.addEventListener('input', () => {
            clearTimeout(t);
            t = setTimeout(updateTableVisibility, 120);
        });
        clearSearch.addEventListener('click', () => {
            searchInput.value = '';
            updateTableVisibility();
        });

        // Copy email to clipboard
        tbody.addEventListener('click', (e) => {
            const btn = e.target.closest('.copy-email');
            if (!btn) return;
            const email = btn.dataset.addr;
            navigator.clipboard?.writeText(email).then(() => {
                const old = btn.textContent;
                btn.textContent = 'Nokopēts!';
                setTimeout(() => btn.textContent = old, 900);
            });
        });

        // Column sorting
        const headers = $$('thead th.sortable', table);
        let sortState = {
            key: null,
            dir: 'asc'
        };

        function getCellValue(row, key) {
            switch (key) {
                case 'id':
                    return parseInt(row.querySelector('[data-id]').textContent.trim(), 10) || 0;
                case 'name':
                    return row.querySelector('[data-name]').innerText.toLowerCase();
                case 'email':
                    return row.querySelector('[data-email]').innerText.toLowerCase();
                case 'role':
                    return row.getAttribute('data-role') || '';
                default:
                    return row.innerText.toLowerCase();
            }
        }

        function sortBy(key) {
            // toggle dir
            sortState.dir = (sortState.key === key && sortState.dir === 'asc') ? 'desc' : 'asc';
            sortState.key = key;

            // visual indicators
            headers.forEach(h => h.removeAttribute('data-dir'));
            const activeHeader = headers.find(h => h.dataset.key === key);
            if (activeHeader) activeHeader.setAttribute('data-dir', sortState.dir);

            const visible = rows.filter(r => r.style.display !== 'none');
            const hidden = rows.filter(r => r.style.display === 'none');

            visible.sort((a, b) => {
                const va = getCellValue(a, key);
                const vb = getCellValue(b, key);
                if (va < vb) return sortState.dir === 'asc' ? -1 : 1;
                if (va > vb) return sortState.dir === 'asc' ? 1 : -1;
                return 0;
            });

            // re-append
            visible.forEach(r => tbody.appendChild(r));
            hidden.forEach(r => tbody.appendChild(r));
        }

        headers.forEach(h => h.addEventListener('click', () => sortBy(h.dataset.key)));

        // Export CSV
        $('#exportCsv').addEventListener('click', () => {
            const data = [
                ['ID', 'Vārds', 'E-pasts', 'Loma']
            ];
            $$('tbody tr', table).forEach(tr => {
                if (tr.style.display === 'none') return; // export only visible
                const id = tr.querySelector('[data-id]').textContent.trim();
                const name = tr.querySelector('[data-name]').innerText.trim();
                const email = tr.querySelector('[data-email]').innerText.trim();
                const role = tr.getAttribute('data-role');
                data.push([id, name, email, role]);
            });
            const csv = data.map(r => r.map(v => `"${String(v).replace(/"/g,'""')}"`).join(',')).join('\n');
            const blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'lietotaji.csv';
            document.body.appendChild(a);
            a.click();
            a.remove();
            URL.revokeObjectURL(url);
        });

        // Density toggle
        $('#toggleDensity').addEventListener('click', (e) => {
            compactOn = !compactOn;
            if (compactOn) {
                table.classList.add('compact');
                e.currentTarget.classList.add('bg-gray-50');
            } else {
                table.classList.remove('compact');
                e.currentTarget.classList.remove('bg-gray-50');
            }
        });

        // Initial state
        setRoleFilter('all');
        updateTableVisibility();
    </script>
</x-app-layout>
