<?php

namespace App\Http\Controllers;

use App\Models\AbsenMurid;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class AjarController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $isAdmin = $user->roles()->where('name', 'admin')->exists();

        if ($isAdmin) {

            // ADMIN → RETURN VIEW
            $jadwals = Jadwal::with(['user', 'mapel', 'kelas', 'jam_pelajaran'])->get();

            return view('jadwal.index', compact('jadwals'));
        }

        // GURU → RETURN JSON
        $jadwals = Jadwal::with(['mapel', 'kelas', 'jam_pelajaran'])
            ->where('user_id', $user->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jadwals
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();

        $isAdmin = $user->roles()->where('name', 'admin')->exists();

        $query = Jadwal::with(['user', 'mapel', 'kelas', 'jam_pelajaran', 'jurnals']);

        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }

        $jadwal = $query->findOrFail($id);

        if ($isAdmin) {
            return view('jadwal.show', compact('jadwal'));
        }

        return response()->json([
            'success' => true,
            'data' => $jadwal
        ]);
    }

    public function absenMurid(Request $request, $id)
    {
        $user = $request->user();

        $isAdmin = $user->roles()->where('name', 'admin')->exists();

        $query = Jadwal::with([
            'mapel',
            'kelas.siswas',
            'jam_pelajaran'
        ]);

        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }

        $jadwal = $query->findOrFail($id);

        $tanggal = now()->toDateString();

        // Ambil absensi hari ini
        $absensHariIni = AbsenMurid::where('jadwal_id', $jadwal->id)
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        $dataSiswa = $jadwal->kelas->siswas->map(function ($siswa) use ($absensHariIni) {

            return [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'status' => $absensHariIni[$siswa->id]->status ?? null
            ];
        });

        return response()->json([
            'success' => true,
            'jadwal' => [
                'id' => $jadwal->id,
                'hari' => $jadwal->hari,
                'mapel' => $jadwal->mapel->nama,
                'kelas' => $jadwal->kelas->nama,
                'jam' => $jadwal->jam_pelajaran->jam_mulai . ' - ' . $jadwal->jam_pelajaran->jam_selesai
            ],
            'tanggal' => $tanggal,
            'siswa' => $dataSiswa
        ]);
    }

    public function storeAbsen(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwal_mengajars,id',
            'tanggal'   => 'required|date',
            'siswa_id'  => 'nullable|exists:siswas,id',
            'data'      => 'nullable|array'
        ]);

        // Pastikan jadwal milik guru tersebut (kecuali admin)
        $jadwalQuery = Jadwal::where('id', $validated['jadwal_id']);

        $isAdmin = $user->roles()->where('name', 'admin')->exists();

        if (!$isAdmin) {
            $jadwalQuery->where('user_id', $user->id);
        }

        $jadwal = $jadwalQuery->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | MODE 1: BULK ABSEN
    |--------------------------------------------------------------------------
    */

        if (!empty($validated['data'])) {

            foreach ($validated['data'] as $item) {

                AbsenMurid::updateOrCreate(
                    [
                        'jadwal_id' => $jadwal->id,
                        'siswa_id'  => $item['siswa_id'],
                        'tanggal'   => $validated['tanggal']
                    ],
                    [
                        'status' => $item['status']
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil disimpan'
            ]);
        }

    /*
    |--------------------------------------------------------------------------
    | MODE 2: SINGLE ABSEN
    |--------------------------------------------------------------------------
    */

        if (!empty($validated['siswa_id'])) {

            $request->validate([
                'status' => 'required|in:hadir,izin,sakit,alpha'
            ]);

            $absen = AbsenMurid::updateOrCreate(
                [
                    'jadwal_id' => $jadwal->id,
                    'siswa_id'  => $validated['siswa_id'],
                    'tanggal'   => $validated['tanggal']
                ],
                [
                    'status' => $request->status
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Absensi siswa berhasil disimpan',
                'data' => $absen
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak valid'
        ], 422);
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN Zone
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jam_pelajaran_id' => 'required|exists:jam_pelajarans,id',
            'hari' => 'required|string',
        ]);

        $jadwal = Jadwal::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dibuat',
            'data' => $jadwal->load(['user', 'mapel', 'kelas', 'jam_pelajaran'])
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin($request);

        $jadwal = Jadwal::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jam_pelajaran_id' => 'required|exists:jam_pelajarans,id',
            'hari' => 'required|string',
        ]);

        $jadwal->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diperbarui',
            'data' => $jadwal->load(['user', 'mapel', 'kelas', 'jam_pelajaran'])
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizeAdmin($request);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus'
        ]);
    }


    private function authorizeAdmin(Request $request)
    {
        if ($request->user()->roles->name !== 'admin') {
            abort(403, 'Unauthorized. Admin only.');
        }
    }
}
