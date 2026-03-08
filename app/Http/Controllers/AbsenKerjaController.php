<?php

namespace App\Http\Controllers;

use App\Models\JamKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenKerjaController extends Controller
{
    public function jamKerja(User $user) 
    {
        $jamKerja = Auth::user()->jadwal_kerja();

        return response()->json([
            'message' => 'data jam kerja anda',
            'data' => $jamKerja,
        ]);
    }

    public function tambahJamKerja(Request $request)
    {
        $request->validate([
            'hari' => 'required|string|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_masuk' => 'required|date_format:H:i:s',
            'jam_keluar' => 'nullable|date_format:H:i:s|after:jam_masuk',
        ]);

        $user = Auth::user();
        
        $jamKerja = JamKerja::create([
            'user_id' => $user->id,
            'hari' => $request->hari,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ]);

        return response()->json([
            'message' => 'Jadwal kerja berhasil ditambahkan',
            'data' => $jamKerja,
        ], 201);
    }

    public function absenMasuk(Request $request)
    {
        $user = Auth::user(); // guru login
        $today = Carbon::today();
        $hariIni = strtolower($today->locale('id')->dayName); 
        // hasil: senin, selasa, dst

        // 1️⃣ cek jadwal kerja hari ini
        $jadwal = JamKerja::where('user_id', $user->id)
            ->where('hari', $hariIni)
            ->first();

        if (!$jadwal) {
            return response()->json([
                'message' => 'Tidak ada jadwal kerja hari ini'
            ], 422);
        }

        // 2️⃣ cegah absen ganda
        $sudahAbsen = JamKerja::where('user_id', $user->id)
            ->where('tanggal', $today->toDateString())
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'message' => 'Anda sudah absen hari ini'
            ], 422);
        }

        // 3️⃣ tentukan status hadir / telat
        $now = Carbon::now();
        $jamMasuk = Carbon::parse($jadwal->jam_masuk);

        $status = $now->gt($jamMasuk) ? 'telat' : 'hadir';

        // 4️⃣ simpan absen
        JamKerja::create([
            'user_id'   => $user->id,
            'tanggal'   => $today->toDateString(),
            'jam_masuk' => $now->toTimeString(),
            'status'    => $status,
        ]);

        return response()->json([
            'message' => 'Absen berhasil',
            'status'  => $status,
            'jam'     => $now->format('H:i:s')
        ]);
    }
}
