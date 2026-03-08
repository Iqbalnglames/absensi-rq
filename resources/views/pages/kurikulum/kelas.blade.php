@extends('layouts.app')
@section('content')
    <div>
        <a href="{{ route('kurikulum.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
            ← Kembali ke Menu Kurikulum
        </a>
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">Data Kelas</h2>
            <div class="space-x-4">
                <a href="{{ route('kurikulum.jenjang.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Jenjang
                </a>
                <a href="{{ route('kurikulum.kelas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                    Tambah Kelas
                </a>
            </div>
        </div>
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Kelas</th>
                        <th class="text-left p-4">Jenjang</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $k)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">Kelas {{ $k->nama_kelas }}</td>
                            <td class="p-4">{{ $k->jenjang->nama_jenjang }}</td>
                            <td class="p-4">
                                <div>
                                    <a class="text-blue-600 hover:text-blue-800" href="{{ route('kurikulum.kelas.edit', $k->id) }}">Edit</a>
                                    <form action="{{ route('kurikulum.kelas.delete', $k->id) }}" method="POST">
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
                                Tidak ada data Kelas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
    </script>
@endsection