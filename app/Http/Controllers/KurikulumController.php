<?php

namespace App\Http\Controllers;

use App\Models\AbsenMurid;
use App\Models\GuruMapelKelas;
use App\Models\Jadwal;
use App\Models\JamPelajaran;
use App\Models\Jenjang;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KurikulumController extends Controller
{
    public function createMapel()
    {
        $mapel = Mapel::paginate(10);
        return view('pages.kurikulum.tambahMapel', compact('mapel'));
    }
    
    public function storeMapel(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
        ]);

        Mapel::create($request->all());

        return redirect()->back()->with('success', 'Mapel berhasil disimpan');
    }

    public function destroyMapel(Mapel $mapel)
    {
        $mapel->delete();

        return redirect()->back()->with('success', 'Mapel berhasil dihapus');
    }

    // bagian jadwal mengajar
    public function tambahJamPelajaran()
    {
        $jenjang = Jenjang::all();
        return view('pages.kurikulum.tambahJamPelajaran', compact('jenjang'));
    }

    public function storeJamPelajaran(Request $request)
    {

        $request->validate([
            'jam_ke' => 'required',
            'jenjang_id' => 'required|exists:jenjangs,id',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $isJamPelajaranExist = JamPelajaran::where('jam_ke', $request->jam_ke)->where('jenjang_id', $request->jenjang_id)->exists();

        if ($isJamPelajaranExist) {
            return back()->with('error', 'Jam ke ' . $request->jam_ke . ' sudah dibuat');
        } else if ($request->jam_mulai > $request->jam_selesai) {
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

        foreach ($request->jam_pelajaran_id as $jamId) {

            $kelasBentrok = Jadwal::where('hari', $request->hari)
                ->where('kelas_id', $request->kelas_id)
                ->whereHas('jam_pelajaran', function ($q) use ($jamId) {
                    $q->where('jam_pelajaran_id', $jamId);
                })
                ->exists();

            if ($kelasBentrok) {
                return back()->with('error', 'Kelas sudah memiliki jadwal di jam tersebut.');
            }

            $guruBentrok = Jadwal::where('hari', $request->hari)
                ->where('user_id', $request->user_id)
                ->whereHas('jam_pelajaran', function ($q) use ($jamId) {
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

        foreach ($request->jam_pelajaran_id as $jamId) {

            $kelasBentrok = Jadwal::where('hari', $request->hari)
                ->where('kelas_id', $request->kelas_id)
                ->whereHas('jam_pelajaran', function ($q) use ($jamId) {
                    $q->where('jam_pelajaran_id', $jamId);
                })
                ->exists();

            if ($kelasBentrok) {
                return back()->with('error', 'Kelas sudah memiliki jadwal di jam tersebut.');
            }

            $guruBentrok = Jadwal::where('hari', $request->hari)
                ->where('user_id', $request->user_id)
                ->whereHas('jam_pelajaran', function ($q) use ($jamId) {
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
        $jurnal = Jurnal::with('jadwal')->orderByDesc('tanggal')->paginate(20);
        $kelas = Kelas::all();

        return view('pages.kurikulum.jurnal', compact('jurnal', 'kelas'));
    }

    public function pembelajaran()
    {
        $jadwal = Jadwal::where('user_id', '3')->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")->get();

        return view('pages.kurikulum.pembelajaran', compact('jadwal'));
    }

    public function jurnalKelas(Jadwal $jadwal)
    {
        $jadwal->load('kelas.murid');
        $today = now()->toDateString();
        
        // dd($today);

        $jurnal = Jurnal::where('jadwal_mengajar_id', $jadwal->id)
            ->where('tanggal', $today)
            ->first();

        return view('pages.kurikulum.jurnalKelas', compact('jadwal', 'jurnal'));
    }

    public function storeJurnalKelas(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'tanggal' => 'required',
            'bab' => 'required',
            'materi' => 'required',
        ]);

        Jurnal::create([
            'tanggal' => $request->tanggal,
            'bab' => $request->bab,
            'materi' => $request->materi,
            'catatan' => $request->catatan,
            'jadwal_mengajar_id' => $jadwal->id,
        ]);

        foreach ($jadwal->kelas->murid as $murid) {
            $status = $request->absen[$murid->id] ?? 'alpha';

            AbsenMurid::create([
                'tanggal' => $request->tanggal,
                'jadwal_mengajar_id' => $jadwal->id,
                'murid_id' => $murid->id,
                'status' => $status,
            ]);
        }
        return redirect()->back()->with('success', 'berhasil mengisi jurnal');
    }

    public function updateJurnalKelas(Request $request, Jadwal $jadwal, Jurnal $jurnal)
    {
        $request->validate([
            'tanggal' => 'required',
            'bab' => 'required',
            'materi' => 'required',
        ]);

        $jurnal->update([
            'tanggal' => $request->tanggal,
            'bab' => $request->bab,
            'materi' => $request->materi,
            'catatan' => $request->catatan,
            'jadwal_mengajar_id' => $jadwal->id,
        ]);

        AbsenMurid::where('jadwal_mengajar_id', $jadwal->id)->where('tanggal', $request->tanggal)->delete();

        foreach ($jadwal->kelas->murid as $murid) {
            $status = $request->absen[$murid->id] ?? 'alpha';


            AbsenMurid::create([
                'tanggal' => $request->tanggal,
                'jadwal_mengajar_id' => $jadwal->id,
                'murid_id' => $murid->id,
                'status' => $status,
            ]);
        }
        return redirect()->back()->with('success', 'berhasil mengisi jurnal');
    }

    // kelas dan jenjang
    public function editWaliKelas(Kelas $kelas)
    {
        $guru = User::whereHas('roles', function ($query) {
            $query->where('name', 'guru');
        })->get();

        return view('pages.kurikulum.editWaliKelas', compact('guru', 'kelas'));
    }

    public function updateWaliKelas(Kelas $kelas, Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $kelas->update($request->all());

        return redirect()->route('kurikulum.kelas')->with('success', 'Wali Kelas berhasil diupdate');
    }

    public function indexKelas(Request $request)
    {
        $query = Kelas::query();

        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }

        $jenjang = Jenjang::all();
        $kelas = $query->orderBy('jenjang_id')->orderBy('nama_kelas')->paginate(10);

        return view('pages.kurikulum.kelas', compact('kelas', 'jenjang'));
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

        $siswa = $query->orderBy('kelas_id')->orderBy('nama')->paginate(20)->withQueryString();
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

    public function mapelGuru(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $search = $request->search;

            $query->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('guruMapelKelas.mapel', function ($q2) use ($search) {
                    $q2->where('nama_mapel', 'like', '%' . $search . '%');
                });
        };

        $guru = $query->whereHas('roles', function ($q) {
            $q->where('name', 'guru');
        })->paginate(10)->withQueryString();

        return view('pages.kurikulum.mapelGuru', compact('guru'));
    }

    public function createMapelGuru(User $guru)
    {
        $mapels = Mapel::all();
        $kelas = Kelas::all();

        return view('pages.kurikulum.tambahMapelGuru', compact('guru', 'mapels', 'kelas'));
    }

    public function storeMapelGuru(Request $request)
    {
        $pengajar = GuruMapelKelas::query();
        $request->validate([
            'user_id' => [
                'required',
                Rule::unique('mapel_gurus')->where(function ($query) use ($request) {
                    return $query->where('kelas_id', $request->kelas_id)
                        ->where('mapel_id', $request->mapel_id);
                }),
            ],
            'kelas_id' => 'required',
            'mapel_id' => 'required',
        ], [
            'user_id.unique' => 'Pengajar dengan kelas dan mapel ini sudah ada',
        ]);

        $pengajar->create([
            'user_id' => $request->user_id,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
        ]);


        return redirect()->back()->with('success', 'Mapel ajar berhasil dibuat');
    }

    public function editMapelGuru(GuruMapelKelas $guru)
    {
        $editGuruMapel = $guru->load('guru', 'mapel', 'kelas');
        $mapels = Mapel::all();
        $kelas = Kelas::all();

        return view('pages.kurikulum.editMapelGuru', compact('editGuruMapel', 'mapels', 'kelas'));
    }

    public function updateMapelGuru(Request $request, GuruMapelKelas $guru)
    {
        if(
            $request->user_id == $guru->user_id &&
            $request->kelas_id == $guru->kelas_id &&
            $request->mapel_id == $guru->mapel_id
        ){
            return redirect()->route('kurikulum.mapel-guru')->with('info', 'tidak ada perubahan');
        }
        $request->validate([
            'user_id' => [
                'required',
                Rule::unique('mapel_gurus')->where(function ($query) use ($request) {
                    return $query->where('kelas_id', $request->kelas_id)
                        ->where('mapel_id', $request->mapel_id);
                })->ignore($guru->id),
            ],
            'kelas_id' => 'required',
            'mapel_id' => 'required',
        ], [
            'user_id.unique' => 'Pengajar dengan kelas dan mapel ini sudah ada',
        ]);

        $guru->update([
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->back()->with('success', 'Mapel ajar berhasil diperbarui');
    }

    public function destroyMapelGuru(GuruMapelKelas $guru)
    {
        $guru->delete();

        return redirect()->back()->with('success', 'Penyerahan Mapel berhasil dihapus');
    }

    public function indexAbsenSiswa(Request $request)
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

        $absenSiswa = $query->orderBy('kelas_id')->orderBy('nama')->paginate(20)->withQueryString();
        $kelas = Kelas::all();
        $jenjang = Jenjang::all();

        return view('pages.kurikulum.absensiMurid', compact('absenSiswa', 'kelas', 'jenjang'));
    }

    public function detailAbsenSiswa(Murid $siswa)
    {
        $siswa->load('kelas');
        return view('pages.kurikulum.detailAbsenSiswa', compact('siswa'));
    }

    public function penilaian(Request $request)
    {
        $query = Kelas::query();

        if ($request->filled('jenjang_id')) {
            $query->where('jenjang_id', $request->jenjang_id);
        }

        $jenjang = Jenjang::all();
        $kelas = $query->orderBy('jenjang_id')->orderBy('nama_kelas')->paginate(10);

        return view('pages.kurikulum.penilaian', compact('kelas', 'jenjang'));
    }

    public function detailPenilaianKelas(Kelas $kelas)
    {
        $murid = $kelas->murid()->orderBy('nama')->paginate(20);
        return view('pages.kurikulum.detailPenilaianKelas', compact('kelas', 'murid'));
    }

    public function detailPenilaianSiswa(Murid $murid)
    {
        $mapel = Mapel::paginate(10);
        return view('pages.kurikulum.detailPenilaianSiswa', compact('murid', 'mapel'));
    }

    public function detailNilaiSiswa(Murid $murid, Mapel $mapel, Kelas $kelas, $semester)
    {
        $nilai = Nilai::where('murid_id', $murid->id)
        ->where('mapel_id', $mapel->id)
        ->where('kelas_id', $kelas->id)
        ->where('semester', $semester)
        ->first();

        return view('pages.kurikulum.detailNilaiMapelSiswa', compact('nilai', 'mapel', 'murid', 'semester'));
    }

    public function storeNilaiSiswa(Request $request)
    {
        $request->validate([
            'tugas_1' => 'nullable|numeric|min:0|max:100',
            'tugas_2' => 'nullable|numeric|min:0|max:100',
            'tugas_3' => 'nullable|numeric|min:0|max:100',
            'pts'     => 'nullable|numeric|min:0|max:100',
            'pas'     => 'nullable|numeric|min:0|max:100',
            'semester'=> 'required|numeric|min:0|max:2',
            'murid_id' =>'required',
            'mapel_id' => 'required',
            'kelas_id' => 'required',
        ], [
            'murid_id.unique' => 'Nilai siswa untuk mapel & semester ini sudah ada'
        ]);

        // hitung nilai akhir (opsional)
        // $semester = collect([
        //     $request->tugas_1,
        //     $request->tugas_2,
        //     $request->tugas_3,
        //     $request->pts,
        //     $request->pas
        // ])->filter()->avg();

        Nilai::create([
            'tugas_1' => $request->tugas_1,
            'tugas_2' => $request->tugas_2,
            'tugas_3' => $request->tugas_3,
            'pts'     => $request->pts,
            'pas'     => $request->pas,
            'semester'=> $request->semester,

            'murid_id'=> $request->murid_id,
            'mapel_id'=> $request->mapel_id,
            'kelas_id'=> $request->kelas_id,

            // 'semester_nilai' => $semester, 
        ]);

        return back()->with('success', 'Nilai berhasil ditambahkan');
    }

    public function updateNilaiSiswa(Request $request, Nilai $nilai)
    {
        // cek tidak ada perubahan
        if (
            $nilai->tugas_1 == $request->tugas_1 &&
            $nilai->tugas_2 == $request->tugas_2 &&
            $nilai->tugas_3 == $request->tugas_3 &&
            $nilai->pts == $request->pts &&
            $nilai->pas == $request->pas &&
            $nilai->semester == $request->semester
        ) {
            return back()->with('info', 'Tidak ada perubahan data');
        }

        $request->validate([
            'tugas_1' => 'nullable|numeric|min:0|max:100',
            'tugas_2' => 'nullable|numeric|min:0|max:100',
            'tugas_3' => 'nullable|numeric|min:0|max:100',
            'pts'     => 'nullable|numeric|min:0|max:100',
            'pas'     => 'nullable|numeric|min:0|max:100',
            'semester'=> 'required|numeric|min:0|max:2',
            'murid_id' => 'required',
            'mapel_id' => 'required',
            'kelas_id' => 'required',
        ]);

        // hitung ulang nilai akhir
        // $semester = collect([
        //     $request->tugas_1,
        //     $request->tugas_2,
        //     $request->tugas_3,
        //     $request->pts,
        //     $request->pas
        // ])->filter()->avg();

        $nilai->update([
            'tugas_1' => $request->tugas_1,
            'tugas_2' => $request->tugas_2,
            'tugas_3' => $request->tugas_3,
            'pts'     => $request->pts,
            'pas'     => $request->pas,
            'semester'=> $request->semester,

            'murid_id'=> $request->murid_id,
            'mapel_id'=> $request->mapel_id,
            'kelas_id'=> $request->kelas_id,

            // 'semester_nilai' => $semester,
        ]);

        return back()->with('success', 'Nilai berhasil diperbarui');
    }
}
