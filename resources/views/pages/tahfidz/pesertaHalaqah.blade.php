@extends('layouts.app')

@section('content')
    <a href="{{ route('tahfidz.halaqah-data') }}" class="text-sm text-blue-500 mb-4 inline-block">
        ← Kembali
    </a>
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Halaqah {{ $detailHalaqah->nama_halaqah }}</h2>
    </div>
    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
    <div>
        <form action="{{ route('tahfidz.halaqah-data.storePeserta', $detailHalaqah->id) }}" method="POST" class="bg-white shadow rounded-xl p-6 space-y-4 mb-2">
            <h1>Tambah peserta</h1>
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Santri</label>
                    <button type="button" id="dropDownBtn" class=" w-full border rounded-lg px-3 py-2">
                        <div class="flex justify-between">
                            <span id="inputValue">--pilih santri--</span>
                            <div class="rotate-90">
                                <span>></span>
                            </div>
                        </div>
                        <input id="hiddenInput" type="hidden" name="murid_id">
                    </button>
                        <div id="dropDown" class="overflow-scroll h-[40%] border-gray-400 absolute border rounded-lg px-3 py-2 bg-white hidden">
                            <input id="searchBar" class="w-full border rounded-lg px-3 py-2" placeholder="cari nama santri atau nis...">
                            @foreach ($siswa as $s)
                                <div class="px-3 py-2 cursor-pointer hover:bg-blue-100" data-id="{{ $s->id }}">
                                    {{ $s->nama . " " . $s->nis }}
                                </div>
                            @endforeach
                        </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                        Tambah Peserta
                    </button>
                </div>
        </form>
    </div>
    <div class="flex flex-col justify-center gap-10">
        <div class="bg-white shadow rounded-xl overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Nama</th>
                        <th class="text-left p-4">Kelas</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detailHalaqah->murid->sortBy('nama') as $h)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-4">{{ $h->nama }}</td>
                            <td class="p-4">Kelas {{ $h->kelas->nama_kelas }}</td>
                            <td class="p-4">
                                <form method="POST" action="{{ route('tahfidz.halaqah-data.deletePeserta',  $h->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-400">
                                Tidak ada Peserta Halaqah
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="bg-white text-black p-2">
            </div>
        </div>
    </div>
    <script>
        const searchInput = document.getElementById('searchBar')
        const dropDown = document.getElementById('dropDown')
        const dropDownBtn = document.getElementById('dropDownBtn')
        const items = dropDown.querySelectorAll('div')
        const hiddenInputSiswa = document.getElementById('hiddenInput')
        const InputValueSiswa = document.getElementById('inputValue')

        let selectedIdSiswa = null
        dropDown.style.width = dropDownBtn.getBoundingClientRect().width + 'px';

        console.log(dropDownBtn.getBoundingClientRect().width)

        dropDownBtn.addEventListener('click', () => {
            if(dropDown.classList.contains('hidden')){
                dropDown.classList.remove('hidden')
            }else{
                dropDown.classList.add('hidden')
            }
        })

        searchInput.addEventListener('keyup', () => {
            let value = searchInput.value.toLowerCase()

            items.forEach(item => {
                let text = item.textContent.toLowerCase()
                item.style.display = text.includes(value) ? '' : 'none'
            })
        })

        items.forEach(item => {
            item.addEventListener('click', () => {
                selectedIdSiswa = item.dataset.id
                dropDown.classList.add('hidden')
                hiddenInputSiswa.value = selectedIdSiswa
                InputValueSiswa.innerHTML = item.textContent
            })
        })

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#dropDownBtn') && !e.target.closest('#dropDown')) {
                dropDown.classList.add('hidden')
            }
        })

    </script>
@endsection
