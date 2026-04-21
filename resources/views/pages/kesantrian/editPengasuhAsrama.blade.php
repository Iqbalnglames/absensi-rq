@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Edit Pengasuh Asrama</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('kesantrian.pengasuh-asrama.update', $asrama->id) }}" method="POST"
            class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label class="block text-sm font-medium mb-1">Nama Asrama</label>
                <input type="text" value="{{ $asrama->nama_asrama }}" class="w-full border rounded-lg px-3 py-2"
                    name="nama_asrama" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Pengasuh Asrama</label>
                <select name="user_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Pengasuh Asrama</option>
                    @foreach($guru as $g)
                        <option value="{{ $g->id }}" {{ $g->id == $asrama->user_id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kesantrian.asrama') }}" class="px-4 py-2 border rounded-lg">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Update Pengasuh Asrama
                </button>
            </div>

        </form>

    </div>
@endsection