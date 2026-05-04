@extends('layouts.app')

@section('content')
    <div class="space-y-6">

        <h1 class="text-xl font-bold text-gray-800">
            Manajemen Tahfidz
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

              <!-- Pembelajaran -->
            <a href="{{ route('tahfidz.pembelajaran-tahfidz') }}" class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg">Pembelajaran Tahfidz</h2>
                <p class="text-sm text-gray-500">Absen dan isi mutabaah</p>
            </a>

            <!-- Pembelajaran -->
            <a href="{{ route('tahfidz.halaqah-data') }}"
                class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg">Halaqah</h2>
                <p class="text-sm text-gray-500">List Halaqah tahfidz</p>
            </a>

            <!-- Data Mutabaah -->
            <a href="{{ route('tahfidz.rekap-mutabaah') }}" class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg">Rekap Mutabaah</h2>
                <p class="text-sm text-gray-500">Kelola Mutabaah Halaqah</p>
            </a>

            <!-- Data Jadwal Halaqah -->
            <a href="{{ route('tahfidz.jadwal-halaqah') }}" class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg">Jadwal Halaqah</h2>
                <p class="text-sm text-gray-500">Tambah & tentukan jadwal halaqah muhafidz</p>
            </a>

        </div>
    </div>
@endsection
