<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\JamKerja;
use App\Models\JamPelajaran;
use App\Models\Jenjang;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
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

    // kurikulum

    // bagian wali kelas
    public function waliKelas()
    {
    }

    // bagian jadwal mengajar
    public function tambahJamPelajaran(){
        $jenjang = Jenjang::all();
        return view('pages.kurikulum.tambahJamPelajaran',compact('jenjang'));
    }

    public function storeJamPelajaran(Request $request){

        $request->validate([
            'jam_ke' => 'required',
            'jenjang_id' => 'required|exists:jenjangs,id',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $isJamPelajaranExist = JamPelajaran::where('jam_ke', $request->jam_ke)->where('jenjang_id', $request->jenjang_id)->exists();

        if($isJamPelajaranExist){
            return back()->with('error', 'Jam ke ' . $request->jam_ke . ' sudah dibuat');
        }else if($request->jam_mulai > $request->jam_selesai){
            return back()->with('error', 'Jam mulai lebih besar daripada jam selesai');
        }

        JamPelajaran::create([
            'jam_ke' => $request->jam_ke,
            'jenjang_id' => $request->jenjang_id,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return back()->with('success', 'Jam pelajaran berhasil dibuat');
    }

    public function indexJadwalMengajar(Request $request)
    {
        $query = Mapel::query();

        // 🔎 Filter berdasarkan hari
        $query->whereHas('jadwal', function ($q) use ($request) {

            if ($request->filled('hari')) {
                $q->where('hari', $request->hari);
            }

            if ($request->filled('kelas_id')) {
                $q->where('kelas_id', $request->kelas_id);
            }

            if ($request->filled('user_id')) {
                $q->where('user_id', $request->user_id);
            }
        });

        $query->with([
            'jadwal' => function ($q) use ($request) {

                if ($request->filled('hari')) {
                    $q->where('hari', $request->hari);
                }

                if ($request->filled('kelas_id')) {
                    $q->where('kelas_id', $request->kelas_id);
                }

                if ($request->filled('user_id')) {
                    $q->where('user_id', $request->user_id);
                }

                $q->with(['user', 'jam_pelajaran', 'kelas'])
                    ->orderByRaw("
        FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')
      ");
            }
        ]);

        $mapels = $query->paginate(10)->withQueryString();

        $kelas = Kelas::all();

        $gurus = User::whereHas('roles', function ($q) {
            $q->where('name', 'guru');
        })->get();

        return view('pages.kurikulum.jadwal', compact(
            'mapels',
            'kelas',
            'gurus'
        ));
    }

    public function createJadwalMengajar()
    {
        $kelas = Kelas::all();

        $gurus = User::whereHas('roles', function ($q) {
            $q->where('name', 'guru');
        })->get();

        $mapels = Mapel::all();

        $jamPelajarans = JamPelajaran::with('jenjang')->orderBy('jenjang_id')->orderBy('jam_mulai')->get()->groupBy('jenjang.nama_jenjang');

        return view('pages.kurikulum.tambahJadwal', compact(
            'kelas',
            'gurus',
            'mapels',
            'jamPelajarans'
        ));
    }

    public function storeJadwalMengajar(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'user_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mapels,id',
            'jam_pelajaran_id' => 'required|array',
            'jam_pelajaran_id.*' => 'exists:jam_pelajarans,id',
        ]);

        foreach($request->jam_pelajaran_id as $jamId) {

            $kelasBentrok = Jadwal::where('hari', $request->hari)
                ->where('kelas_id', $request->kelas_id)
                ->whereHas('jam_pelajaran', function($q) use ($jamId){
                    $q->where('jam_pelajaran_id', $jamId);
                })
                ->exists();

            if ($kelasBentrok) {
                return back()->with('error', 'Kelas sudah memiliki jadwal di jam tersebut.');
            }

            $guruBentrok = Jadwal::where('hari', $request->hari)
                ->where('user_id', $request->user_id)
                ->whereHas('jam_pelajaran', function($q) use ($jamId){
                    $q->where('jam_pelajaran_id', $jamId);
                })
                ->exists();

            if ($guruBentrok) {
                return back()->with('error', 'Guru sudah mengajar di jam tersebut.');
            }
        }

         $jadwal = Jadwal::create([
            'hari' => $request->hari,
            'kelas_id' => $request->kelas_id,
            'user_id' => $request->user_id,
            'mapel_id' => $request->mapel_id,
        ]);

        $jadwal->jam_pelajaran()->attach($request->jam_pelajaran_id);

        return redirect()
            ->route('kurikulum.jadwal')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function editJadwalMengajar(Jadwal $jadwal)
    {
        $mapels = Mapel::all();
        $kelas = Kelas::all();
        $jamPelajarans = JamPelajaran::with('jenjang')->orderBy('jenjang_id')->orderBy('jam_mulai')->get()->groupBy('jenjang.nama_jenjang');
        $jadwalEdit = $jadwal->load('user');
        return view('pages.kurikulum.editJadwal', compact('jadwalEdit', 'mapels', 'kelas', 'jamPelajarans'));
    }

    public function updateJadwalMengajar(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'hari' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'jam_pelajaran_id' => 'required|array',
            'jam_pelajaran_id.*' => 'exists:jam_pelajarans,id',
        ]);

        foreach($request->jam_pelajaran_id as $jamId) {

            $kelasBentrok = Jadwal::where('hari', $request->hari)
                ->where('kelas_id', $request->kelas_id)
                ->whereHas('jam_pelajaran', function($q) use ($jamId){
                    $q->where('jam_pelajaran_id', $jamId);
                })
                ->exists();

            if ($kelasBentrok) {
                return back()->with('error', 'Kelas sudah memiliki jadwal di jam tersebut.');
            }

            $guruBentrok = Jadwal::where('hari', $request->hari)
                ->where('user_id', $request->user_id)
                ->whereHas('jam_pelajaran', function($q) use ($jamId){
                    $q->where('jam_pelajaran_id', $jamId);
                })
                ->exists();

            if ($guruBentrok) {
                return back()->with('error', 'Guru sudah mengajar di jam tersebut.');
            }
        }

        $jadwal->update($request->only('hari', 'kelas_id', 'mapel_id'));
        $jadwal->jam_pelajaran()->sync($request->jam_pelajaran_id);

         return redirect()
            ->route('kurikulum.jadwal')
            ->with('success', 'Jadwal berhasil diupdate.');
    }

    public function destroyJadwalMengajar(Jadwal $jadwal)
    {
        $jadwal->jam_pelajaran()->detach();
        $jadwal->delete();
        return redirect()
        ->route('kurikulum.jadwal')
        ->with('success', 'Jadwal berhasil dihapus.');
    }

    // jurnal
    public function indexJurnal()
    {
        $jurnal = Jurnal::with('jadwal')->get();
        $kelas = Kelas::all();

        return view('pages.kurikulum.jurnal', compact('jurnal', 'kelas'));
    }

    // kelas dan jenjang
    public function indexKelas()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get()->sortByDesc('jenjang.nama_jenjang');

        return view('pages.kurikulum.kelas', compact('kelas'));
    }

    public function createKelas()
    {
        $jenjang = Jenjang::all();

        return view('pages.kurikulum.tambahKelas', compact('jenjang'));
    }

    public function editKelas(Kelas $kelas)
    {
        $jenjang = Jenjang::all();
        $kelas->load('jenjang');

        return view('pages.kurikulum.editKelas', compact('kelas', 'jenjang'));
    }

    public function updateKelas(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'jenjang_id' => 'required|exists:jenjangs,id',
        ]);
        $kelas->update($request->all());

         return redirect()->route('kurikulum.kelas')->with('success', 'Kelas berhasil diupdate');
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'jenjang_id' => 'required|exists:jenjangs,id',
        ]);

        Kelas::create($request->all());

        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan');

    }

    public function destroyKelas(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()->back()->with('success', 'Kelas berhasil dihapus');

    }

    public function createJenjang()
    {
        return view('pages.kurikulum.tambahJenjang');
    }

    public function storeJenjang(Request $request)
    {
        $request->validate([
            'nama_jenjang' => 'required',
        ]);

        Jenjang::create($request->all());

        return redirect()->back()->with('success', 'Jenjang berhasil ditambahkan');
    }

    public function indexSiswa(Request $request)
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

        $siswa = $query->paginate(20)->withQueryString();
        $kelas = Kelas::all();
        $jenjang = Jenjang::all();

        return view('pages.kurikulum.siswa', compact('siswa', 'kelas', 'jenjang'));
    }

    public function createSiswa(Murid $siswa)
    {
        $jenjang = Jenjang::all();
        $kelas = Kelas::all();

        return view('pages.kurikulum.tambahSiswa', compact('jenjang', 'kelas'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'alamat' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        Murid::create($request->all());

        return redirect()->route('kurikulum.siswa.create')->with('success', 'Santri berhasil ditambahkan');
    }

    public function editSiswa(Murid $siswa)
    {
        $jenjang = Jenjang::all();
        $kelas = Kelas::all();
        $siswa->load('kelas');

        return view('pages.kurikulum.editSiswa', compact('siswa', 'jenjang', 'kelas'));
    }

    public function updateSiswa(Murid $siswa, Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'alamat' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
        ]);
        $siswa->update($request->all());

        return redirect()->route('kurikulum.siswa')->with('success', 'Santri berhasil diupdate');
    }

    public function destroySiswa(Murid $siswa)
    {
        $siswa->delete();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus');

    }
}
