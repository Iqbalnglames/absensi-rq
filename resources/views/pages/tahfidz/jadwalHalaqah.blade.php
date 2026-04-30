@extends('layouts.app')
@section('content')
    <div>
        <a href="{{ route('tahfidz.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
            ← Kembali ke Menu Tahfidz
        </a>
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">Jadwal Halaqah</h2>
        </div>
        <div class="p-4 mb-4 flex justify-between bg-white shadow rounded">
            <div class="flex space-x-2 items-center">
                <a href="{{ route('tahfidz.jadwal-halaqah.jam-halaqah.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Jam Halaqah
                </a>
                <a href="{{ route('tahfidz.jadwal-halaqah.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Jadwal Halaqah
                </a>
            </div>
        </div>
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Halaqah</th>
                        <th class="text-left p-4">Muhafidz</th>
                        <th class="text-left p-4">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($halaqah as $h)
                        {{-- {{ $mapel }} --}}
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $h->nama_halaqah }}</td>
                            <td class="p-4">{{ $h->user->name }}</td>
                            <td class="p-4">
                                <div class="flex items-center space-x-2">
                                    @foreach ($h->jam_halaqah as $j)
                                        <p>{{ $j->jam_mulai . " - " . $j->jam_selesai }}</p>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada data jadwal
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
