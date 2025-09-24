<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reģistrācija - VolleyLV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Floating label style */
        .floating-input {
            position: relative;
        }

        .floating-input input:focus+label,
        .floating-input input:not(:placeholder-shown)+label {
            transform: translateY(-1.25rem) scale(0.85);
            color: #dc2626;
            /* Red-600 */
        }

        .floating-input label {
            position: absolute;
            left: 0.75rem;
            top: 0.75rem;
            color: #6B7280;
            /* Gray-500 */
            pointer-events: none;
            transition: all 0.2s ease;
            background: white;
            padding: 0 0.25rem;
        }

        /* Lielvārdes josta abās pusēs */
        body {
            background-color: #f9fafb;
            /* Gray-50 */
            background-image: url("https://druku.lv/wp-content/uploads/2025/07/Lielvardes-josta-17-no-29.png"),
                url("https://druku.lv/wp-content/uploads/2025/07/Lielvardes-josta-17-no-29.png");
            background-repeat: repeat-y, repeat-y;
            background-position: left top, right top;
            background-size: 60px auto, 60px auto;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-xl space-y-6">
        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV Logo" class="w-28 h-28 object-contain">
        </div>

        <h1 class="text-2xl font-bold text-gray-900 text-center">Izveido kontu</h1>
        <p class="text-sm text-gray-600 text-center">Pievienojies VolleyLV un seko līdzi turnīriem un jaunumiem!</p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-md">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Vārds -->
            <div class="floating-input">
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder=" " required
                    autofocus
                    class="block w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600">
                <label for="name">Vārds</label>
            </div>

            <!-- E-pasts -->
            <div class="floating-input">
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder=" " required
                    class="block w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600">
                <label for="email">E-pasts</label>
            </div>

            <!-- Parole -->
            <div class="floating-input">
                <input id="password" type="password" name="password" placeholder=" " required
                    class="block w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600">
                <label for="password">Parole</label>
            </div>

            <!-- Apstiprini paroli -->
            <div class="floating-input">
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder=" " required
                    class="block w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600">
                <label for="password_confirmation">Apstiprini paroli</label>
            </div>

            <!-- Pogas -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900 underline mb-3 sm:mb-0">
                    Jau esi reģistrējies?
                </a>

                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition">
                    Reģistrēties
                </button>
            </div>
        </form>
    </div>

</body>

</html>
