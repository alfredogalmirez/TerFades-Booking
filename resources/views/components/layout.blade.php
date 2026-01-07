<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Haircut Booking System' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@php
    use Illuminate\Support\Facades\Auth;
@endphp

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gray-900 text-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ Auth::check() && Auth::user()->is_admin ? '/admin/bookings' : '/' }}"
                class="text-xl font-bold tracking-wide">
                Ter Fades
            </a>
            <div class="space-x-6 text-sm">
                @if (Auth::check() && Auth::user()->is_admin)
                    <a href="/admin/bookings" class="hover:text-gray-300">Booking List</a>
                    <a href="/admin/services" class="hover:text-gray-300">Services</a>

                    <form action="/admin/logout" method="POST" class="inline">
                        @csrf
                        <button>Log out</button>
                    </form>
                @else
                    <a href="/" class="hover:text-gray-300">Home</a>
                    <a href="/book" class="hover:text-gray-300">Book Now</a>
                    <a href="/queue" class="hover:text-gray-300">Queue</a>
                    <a href="/track" class="hover:text-gray-300">Track Booking</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="flex-1">
        <div class="max-w-3xl mx-auto px-6 py-10">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 text-center text-xs py-4">
        © {{ date('Y') }} Ter Fades. All rights reserved.
    </footer>

</body>

</html>
