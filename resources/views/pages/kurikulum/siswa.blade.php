@extends('layouts.app')
@section('content')
    <div>
        <a href="{{ route('kurikulum.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
            ← Kembali ke Menu Kurikulum
        </a>
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">Data Siswa</h2>
        </div>
        @if(session('error'))
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

                <select id="jenjang" name="jenjang_id" class="border rounded px-3 py-2">
                    <option value="">Semua Jenjang</option>
                    @foreach($jenjang as $j)
                        <option value="{{ $j->id }}" {{ request('jenjang_id') == $j->id ? 'selected' : '' }}>
                            {{ $j->nama_jenjang }}
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

                <button class="bg-blue-600 text-white px-4 rounded">
                    Filter
                </button>
                <button type="button" onclick="resetFilter()" class="border border-blue-600 text-blue-600 px-4 rounded">
                    Reset
                </button>

            </form>
            <div class="flex space-x-2 items-center">
                <a href="{{ route('kurikulum.siswa.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Data Santri
                </a>
            </div>
        </div>
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">NIS</th>
                        <th class="text-left p-4">Nama</th>
                        <th class="text-left p-4">Kelas</th>
                        <th class="text-left p-4">Alamat</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $s)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $s->nis }}</td>
                            <td class="p-4">{{ $s->nama }}</td>
                            <td class="p-4">Kelas {{ $s->kelas->nama_kelas }}</td>
                            <td class="p-4">{{ $s->alamat }}</td>
                            <td class="p-4">
                                <div>
                                    <a class="text-blue-600 hover:text-blue-800" href="{{ route('kurikulum.siswa.edit', $s->id) }}">Edit</a>
                                    <form action="{{ route('kurikulum.siswa.delete', $s->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada data Siswa
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="bg-white text-black p-2">
                {{ $siswa->links() }}
            </div>
        </div>
    </div>
    <script>
        const jenjang = document.getElementById('jenjang')
        const kelas = document.getElementById('kelas')

        function resetFilter() {
            jenjang.value = ""
            kelas.value = ""
            document.querySelector('form').submit()
        }
    </script>
@endsection
