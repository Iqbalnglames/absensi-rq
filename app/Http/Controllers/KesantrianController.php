<?php

namespace App\Http\Controllers;

use App\Models\Asrama;
use App\Models\CatatanPelanggaran;
use App\Models\Jenjang;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Pelanggaran;
use App\Models\User;
use Illuminate\Http\Request;

class KesantrianController extends Controller
{
    // kesantrian
    public function indexAsrama()
    {
        $asrama = Asrama::paginate(10);

        return view('pages.kesantrian.asrama', compact('asrama'));
    }
    public function createAsrama()
    {
        $jenjang = Jenjang::all();

        return view('pages.kesantrian.tambahAsrama', compact('jenjang'));
    }

    public function storeAsrama(Request $request)
    {
        $request->validate([
            'nama_asrama' => 'required',
            'jenjang_id' => 'required|exists:jenjangs,id',
        ]);

        Asrama::create($request->all());

        return redirect()->back()->with('success', 'Asrama berhasil ditambahkan');
    }

    public function editPengasuhAsrama(Asrama $asrama)
    {
        $guru = User::whereHas('roles', function ($query) {
            $query->where('name', 'pengasuh asrama');
        })->get();

        return view('pages.kesantrian.editPengasuhAsrama', compact('guru', 'asrama'));
    }

    public function updatePengasuhAsrama(Asrama $asrama, Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $asrama->update($request->all());

        return redirect()->route('kesantrian.asrama')->with('success', 'Pengasuh Asrama berhasil diupdate');
    }

    public function indexPelanggaran(Request $request)
    {
        $query = Murid::query();

        $query->whereHas('kelas', function ($q) use ($request) {

            if ($request->filled('jenjang_id')) {
                $q->where('jenjang_id', $request->jenjang_id);
            }

            if ($request->filled('kelas_id')) {
                $q->where('kelas_id', $request->kelas_id);
            }
        });

        $jenjang = Jenjang::all();
        $kelas = Kelas::all();
        $pelanggaranSiswa = $query->orderBy('kelas_id')->orderBy('nama')->paginate(20)->withQueryString();

        return view('pages.kesantrian.pelanggaranSiswa', compact('pelanggaranSiswa', 'kelas', 'jenjang'));
    }

    public function createPelanggaran()
    {
        $siswa = Murid::all();
        $pelanggaran = Pelanggaran::all();

        return view('pages.kesantrian.tambahPelanggaranSiswa', compact('siswa', 'pelanggaran'));
    }

    public function storePelanggaran(Request $request)
    {
         $request->validate([
            'murid_id' => 'required',
            'pelanggaran_id' => 'required',
            'catatan_pelanggaran' => 'required',
        ]);

        CatatanPelanggaran::create($request->all());

        return redirect()->back()->with('success', 'data pelanggaran berhasil disimpan');

    }
}
