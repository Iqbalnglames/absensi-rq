<?php

namespace App\Http\Controllers;

use App\Models\AbsenGuru;
use App\Models\Izin;
use App\Models\JamKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KepegawaianController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today()->toDateString();
        $hariIni = strtolower(Carbon::today()->locale('id')->dayName);
        $absenGuru = AbsenGuru::where('tanggal', $today)->paginate(20);
        $absenHariIni = $absenGuru->where('tanggal', $today)->count();
        $absenTerlambatHariIni = $absenGuru->where('tanggal', $today)->where('status', 'terlambat')->count();
        $absenIzinHariIni = $absenGuru->where('tanggal', $today)->where('status', 'izin')->count();
        $belumAbsen = User::whereHas('jadwal_kerja', function ($q) use ($hariIni) {
            $q->where('hari', $hariIni);
        })->whereDoesntHave('absen_guru', function ($q) use ($today) {
            $q->where('tanggal', $today);
        })->count();

        return view('dashboard', compact('absenGuru', 'absenHariIni', 'absenTerlambatHariIni', 'absenIzinHariIni', 'belumAbsen'));
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
        $jadwalHariIni = $user->whereHas('jadwal_kerja', function ($q) use ($hariIni) {
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
        $jadwalHariIni = $user->whereHas('jadwal_kerja', function ($q) use ($hariIni) {
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

        if ($request->token_absen != $todayToken) {
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

    public function izinUser()
    {
        $user = Auth::user();

        $izin = Izin::where('user_id', $user->id)->get();

        return view('pages.kepegawaian.izinUser', compact('user', 'izin'));
    }

    public function pengajuanIzinUser()
    {
        return view('pages.kepegawaian.tambahIzin');
    }

    public function storeIzinUser(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'alasan' => 'required',
        ]);

        Izin::create([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'menunggu persetujuan',
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('kepegawaian.izin-user')->with('success', 'berhasil mengajukan izin');
    }

    public function editIzinUser(Izin $izin)
    {
        return view('pages.kepegawaian.editIzin', compact('izin'));
    }

    public function updateIzinUser(Request $request, Izin $izin)
    {
        $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'alasan' => 'required',
        ]);

        $izin->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'menunggu persetujuan',
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('kepegawaian.izin-user')->with('success', 'berhasil mengedit izin');
    }

    public function destroyIzinUser(Izin $izin)
    {
        $izin->delete();

        return redirect()->back()->with('success', 'izin berhasil dibatalkan');
    }
}
