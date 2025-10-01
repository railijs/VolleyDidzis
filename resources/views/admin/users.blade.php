<x-app-layout>
    <div class="relative min-h-screen pt-28 pb-16 bg-gradient-to-b from-white via-red-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <!-- Header -->
            <header class="fade-up opacity-0 translate-y-3 transition duration-500 ease-out">
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
                                class="rounded-lg border px-4 py-3
                          border-{{ $color }}-200 bg-{{ $color }}-50 text-{{ $color }}-800">
                                {{ session($type) }}
                            </div>
                        @endif
                    @endforeach
                </div>
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

            <!-- Quick Stats -->
            <section
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 fade-up opacity-0 translate-y-3 transition duration-500 ease-out">
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
            <section
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 fade-up opacity-0 translate-y-3 transition duration-500 ease-out">
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
                        class="block bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200 shadow-sm p-5
                    hover:shadow-lg hover:border-gray-300 transition">
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
            <section class="space-y-4 fade-up opacity-0 translate-y-3 transition duration-500 ease-out">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h2 class="text-2xl font-extrabold text-gray-900">Lietotāji</h2>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Filters -->
                        <div class="flex items-center gap-2">
                            <button id="filterAll"
                                class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold
                             border-gray-300 text-gray-700 hover:bg-gray-50">
                                Visi
                            </button>
                            <button id="filterAdmin"
                                class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold
                             border-gray-300 text-gray-700 hover:bg-gray-50">
                                Admini
                            </button>
                            <button id="filterUser"
                                class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold
                             border-gray-300 text-gray-700 hover:bg-gray-50">
                                Lietotāji
                            </button>
                        </div>

                        <!-- Density -->
                        <button id="toggleDensity"
                            class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold
                           border-gray-300 text-gray-700 hover:bg-gray-50">
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
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-gray-900 shadow-sm
                        focus:border-red-500 focus:ring-2 focus:ring-red-200">
                    <button id="clearSearch"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-sm text-gray-500 hover:text-gray-700 hidden">
                        Notīrīt
                    </button>
                </div>

                <!-- Table -->
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200 shadow-md max-h-[70vh] overflow-auto">
                    <table id="usersTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/90 backdrop-blur-sm sticky top-0 z-10">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer select-none"
                                    data-key="id">
                                    <span class="align-middle">ID</span>
                                    <span class="indicator ml-2 text-gray-500 text-xs"></span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer select-none"
                                    data-key="name">
                                    <span class="align-middle">Vārds</span>
                                    <span class="indicator ml-2 text-gray-500 text-xs"></span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer select-none"
                                    data-key="email">
                                    <span class="align-middle">E-pasts</span>
                                    <span class="indicator ml-2 text-gray-500 text-xs"></span>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer select-none"
                                    data-key="role">
                                    <span class="align-middle">Loma</span>
                                    <span class="indicator ml-2 text-gray-500 text-xs"></span>
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

                                                <div class="relative inline-block">
                                                    <!-- Uzlabots selects -->
                                                    <select name="role" onchange="this.form.submit()"
                                                        aria-label="Mainīt {{ $user->name }} lomu"
                                                        class="appearance-none pr-10 pl-3 py-2 text-sm leading-tight rounded-lg bg-white border border-gray-300 shadow-sm
                 focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-500
                 hover:border-gray-400 transition">
                                                        <option value="user" @selected($user->role === 'user')>User
                                                        </option>
                                                        <option value="admin" @selected($user->role === 'admin')>Admin
                                                        </option>
                                                    </select>

                                                    <!-- Chevron ikona (neklikšķināma) -->

                                                </div>
                                            </form>
                                        @else
                                            <span
                                                class="{{ $user->role === 'admin'
                                                    ? 'inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold bg-red-100 text-red-700'
                                                    : 'inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-semibold bg-gray-100 text-gray-700' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Vai tiešām dzēst šo lietotāju?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-md bg-red-600 px-4 py-2 text-white transition hover:bg-red-700
                                       focus:outline-none focus:ring-2 focus:ring-red-500">
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
        // Page-load reveal (no CSS <style>): remove opacity/translate classes
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.fade-up').forEach((el, i) => {
                // neliels “stagger”
                const delay = 80 * i;
                setTimeout(() => {
                    el.classList.remove('opacity-0', 'translate-y-3');
                }, delay);
            });
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
        const filterBtns = {
            all: $('#filterAll'),
            admin: $('#filterAdmin'),
            user: $('#filterUser')
        };
        let activeRoleFilter = 'all';

        function updateTableVisibility() {
            const q = (searchInput?.value || '').trim().toLowerCase();
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

            if (infoShown) infoShown.textContent = shown;
            if (clearSearch) clearSearch.classList.toggle('hidden', !q);
        }

        function setRoleFilter(which) {
            activeRoleFilter = which;
            Object.entries(filterBtns).forEach(([k, btn]) => {
                if (!btn) return;
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

        if (filterBtns.all) filterBtns.all.addEventListener('click', () => setRoleFilter('all'));
        if (filterBtns.admin) filterBtns.admin.addEventListener('click', () => setRoleFilter('admin'));
        if (filterBtns.user) filterBtns.user.addEventListener('click', () => setRoleFilter('user'));

        // Debounced search
        let t;
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                clearTimeout(t);
                t = setTimeout(updateTableVisibility, 120);
            });
        }
        if (clearSearch) {
            clearSearch.addEventListener('click', () => {
                searchInput.value = '';
                updateTableVisibility();
            });
        }

        // Copy email to clipboard
        if (tbody) {
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
        }

        // Column sorting (with inline indicator spans)
        const headers = $$('thead th[data-key]', table);
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
            sortState.dir = (sortState.key === key && sortState.dir === 'asc') ? 'desc' : 'asc';
            sortState.key = key;

            headers.forEach(h => {
                const ind = h.querySelector('.indicator');
                if (ind) ind.textContent = '';
            });
            const activeHeader = headers.find(h => h.dataset.key === key);
            if (activeHeader) {
                const ind = activeHeader.querySelector('.indicator');
                if (ind) ind.textContent = sortState.dir === 'asc' ? '▲' : '▼';
            }

            const visible = rows.filter(r => r.style.display !== 'none');
            const hidden = rows.filter(r => r.style.display === 'none');

            visible.sort((a, b) => {
                const va = getCellValue(a, key);
                const vb = getCellValue(b, key);
                if (va < vb) return sortState.dir === 'asc' ? -1 : 1;
                if (va > vb) return sortState.dir === 'asc' ? 1 : -1;
                return 0;
            });

            visible.forEach(r => tbody.appendChild(r));
            hidden.forEach(r => tbody.appendChild(r));
        }

        headers.forEach(h => h.addEventListener('click', () => sortBy(h.dataset.key)));

        // Export CSV (only visible rows)
        const exportBtn = $('#exportCsv');
        if (exportBtn) {
            exportBtn.addEventListener('click', () => {
                const data = [
                    ['ID', 'Vārds', 'E-pasts', 'Loma']
                ];
                $$('#usersTable tbody tr').forEach(tr => {
                    if (tr.style.display === 'none') return;
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
        }

        // Density toggle (bez CSS selektoriem: mainām py-* klasēs visiem th/td)
        const toggleDensity = $('#toggleDensity');
        let compactOn = false;

        function setDensity(compact) {
            const ths = $$('thead th', table);
            const tds = $$('tbody td', table);

            const applyPad = (els, normal, compactCls) => {
                els.forEach(el => {
                    el.classList.remove(normal, compactCls);
                    el.classList.add(compact ? compactCls : normal);
                });
            };

            applyPad(ths, 'py-3', 'py-2');
            applyPad(tds, 'py-4', 'py-2');
        }

        if (toggleDensity) {
            toggleDensity.addEventListener('click', (e) => {
                compactOn = !compactOn;
                setDensity(compactOn);
                e.currentTarget.classList.toggle('bg-gray-50', compactOn);
            });
        }

        // Initial state
        setRoleFilter('all');
        updateTableVisibility();
        setDensity(false); // default spacing
    </script>
</x-app-layout>
