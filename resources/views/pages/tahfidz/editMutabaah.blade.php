@extends('layouts.app')

@section('content')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <a href="{{ route('tahfidz.halaqah-data') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali ke Menu Mutabaah
    </a>
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Edit Mutabaah</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('tahfidz.mutabaah.update', [$mutabaah->id, $murid->id]) }}" method="POST"
            class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal</label>
                <input name="tanggal" type="date" value="{{ $mutabaah->tanggal }}" class="w-full border rounded-lg px-3 py-2"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nama Surat</label>
                <input type="text" value="{{$mutabaah->nama_surat }}" class="w-full border rounded-lg px-3 py-2" name="nama_surat">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Ayat Awal</label>
                <input type="number" value="{{ $mutabaah->ayat_awal }}" class="w-full border rounded-lg px-3 py-2" name="ayat_awal">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Ayat Akhir</label>
                <input type="number" value="{{ $mutabaah->ayat_akhir }}" class="w-full border rounded-lg px-3 py-2" name="ayat_akhir">
            </div>


            <div class="flex justify-end gap-3 pt-4">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan Halaqah
                </button>
            </div>

        </form>

    </div>
@endsection