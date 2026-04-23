<?php

namespace App\Http\Controllers;

use App\Models\Halaqah;
use App\Models\Murid;
use App\Models\User;
use Illuminate\Http\Request;

class TahfidzController extends Controller
{
    public function halaqahData()
    {
        $halaqah = Halaqah::paginate(20);

        return view('pages.tahfidz.halaqahData', compact('halaqah'));
    }

    public function tambahHalaqah()
    {
        $muhafidz = User::whereHas('roles', function($q) {
            $q->where('name', 'guru');
        })->get();

        return view('pages.tahfidz.tambahHalaqah', compact('muhafidz'));
    }

    public function storeHalaqah(Request $request)
    {
        $request->validate([
            'nama_halaqah' => 'required',
        ]);

        Halaqah::create($request->all());

        return redirect()->back()->with('success', 'halaqah berhasil dibuat');
    }

    public function editHalaqah(Halaqah $halaqah)
    {
        $muhafidz = User::whereHas('roles', function($q) {
            $q->where('name', 'guru');
        })->get();

        return view('pages.tahfidz.editHalaqah', compact('halaqah', 'muhafidz'));
    }

    public function updateHalaqah(Halaqah $halaqah, Request $request)
    {
        $request->validate([
            'nama_halaqah' => 'required',
        ]);

        $halaqah->update($request->all());

        return redirect()->back()->with('success', 'halaqah berhasil diupdate');
    }


    public function pesertaHalaqah(Halaqah $halaqah)
    {
        $siswa = Murid::all();
        $detailHalaqah = $halaqah->load('murid');

        return view('pages.tahfidz.pesertaHalaqah', compact('detailHalaqah', 'siswa'));
    }

    public function destroyHalaqah(Halaqah $halaqah)
    {
        $halaqah->delete();

        return redirect()->back()->with('success', 'halaqah berhasil dihapus');
    }

    public function storePesertaHalaqah(Request $request, Halaqah $halaqah)
    {
         $request->validate([
            'murid_id' => 'required',
        ]);

        $exist = $halaqah->murid()->where('id', $request->murid_id)->exists();

        if($exist){
            return redirect()->back()->with('error', 'peserta halaqah sudah ditambahkan sebelumnya!');
        }

        $murid = Murid::find($request->murid_id);

        if ($murid) {
            $murid->update([
                'halaqah_id' => $halaqah->id,
            ]);
        }

        return redirect()->back()->with('success', 'peserta halaqah berhasil ditambahkan');
    }

    public function hapusPesertaHalaqah(Murid $murid)
    {
        $murid->update([
            'halaqah_id' => null
        ]);

        return redirect()->back()->with('success', 'peserta halaqah berhasil dihapus');
    }
}
