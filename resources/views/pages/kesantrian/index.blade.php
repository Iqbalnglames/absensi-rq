@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <h1 class="text-xl font-bold text-gray-800">
        Manajemen Kesantrian
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Data Asrama -->
        <a href="{{ route('kesantrian.asrama') }}"
           class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="font-semibold text-lg">Data Asrama</h2>
            <p class="text-sm text-gray-500">Kelola Asrama Santri</p>
        </a>

        <!-- Data Pelanggaran -->
        <a href="{{ route('kurikulum.kelas') }}"
           class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="font-semibold text-lg">Data Pelanggaran Santri</h2>
            <p class="text-sm text-gray-500">Kelola pelanggaran santri</p>
        </a>

        <!-- Data Perizinan -->
        <a href="{{ route('kurikulum.siswa') }}"
           class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="font-semibold text-lg">Data Perizinan Santri</h2>
            <p class="text-sm text-gray-500">Kelola perizinan santri</p>
        </a>

    </div>
</div>
@endsection
