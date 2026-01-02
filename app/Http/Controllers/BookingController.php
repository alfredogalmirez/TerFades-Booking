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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'date' => ['required', 'date_format:Y-m-d'],
            'time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000']
        ]);

        $scheduled = Carbon::createFromFormat('Y-m-d H:i', $validated['date'] . ' ' . $validated['time']);
        $validated['scheduled_at'] = $scheduled->format('Y-m-d H:i:s');


        $startTime = $scheduled->copy()->setTime(9, 0);
        $endTime = $scheduled->copy()->setTime(19, 0);

        if ($scheduled->lt($startTime) || $scheduled->gte($endTime)) {
            return back()
                ->withInput()
                ->withErrors([
                    'scheduled_at' => 'Please choose a time between 9:00 AM and 7:00 PM.'
                ]);
        }

        $minutes = (int) $scheduled->format('i');
        if ($minutes % 60 !== 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'scheduled_at' => 'Please choose a time in 1 hour intervals (e.g., 10:00, 11:00).'
                ]);
        }

        $validated['scheduled_at'] = $scheduled->format('Y-m-d H:i:s');

        $alreadyTaken = Booking::where('scheduled_at', $validated['scheduled_at'])->exists();
        if ($alreadyTaken) {
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

    public function trackForm()
    {
        return view('bookings.track');
    }

    public function trackResult(Request $request)
    {
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

    public function availableSlots(Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date_format:Y-m-d'],
            'service_id' => ['required', 'exists:services,id'],
        ]);

        $service = Service::findorFail($data['service_id']);
        $durationMinutes = (int) $service->duration_minutes;

        $day = Carbon::createFromFormat('Y-m-d', $data['date']);
        $start = $day->copy()->setTime(9, 0);
        $end = $day->copy()->setTime(19, 0);

        $interval = 60;

        $bookings = Booking::with('service')
            ->whereDate('scheduled_at', $data['date'])
            ->get()
            ->map(function ($b) {
                $bStart = Carbon::parse($b->scheduled_at);
                $bEnd = $bStart->copy()->addMinutes((int) ($b->service?->duration_minutes ?? 30));
                return [
                    'start' => $bStart,
                    'end' => $bEnd,
                    'status' => $b->status,
                ];
            });

        $lastStart = $end->copy()->subMinutes($durationMinutes);

        $slots = [];
        $cursor = $start->copy();

        while ($cursor->lte($lastStart)) {
            $slotStart = $cursor->copy();
            $slotEnd = $slotStart->copy()->addMinutes($durationMinutes);

            if ($slotStart->lt(now())) {
                $cursor->addMinutes($interval);
                continue;
            }

            $overlaps = $bookings->contains(function ($b) use ($slotStart, $slotEnd) {
                if (($b['status'] ?? '') === 'cancelled') return false;

                return $slotStart->lt($b['end']) && $slotEnd->gt($b['start']);
            });

            if (!$overlaps) {
                $slots[] = [
                    'value' => $slotStart->format('H:i'),
                    'label' => $slotStart->format('g:i A'),
                ];
            }

            $cursor->addMinutes($interval);
        }

        return response()->json($slots);
    }
}
