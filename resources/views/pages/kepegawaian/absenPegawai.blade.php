@extends('layouts.app')

@section('content')
@vite('resources/js/app.js')
<a href="{{ route('kepegawaian.users.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
    ← Kembali ke daftar user
</a>
@if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 text-blue-700 p-3 rounded mb-4">
            {{ session('info') }}
        </div>
    @endif
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
<div class="bg-white p-6 rounded-xl shadow max-w-lg">
    <h2 class="text-xl font-semibold mb-6">Absen Masuk Pegawai</h2>
    <div id="reader"></div>
    <div id="result"></div>
    <form id='formAbsen' action="{{ route('kepegawaian.absen.masuk') }}" method="POST">
        @csrf
        <input type="hidden" name="token_absen" value="{{ $rawToken }}" id="tokenAbsen">
    </form>
</div>

@endsection
