<?php

namespace App\Http\Controllers;

use App\Models\Halaqah;
use App\Models\JadwalHalaqah;
use App\Models\JamHalaqah;
use App\Models\Murid;
use App\Models\Mutabaah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TahfidzController extends Controller
{
    public function halaqahData()
    {
        $halaqah = Halaqah::paginate(20);

        return view('pages.tahfidz.halaqahData', compact('halaqah'));
    }

    public function tambahHalaqah()
    {
        $muhafidz = User::whereHas('roles', function ($q) {
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
        $muhafidz = User::whereHas('roles', function ($q) {
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

        if ($exist) {
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

    public function rekapMutabaah(Request $request)
    {
        $query = Mutabaah::query();

        $query->whereHas('murid', function ($q) use ($request) {
            if ($request->filled('nama_siswa')) {
                $q->where('nama', 'like', '%' . $request->nama_siswa . '%');
            }

            $hariMap = [
                'Minggu' => 1,
                'Senin' => 2,
                'Selasa' => 3,
                'Rabu' => 4,
                'Kamis' => 5,
                'Jumat' => 6,
                'Sabtu' => 7,
            ];

            if ($request->filled('hari')) {
                $hariAngka = $hariMap[$request->hari] ?? null;

                if ($hariAngka) {
                    $q->whereRaw('DAYOFWEEK(tanggal) = ?', [$hariAngka]);
                }
            }
        });

        $mutabaah = $query->paginate(20)->withQueryString();
            $murid = Murid::all();

        return view('pages.tahfidz.rekapMutabaah', compact('mutabaah', 'murid'));
    }

    public function pembelajaranTahfidz()
    {
        $user = Auth::user();
        $jadwal = JadwalHalaqah::whereHas('halaqah', function($q) use ($user){
            $q->whereHas('user', function($qu) use ($user){
                $qu->where('id', $user->id);
            });
        })->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")->get();

        return view('pages.tahfidz.pembelajaranTahfidz', compact('jadwal'));
    }

    public function indexJadwalHalaqah(Request $request)
    {
        $query = Halaqah::query();

        if ($request->filled('hari')) {
            $query->whereHas('jadwal_halaqah', function ($q) use ($request) {
                $q->where('hari', $request->hari);
            });
        }

        $query->with([
            'jadwal_halaqah' => function ($q) use ($request) {
                if ($request->filled('hari')) {
                    $q->where('hari', $request->hari);
                }

                $q->with('jam_halaqah')
                  ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')");
            }
        ]);

        $halaqah = $query->paginate(10)->withQueryString();

        $gurus = User::whereHas('roles', function ($q) {
            $q->where('name', 'muhafidz');
        })->get();

        return view('pages.tahfidz.jadwalHalaqah', compact('halaqah', 'gurus'));
    }

    public function createJamHalaqah()
    {
        return view('pages.tahfidz.tambahJamHalaqah');
    }

    public function storeJamHalaqah(Request $request)
    {

        $request->validate([
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $isJamHalaqahExist = JamHalaqah::where('jam_mulai', $request->jam_mulai)->where('jam_selesai', $request->jam_selesai)->exists();

        if ($isJamHalaqahExist) {
            return back()->with('error', 'Jam ke tersebut sudah dibuat');
        } else if ($request->jam_mulai > $request->jam_selesai) {
            return back()->with('error', 'Jam mulai lebih besar daripada jam selesai');
        }

        JamHalaqah::create([
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return back()->with('success', 'Jam halaqah berhasil dibuat');
    }

    public function createJadwalHalaqah()
    {
        $halaqah = Halaqah::all();

        $gurus = User::whereHas('roles', function ($q) {
            $q->where('name', 'muhafidz');
        })->get();


        $jamHalaqah = JamHalaqah::orderBy('jam_mulai')->get();

        return view('pages.tahfidz.tambahJadwalHalaqah', compact(
            'gurus',
            'halaqah',
            'jamHalaqah'
        ));
    }

    public function storeJadwalhalaqah(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'halaqah_id' => 'required|exists:mapels,id',
            'jam_halaqah_id' => 'required|array',
            'jam_pelajaran_id.*' => 'exists:jam_pelajarans,id',
        ]);

        foreach ($request->jam_halaqah_id as $jamId) {

            $halaqahBentrok = JadwalHalaqah::where('hari', $request->hari)
                ->whereHas('jam_halaqah', function ($q) use ($jamId) {
                    $q->where('jam_halaqah_id', $jamId);
                })
                ->exists();

            if ($halaqahBentrok) {
                return back()->with('error', 'Halaqah sudah memiliki jadwal di jam tersebut.');
            }
        }

        $jadwalHalaqah = JadwalHalaqah::create([
            'hari' => $request->hari,
            'halaqah_id' => $request->halaqah_id,
        ]);

        $jadwalHalaqah->jam_halaqah()->attach($request->jam_halaqah_id);

        return redirect()->route('tahfidz.jadwal-halaqah')->with('success', 'Jadwal berhasil ditambahkan.');
    }

}
