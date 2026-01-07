<x-layout title="Edit Service">
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Edit Service</h1>
        <p class="text-gray-600 mt-1">Update service details.</p>
    </div>
    <a href="/admin/services" class="px-3 py-2 rounded-lg border text-sm hover:bg-white">Back</a>
</div>

@if ($errors->any())
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white shadow rounded-2xl border p-6">
    <form method="POST" action="/admin/services/{{ $service->id }}" class="space-y-5">
        @csrf
        @method('PATCH')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
            <input name="name" value="{{ old('name', $service->name) }}" required
                   class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900 px-4 py-2">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}" required min="5" max="480"
                       class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900 px-4 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price (optional)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $service->price) }}" min="0"
                       class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900 px-4 py-2">
            </div>
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_active" @checked(old('is_active', $service->is_active))>
            <span class="text-sm text-gray-700">Active (visible to customers)</span>
        </label>

        <div class="flex justify-end">
            <button class="px-6 py-2.5 rounded-xl bg-gray-900 text-white font-medium hover:bg-black">
                Update Service
            </button>
        </div>
    </form>
</div>
</x-layout>
