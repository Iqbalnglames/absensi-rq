<?php

namespace App\Http\Controllers;

use App\Models\JamKerja;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // penjadwalan
    public function indexJadwal(User $user)
    {
        $users = $user->orderBy('name')->get();

        return view('pages.kepegawaian.jadwalKerja', compact('users'));
    }

    public function detailJadwal(User $user)
    {
        $jadwals = $user->jadwal_kerja()->orderBy('hari')->get();

        return view('pages.kepegawaian.detailJadwal', compact('user', 'jadwals'));
    }

    public function storeJadwal(Request $request, User $user)
    {
        $request->validate([
            'hari' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);

        $user->jadwal_kerja()->create($request->all());

        return back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function updateJadwal(Request $request, JamKerja $jamKerja)
    {
        $request->validate([
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);

        $jamKerja->update($request->only('jam_masuk', 'jam_pulang'));

        return back()->with('success', 'Jadwal berhasil diupdate');
    }

    public function destroyJadwal(JamKerja $jamKerja)
    {
        $jamKerja->delete();

        return back()->with('success', 'Jadwal berhasil dihapus');
    }

    // tampilkan perizinan
    public function indexIzin(User $user)
    {
        $users = User::withCount('izins')->get();

        return view('pages.kepegawaian.izin', compact('users'));
    }

    public function detailIzin(User $user)
    {
        $izins = $user->izins()->get();

        return view('pages.kepegawaian.detailIzin', compact('user', 'izins'));
    }

}
