@extends('layouts.app')

@section('content')
    <a href="{{ route('kepegawaian.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali ke menu kepegawaian
    </a>
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @elseif(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Riwayat Izin {{ $user->name }}</h2>
            <a href="{{ route('kepegawaian.izin-user.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                    Ajukan Izin
                </a>
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
                    @forelse($izin as $i)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">{{ $i->tanggal_mulai }} - {{ $i->tanggal_selesai }}</td>
                            <td class="px-4 py-3 font-medium">{{ $i->alasan }}</td>
                            <td class="px-4 py-3">{{ $i->status }}</td>
                            <td>
                                <a href="{{ route('kepegawaian.izin-user.edit', $i->id) }}" class="text-blue-500">
                                    Ubah izin
                                </a>
                                <form action="{{ route('kepegawaian.izin-user.delete', $i->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 cursor-pointer">Batalkan izin</button>
                                </form>
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