@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Tambah Jadwal Ekskul</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-3">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('kesantrian.ekskul.storeJadwal') }}" method="POST"
            class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Nama Ekskul</label>
                <select name="ekskul_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Ekskul</option>
                    @foreach($ekskul as $e)
                        <option value="{{ $e->id }}">{{ $e->nama_ekskul }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Hari Ekskul</label>
                <select id="hari" name="hari" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Hari</option>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                        <option value="{{ $hari }}">
                            {{ $hari }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Pengampu Ekskul</label>
                <select id="guru" name="user_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Pengampu</option>
                    @foreach($guru as $g)
                        <option value="{{ $g->id }}">
                            {{ $g->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kesantrian.ekskul') }}" class="px-4 py-2 border rounded-lg">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan Jadwal Ekskul
                </button>
            </div>

        </form>

    </div>
@endsection