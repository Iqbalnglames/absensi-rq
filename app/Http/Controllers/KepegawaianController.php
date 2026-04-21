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
    public function qrGenerator()
    {
        $today = Carbon::today();
        $hariIni = strtolower($today->locale('id')->dayName);
        $hashHariIni = hash('sha256', $hariIni . "|");
        $qr =  QrCode::size(200)->generate($hashHariIni);

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
        return view('pages.kepegawaian.absenPegawai', compact('rawToken'));
    }

    public function absenMasuk(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $hariIni = strtolower($today->locale('id')->dayName);
        $jadwalHariIni = $user->where('jadwal_kerja.hari', $hariIni)->exists();
        $secret = config('app.key');
        $todayToken = hash('sha256',  $hariIni . '|' . $jadwalHariIni . '|' . $secret);
  
        $jadwal = JamKerja::where('user_id', $user->id)
            ->where('hari', $hariIni)
            ->first();

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Tidak ada jadwal kerja hari ini');
        }

        if(!$request->tokenAbsen == $todayToken) {
            return redirect()->back()->with('error', 'qr code tidak valid');
        }
        
        $sudahAbsen = JamKerja::where('user_id', $user->id)
            ->where('tanggal', $today->toDateString())
            ->exists();

        if ($sudahAbsen) {
            return redirect()->back()->with('message', 'Anda sudah absen hari ini');
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
        return redirect()->route('kepegawaian.index')->with(['success' => 'Absensi Berhasil', 'status' => $status]);
    }
}
