@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Tambah Ekskul</h1>
        <form action="{{ route('kesantrian.ekskul.update', $ekskul->id) }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1">Nama Ekskul</label>
                <input type="text" class="w-full border rounded-lg px-3 py-2" value="{{ $ekskul->nama_ekskul }}" name="nama_ekskul">
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kesantrian.ekskul') }}" class="px-4 py-2 border rounded-lg">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan Ekskul
                </button>
            </div>

        </form>

    </div>
@endsection
