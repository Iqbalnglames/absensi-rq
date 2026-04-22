@extends('layouts.app')

@section('content')
<a href="{{ route('kepegawaian.izin-user') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali ke menu izin
    </a>
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Ajukan Izin</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('kepegawaian.izin-user.store') }}" method="POST"
            class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Mulai Izin</label>
                <input name="tanggal_mulai" type="date" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Selesai Izin</label>
                <input name="tanggal_selesai" type="date" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Alasan</label>
                <textarea name="alasan" class="w-full border rounded-lg px-3 py-2 h-40"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Ajukan Perizinan
                </button>
            </div>
        </form>
    </div>
@endsection