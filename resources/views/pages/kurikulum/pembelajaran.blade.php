@extends('layouts.app')

@section('content')
<a href="{{ route('kurikulum.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali ke halaman kurikulum
    </a>
<div class="space-y-6">

    <h1 class="text-xl font-bold text-gray-800">
        Jadwal anda
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($jadwal as $j)
        <a href="{{ route('kurikulum.pembelajaran.jurnal', $j->id) }}"
           class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
            <h2 class="font-semibold text-lg">{{ $j->mapel->nama_mapel }} Kelas {{ $j->kelas->nama_kelas }}</h2>
            <p class="text-sm text-gray-500">
                {{ $j->hari }}
            </p>
            @foreach ($j->jam_pelajaran as $jam)
            <p class="text-sm text-gray-500">
                {{ $jam->jam_mulai . '-' . $jam->jam_selesai }}
            </p>
                @endforeach
        </a>
        @endforeach

    </div>
</div>
@endsection
