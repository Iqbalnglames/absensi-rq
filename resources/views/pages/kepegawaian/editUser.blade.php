@extends('layouts.app')

@section('content')
<a href="{{ route('kepegawaian.users.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
    ← Kembali ke daftar user
</a>
<div class="bg-white p-6 rounded-xl shadow max-w-lg">

    <h2 class="text-xl font-semibold mb-6">Edit User</h2>

    <form action="{{ route('kepegawaian.users.update',$user) }}"
          method="POST"
          class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="text-sm">Nama</label>
            <input type="text" name="name"
                   value="{{ $user->name }}"
                   class="w-full border rounded-lg px-3 py-2 mt-1">
        </div>

        <div>
            <label class="text-sm">Username</label>
            <input type="text" value="{{ $user->username }}" name="username"
                   class="w-full border rounded-lg px-3 py-2 mt-1">
        </div>

        <div>
            <label class="text-sm">Email</label>
            <input type="email" name="email"
                   value="{{ $user->email }}"
                   class="w-full border rounded-lg px-3 py-2 mt-1">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            Update
        </button>
    </form>

</div>

@endsection