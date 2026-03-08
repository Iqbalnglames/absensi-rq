@extends('layouts.app')

@section('content')

    <h2 class="text-xl font-semibold mb-4">
        Jadwal Kerja - {{ $user->name }}
    </h2>

    <a href="{{ route('kepegawaian.jadwal') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali ke daftar user
    </a>

    <!-- Form Tambah -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
        <form method="POST" action="{{ route('kepegawaian.jadwal.store', $user->id) }}">
            @csrf

            <div class="grid grid-cols-4 gap-4">
                <select name="hari" class="border p-2 rounded">
                    <option value="senin">Senin</option>
                    <option value="selasa">Selasa</option>
                    <option value="rabu">Rabu</option>
                    <option value="kamis">Kamis</option>
                    <option value="jumat">Jumat</option>
                    <option value="sabtu">Sabtu</option>
                </select>

                @php
                    function generateJamOptions($selected = null)
                    {
                        $start = strtotime('06:00');
                        $end = strtotime('22:00');

                        $html = '';

                        while ($start <= $end) {
                            $value = date('H:i:s', $start);
                            $label = date('H:i', $start);

                            $isSelected = $selected == $value ? 'selected' : '';

                            $html .= "<option value='$value' $isSelected>$label</option>";

                            $start = strtotime('+30 minutes', $start);
                        }

                        return $html;
                    }
                @endphp

                <select name="jam_masuk" class="border p-2 rounded">
                    <option value="">Jam Masuk</option>
                    {!! generateJamOptions() !!}
                </select>

                <select name="jam_pulang" class="border p-2 rounded">
                    <option value="">Jam Pulang</option>
                    {!! generateJamOptions() !!}
                </select>

                <button class="bg-blue-500 text-white rounded px-4">
                    Tambah
                </button>
            </div>
        </form>
    </div>

      @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul class="text-sm list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <!-- Tabel -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Hari</th>
                    <th class="p-3 text-left">Masuk</th>
                    <th class="p-3 text-left">Pulang</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                    <tr class="border-t">
                        <td class="p-3 capitalize">{{ $jadwal->hari }}</td>
                        <td class="p-3">{{ $jadwal->jam_masuk }}</td>
                        <td class="p-3">{{ $jadwal->jam_pulang }}</td>
                        <td class="p-3 text-center">
                            <button
                                onclick="openModal('{{ $jadwal->id }}','{{ $jadwal->jam_masuk }}','{{ $jadwal->jam_pulang }}')"
                                class="text-blue-600 hover:text-blue-800 text-sm">
                                Edit
                            </button>
                            <form method="POST" action="{{ route('kepegawaian.jadwal.destroy', $jadwal->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 text-xs">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            Belum ada jadwal
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div id="modalEdit" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow w-96">

                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">

                        <select name="jam_masuk" id="edit_jam_masuk" class="border p-2 rounded">
                            <option value="">Jam Masuk</option>
                            {!! generateJamOptions() !!}
                        </select>

                        <select name="jam_pulang" id="edit_jam_pulang" class="border p-2 rounded">
                            <option value="">Jam Pulang</option>
                            {!! generateJamOptions() !!}
                        </select>

                        <div class="flex justify-between mt-4">
                            <button type="button" onclick="closeModal()" class="text-gray-500">
                                Batal
                            </button>

                            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                                Update
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <script>
        function openModal(jadwalId, jamMasuk, jamPulang) {
            document.getElementById('formEdit').action = 
            `/kepegawaian/jadwal/${jadwalId}`

            document.getElementById('edit_jam_masuk').value = jamMasuk
            document.getElementById('edit_jam_pulang').value = jamPulang

            document.getElementById('modalEdit').classList.remove('hidden')
        }
        
        function closeModal() {
            document.getElementById('modalEdit').classList.add('hidden')
        }
    </script>
@endsection