<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Haircut Booking System')</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-gray-900 text-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Logo --}}
            <a href="/" class="text-xl font-bold tracking-wide">
                💈 Ter Fades
            </a>

            <div class="space-x-6 text-sm">
                <a href="/book" class="hover:text-gray-300">Book
                    Now</a>
                <a href="/admin/bookings" class="hover:text-gray-300">Admin
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-1">
        <div class="max-w-3xl mx-auto px-6 py-10">
            @yield('content')
        </div>
    </main>

    <footer class="bg-gray-300 text-gray-400 text-center text-xs py-4">
        © {{ date('Y') }} Ter Fades. All rights reserved.
    </footer>
</body>

</html>
