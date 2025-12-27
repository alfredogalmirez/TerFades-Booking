<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

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

}
