@extends('layouts.app')
@section('content')
    <div>
        <a href="{{ url()->previous() }}" class="text-sm text-blue-500 mb-4 inline-block">
            ← Kembali
        </a>
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">Mutabaah {{ $murid->nama }}</h2>
        </div>
        <div class="p-4 mb-4 flex justify-between bg-white shadow rounded">
           
        </div>
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Tanggal</th>
                        <th class="text-left p-4">Nama Surat</th>
                        <th class="text-left p-4">Ayat Setoran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($murid->mutabaah as $m)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $m->tanggal }}</td>
                            <td class="p-4">{{ $m->nama_surat }}</td>
                            <td class="p-4">{{ $m->ayat_awal }} - {{ $m->ayat_akhir }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada data setoran
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
