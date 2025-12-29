<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingAdminController extends Controller
{
    public function index(Request $request) {
        $status = $request->query('status');

        $query = Booking::with('service')->orderBy('scheduled_at', 'asc');

        if($status){
            $query->where('status', $status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'status'));
    }

    public function updateStatus(Request $request, Booking $booking){
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,done,cancelled'],
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Booking status updated.');
    }
}
