@extends('layouts.app')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Manajemen User</h2>

        <div class="space-x-2">
            <a href="{{ route('kepegawaian.users.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                + Tambah Data Role
            </a>
            <a href="{{ route('kepegawaian.users.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                + Tambah User
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="text-left px-4 py-3">Nama</th>
                    <th class="text-left px-4 py-3">Email</th>
                    <th class="text-left px-4 py-3">Tanggal Dibuat</th>
                    <th class="text-left px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 space-x-3">

                        <a href="{{ route('kepegawaian.users.edit',$user) }}"
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            Edit
                        </a>

                        <form action="{{ route('kepegawaian.users.destroy',$user) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:text-red-800 text-sm">
                                Hapus
                            </button>
                        </form>

                        <a href="{{ route('kepegawaian.users.role',$user) }}"
                           class="text-green-600 hover:text-green-800 text-sm">
                            Tambah Role
                        </a>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-400">
                        Tidak ada data user
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>

@endsection