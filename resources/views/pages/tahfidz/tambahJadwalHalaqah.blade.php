@extends('layouts.app')

@section('content')
<a href="{{ route('tahfidz.jadwal-halaqah') }}" class="text-sm text-blue-500 mb-4 inline-block">
            ← Kembali ke jadwal halaqah
        </a>
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Tambah Jadwal Halaqah</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any)
            {{ $errors }}
        @endif

        <form action="{{ route('tahfidz.jadwal-halaqah.store') }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf

            {{-- Halaqah --}}
            <div>
                <label class="block text-sm font-medium mb-1">Halaqah</label>
                <select name="halaqah_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Halaqah</option>
                    @foreach($halaqah as $h)
                        <option value="{{ $h->id }}">
                            {{ $h->nama_halaqah }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jam --}}
            <div>
                <label class="block text-sm font-medium mb-1">Jam Halaqah</label>
                <div class="space-y-4">
                    @foreach($jamHalaqah as $j)
                            <div class="flex items-center gap-2 space-y-4">
                                <input type="checkbox" name="jam_halaqah_id[]" value="{{ $j->id }}">
                                {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                                </input>
                            </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan Jadwal Halaqah
                </button>
            </div>

        </form>

    </div>
@endsection
