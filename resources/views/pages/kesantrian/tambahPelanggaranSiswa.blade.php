@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Tambah Pelanggaran Santri</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('kesantrian.pelanggaran-siswa.store') }}" method="POST"
            class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Nama Santri</label>
                <select name="murid_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Santri</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->id }}">{{ $s->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jenis Pelanggaran</label>
                <select name="pelanggaran_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">--Pilih Jenis Pelanggaran--</option>
                    @foreach($pelanggaran as $p)
                        <option value="{{ $p->id }}">{{ $p->jenis_pelanggaran }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jenis Pelanggaran</label>
                <textarea name="catatan_pelanggaran" class="w-full border h-96 rounded-lg p-2" required></textarea>
            </div>


            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kesantrian.pelanggaran-siswa') }}" class="px-4 py-2 border rounded-lg">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan Data Pelanggaran
                </button>
            </div>

        </form>

    </div>
@endsection