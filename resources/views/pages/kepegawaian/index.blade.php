@extends('layouts.app')

@section('content')

<h2 class="text-xl font-semibold mb-6">Modul Kepegawaian</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Kelola User -->
    <a href="{{ route('kepegawaian.users.index') }}"
       class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-blue-500 text-3xl mb-3">👤</div>
        <h3 class="font-semibold text-lg">Kelola User</h3>
        <p class="text-sm text-gray-500 mt-1">
            Tambah, ubah, dan hapus user dan role user
        </p>
    </a>

    <!-- Jadwal Kerja -->
    <a href="{{ route('kepegawaian.jadwal') }}"
       class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-green-500 text-3xl mb-3">🗓️</div>
        <h3 class="font-semibold text-lg">Jadwal Kerja</h3>
        <p class="text-sm text-gray-500 mt-1">
            Atur jadwal kerja pegawai
        </p>
    </a>

    <!-- Izin -->
    <a href="{{ route('kepegawaian.izin') }}"
       class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-yellow-500 text-3xl mb-3">📄</div>
        <h3 class="font-semibold text-lg">Data Izin</h3>
        <p class="text-sm text-gray-500 mt-1">
            Lihat dan kelola izin pegawai
        </p>
    </a>

    <!-- Performa -->
    <a href="#"
       class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-purple-500 text-3xl mb-3">📊</div>
        <h3 class="font-semibold text-lg">Performa</h3>
        <p class="text-sm text-gray-500 mt-1">
            Monitoring performa pegawai
        </p>
    </a>

</div>

@endsection