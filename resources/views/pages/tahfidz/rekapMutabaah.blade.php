@extends('layouts.app')
@section('content')
    <div>
        <a href="{{ route('tahfidz.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
            ← Kembali ke Menu Tahfidz
        </a>
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">Rekap Mutabaah</h2>
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

                <input id="siswa" class="border rounded px-3 py-2" name="nama_siswa" placeholder="cari santri...">
                <button class="bg-blue-600 text-white px-4 rounded">
                    Filter
                </button>
                <button type="submit" onclick="resetFilter()" class="border border-blue-600 text-blue-600 px-4 rounded">
                    Reset
                </button>

            </form>
            {{-- <div class="flex space-x-2 items-center">
                <a href="{{ route('kurikulum.jadwal.jam-pelajaran') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Jam Pelajaran
                </a>
                <a href="{{ route('kurikulum.jadwal.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Jadwal
                </a>
            </div> --}}
        </div>
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Tanggal</th>
                        <th class="text-left p-4">Nama Santri</th>
                        <th class="text-left p-4">Surat Setoran</th>
                        <th class="text-left p-4">Ayat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mutabaah as $m)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $m->tanggal }}</td>
                            <td class="p-4">{{ $m->murid->nama }}</td>
                            <td class="p-4">{{ $m->nama_surat }}</td>
                            <td class="p-4">{{ $m->ayat_awal }} {{ $m->ayat_akhir }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada data mutabaah
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $mutabaah->links() }}
        </div>
    </div>
    <script>
        const nama = document.getElementById('siswa')
        const hari = document.getElementById('hari')

        function resetFilter() {
            nama.value = ""
            hari.value = ""
            document.querySelector('form').submit()
        }
    </script>
@endsection
