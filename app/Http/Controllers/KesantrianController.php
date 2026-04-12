<?php

namespace App\Http\Controllers;

use App\Models\Asrama;
use App\Models\Jenjang;
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
}
