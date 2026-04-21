@extends('layouts.app')

@section('content')
    <a href="{{ route('kurikulum.penilaian') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali
    </a>
    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @elseif(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div>
        <div class="bg-white shadow rounded-xl p-6 space-y-4 mb-2">
            <h1 class="font-bold text-2xl">Kelas {{ $kelas->nama_kelas }}</h1>
            <h1 class="">{{ $kelas->wali_kelas->name ?? 'Belum ada wali kelas' }}</h1>
        </div>
    </div>
    <div class="flex flex-col justify-center gap-10">
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Nama</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($murid as $s)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $s->nama }}</td>
                            <td class="p-4">
                                <a href="{{ route('kurikulum.penilaian.detailSiswa', $s->id) }}"
                                    class="text-blue-600 hover:text-blue-800">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada Anggota Kelas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="bg-white text-black p-2">
                {{ $murid->links() }}
            </div>
        </div>
    </div>
@endsection