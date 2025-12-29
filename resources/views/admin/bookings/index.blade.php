@extends('layouts.app')

@section('title', 'Admin - Bookings')

@section('content')<div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Bookings</h1>
            <p class="text-gray-600 mt-1">Manage customer appointments.</p>
        </div>

        <div class="flex gap-2">
            <a href="/admin/bookings" class="px-3 py-2 rounded-lg border text-sm hover:bg-white">All</a>
            <a href="/admin/bookings?status=pending" class="px-3 py-2 rounded-lg border text-sm hover:bg-white">Pending</a>
            <a href="/admin/bookings?status=confirmed"
                class="px-3 py-2 rounded-lg border text-sm hover:bg-white">Confirmed</a>
            <a href="/admin/bookings?status=done" class="px-3 py-2 rounded-lg border text-sm hover:bg-white">Done</a>
            <a href="/admin/bookings?status=cancelled"
                class="px-3 py-2 rounded-lg border text-sm hover:bg-white">Cancelled</a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-2xl border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-4 py-3">Customer</th>
                        <th class="text-left px-4 py-3">Service</th>
                        <th class="text-left px-4 py-3">Schedule</th>
                        <th class="text-left px-4 py-3">Phone</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Notes</th>
                        <th class="text-left px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $booking->customer_name }}</td>
                            <td class="px-4 py-3">{{ $booking->service?->name }}</td>
                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($booking->scheduled_at)->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-4 py-3">{{ $booking->phone }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-lg text-xs border">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ $booking->notes ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <form method="POST" action="/admin/bookings/{{ $booking->id }}/status" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status" class="rounded-lg border-gray-300 text-sm">
                                        <option value="pending" @selected($booking->status === 'pending')>Pending</option>
                                        <option value="confirmed" @selected($booking->status === 'confirmed')>Confirmed</option>
                                        <option value="done" @selected($booking->status === 'done')>Done</option>
                                        <option value="cancelled" @selected($booking->status === 'cancelled')>Cancelled</option>
                                    </select>

                                    <button class="px-3 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-black">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
