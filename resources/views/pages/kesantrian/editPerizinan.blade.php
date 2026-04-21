@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Edit Perizinan Santri</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('kesantrian.perizinan.update', $perizinan->id) }}" method="POST"
            class="bg-white shadow rounded-xl p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1">Nama Santri</label>
                <button type="button" id="dropDownBtn" class=" w-full border rounded-lg px-3 py-2">
                    <div class="flex justify-between">
                        <span id="inputValue">{{ $perizinan->murid->nama }}</span>
                        <div class="rotate-90">
                            <span>></span>
                        </div>
                    </div>
                    <input id="hiddenInput" type="hidden" name="murid_id" value="{{ $perizinan->murid_id }}">
                </button>
                <div id="dropDown"
                    class="overflow-scroll h-[40%] border-gray-400 absolute border rounded-lg px-3 py-2 bg-white hidden">
                    <input id="searchBar" class="w-full border rounded-lg px-3 py-2"
                        placeholder="cari nama santri atau nis...">
                    @foreach ($siswa as $s)
                        <div class="px-3 py-2 cursor-pointer hover:bg-blue-100" data-id="{{ $s->id }}">
                            {{ $s->nama . " " . $s->nis }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Izin</label>
                <input name="tanggal" type="date" value="{{ $perizinan->tanggal }}"
                    class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Waktu mulai izin</label>
                <input name="waktu_mulai_izin" type="time" value="{{ explode('-', $perizinan->waktu_izin)[0] }}"
                    class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Waktu selesai izin</label>
                <input name="waktu_selesai_izin" type="time" value="{{ explode('-', $perizinan->waktu_izin)[1] }}"
                    class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kesantrian.perizinan') }}" class="px-4 py-2 border rounded-lg">
                    Batal
                </a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Update Data Perizinan
                </button>
            </div>
        </form>
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
            if (dropDown.classList.contains('hidden')) {
                dropDown.classList.remove('hidden')
            } else {
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