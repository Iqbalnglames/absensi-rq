@extends('layouts.app')
@section('content')
    <div>
        <a href="{{ route('kurikulum.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
            ← Kembali ke Menu Kurikulum
        </a>
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">Jadwal Mengajar</h2>
        </div>
        <div class="p-4 mb-4 flex justify-between bg-white shadow rounded">
            <form method="GET" class="flex gap-3">

                <select id="hari" name="hari" class="border rounded px-3 py-2">
                    <option value="">Semua Hari</option>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                        <option value="{{ $hari }}" {{ request('hari') == $hari ? 'selected' : '' }}>
                            {{ $hari }}
                        </option>
                    @endforeach
                </select>

                <select id="kelas" name="kelas_id" class="border rounded px-3 py-2">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <select id="user" name="user_id" class="border rounded px-3 py-2">
                    <option value="">Semua Guru</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ request('user_id') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->name }}
                        </option>
                    @endforeach
                </select>

                <button class="bg-blue-600 text-white px-4 rounded">
                    Filter
                </button>
                <button type="button" onclick="resetFilter()" class="border border-blue-600 text-blue-600 px-4 rounded">
                    Reset
                </button>

            </form>
            <div class="flex space-x-2 items-center">
                <a href="{{ route('kurikulum.jadwal.jam-pelajaran') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Jam Pelajaran
                </a>
                <a href="{{ route('kurikulum.jadwal.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Jadwal
                </a>
            </div>
        </div>
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Mapel</th>
                        <th class="text-left p-4">Guru Waktu dan Hari</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapels as $mapel)
                        {{-- {{ $mapel }} --}}
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $mapel->nama_mapel }}</td>
                            <td class="p-4">
                                <div class="flex items-center space-x-2">
                                    @foreach ($mapel->jadwal as $jadwal)
                                        <div>
                                            {{ $jadwal->user->name }}
                                            {{ ucfirst($jadwal->hari) }}
                                            {{-- {{ $jadwal->jam_pelajaran->jam_mulai . " - " . $jadwal->jam_pelajaran->jam_selesai }} --}}
                                            <div class="block">
                                                @foreach ($jadwal->jam_pelajaran as $jam_pelajaran)
                                                    <p>{{ "jam ke " . $jam_pelajaran->jam_ke }} {{ $jam_pelajaran->jam_mulai . " - " . $jam_pelajaran->jam_selesai }}</p> 
                                                @endforeach
                                            </div>
                                            {{ "Kelas " . $jadwal->kelas->nama_kelas }}
                                        </div>
                                        <div>
                                            <a href="{{ route('kurikulum.jadwal.edit', $jadwal->id) }}" class="text-blue-700 hover:text-blue-800">Edit</a>
                                            <form action="{{ route('kurikulum.jadwal.delete', $jadwal->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-700">Hapus</button>
                                            </form>
                                        </div>
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
    <script>
        const hari = document.getElementById('hari')
        const kelas = document.getElementById('kelas')
        const user = document.getElementById('user')

        function resetFilter() {
            hari.value = ""
            kelas.value = ""
            user.value = ""
            document.querySelector('form').submit()
        }
    </script>
@endsection