<x-layout title="Create Admin">
    <h1 class="text-2xl font-bold mb-6">Create Admin</h1>

    <form method="POST" action="/admin/users" class="bg-white border rounded-2xl p-6 space-y-4">
        @csrf

        <div>
            <label class="text-sm font-medium">Name</label>
            <input name="name" value="{{ old('name') }}" class="w-full border rounded-xl p-3" />
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Email</label>
            <input name="email" value="{{ old('email') }}" class="w-full border rounded-xl p-3" />
            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Password</label>
            <input type="password" name="password" class="w-full border rounded-xl p-3" />
            @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded-xl p-3" />
        </div>

        <button class="rounded-xl bg-gray-900 text-white px-5 py-3 hover:bg-black">
            Create Admin
        </button>
    </form>
</x-layout>
