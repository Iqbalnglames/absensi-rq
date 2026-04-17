@extends('layouts.app')
@section('content')
    <div>
        <a href="{{ route('kesantrian.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
            ← Kembali ke Menu Kesantrian
        </a>
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">Data Perizinan Santri</h2>
        </div>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="p-4 mb-4 flex justify-between bg-white shadow rounded">
            <form method="GET" class="flex gap-3">
                <input id="nama" name="nama_siswa" class="border rounded px-3 py-2" placeholder="cari santri...">

                <button class="bg-blue-600 text-white px-4 rounded">
                    Filter
                </button>
                <button type="button" onclick="resetFilter()" class="border border-blue-600 text-blue-600 px-4 rounded">
                    Reset
                </button>

            </form>
            <div class="flex space-x-2 items-center">
                <a href="{{ route('kesantrian.perizinan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Data Perizinan
                </a>
            </div>
        </div>
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Tanggal Izin</th>
                        <th class="text-left p-4">Nama Santri</th>
                        <th class="text-left p-4">Waktu Izin</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perizinan as $p)

                            <td class="p-4">{{ $p->tanggal }}</td>
                            <td class="p-4">{{ $p->murid->nama }}</td>
                            <td class="p-4">{{ $p->waktu_izin }}</td>
                            <td class="p-4">
                                <div>
                                    <a class="text-blue-600 hover:text-blue-800"
                                        href="{{ route('kesantrian.perizinan.edit', $p->id) }}">Edit</a>
                                    {{-- <form action="{{ route('kurikulum.kelas.delete', $a->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada data Perizinan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="bg-white text-black p-2">
                {{ $perizinan->links() }}
            </div>
        </div>
    </div>
    <script>
        const nama = document.getElementById('nama_siswa')

        function resetFilter() {
            document.querySelector('form').submit()
        }
    </script>
@endsection
