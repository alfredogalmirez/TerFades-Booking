<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index(){
        $today = Carbon::today();

        $nowServing = Booking::with('service')
        ->whereDate('scheduled_at', $today)
        ->where('status', 'in_progress')
        ->orderBy('queue_no')
        ->first();

        $nextUp = Booking::with('service')
        ->whereDate('scheduled_at', $today)
        ->where('status', 'confirmed')
        ->whereNotNull('queue_no')
        ->orderBy('queue_no')
        ->limit(5)
        ->get();

        return view('queue', compact('nowServing', 'nextUp'));
    }
}
