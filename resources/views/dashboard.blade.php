@extends('layouts.app')
@section('content')
  <!-- Summary Cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

    <div class="bg-white p-4 rounded-xl shadow">
      <p class="text-xs text-gray-500">Hadir Hari Ini</p>
      <h2 class="text-2xl font-bold text-green-500">{{ $absenHariIni }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
      <p class="text-xs text-gray-500">Terlambat Hari Ini</p>
      <h2 class="text-2xl font-bold text-yellow-500">{{ $absenTerlambatHariIni }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
      <p class="text-xs text-gray-500">Izin Hari Ini</p>
      <h2 class="text-2xl font-bold text-blue-500">{{ $absenIzinHariIni }}</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow">
      <p class="text-xs text-gray-500">Tidak Hadir Hari Ini</p>
      <h2 class="text-2xl font-bold text-red-500">{{ $belumAbsen }}</h2>
    </div>

  </div>

  <!-- Attendance Table -->
  <div class="bg-white rounded-xl shadow">
    <div class="p-4 border-b border-gray-400 font-semibold text-sm">
      Log Absensi Hari Ini
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
          <tr>
            <th class="text-left p-3">Nama</th>
            <th class="text-left p-3">Jam Masuk</th>
            <th class="text-left p-3">Jam Keluar</th>
            <th class="text-left p-3">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($absenGuru as $absen)
            <tr class="border-t border-gray-400">
              <td class="p-3">{{ $absen->jadwal_kerja->user->name }}</td>
              <td class="p-3">{{ $absen->jam_masuk }}</td>
              <td class="p-3">{{ $absen->jam_keluar }}</td>
              <td class="p-3 {{ $absen->status == 'hadir' ? 'text-green-500' : 'text-red-500' }}">
                {{ ucfirst($absen->status) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div>
      {{ $absenGuru->links() }}
    </div>
  </div>
@endsection