@extends('layouts.app')

@section('content')
 <a href="{{ route('tahfidz.halaqah-data') }}" class="text-sm text-blue-500 mb-4 inline-block">
            ← Kembali ke Menu Halaqah
        </a>
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Edit halaqah</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('tahfidz.halaqah-data.update', $halaqah->id) }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Nama Halaqah</label>
                <input type="text" class="w-full border rounded-lg px-3 py-2" value="{{ $halaqah->nama_halaqah }}" name="nama_halaqah">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Muhafidz</label>
                <select name="user_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Muhafidz</option>
                    @foreach($muhafidz as $m)
                        <option value="{{ $m->id }}" {{ $m->id == $halaqah->user_id ? 'selected': '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan Halaqah
                </button>
            </div>

        </form>

    </div>
@endsection