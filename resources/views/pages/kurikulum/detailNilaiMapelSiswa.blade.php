@extends('layouts.app')

@section('content')
    <a href="{{ route('kurikulum.penilaian.detailSiswa', $murid->id) }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali
    </a>
    <div class="flex flex-col justify-center gap-10">
        <div
            class="max-w-2xl mx-4 sm:max-w-sm md:max-w-sm lg:max-w-sm xl:max-w-sm sm:mx-auto md:mx-auto lg:mx-auto xl:mx-auto mt-16 bg-white shadow-xl rounded-lg text-gray-900">
            <div class="rounded-t-lg h-32 overflow-hidden">
                <img class="object-cover object-top w-full"
                    src='https://images.unsplash.com/photo-1549880338-65ddcdfd017b?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ'
                    alt='Mountain'>
            </div>
            <div class="mx-auto w-32 h-32 relative -mt-16 border-4 border-white rounded-full overflow-hidden">
                <img class="object-cover object-center h-32"
                    src='https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ'
                    alt='Woman looking front'>
            </div>
            <div class="text-center mt-2">
                <h2 class="font-semibold">{{ $murid->nama }}</h2>
                <p class="text-gray-500">Kelas {{ $murid->kelas->nama_kelas }}</p>
                <p class="text-gray-500">Nilai {{ $mapel->nama_mapel }} semester {{ $semester }}</p>
            </div>
            <ul class="py-4 mt-2 text-gray-700 flex items-center justify-around">
                <li class="flex flex-col items-center justify-around">
                    <span>Tugas 1</span>
                    <div>{{ $nilai->tugas_1 ?? 0 }}</div>
                </li>
                <li class="flex flex-col items-center justify-around">
                    <span>Tugas 2</span>
                    <div>{{ $nilai->tugas_2 ?? 0 }}</div>
                </li>
                <li class="flex flex-col items-center justify-around">
                    <span>Tugas 3</span>
                    <div>{{ $nilai->tugas_3 ?? 0 }}</div>
                </li>
                <li class="flex flex-col items-center justify-around">
                    <span>PTS</span>
                    <div>{{ $nilai->pts ?? 0 }}</div>
                </li>
                <li class="flex flex-col items-center justify-around">
                    <span>PAS</span>
                    <div>{{ $nilai->pas ?? 0 }}</div>
                </li>
            </ul>
        </div>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST"
            action="{{  !$nilai ? route('kurikulum.penilaian.storeNilai') : route('kurikulum.penilaian.updateNilai', $nilai->id) }}"
            class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf
            @if($nilai)
                @method('PUT')
            @endif
            <input name="murid_id" type="hidden" value="{{ $murid->id }}" readonly>
            <input name="kelas_id" type="hidden" value="{{ $murid->kelas_id }}" readonly>
            <input name="mapel_id" type="hidden" value="{{ $mapel->id }}" readonly>
            <input name="semester" type="hidden" value="{{ $semester }}" readonly>
            <div class="flex gap-2 flex-col justify-between lg:flex-row">
                <div>
                    <label class="block text-sm font-medium mb-1">Tugas 1</label>
                    <input name="tugas_1" value="{{ $nilai->tugas_1 ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tugas 2</label>
                    <input name="tugas_2" value="{{ $nilai->tugas_2 ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tugas 3</label>
                    <input name="tugas_3" value="{{ $nilai->tugas_3 ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">PTS</label>
                    <input name="pts" value="{{ $nilai->pts ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">PAS</label>
                    <input name="pas" value="{{ $nilai->pas ?? '' }}" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Update Nilai
                </button>
            </div>

        </form>
    </div>
@endsection