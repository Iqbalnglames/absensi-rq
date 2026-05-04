@extends('layouts.app')

@section('content')
    <a href="{{ route('tahfidz.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali ke halaman Tahfidz
    </a>
    <div class="space-y-6">

        <h1 class="text-xl font-bold text-gray-800">
            Jadwal anda
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($jadwal as $j)
                @foreach($j->jam_halaqah as $jam)
                    <a href="{{ route('tahfidz.pembelajaran-tahfidz.jurnal', [$j->id, $jam->id]) }}"
                        class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
                        <h2 class="font-semibold text-lg">Halaqah {{ $j->nama_halaqah }}</h2>
                        <p class="text-sm text-gray-500">
                            {{ $jam->jam_mulai . '-' . $jam->jam_selesai }}
                        </p>
                    </a>
                @endforeach
            @endforeach

        </div>
    </div>
@endsection