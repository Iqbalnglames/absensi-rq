@extends('layouts.app')
@section('content')
 <!-- Summary Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <div class="bg-white p-4 rounded-xl shadow">
          <p class="text-xs text-gray-500">Hadir Hari Ini</p>
          <h2 class="text-2xl font-bold text-green-500">18</h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
          <p class="text-xs text-gray-500">Terlambat</p>
          <h2 class="text-2xl font-bold text-yellow-500">3</h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
          <p class="text-xs text-gray-500">Izin</p>
          <h2 class="text-2xl font-bold text-blue-500">2</h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
          <p class="text-xs text-gray-500">Tidak Hadir</p>
          <h2 class="text-2xl font-bold text-red-500">1</h2>
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
              <tr class="border-t border-gray-400">
                <td class="p-3">Ahmad</td>
                <td class="p-3">08:01</td>
                <td class="p-3">17:02</td>
                <td class="p-3 text-green-500">Hadir</td>
              </tr>             
            </tbody>
          </table>
        </div>
      </div>
@endsection