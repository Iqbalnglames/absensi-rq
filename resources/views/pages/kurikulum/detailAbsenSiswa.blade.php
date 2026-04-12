@extends('layouts.app')

@section('content')
    <a href="{{ route('kurikulum.absen-siswa') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali
    </a>
    <div class="flex flex-col justify-center gap-10">
        <div
            class="max-w-2xl mx-4 sm:max-w-sm md:max-w-sm lg:max-w-sm xl:max-w-sm sm:mx-auto md:mx-auto lg:mx-auto xl:mx-auto mt-16 bg-white shadow-xl rounded-lg text-gray-900">
            <div class="rounded-t-lg h-32 overflow-hidden">
                <img class="object-cover object-top w-full"
                    src='https://images.unsplash.com/photo-1549880338-65ddcdfd017b?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ'
                    alt='Mountain'>
            </div>
            <div class="mx-auto w-32 h-32 relative -mt-16 border-4 border-white rounded-full overflow-hidden">
                <img class="object-cover object-center h-32"
                    src='https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ'
                    alt='Woman looking front'>
            </div>
            <div class="text-center mt-2">
                <h2 class="font-semibold">{{ $siswa->nama }}</h2>
                <p class="text-gray-500">Kelas {{ $siswa->kelas->nama_kelas }}</p>
            </div>
            <ul class="py-4 mt-2 text-gray-700 flex items-center justify-around">
                <li class="flex flex-col items-center justify-around">
                    <span>Total Hadir</span>
                    <div>{{ $siswa->absen_murid->where('status', 'hadir')->count() }}</div>
                </li>
                <li class="flex flex-col items-center justify-between">
                    <span>Total Izin</span>
                    <div>{{ $siswa->absen_murid->where('status', 'izin')->count() }}</div>
                </li>
                <li class="flex flex-col items-center justify-around">
                    <span>Total Sakit</span>
                    <div>{{ $siswa->absen_murid->where('status', 'sakit')->count() }}</div>
                </li>
                <li class="flex flex-col items-center justify-around">
                    <span>Total Alpha</span>
                    <div>{{ $siswa->absen_murid->where('status', 'alpha')->count() }}</div>
                </li>
            </ul>
        </div>
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Tanggal</th>
                        <th class="text-left p-4">Mapel</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa->absen_murid->sortBy('tanggal') as $s)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $s->tanggal }}</td>
                            <td class="p-4">{{ $s->jadwal_pelajaran->mapel->nama_mapel }}</td>
                            <td class="p-4">{{ $s->status }}</td>
                            <td class="p-4">
                                <div>
                                    <a class="text-blue-600 hover:text-blue-800"
                                        href="{{ route('kurikulum.siswa.edit', $s->id) }}">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada data Absen Siswa
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="bg-white text-black p-2">
            </div>
        </div>
    </div>
@endsection