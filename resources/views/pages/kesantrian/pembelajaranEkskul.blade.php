@extends('layouts.app')

@section('content')
    <a href="{{ route('kesantrian.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali ke halaman kesantrian
    </a>
    <div class="space-y-6">

        <h1 class="text-xl font-bold text-gray-800">
            Jadwal anda
        </h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($ekskul as $j)
                <a href="{{ route('kesantrian.ekskul.jurnal', $j->id) }}"
                    class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition">
                    <h2 class="font-semibold text-lg">{{ $j->ekskul->nama_ekskul }}</h2>
                    <p class="text-sm text-gray-500">
                        {{ $j->hari }}
                    </p>
                </a>
            @endforeach
        </div>
    </div>
@endsection