<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AbsenMurid;
use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Jadwal;

class JurnalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST JURNAL BERDASARKAN JADWAL
    |--------------------------------------------------------------------------
    */

    public function index(Request $request, $jadwalId)
    {
        $user = $request->user();

        $isAdmin = $user->roles()->where('name', 'admin')->exists();

        $jadwalQuery = Jadwal::where('id', $jadwalId);

        if (!$isAdmin) {
            $jadwalQuery->where('user_id', $user->id);
        }

        $jadwal = $jadwalQuery->firstOrFail();

        $jurnals = $jadwal->jurnals()->latest()->get();

        return response()->json([
            'success' => true,
            'jadwal' => $jadwal->id,
            'data' => $jurnals
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN / UPDATE JURNAL
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwal_mengajars,id',
            'tanggal'   => 'required|date',
            'materi'    => 'required|string',
            'catatan'   => 'nullable|string'
        ]);

        $jadwalQuery = Jadwal::where('id', $validated['jadwal_id']);

        $isAdmin = $user->roles()->where('name', 'admin')->exists();

        if (!$isAdmin) {
            $jadwalQuery->where('user_id', $user->id);
        }

        $jadwal = $jadwalQuery->firstOrFail();

        $jurnal = Jurnal::updateOrCreate(
            [
                'jadwal_id' => $jadwal->id,
                'tanggal'   => $validated['tanggal']
            ],
            [
                'materi'  => $validated['materi'],
                'catatan' => $validated['catatan']
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil disimpan',
            'data' => $jurnal
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL JURNAL
    |--------------------------------------------------------------------------
    */

    public function show(Request $request, $id)
    {
        $user = $request->user();

        $jurnal = Jurnal::with('jadwal')->findOrFail($id);

        $isAdmin = $user->roles()->where('name', 'admin')->exists();

        if (!$isAdmin && $jurnal->jadwal->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return response()->json([
            'success' => true,
            'data' => $jurnal
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE JURNAL (ADMIN ONLY)
    |--------------------------------------------------------------------------
    */

    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        if (!$user->roles()->where('name', 'admin')->exists()) {
            abort(403, 'Admin only');
        }

        $jurnal = Jurnal::findOrFail($id);
        $jurnal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil dihapus'
        ]);
    }

    public function rekapBulanan(Request $request)
    {
        $user = $request->user();

        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $isAdmin = $user->roles()->where('name', 'admin')->exists();

        /*
    |--------------------------------------------------------------------------
    | QUERY JURNAL
    |--------------------------------------------------------------------------
    */

        $jurnalQuery = Jurnal::with('jadwal')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        if (!$isAdmin) {
            $jurnalQuery->whereHas('jadwal', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $jurnals = $jurnalQuery->get();

        /*
    |--------------------------------------------------------------------------
    | QUERY ABSENSI
    |--------------------------------------------------------------------------
    */

        $absenQuery = AbsenMurid::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        if (!$isAdmin) {
            $absenQuery->whereHas('jadwal', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $absens = $absenQuery->get();

        /*
    |--------------------------------------------------------------------------
    | HITUNG DATA
    |--------------------------------------------------------------------------
    */

        $totalJurnal = $jurnals->count();
        $totalPertemuan = $jurnals->pluck('tanggal')->unique()->count();
        $totalKelas = $jurnals->pluck('jadwal.kelas_id')->unique()->count();

        $hadir = $absens->where('status', 'hadir')->count();
        $izin  = $absens->where('status', 'izin')->count();
        $sakit = $absens->where('status', 'sakit')->count();
        $alpha = $absens->where('status', 'alpha')->count();

        $totalAbsen = $hadir + $izin + $sakit + $alpha;

        $persentase = $totalAbsen > 0
            ? round(($hadir / $totalAbsen) * 100, 2)
            : 0;

        return response()->json([
            'success' => true,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data' => [
                'total_jurnal_mengajar' => $totalJurnal,
                'total_pertemuan' => $totalPertemuan,
                'total_kelas_aktif' => $totalKelas,
                'rekap_absensi' => [
                    'hadir' => $hadir,
                    'izin'  => $izin,
                    'sakit' => $sakit,
                    'alpha' => $alpha,
                    'persentase_kehadiran' => $persentase . '%'
                ]
            ]
        ]);
    }
}
