<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ienākt - VolleyLV</title>
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

        <h1 class="text-2xl font-bold text-gray-900 text-center">Laipni lūdzam atpakaļ</h1>
        <p class="text-sm text-gray-600 text-center">Ienāc, lai sekotu saviem turnīriem un spēlēm!</p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-md">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded-md text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- E-pasts -->
            <div class="floating-input">
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder=" " required
                    autofocus
                    class="block w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600">
                <label for="email">E-pasts</label>
            </div>

            <!-- Parole -->
            <div class="floating-input">
                <input id="password" type="password" name="password" placeholder=" " required
                    class="block w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600">
                <label for="password">Parole</label>
            </div>

            <!-- Atcerēties mani -->
            <div class="flex items-center">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-600">
                    <span class="ml-2 text-sm text-gray-700">Atcerēties mani</span>
                </label>
            </div>

            <!-- Pogas -->
            <div class="flex flex-col space-y-3 mt-4">
                <button type="submit"
                    class="w-full px-6 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                    Ienākt
                </button>

                <div class="flex justify-between text-sm">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-gray-700 hover:text-gray-900 underline">
                            Aizmirsi paroli?
                        </a>
                    @endif

                    <a href="{{ route('register') }}" class="text-red-600 hover:text-red-800 underline">
                        Vai nav konta? Reģistrējies
                    </a>
                </div>
            </div>
        </form>
    </div>

</body>

</html>
