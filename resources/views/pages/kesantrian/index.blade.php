@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">
    <h2 class="text-lg font-semibold mb-4">Data Santri</h2>

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="text-left py-2">Nama</th>
                <th class="text-left py-2">Kamar</th>
                <th class="text-left py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b">
                <td class="py-2">Zaid</td>
                <td>Al-Fatih</td>
                <td class="text-green-500">Mukim</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection