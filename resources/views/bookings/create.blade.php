<x-layout title="Book a Haircut">
<div class="w-full max-w-2xl">
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-bold text-gray-900">Haircut Booking</h1>
        <p class="text-gray-600 mt-2">Pick a service and choose your preferred time.</p>
    </div>

    <div class="bg-white shadow-lg rounded-2xl p-6 md:p-8 border border-gray-100">

        <x-flash-message type="success" />

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                <p class="font-semibold mb-2">Please fix the following:</p>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/book" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                <select name="service_id" id="service_id" required
                    class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900 px-4 py-2">
                    <option value="" disabled selected hidden>Choose a service</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>
                            {{ $service->name }} ({{ $service->duration_minutes }} mins)
                            @if (!is_null($service->price))
                                - ₱{{ number_format($service->price, 2) }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required
                        placeholder="Juan Dela Cruz"
                        class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900 px-4 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="09xxxxxxxxx"
                        class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900 px-4 py-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="date" id="date" required value="{{ old('date') }}"
                    class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900 px-4 py-2">
                <p class="text-xs text-gray-500 mt-2">Business hours: 9:00 AM–7:00 PM</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Time Slot</label>
                <select name="time" id="time" required
                    class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900 px-4 py-2">
                    <option value="" disabled selected hidden>Select a date first</option>
                </select>
                <p class="text-xs text-gray-500 mt-2">Slots are every 60 minutes</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                <textarea name="notes" rows="4" placeholder="Any special request? (e.g. fade haircut, short sides)"
                    class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900 px-4 py-2">{{ old('notes') }}</textarea>
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="/" class="text-sm text-gray-600 hover:text-gray-900">← Back</a>

                <button type="submit"
                    class="rounded-xl bg-gray-900 text-white px-6 py-2.5 font-medium hover:bg-black transition">
                    Submit Booking
                </button>
            </div>
        </form>

    </div>

    <p class="text-center text-xs text-gray-500 mt-6">
        Your booking will be marked as <span class="font-semibold">pending</span> until confirmed.
    </p>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const serviceEl = document.getElementById('service_id');
            const dateEl = document.getElementById('date');
            const timeEl = document.getElementById('time');

            async function loadSlots() {
                const serviceId = serviceEl.value;
                const date = dateEl.value;

                timeEl.innerHTML = `<option value="">Loading slots...</option>`;

                if (!serviceId || !date) {
                    timeEl.innerHTML = `<option value="" disabled selected hidden>Select service and date</option>`;
                    return;
                }

                try {
                    const res = await fetch(
                        `/slots?service_id=${encodeURIComponent(serviceId)}&date=${encodeURIComponent(date)}`
                    );
                    const slots = await res.json();

                    if (!Array.isArray(slots) || slots.length === 0) {
                        timeEl.innerHTML = `<option value="">No available slots</option>`;
                        return;
                    }

                    timeEl.innerHTML = `<option value="" disabled selected hidden>Choose a time</option>`;
                    for (const s of slots) {
                        const opt = document.createElement('option');
                        opt.value = s.value; // "09:30"
                        opt.textContent = s.label; // "9:30 AM"
                        timeEl.appendChild(opt);
                    }
                } catch (e) {
                    timeEl.innerHTML = `<option value="">Error loading slots</option>`;
                }
            }

            serviceEl.addEventListener('change', loadSlots);
            dateEl.addEventListener('change', loadSlots);

            // If old values exist, attempt to load immediately
            loadSlots();
        });
    </script>
</x-layout>
