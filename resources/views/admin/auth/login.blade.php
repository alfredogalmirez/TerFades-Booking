@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-4">Admin Login</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 p-3 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/admin/login" class="space-y-4">
            @csrf
            <div>
                <label>Email</label>
                <input type="email" name="email" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" required class="w-full border p-2 rounded">
            </div>

            <button class="w-full bg-gray-900 text-white py-2 rounded">
                Login
            </button>
        </form>
    </div>
@endsection
