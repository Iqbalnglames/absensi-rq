@extends('layouts.app')

@section('content')
    <a href="{{ route('kesantrian.ekskul.pembelajaran') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali
    </a>
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @elseif(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ $jurnal
        ? route('kesantrian.ekskul.updateJurnal', [$jadwal->id, $jurnal->id])
        : route('kesantrian.ekskul.storeJurnal', $jadwal->id) }}" class="bg-white shadow rounded-xl p-6 space-y-4">
        @csrf
        @if($jurnal)
            @method('PUT')
        @endif
        <div>
            <p class="block text-lg font-bold mb-1">{{ $jadwal->ekskul->nama_ekskul }}</p>
        </div>

        <div>
            <p class="block text-sm text-gray-600 font-medium mb-1">{{ $jadwal->hari }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Tanggal</label>
            <input name="tanggal" type="date" value="{{ $jurnal->tanggal ?? '' }}"
                class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Materi</label>
            <textarea name="materi" id=""
                class="w-full border h-40 rounded-lg px-3 py-2">{{ $jurnal->materi ?? '' }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Catatan</label>
            <textarea name="catatan" id=""
                class="w-full border h-40 rounded-lg px-3 py-2">{{ $jurnal->catatan ?? '' }}</textarea>
        </div>

        <div class="w-full border rounded-lg px-3 py-2">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left">Nama</th>
                        <th>Hadir</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurnal ? $jurnal->jadwal_ekskul->absen_ekskul : $jadwal->ekskul->murid as $murid)
                        <tr>
                            <td>{{ $jurnal ? $murid->murid->nama : $murid->nama }}</td>
                            <td><input name="absen[{{ $jurnal ? $murid->murid->id : $murid->id }}]" type="checkbox" {{ $murid->status == 'hadir' ? 'checked' : '' }} value="hadir"
                                    class="w-full border rounded-lg px-3 py-2"></td>
                            <td><input name="absen[{{ $jurnal ? $murid->murid->id : $murid->id }}]" type="checkbox" {{ $murid->status == 'sakit' ? 'checked' : '' }} value="sakit"
                                    class="w-full border rounded-lg px-3 py-2"></td>
                            <td><input name="absen[{{ $jurnal ? $murid->murid->id : $murid->id }}]" type="checkbox" {{ $murid->status == 'izin' ? 'checked' : '' }} value="izin"
                                    class="w-full border rounded-lg px-3 py-2"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('kurikulum.pembelajaran') }}" class="px-4 py-2 border rounded-lg">
                Batal
            </a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Simpan Jurnal dan Absen
            </button>
        </div>
    </form>
@endsection