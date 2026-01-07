<x-layout title="Track Booking">
@php
    $colors = [
        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
        'done' => 'bg-green-100 text-green-800 border-green-200',
        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
    ];
@endphp

<div class="bg-white shadow rounded-2xl border p-6">
    <h1 class="text-2xl font-bold text-gray-900">Track Your Booking</h1>
    <p class="text-gray-600 mt-2">Enter the phone number you used when booking.</p>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/track" class="mt-5 flex flex-col sm:flex-row gap-3">
        @csrf
        <input
            type="text"
            name="phone"
            value="{{ old('phone', $phone ?? '') }}"
            placeholder="09xxxxxxxxx"
            class="flex-1 rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900 px-4 py-2"
            required
        >
        <button
            class="rounded-xl bg-gray-900 text-white px-6 py-2.5 font-medium hover:bg-black transition"
            type="submit"
        >
            Search
        </button>
    </form>
</div>

@if(isset($phone))
    <div class="mt-6">
        <h2 class="text-lg font-semibold text-gray-900">
            Results for: <span class="font-bold">{{ $phone }}</span>
        </h2>

        @if(($bookings ?? collect())->isEmpty())
            <div class="mt-3 bg-white border rounded-xl p-5 text-gray-600">
                No bookings found for this phone number.
            </div>
        @else
            <div class="mt-3 space-y-3">
                @foreach($bookings as $booking)
                    <div class="bg-white border rounded-xl p-5 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $booking->service?->name ?? 'Service' }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    Schedule:
                                    {{ \Carbon\Carbon::parse($booking->scheduled_at)->format('M d, Y h:i A') }}
                                </p>
                            </div>

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border
                                {{ $colors[$booking->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>

                        @if($booking->notes)
                            <p class="text-sm text-gray-600 mt-3">
                                Notes: {{ $booking->notes }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endif
</x-layout>
