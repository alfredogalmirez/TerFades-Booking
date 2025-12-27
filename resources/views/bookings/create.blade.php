<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Haircut</title>
</head>
<body style="font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto;">

    <h1>Haircut Booking</h1>

    @if (session('success'))
        <div style="padding: 10px; background: #d1fae5; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="padding: 10px; background: #fee2e2; margin-bottom: 15px;">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/book">
        @csrf

        <div style="margin-bottom: 12px;">
            <label>Service</label><br>
            <select name="service_id" required style="width:100%; padding:8px;">
                <option value="">-- Choose a service --</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>
                        {{ $service->name }} ({{ $service->duration_minutes }} mins)
                        @if(!is_null($service->price)) - ₱{{ number_format($service->price, 2) }} @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 12px;">
            <label>Your Name</label><br>
            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom: 12px;">
            <label>Phone Number</label><br>
            <input type="text" name="phone" value="{{ old('phone') }}" required style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom: 12px;">
            <label>Date & Time</label><br>
            <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}" required style="width:100%; padding:8px;">
            <small>Choose a future date/time.</small>
        </div>

        <div style="margin-bottom: 12px;">
            <label>Notes (optional)</label><br>
            <textarea name="notes" rows="4" style="width:100%; padding:8px;">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" style="padding:10px 14px; cursor:pointer;">
            Submit Booking
        </button>
    </form>

</body>
</html>
