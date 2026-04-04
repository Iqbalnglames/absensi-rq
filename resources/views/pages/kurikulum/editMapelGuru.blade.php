@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Edit Mapel Ajar</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('kurikulum.mapel-guru.update', $editGuruMapel->id) }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-sm font-medium mb-1">Guru</label>
                <select name="user_id" id="guruSelect" class="w-full border rounded-lg px-3 py-2" readonly>
                    <option value="{{ $editGuruMapel->guru->id }}">{{ $editGuruMapel->guru->name }}</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kelas</label>
                <select name="kelas_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $k->id == $editGuruMapel->kelas->id ? 'selected' : '' }}>Kelas {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Mata Pelajaran</label>
                <div class="space-y-4">
                    <select name="mapel_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Mapel</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}" {{ $mapel->id == $editGuruMapel->mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kurikulum.mapel-guru') }}" class="px-4 py-2 border rounded-lg">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Update Mapel Ajar
                </button>
            </div>

        </form>

    </div>
@endsection
