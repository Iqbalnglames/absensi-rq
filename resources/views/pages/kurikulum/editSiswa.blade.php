@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Edit data Santri</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
            @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('kurikulum.siswa.update', $siswa->id) }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1">NIS</label>
                <input type="text" value="{{ $siswa->nis }}" class="w-full border rounded-lg px-3 py-2" name="nis">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Nama Santri</label>
                <input type="text" value="{{ $siswa->nama }}" class="w-full border rounded-lg px-3 py-2" name="nama">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Alamat</label>
                <input type="text" value="{{ $siswa->alamat }}" class="w-full border rounded-lg px-3 py-2" name="alamat">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Kelas</label>
                <select name="kelas_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $k->id == $siswa->kelas_id ? 'selected' : '' }}>Kelas {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kurikulum.siswa') }}" class="px-4 py-2 border rounded-lg">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Update data Santri
                </button>
            </div>

        </form>

    </div>
@endsection
