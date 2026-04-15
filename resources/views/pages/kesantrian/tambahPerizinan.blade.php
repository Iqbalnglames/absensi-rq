@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Tambah Perizinan Santri</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
            @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('kesantrian.perizinan.store') }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Nama Santri</label>
                <select id="jenjang" name="murid_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">--nama santri--</option>
                    <input name="jenis_pelanggaran" class="w-full border rounded-lg px-3 py-2" required>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nama Jenis Pelanggaran</label>
                <input name="jenis_pelanggaran" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Poin</label>
                <input name="poin" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kesantrian.perizinan') }}" class="px-4 py-2 border rounded-lg">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan Data Jenis Pelanggaran
                </button>
            </div>

        </form>

    </div>
@endsection
