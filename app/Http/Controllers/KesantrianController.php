<?php

namespace App\Http\Controllers;

use App\Models\AbsenEkskul;
use App\Models\Asrama;
use App\Models\CatatanPelanggaran;
use App\Models\Ekskul;
use App\Models\JadwalEkskul;
use App\Models\Jenjang;
use App\Models\JurnalEkskul;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Pelanggaran;
use App\Models\Perizinan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            $query->where('name', 'kesantrian');
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

    public function createJenisPelanggaran()
    {
        return view('pages.kesantrian.tambahJenisPelanggaran');
    }

    public function storeJenisPelanggaran(Request $request)
    {
         $request->validate([
            'jenis_pelanggaran' => 'required',
            'poin' => 'required',
        ]);

        Pelanggaran::create($request->all());

        return redirect()->back()->with('success', 'data jenis pelanggaran berhasil disimpan');

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

    public function perizinan(Request $request)
    {
       $query = Perizinan::query();

        $query->whereHas('murid', function($q) use ($request) {
            if ($request->filled('nama_siswa')){
                $q->where('nama', 'like', '%' . $request->nama_siswa . '%');
            }
        });

        $perizinan = $query->orderByDesc('created_at')->paginate(20);

       return view('pages.kesantrian.perizinan', compact('perizinan'));
    }

    public function createPerizinan()
    {
        $siswa = Murid::all();
        return view('pages.kesantrian.tambahPerizinan', compact('siswa'));
    }

    public function editPerizinan(Perizinan $perizinan)
    {
        $siswa = Murid::all();
        return view('pages.kesantrian.editPerizinan', compact('perizinan', 'siswa'));
    }

    public function updatePerizinan(Perizinan $perizinan, Request $request)
    {
         $request->validate([
            'murid_id' => 'required',
            'waktu_mulai_izin' => 'required',
            'waktu_selesai_izin' => 'required',
            'tanggal' => 'required',
        ]);

        $perizinan->update([
            'murid_id' => $request->murid_id,
            'waktu_izin' => $request->waktu_mulai_izin . "-" . $request->waktu_selesai_izin,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('kesantrian.perizinan')->with('success', 'data perizinan berhasil diupdate');
    }

    public function storePerizinan(Request $request)
    {
         $request->validate([
            'murid_id' => 'required',
            'waktu_mulai_izin' => 'required',
            'waktu_selesai_izin' => 'required',
            'tanggal' => 'required',
        ]);

        Perizinan::create([
            'murid_id' => $request->murid_id,
            'waktu_izin' => $request->waktu_mulai_izin . "-" . $request->waktu_selesai_izin,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->back()->with('success', 'data perizinan berhasil disimpan');
    }

    public function ekskul(Request $request)
    {
        $ekskul = Ekskul::orderByDesc('created_at')->paginate(20);

        return view('pages.kesantrian.ekskul', compact('ekskul'));
    }

    public function createEkskul()
    {
        return view('pages.kesantrian.tambahEkskul');
    }

    public function storeEkskul(Request $request)
    {
         $request->validate([
            'nama_ekskul' => 'required',
        ]);

        Ekskul::create($request->all());

        return redirect()->back()->with('success', 'data ekskul berhasil disimpan');
    }

    public function editEkskul(Ekskul $ekskul)
    {
        return view('pages.kesantrian.editEkskul', compact('ekskul'));
    }

    public function updateEkskul(Request $request, Ekskul $ekskul)
    {
         $request->validate([
            'nama_ekskul' => 'required',
        ]);

        $ekskul->update($request->all());

        return redirect()->route('kesantrian.ekskul')->with('success', 'data ekskul berhasil disimpan');
    }

    public function destroyEkskul(Ekskul $ekskul)
    {
        $ekskul->delete();

        return redirect()->back()->with('success', 'ekskul berhasil dihapus');
    }

    public function pesertaEkskul(Ekskul $ekskul)
    {
        $siswa = Murid::all();
        $detailEkskul = $ekskul->load('murid');

        return view('pages.kesantrian.pesertaEkskul', compact('detailEkskul', 'siswa'));
    }

    public function storePesertaEkskul(Request $request, Ekskul $ekskul)
    {
         $request->validate([
            'murid_id' => 'required',
        ]);

        $exist = $ekskul->murid()->where('murid_id', $request->murid_id)->exists();

        if($exist){
            return redirect()->back()->with('error', 'peserta ekskul sudah ditambahkan sebelumnya!');
        }

        $ekskul->murid()->syncWithoutDetaching($request->murid_id);

        return redirect()->back()->with('success', 'peserta ekskul berhasil ditambahkan');
    }

    public function hapusPesertaEkskul(Ekskul $ekskul, Murid $murid)
    {
        $murid->ekskul()->detach($ekskul->id);
        return redirect()->back()->with('success', 'peserta ekskul berhasil dihapus');
    }

    public function createJadwalEkskul()
    {
        $ekskul = Ekskul::all();
        $guru = User::whereHas('roles', function($q){
            $q->where('name', 'guru');
        })->get();
        return view('pages.kesantrian.tambahJadwalEkskul', compact('ekskul', 'guru'));
    }

    public function storeJadwalEkskul(Request $request)
    {
         $request->validate([
        'ekskul_id' => ['required', Rule::unique('jadwal_ekskuls')->where(function($q) use ($request){
            return $q->where('hari', $request->hari);
        }),
        ],
        'hari' => 'required',
    ], [
        'ekskul_id.unique' => 'Jadwal ekskul di hari tersebut sudah dibuat!',
    ]);

        JadwalEkskul::create($request->all());

        return redirect()->back()->with('success', 'jadwal ekskul berhasil dibuat');
    }

    public function pembelajaranEkskul()
    {
        $user = Auth::user();
        $ekskul = JadwalEkskul::where('user_id', $user->id)->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")->get();

        return view('pages.kesantrian.pembelajaranEkskul', compact('ekskul'));
    }

    public function createJurnalEkskul(JadwalEkskul $jadwal)
    {
        $jadwal->load('ekskul.murid');
        $today = now()->toDateString();

        $jurnal = JurnalEkskul::where('jadwal_ekskul_id', $jadwal->id)
        ->where('tanggal', $today)
        ->first();

        return view('pages.kesantrian.jurnalEkskul', compact('jadwal', 'jurnal'));
    }

    public function storeJurnalEkskul(Request $request, JadwalEkskul $jadwal)
    {
        $request->validate([
            'tanggal' => 'required',
            'materi' => 'required',
        ]);

        JurnalEkskul::create([
            'tanggal' => $request->tanggal,
            'materi' => $request->materi,
            'catatan' => $request->catatan,
            'jadwal_ekskul_id' => $jadwal->id,
            ]);

            foreach($jadwal->ekskul->murid as $murid){
                $status = $request->absen[$murid->id] ?? 'alpha';

            AbsenEkskul::create([
                'tanggal' => $request->tanggal,
                'jadwal_ekskul_id' => $jadwal->id,
                'murid_id' => $murid->id,
                'status' => $status,
            ]);
        }
        return redirect()->back()->with('success', 'berhasil mengisi jurnal');
    }

    public function updateJurnalEkskul(Request $request, JadwalEkskul $jadwal, JurnalEkskul $jurnal)
    {
        $request->validate([
            'tanggal' => 'required',
            'materi' => 'required',
        ]);

        $jurnal->update([
            'tanggal' => $request->tanggal,
            'materi' => $request->materi,
            'catatan' => $request->catatan,
            'jadwal_ekskul_id' => $jadwal->id,
            ]);

            AbsenEkskul::where('jadwal_ekskul_id', $jadwal->id)->where('tanggal', $request->tanggal)->delete();

            foreach($jadwal->ekskul->murid as $murid){
                $status = $request->absen[$murid->id] ?? 'alpha';


            AbsenEkskul::create([
                'tanggal' => $request->tanggal,
                'jadwal_ekskul_id' => $jadwal->id,
                'murid_id' => $murid->id,
                'status' => $status,
            ]);
        }
        return redirect()->back()->with('success', 'berhasil mengisi jurnal');
    }
}
