@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <h1 class="text-xl font-bold text-gray-800">
        Manajemen Kurikulum
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Data Jurnal -->
        <a href="{{ route('kurikulum.jurnal') }}"
           class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="font-semibold text-lg">Data Jurnal</h2>
            <p class="text-sm text-gray-500">Kelola Jurnal Kelas</p>
        </a>

        <!-- Data Kelas -->
        <a href="{{ route('kurikulum.kelas') }}"
           class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="font-semibold text-lg">Data Kelas dan Wali Kelas</h2>
            <p class="text-sm text-gray-500">Tambah & kelola kelas</p>
        </a>

        <!-- Data Siswa -->
        <a href="{{ route('kurikulum.siswa') }}"
           class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="font-semibold text-lg">Data Siswa</h2>
            <p class="text-sm text-gray-500">Tambah & tentukan kelas siswa</p>
        </a>

        <!-- Mapel Guru -->
        <a href="{{ route('kurikulum.mapel-guru') }}"
           class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="font-semibold text-lg">Mapel & Guru</h2>
            <p class="text-sm text-gray-500">Tentukan mapel yang diajar guru</p>
        </a>

        <!-- Jadwal Mengajar -->
        <a href="{{ route('kurikulum.jadwal') }}"
           class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="font-semibold text-lg">Jadwal Mengajar</h2>
            <p class="text-sm text-gray-500">Atur jadwal guru</p>
        </a>

    </div>
</div>
@endsection
