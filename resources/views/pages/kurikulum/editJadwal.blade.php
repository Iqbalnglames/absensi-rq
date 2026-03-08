@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Edit Jadwal Mengajar</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('kurikulum.jadwal.update', $jadwalEdit->id) }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1">Hari</label>
                <select name="hari" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Hari</option>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                        <option value="{{ $hari }}" {{ $hari == ucfirst($jadwalEdit->hari) ? 'selected' : '' }}>{{ $hari }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kelas</label>
                <select name="kelas_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $jadwalEdit->kelas_id == $k->id ? 'selected' : '' }}>Kelas {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Guru</label>
                <select name="user_id" id="guruSelect" class="w-full border rounded-lg px-3 py-2" readonly>
                    <option value="{{ $jadwalEdit->user->id }}">{{ $jadwalEdit->user->name }}</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Mata Pelajaran</label>
                <select name="mapel_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Mapel</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}" {{ $jadwalEdit->mapel_id == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jam Pelajaran</label>
                <div class="space-y-4">
                    @foreach($jamPelajarans as $nama_jenjang => $jams)
                    <h2>Jenjang {{ $nama_jenjang }}</h2>
                    @foreach ($jams as $jam)
                    <div class="flex items-center gap-2 space-y-4">
                        <input type="checkbox" name="jam_pelajaran_id[]" value="{{ $jam->id }}" {{ $jadwalEdit->jam_pelajaran->contains($jam->id) ? 'checked' : '' }}>
                        {{"Jam " . $jam->jam_ke. ": " }}
                        {{ $jam->jam_mulai }} - {{ $jam->jam_selesai }}
                        </input>
                    </div>
                    @endforeach
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kurikulum.jadwal') }}" class="px-4 py-2 border rounded-lg">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Update Jadwal
                </button>
            </div>

        </form>

    </div>
@endsection