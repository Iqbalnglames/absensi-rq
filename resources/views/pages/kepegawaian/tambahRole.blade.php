@extends('layouts.app')

@section('content')
<a href="{{ route('kepegawaian.users.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
    ← Kembali ke daftar user
</a>
<div class="max-w-3xl mx-auto bg-white shadow rounded-xl p-6">

    <h2 class="text-2xl font-bold mb-6">Edit Role User</h2>

    {{-- Detail User --}}
    <div class="mb-6 border p-4 rounded-lg bg-gray-50">
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    <form action="{{ route('kepegawaian.users.roles.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h3 class="font-semibold mb-3">Pilih Role:</h3>

        <div class="grid grid-cols-2 gap-4">
            @foreach($roles as $role)
                <label class="flex items-center space-x-2">
                    <input type="checkbox"
                           name="roles[]"
                           value="{{ $role->id }}"
                           class="rounded"
                           {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                    <span>{{ $role->name }}</span>
                </label>
            @endforeach
        </div>

        <div class="mt-6">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Update Role
            </button>
        </div>
    </form>

</div>
@endsection