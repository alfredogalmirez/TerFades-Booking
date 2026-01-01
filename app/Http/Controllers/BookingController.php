<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create()
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();
        return view('bookings.create', compact('services'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'scheduled_at' => ['required', 'date', 'after:now'],
            'notes' => ['nullable', 'string', 'max:1000']
        ]);

        $scheduled = Carbon::parse($validated['scheduled_at']);

        $startTime = $scheduled->copy()->setTime(9, 0);
        $endTime = $scheduled->copy()->setTime(19, 0);

        if($scheduled->lt($startTime) || $scheduled->gte($endTime)) {
            return back()
            ->withInput()
            ->withErrors([
                'scheduled_at' => 'Please choose a time between 9:00 AM and 7:00 PM.'
            ]);
        }

        $minutes = (int) $scheduled->format('i');
        if($minutes % 60 !== 0){
            return back()
            ->withInput()
            ->withErrors([
                'scheduled_at' => 'Please choose a time in 1 hour intervals (e.g., 10:00, 11:00).'
            ]);
        }

        $validated['scheduled_at'] = $scheduled->format('Y-m-d H:i:s');

        $alreadyTaken = Booking::where('scheduled_at', $validated['scheduled_at'])->exists();
        if($alreadyTaken){
            return back()
                ->withInput()
                ->withErrors(['scheduled_at' => 'This time is already booked. Please choose another time.']);
        }

        Booking::create([
            'service_id' => $validated['service_id'],
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],
            'scheduled_at' => $validated['scheduled_at'],
            'notes' => $validated['notes'],
            'status' => 'pending'
        ]);

        return redirect('/book')->with('success', 'Booking submitted! Please wait for cofirmation.');
    }

    public function trackForm() {
        return view('bookings.track');
    }

    public function trackResult(Request $request) {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $bookings = Booking::with('service')
        ->where('phone', $data['phone'])
        ->orderBy('scheduled_at', 'desc')
        ->get();

        return view('bookings.track', [
            'phone' => $data['phone'],
            'bookings' => $bookings,
        ]);
    }
}
