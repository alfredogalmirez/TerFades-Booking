@extends('layouts.app')

@section('title', 'Admin - Services')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Services</h1>
        <p class="text-gray-600 mt-1">Manage your haircut services (name, duration, price, active).</p>
    </div>

    <div class="flex items-center gap-2">
        <a href="/admin/services/create" class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-black">
            + Add Service
        </a>
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
                    <th class="text-left px-4 py-3">Name</th>
                    <th class="text-left px-4 py-3">Duration</th>
                    <th class="text-left px-4 py-3">Price</th>
                    <th class="text-left px-4 py-3">Active</th>
                    <th class="text-left px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($services as $service)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $service->name }}</td>
                        <td class="px-4 py-3">{{ $service->duration_minutes }} mins</td>
                        <td class="px-4 py-3">
                            @if(is_null($service->price))
                                —
                            @else
                                ₱{{ number_format($service->price, 2) }}
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($service->is_active)
                                <span class="text-xs px-2 py-1 rounded-full border bg-green-50 text-green-700 border-green-200">Yes</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full border bg-gray-100 text-gray-700 border-gray-200">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 flex items-center gap-2">
                            <a href="/admin/services/{{ $service->id }}/edit"
                               class="px-3 py-2 rounded-lg border text-sm hover:bg-white">
                                Edit
                            </a>

                            <form method="POST" action="/admin/services/{{ $service->id }}"
                                  onsubmit="return confirm('Delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 rounded-lg border text-sm hover:bg-red-50 hover:border-red-200 hover:text-red-700">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                            No services yet. Click “Add Service”.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
