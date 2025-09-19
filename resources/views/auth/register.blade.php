<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - VolleyLV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Floating label style */
        .floating-input {
            position: relative;
        }
        .floating-input input:focus + label,
        .floating-input input:not(:placeholder-shown) + label {
            transform: translateY(-1.25rem) scale(0.85);
            color: #6366F1; /* Indigo-500 */
        }
        .floating-input label {
            position: absolute;
            left: 0.75rem;
            top: 0.75rem;
            color: #6B7280; /* Gray-500 */
            pointer-events: none;
            transition: all 0.2s ease;
            background: white;
            padding: 0 0.25rem;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50">

    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-xl space-y-6">
        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV Logo" class="w-20 h-20 object-contain">
        </div>

        <h1 class="text-2xl font-bold text-gray-900 text-center">Create an Account</h1>
        <p class="text-sm text-gray-600 text-center">Join VolleyLV to track tournaments and volleyball news!</p>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-md">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div class="floating-input">
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder=" " required autofocus
                    class="block w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <label for="name">Name</label>
            </div>

            <!-- Email -->
            <div class="floating-input">
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder=" " required
                    class="block w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <label for="email">Email</label>
            </div>

            <!-- Password -->
            <div class="floating-input">
                <input id="password" type="password" name="password" placeholder=" " required
                    class="block w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <label for="password">Password</label>
            </div>

            <!-- Confirm Password -->
            <div class="floating-input">
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder=" " required
                    class="block w-full border border-gray-300 rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <label for="password_confirmation">Confirm Password</label>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900 underline mb-3 sm:mb-0">
                    Already registered?
                </a>

                <button type="submit"
                        class="w-full sm:w-auto px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                    Register
                </button>
            </div>
        </form>
    </div>

</body>
</html>
