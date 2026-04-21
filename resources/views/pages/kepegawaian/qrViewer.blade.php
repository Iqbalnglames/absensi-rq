@extends('layouts.app')

@section('content')
@vite('resources/js/app.js')
<a href="{{ route('kepegawaian.index') }}" class="text-sm text-blue-500 mb-4 inline-block">
    ← Kembali ke menu kepegawaian
</a>
<div class="bg-white p-6 rounded-xl shadow max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-6 text-center">Qr Untuk Absensi</h2>
    <div class="flex justify-center">
        {!! $qr !!}
    </div>
</div>

@endsection