<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

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
            'status' => ['required', 'in:pending,confirmed,in_progress,done,cancelled'],
        ]);

        $newStatus = $validated['status'];

        if($newStatus === 'confirmed' && is_null($booking->queue_no)){
            $date = Carbon::parse($booking->scheduled_at)->toDateString();

            $maxQueue = Booking::whereDate('scheduled_at', $date)
            ->whereNotNull('queue_no')
            ->max('queue_no');

            $booking->queue_no = ($maxQueue ?? 0) + 1;
        }

        $booking->status = $newStatus;
        $booking->save();

        return back()->with('success', 'Booking status updated.');
    }
}
