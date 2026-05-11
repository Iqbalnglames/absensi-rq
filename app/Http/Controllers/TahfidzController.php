<?php

namespace App\Http\Controllers;

use App\Models\AbsenHalaqah;
use App\Models\Halaqah;
use App\Models\JadwalHalaqah;
use App\Models\JamHalaqah;
use App\Models\JurnalTahfidz;
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
            $q->where('name', 'muhafidz');
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
            $q->where('name', 'muhafidz');
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
        $jadwal = Halaqah::where('user_id', $user->id)->get();

        return view('pages.tahfidz.pembelajaranTahfidz', compact('jadwal'));
    }

    public function indexJadwalHalaqah(Request $request)
    {
        $query = Halaqah::query();

        $halaqah = $query->with('jam_halaqah')->paginate(10)->withQueryString();

        return view('pages.tahfidz.jadwalHalaqah', compact('halaqah'));
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
            'halaqah_id' => 'required|exists:mapels,id',
            'jam_halaqah_id' => 'required|array',
            'jam_halaqahs_id.*' => 'exists:jam_halaqahs,id',
        ]);

        // foreach ($request->jam_halaqah_id as $jamId) {

        
        // }
        $halaqah = Halaqah::find($request->halaqah_id);

        $halaqah->jam_halaqah()->sync($request->jam_halaqah_id);

        return redirect()->route('tahfidz.jadwal-halaqah')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function jurnalHalaqah(Halaqah $halaqah, JamHalaqah $jamHalaqah)
    {
        $today = now()->toDateString();

        $jurnal = JurnalTahfidz::where('jam_halaqah_id', $jamHalaqah->id)->where('halaqah_id', $halaqah->id)->where('tanggal', $today)->first();

        return view('pages.tahfidz.jurnalHalaqah', compact('jurnal', 'jamHalaqah', 'halaqah'));
    }

    public function storeJurnalHalaqah(Request $request, Halaqah $halaqah, JamHalaqah $jamHalaqah)
    {
        $request->validate([
            'tanggal' => 'required',
        ]);

        $jurnal = JurnalTahfidz::create([
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'halaqah_id' => $halaqah->id,
            'jam_halaqah_id' => $jamHalaqah->id,
            ]);

            foreach($halaqah->murid as $murid){
                $status = $request->absen[$murid->id] ?? 'alpha';

            AbsenHalaqah::create([
                'tanggal' => $request->tanggal,
                'jurnal_tahfidz_id' => $jurnal->id,
                'murid_id' => $murid->id,
                'status' => $status,
            ]);
        }
        return redirect()->back()->with('success', 'berhasil mengisi jurnal');
    }

    public function updateJurnalHalaqah(Request $request, JurnalTahfidz $jurnal, Halaqah $halaqah, JamHalaqah $jamHalaqah)
    {
        $request->validate([
            'tanggal' => 'required',
        ]);

        $jurnal->update([
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'jam_halaqah_id' => $jamHalaqah->id,
            'halaqah_id' => $halaqah->id,
            ]);

            AbsenHalaqah::where('jurnal_tahfidz_id', $jurnal->id)->where('tanggal', $request->tanggal)->delete();

            foreach($halaqah->murid as $murid) {
                $status = $request->absen[$murid->id] ?? 'alpha';


            AbsenHalaqah::create([
                'tanggal' => $request->tanggal,
                'jurnal_tahfidz_id' => $jurnal->id,
                'murid_id' => $murid->id,
                'status' => $status,
            ]);
        }
        return redirect()->back()->with('success', 'berhasil mengisi jurnal');
    }

    public function mutabaah(Murid $murid)
    {
        return view('pages.tahfidz.mutabaah', compact('murid'));
    }

    public function createMutabaah(Murid $murid)
    {
        return view('pages.tahfidz.tambahMutabaah', compact('murid'));
    }

    public function storeMutabaah(Request $request, Murid $murid)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_surat' => 'required',
            'ayat_awal' => 'required|numeric',
            'ayat_akhir' => 'required|numeric',
        ]);

        Mutabaah::create([
            'tanggal' => $request->tanggal,
            'nama_surat' => $request->nama_surat,
            'ayat_awal' => $request->ayat_awal,
            'ayat_akhir' => $request->ayat_akhir,
            'murid_id' => $murid->id,
        ]);

        return back()->with('success', 'berhasil mengisi mutabaah');
    }

    public function editMutabaah(Mutabaah $mutabaah, Murid $murid)
    {
        return view('pages.tahfidz.editMutabaah', compact('murid', 'mutabaah'));
    }

    public function updateMutabaah(Request $request, Mutabaah $mutabaah, Murid $murid)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_surat' => 'required',
            'ayat_awal' => 'required|numeric',
            'ayat_akhir' => 'required|numeric',
        ]);

        $mutabaah->update([
            'tanggal' => $request->tanggal,
            'nama_surat' => $request->nama_surat,
            'ayat_awal' => $request->ayat_awal,
            'ayat_akhir' => $request->ayat_akhir,
            'murid_id' => $murid->id,
        ]);

        return back()->with('success', 'berhasil mengupdate mutabaah');
    }

    public function rekapJurnalHalaqah($halaqah)
    {
        $jurnal = JurnalTahfidz::where('halaqah_id', $halaqah)->paginate(20);

        return view('pages.tahfidz.rekapJurnalHalaqah', compact('jurnal'));
    }
}
