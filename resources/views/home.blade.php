@extends('layouts.app')

@section('title', 'Ter Fades')

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="bg-white border shadow rounded-2xl p-8">
    <div class="text-center">
        <h1 class="text-4xl font-extrabold text-gray-900">Ter Fades</h1>
        <p class="text-gray-600 mt-3 max-w-xl mx-auto">
            Simple haircut booking for customers, and easy schedule management for the barber.
        </p>

        <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="/book"
                   class="inline-flex justify-center rounded-xl bg-gray-900 text-white px-6 py-3 font-medium hover:bg-black transition">
                    Book an Appointment
                </a>
        </div>
    </div>

    <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-xl border p-5">
            <p class="text-sm text-gray-500">Step 1</p>
            <h3 class="font-semibold text-gray-900 mt-1">Choose a service</h3>
            <p class="text-sm text-gray-600 mt-2">Pick what you need—haircut, trim, or package.</p>
        </div>
        <div class="rounded-xl border p-5">
            <p class="text-sm text-gray-500">Step 2</p>
            <h3 class="font-semibold text-gray-900 mt-1">Select your time</h3>
            <p class="text-sm text-gray-600 mt-2">Choose a valid schedule within business hours.</p>
        </div>
        <div class="rounded-xl border p-5">
            <p class="text-sm text-gray-500">Step 3</p>
            <h3 class="font-semibold text-gray-900 mt-1">Wait for confirmation</h3>
            <p class="text-sm text-gray-600 mt-2">The barber confirms your booking in the dashboard.</p>
        </div>
    </div>
</div>

<div class="mt-8">
    <div class="flex items-center justify-between mb-3">
        <h2 class="text-xl font-bold text-gray-900">Services</h2>
        @if (!Auth::check() || !Auth::user()->is_admin)
            <a href="/book" class="text-sm text-gray-700 hover:text-black">Book now →</a>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @forelse ($services as $service)
            <div class="bg-white border rounded-xl p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $service->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">{{ $service->duration_minutes }} minutes</p>
                    </div>

                    @if (!is_null($service->price))
                        <span class="text-sm font-semibold text-gray-900">
                            ₱{{ number_format($service->price, 2) }}
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white border rounded-xl p-5 text-gray-600">
                No services yet. Add services first.
            </div>
        @endforelse
    </div>
</div>
@endsection
