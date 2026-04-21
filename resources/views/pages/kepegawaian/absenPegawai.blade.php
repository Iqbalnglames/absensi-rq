@extends('layouts.app')

@section('content')
@vite('resources/js/app.js')
<a href="{{ route('kepegawaian.users.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
    ← Kembali ke daftar user
</a>
<div class="bg-white p-6 rounded-xl shadow max-w-lg">
    <h2 class="text-xl font-semibold mb-6">Absen Masuk Pegawai</h2>
    <div id="reader"></div>
    <div id="result"></div>
    <form action="{{ route('kepegawaian.absen.masuk') }}" method="POST">
        @csrf
        <input type="hidden" name="token_absen" value="{{ $rawToken }}" id="tokenAbsen">
    </form>
</div>

@endsection