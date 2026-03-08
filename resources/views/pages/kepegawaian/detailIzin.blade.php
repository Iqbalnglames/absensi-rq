@extends('layouts.app')

@section('content')
    <a href="{{ route('kepegawaian.izin') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali ke daftar user
    </a>
    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Riwayat Izin {{ $user->name }}</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="text-left px-4 py-3">Tanggal</th>
                        <th class="text-left px-4 py-3">Alasan</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($izins as $izin)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">{{ $izin->tanggal }}</td>
                            <td class="px-4 py-3 font-medium">{{ $izin->alasan }}</td>
                            <td class="px-4 py-3">{{ $izin->status }}</td>
                            <td>
                                {{-- <a href="{{ route('kepegawaian.izin.detail', $user->id) }}" class="text-blue-500">
                                    Lihat Riwayat
                                </a> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada data izin
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection