@extends('layouts.app')

@section('content')

<h2 class="text-xl font-semibold mb-6">
    Penjadwalan Guru
</h2>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4 text-left">Jumlah Hari Kerja</th>
                <th class="p-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-4">{{ $user->name }}</td>
                <td class="p-4">{{ $user->jadwal_kerja->count() }} Hari</td>
                <td class="p-4 text-center">
                    <a href="{{ route('kepegawaian.jadwal.detail', $user->id) }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded-lg text-xs">
                        Atur Jadwal
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="p-4 text-center text-gray-500">
                    Tidak ada user
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection