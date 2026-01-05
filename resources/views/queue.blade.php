@extends('layouts.app')

@section('title', 'Queue')

@section('content')
<div class="bg-white border rounded-2xl shadow p-8 text-center">
    <h1 class="text-3xl font-extrabold text-gray-900">Now Serving</h1>

    @if($nowServing)
        <div class="mt-6 text-6xl font-black text-gray-900">
            #{{ $nowServing->queue_no }}
        </div>
        <p class="text-lg text-gray-600 mt-2">
            {{ $nowServing->service?->name }}
        </p>
    @else
        <p class="mt-6 text-gray-500 text-lg">No one is being served right now.</p>
    @endif
</div>

<div class="mt-10 bg-white border rounded-2xl shadow p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Up Next</h2>

    @if($nextUp->isEmpty())
        <p class="text-gray-500">No customers waiting.</p>
    @else
        <ul class="space-y-3">
            @foreach($nextUp as $b)
                <li class="flex items-center justify-between border rounded-xl px-4 py-3">
                    <span class="font-semibold text-gray-900">
                        #{{ $b->queue_no }}
                    </span>
                    <span class="text-gray-600 text-sm">
                        {{ $b->service?->name }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
