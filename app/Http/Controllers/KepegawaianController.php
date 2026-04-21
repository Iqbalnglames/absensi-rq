<?php

namespace App\Http\Controllers;

use App\Models\AbsenGuru;
use App\Models\JamKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KepegawaianController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today()->toDateString();;
        $absenGuru = AbsenGuru::where('tanggal', $today)->paginate(20);
        $absenHariIni = $absenGuru->where('tanggal', $today)->count();
        $absenTerlambatHariIni = $absenGuru->where('tanggal', $today)->where('status', 'terlambat')->count();
        $absenIzinHariIni = $absenGuru->where('tanggal', $today)->where('status', 'izin')->count();

        return view('dashboard', compact('absenGuru', 'absenHariIni', 'absenTerlambatHariIni', 'absenIzinHariIni'));
    }

    public function qrGenerator()
    {
        $today = Carbon::today();
        $hariIni = strtolower($today->locale('id')->dayName);
        $hashHariIni = hash('sha256', $hariIni . "|");
        $qr =  QrCode::size(400)->generate($hashHariIni);

        return view('pages.kepegawaian.qrViewer', compact('hashHariIni', 'qr'));
    }

    public function absen()
    {
        $today = Carbon::today();
        $hariIni = strtolower($today->locale('id')->dayName);
        $secret = config('app.key');
        $user = Auth::user();
        $jadwalHariIni = $user->whereHas('jadwal_kerja', function($q) use ($hariIni) {
            $q->where('hari', $hariIni);
        });

        $rawToken = $jadwalHariIni->exists() ? hash('sha256', $jadwalHariIni->first() . '|' . $secret) : '';
        // dd($rawToken);
        return view('pages.kepegawaian.absenPegawai', compact('rawToken'));
    }

    public function absenMasuk(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $hariIni = strtolower($today->locale('id')->dayName);
        $jadwalHariIni = $user->whereHas('jadwal_kerja', function($q) use ($hariIni) {
            $q->where('hari', $hariIni);
        });
        $secret = config('app.key');
        $hashHariIni = hash('sha256', $hariIni . "|");
        $todayToken = $hashHariIni . hash('sha256', $jadwalHariIni->first() . '|' . $secret);

        $jadwal = JamKerja::where('user_id', $user->id)
            ->where('hari', $hariIni)
            ->first();

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Tidak ada jadwal kerja hari ini');
        }

        if($request->token_absen != $todayToken) {
            return redirect()->back()->with('error', 'qr code tidak valid');
        }

        $sudahAbsen = AbsenGuru::where('jadwal_kerja_id', $jadwal->id)
            ->where('tanggal', $today->toDateString())
            ->exists();

        if ($sudahAbsen) {
            return redirect()->back()->with('info', 'Anda sudah absen hari ini');
        }

        $now = Carbon::now();
        $jamMasuk = Carbon::parse($jadwal->jam_masuk);
        $toleransiMasuk = $jamMasuk->copy()->addMinutes(10);

        $status = $now->gt($toleransiMasuk) ? 'terlambat' : 'hadir';

        AbsenGuru::create([
            'jadwal_kerja_id' => $jadwal->id,
            'tanggal'   => $today->toDateString(),
            'jam_masuk' => $now->toTimeString(),
            'status'    => $status,
        ]);

        // return response()->json([
        //     'message' => 'Absen berhasil',
        //     'status'  => $status,
        //     'jam'     => $now->format('H:i:s')
        // ]);
        return redirect()->route('kepegawaian.absen')->with(['success' => 'Absensi Berhasil', 'status' => $status]);
    }

    public function absenPulang()
{
    $user = Auth::user();
    $today = Carbon::today();
    $now = Carbon::now();
    $hariIni = strtolower($today->locale('id')->dayName);

    $jadwal = JamKerja::where('user_id', $user->id)
        ->where('hari', $hariIni)
        ->first();

    if (!$jadwal) {
        return back()->with('error', 'jadwal tidak ditemukan');
    }

    $cekAbsen = AbsenGuru::where('jadwal_kerja_id', $jadwal->id)
        ->where('tanggal', $today->toDateString())
        ->first();

    if (!$cekAbsen) {
        return back()->with('error', 'anda belum melakukan absen masuk');
    }

    if ($cekAbsen->jam_keluar) {
        return back()->with('error', 'anda sudah melakukan absen keluar');
    }

    $jamPulang = Carbon::parse($jadwal->jam_pulang);
    $status = $now->lt($jamPulang) ? 'pulang sebelum waktunya' : 'sesuai waktu';

    $cekAbsen->update([
        'jam_keluar' => $now->toTimeString(),
    ]);

    return back()->with([
        'success' => 'absen keluar berhasil',
        'status' => $status
    ]);
}
}
