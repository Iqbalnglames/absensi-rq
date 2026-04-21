@extends('layouts.app')

@section('content')
    <a href="{{ route('kepegawaian.users.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali ke daftar user
    </a>
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 text-blue-700 p-3 rounded mb-4">
            {{ session('info') }}
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white p-6 rounded-xl shadow max-w-lg mx-auto">

        <h2 class="text-xl font-semibold mb-6">Tambah User</h2>

        <form action="{{ route('kepegawaian.users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm">Nama</label>
                <input type="text" name="name" class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="text-sm">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="text-sm">Username</label>
                <input type="text" name="username" class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="text-sm">Password</label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Simpan
            </button>
        </form>

    </div>

@endsection