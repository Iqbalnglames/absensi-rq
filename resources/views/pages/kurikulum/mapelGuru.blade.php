@extends('layouts.app')
@section('content')
    <div>
        <a href="{{ route('kurikulum.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
            ← Kembali ke Menu Kurikulum
        </a>
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">Data Mapel Guru</h2>
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

                <input id="search" name="search" placeholder="Cari..." class="border rounded px-3 py-2">

                <button class="bg-blue-600 text-white px-4 rounded">
                    Cari
                </button>
                <button type="button" onclick="resetFilter()" class="border border-blue-600 text-blue-600 px-4 rounded">
                    Reset
                </button>

            </form>
            {{-- <div class="flex space-x-2 items-center">
                <a href="{{ route('kurikulum.mapel-guru.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Pengajar Mapel
                </a>
            </div> --}}
        </div>
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Nama Guru</th>
                        <th class="text-left p-4">Mapel</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guru as $g)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $g->name }}</td>
                            <td class="p-4">
                                @if ($g->guruMapelKelas->count() == 0)
                                    <a href="{{ route('kurikulum.mapel-guru.create', $g->id) }}" class="text-blue-600 hover:text-blue-800">Tambah Mapel Ajar</a>
                                    @else
                                    @foreach ($g->guruMapelKelas as $item)
                                    {{ $item->mapel->nama_mapel . ' ' . $item->kelas->nama_kelas  }}
                                    <a href="{{ route('kurikulum.mapel-guru.edit', $g->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    @endforeach
                                @endif
                            </td>
                            <td class="p-4">
                                {{-- <div>
                                    <a class="text-blue-600 hover:text-blue-800"
                                        href="{{ route('kurikulum.kelas.edit', $k->id) }}">Edit</a>
                                    <form action="{{ route('kurikulum.kelas.delete', $k->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </div> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada mapel yang sudah diajar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="bg-white text-black p-2">
                {{ $guru->links() }}
            </div>
        </div>
    </div>
    <script>
        const search = document.getElementById('search')

        function resetFilter() {
            search.value = ""
            document.querySelector('form').submit()
        }
    </script>
@endsection
