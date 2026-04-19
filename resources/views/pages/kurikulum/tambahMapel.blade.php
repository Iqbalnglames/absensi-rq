@extends('layouts.app')

@section('content')
    <a href="{{ route('kurikulum.mapel-guru') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali
    </a>
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Tambah Mapel</h2>
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
    <div>
        <form action="{{ route('kurikulum.mapel.store') }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4 mb-2">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Mapel</label>
                    <input name="nama_mapel" class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                        Tambah Peserta
                    </button>
                </div>
        </form>
    </div>
    <div class="flex flex-col justify-center gap-10">
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Nama Mapel</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapel as $m)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $m->nama_mapel }}</td>
                            <td class="p-4">
                                <form method="POST" action="{{ route('kurikulum.mapel.destroy', $m->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada Peserta Ekskul
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="bg-white text-black p-2">
                {{ $mapel->links() }}
            </div>
        </div>
    </div>
@endsection
