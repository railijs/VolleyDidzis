<x-app-layout>
    <div class="max-w-7xl mx-auto mt-28 px-4 sm:px-6 lg:px-8">
        <h1 class="mb-6 text-3xl font-bold">Admin Panel – Dashboard</h1>

        {{-- Success/Error Messages --}}
        @foreach (['success' => 'green', 'error' => 'red'] as $type => $color)
            @if (session($type))
                <div class="mb-6 rounded border-l-4 border-{{ $color }}-500 bg-{{ $color }}-100 p-4 text-{{ $color }}-800"
                    role="alert">
                    {{ session($type) }}
                </div>
            @endif
        @endforeach

        {{-- Dashboard Cards --}}
        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $cards = [
                    [
                        'route' => 'tournaments.create',
                        'title' => 'Create Tournament',
                        'desc' => 'Set up a new tournament and define teams, rules, and dates.',
                    ],
                    [
                        'route' => 'tournaments.index',
                        'title' => 'Manage Tournaments',
                        'desc' => 'Edit, start/stop, or view tournament progress.',
                    ],
                    ['route' => 'news.create', 'title' => 'Create News', 'desc' => 'Post news updates to the website.'],
                    [
                        'route' => 'news.index',
                        'title' => 'Manage News',
                        'desc' => 'Edit or delete existing news posts.',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <a href="{{ route($card['route']) }}"
                    class="block rounded-lg bg-white p-6 shadow transition hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <h2 class="mb-2 text-xl font-semibold">{{ $card['title'] }}</h2>
                    <p class="text-gray-600">{{ $card['desc'] }}</p>
                </a>
            @endforeach
        </div>

        {{-- Users Table --}}
        <h2 class="mb-4 text-2xl font-semibold">Users</h2>

        {{-- Search --}}
        <input type="text" placeholder="Search users..."
            class="mb-4 w-full rounded-md border px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
            oninput="filterUsers(this.value)" aria-label="Search users">

        <div class="overflow-x-auto rounded-lg bg-white shadow-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach (['ID', 'Name', 'Email', 'Role', 'Actions'] as $header)
                            <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="{{ auth()->id() === $user->id ? 'bg-yellow-50' : '' }}">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if (auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()"
                                            class="rounded border px-2 py-1 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User
                                            </option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                                Admin</option>
                                        </select>
                                    </form>
                                @else
                                    <span class="text-gray-400">{{ ucfirst($user->role) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                @if (auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-md bg-red-600 px-4 py-2 text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterUsers(query) {
            const lowerQuery = query.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(lowerQuery) ? '' : 'none';
            });
        }
    </script>
</x-app-layout>
