@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Tambah Jam Pelajaran</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
            @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('kurikulum.jadwal.store-jam-pelajaran') }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Jenjang</label>
                <select name="jenjang_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Jenjang</option>
                    @foreach($jenjang as $j)
                        <option value="{{ $j->id }}">{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jam Ke</label>
                <input type="text" class="w-full border rounded-lg px-3 py-2" name="jam_ke">
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Waktu Mulai</label>
                <input type="time" class="w-full border rounded-lg px-3 py-2" name="jam_mulai">
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Waktu selesai</label>
                <input type="time" class="w-full border rounded-lg px-3 py-2" name="jam_selesai">
            </div>


            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kurikulum.jadwal') }}" class="px-4 py-2 border rounded-lg">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan Jam Pelajaran
                </button>
            </div>

        </form>

    </div>
@endsection