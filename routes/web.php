<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KepegawaianController;
use App\Http\Controllers\KesantrianController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\TahfidzController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login.show');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

Route::get('/search-murid', [AdminController::class, 'searchMurid'])
    ->name('search-siswa');

Route::middleware('auth')->group(function() {
    Route::get('/', [KepegawaianController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/kepegawaian', function () {
        return view('pages.kepegawaian.index');
    })->name('kepegawaian.index');

    Route::prefix('kepegawaian')->name('kepegawaian.')->group(function () {

        // CRUD User
        Route::resource('users', UserController::class);

        Route::get('/tambah-role', [UserController::class, 'createRole'])
            ->name('role.create');

        Route::post('/simpan-role', [UserController::class, 'storeRole'])
            ->name('role.store');

        Route::get('users/{user}/roles', [UserController::class, 'editRole'])
            ->name('users.role');

        Route::put('users/{user}/roles', [UserController::class, 'updateRole'])
            ->name('users.roles.update');

        Route::get('qr-absen', [KepegawaianController::class, 'qrGenerator'])
            ->name('qr-absen');

        Route::get('absen', [KepegawaianController::class, 'absen'])
            ->name('absen');

        Route::post('absen-masuk', [KepegawaianController::class, 'absenMasuk'])
            ->name('absen.masuk');

        Route::put('absen-pulang', [KepegawaianController::class, 'absenPulang'])
            ->name('absen.pulang');

        Route::get('izin-user', [KepegawaianController::class, 'izinUser'])
            ->name('izin-user');

        Route::get('izin-user/ajukan', [KepegawaianController::class, 'pengajuanIzinUser'])
            ->name('izin-user.create');

        Route::post('izin-user/simpan', [KepegawaianController::class, 'storeIzinUser'])
            ->name('izin-user.store');

        Route::get('izin-user/edit-izin/{izin}', [KepegawaianController::class, 'editIzinUser'])
            ->name('izin-user.edit');

        Route::put('izin-user/update-izin/{izin}', [KepegawaianController::class, 'updateIzinUser'])
            ->name('izin-user.update');

        Route::delete('izin-user/delete-izin/{izin}', [KepegawaianController::class, 'destroyIzinUser'])
            ->name('izin-user.delete');

        // Jadwal Kerja
        Route::get('/jadwal', [AdminController::class, 'indexJadwal'])
            ->name('jadwal');

        Route::get('/jadwal/{user}', [AdminController::class, 'detailJadwal'])
            ->name('jadwal.detail');

        Route::put('/jadwal/{jamKerja}', [AdminController::class, 'updateJadwal'])
            ->name('jadwal.update');

        Route::post('jadwal/{user}', [AdminController::class, 'storeJadwal'])
            ->name('jadwal.store');

        Route::delete('jadwal/{jamKerja}', [AdminController::class, 'destroyJadwal'])
            ->name('jadwal.destroy');

        // Izin
        Route::get('/izin', [AdminController::class, 'indexIzin'])
            ->name('izin');

        Route::get('/izin/{user}', [AdminController::class, 'detailIzin'])
            ->name('izin.detail');

        // Performa
        Route::get('users/{user}/performa', [AdminController::class, 'indexPerforma'])
            ->name('users.performa');
    });
    Route::get('/kurikulum', function () {
        return view('pages.kurikulum.index');
    })->name('kurikulum.index');

    Route::prefix('kurikulum')->name('kurikulum.')->group(function () {

        Route::get('/wali-kelas', [KurikulumController::class, 'indexWaliKelas'])
            ->name('wali-kelas');

        Route::get('/mapel', [KurikulumController::class, 'createMapel'])
            ->name('mapel');

        Route::post('/simpan-mapel', [KurikulumController::class, 'storeMapel'])
            ->name('mapel.store');

        Route::delete('/hapus-mapel/{mapel}', [KurikulumController::class, 'destroyMapel'])
            ->name('mapel.destroy');

        // kelas dan jenjang
        Route::get('/jurnal', [KurikulumController::class, 'indexJurnal'])
            ->name('jurnal');

        Route::get('/kelas', [KurikulumController::class, 'indexKelas'])
            ->name('kelas');

        Route::get('/kelas/tambah-kelas', [KurikulumController::class, 'createKelas'])
            ->name('kelas.create');

        Route::post('/kelas/tambah-kelas', [KurikulumController::class, 'storeKelas'])
            ->name('kelas.store');

        Route::get('/kelas/tambah-jenjang', [KurikulumController::class, 'createJenjang'])
            ->name('jenjang.create');

        Route::post('/kelas/tambah-jenjang', [KurikulumController::class, 'storeJenjang'])
            ->name('jenjang.store');

        Route::get('/kelas/edit-kelas/{kelas}', [KurikulumController::class, 'editKelas'])
            ->name('kelas.edit');

        Route::put('/kelas/update-kelas/{kelas}', [KurikulumController::class, 'updateKelas'])
            ->name('kelas.update');

        Route::delete('/kelas/delete-kelas/{kelas}', [KurikulumController::class, 'destroyKelas'])
            ->name('kelas.delete');

        Route::get('/siswa', [KurikulumController::class, 'indexSiswa'])
            ->name('siswa');

        Route::get('/absen-siswa', [KurikulumController::class, 'indexAbsenSiswa'])
            ->name('absen-siswa');

        Route::get('/absen-siswa/{siswa}', [KurikulumController::class, 'detailAbsenSiswa'])
            ->name('absen-siswa.detail');

        Route::get('/mapel-guru', [KurikulumController::class, 'indexMapelGuru'])
            ->name('mapel-guru');

        // jadwal mengajar
        Route::get('/jadwal', [KurikulumController::class, 'indexJadwalMengajar'])
            ->name('jadwal');

        Route::get('/jadwal/buat-jam-pelajaran', [KurikulumController::class, 'tambahJamPelajaran'])
            ->name('jadwal.jam-pelajaran');

        Route::post('/jadwal/buat-jam-pelajaran', [KurikulumController::class, 'storeJamPelajaran'])
            ->name('jadwal.store-jam-pelajaran');

        Route::get('/jadwal/buat-jadwal', [KurikulumController::class, 'createJadwalMengajar'])
            ->name('jadwal.create');

        Route::get('/jadwal/edit-jadwal/{jadwal}', [KurikulumController::class, 'editJadwalMengajar'])
            ->name('jadwal.edit');

        Route::put('/jadwal/update-jadwal/{jadwal}', [KurikulumController::class, 'updateJadwalMengajar'])
            ->name('jadwal.update');

        Route::post('/jadwal/buat-jadwal', [KurikulumController::class, 'storeJadwalMengajar'])
            ->name('jadwal.store');

        Route::delete('/jadwal/delete-jadwal/{jadwal}', [KurikulumController::class, 'destroyJadwalMengajar'])
            ->name('jadwal.delete');

        Route::get('/pembelajaran', [KurikulumController::class, 'pembelajaran'])
            ->name('pembelajaran');

        Route::get('/pembelajaran/{jadwal}', [KurikulumController::class, 'jurnalKelas'])
            ->name('pembelajaran.jurnal');

        Route::post('/pembelajaran/simpan-jurnal/{jadwal}', [KurikulumController::class, 'storeJurnalKelas'])
            ->name('pembelajaran.storeJurnal');

        Route::put('/pembelajaran/update-jurnal/{jadwal}/{jurnal}', [KurikulumController::class, 'updateJurnalKelas'])
            ->name('pembelajaran.updateJurnal');

        // data murid
        Route::get('/siswa', [KurikulumController::class, 'indexSiswa'])
            ->name('siswa');

        Route::get('/siswa/tambah-siswa', [KurikulumController::class, 'createSiswa'])
            ->name('siswa.create');

        Route::post('/siswa/simpan-siswa', [KurikulumController::class, 'storeSiswa'])
            ->name('siswa.store');

        Route::get('/siswa/edit-siswa/{siswa}', [KurikulumController::class, 'editSiswa'])
            ->name('siswa.edit');

        Route::put('/siswa/update-siswa/{siswa}', [KurikulumController::class, 'updateSiswa'])
            ->name('siswa.update');

        Route::delete('/siswa/delete-siswa/{siswa}', [KurikulumController::class, 'destroySiswa'])
            ->name('siswa.delete');

        // wali kelas
        Route::get('/edit-wali-kelas/{kelas}', [KurikulumController::class, 'editWaliKelas'])
            ->name('wali-kelas.edit');

        Route::patch('/update-wali-kelas/{kelas}', [KurikulumController::class, 'updateWaliKelas'])
            ->name('wali-kelas.update');

        // mapel ajar guru
        Route::get('/mapel-guru', [KurikulumController::class, 'mapelGuru'])
            ->name('mapel-guru');

        Route::get('/buat-mapel-guru/{guru}', [KurikulumController::class, 'createMapelGuru'])
            ->name('mapel-guru.create');

        Route::post('/update-mapel-guru', [KurikulumController::class, 'storeMapelGuru'])
            ->name('mapel-guru.store');

        Route::get('/edit-mapel-guru/{guru}', [KurikulumController::class, 'editMapelGuru'])
            ->name('mapel-guru.edit');

        Route::patch('/update-mapel-guru/{guru}', [KurikulumController::class, 'updateMapelGuru'])
            ->name('mapel-guru.update');

        Route::delete('/delete-mapel-guru/{guru}', [KurikulumController::class, 'destroyMapelGuru'])
            ->name('mapel-guru.delete');

        // penilaian
        Route::get('/penilaian', [KurikulumController::class, 'penilaian'])
            ->name('penilaian');

        Route::get('/penilaian/{kelas}', [KurikulumController::class, 'detailPenilaianKelas'])
            ->name('penilaian.detailKelas');

        Route::get('/penilaian-siswa/{murid}', [KurikulumController::class, 'detailPenilaianSiswa'])
            ->name('penilaian.detailSiswa');

        Route::get('/penilaian-siswa/{murid}/{mapel}/{kelas}/{semester}/detail', [KurikulumController::class, 'detailNilaiSiswa'])
            ->name('penilaian.detailNilaiSiswa');

        Route::post('/penilaian-siswa/simpan-nilai', [KurikulumController::class, 'storeNilaiSiswa'])
            ->name('penilaian.storeNilai');

        Route::put('/penilaian-siswa/update-nilai/{nilai}', [KurikulumController::class, 'updateNilaiSiswa'])
            ->name('penilaian.updateNilai');
    });

    Route::get('/kesantrian', function () {
        return view('pages.kesantrian.index');
    })->name('kesantrian.index');

    Route::prefix('kesantrian')->name('kesantrian.')->group(function () {

        // keasramaan
        Route::get('/asrama', [KesantrianController::class, 'indexAsrama'])
            ->name('asrama');

        Route::get('/asrama/tambah-asrama', [KesantrianController::class, 'createAsrama'])
            ->name('asrama.create');

        Route::post('/asrama/simpan-asrama', [KesantrianController::class, 'storeAsrama'])
            ->name('asrama.store');

        Route::get('/asrama/edit-pengasuh-asrama/{asrama}', [KesantrianController::class, 'editPengasuhAsrama'])
            ->name('pengasuh-asrama.edit');

        Route::patch('/asrama/update-pengasuh-asrama/{asrama}', [KesantrianController::class, 'updatePengasuhAsrama'])
            ->name('pengasuh-asrama.update');

        Route::get('/pelanggaran', [KesantrianController::class, 'indexPelanggaran'])
            ->name('pelanggaran-siswa');

        Route::get('/pelanggaran/tambah-jenis-pelanggaran', [KesantrianController::class, 'createJenisPelanggaran'])
            ->name('jenis-pelanggaran-siswa.create');

        Route::post('/pelanggaran/simpan-jenis-pelanggaran', [KesantrianController::class, 'storeJenisPelanggaran'])
            ->name('jenis-pelanggaran-siswa.store');

        Route::get('/pelanggaran/tambah-pelanggaran', [KesantrianController::class, 'createPelanggaran'])
            ->name('pelanggaran-siswa.create');

        Route::post('/pelanggaran/simpan-pelanggaran', [KesantrianController::class, 'storePelanggaran'])
            ->name('pelanggaran-siswa.store');

        Route::get('/perizinan', [KesantrianController::class, 'perizinan'])
            ->name('perizinan');

        Route::get('/perizinan/tambah-perizinan', [KesantrianController::class, 'createPerizinan'])
            ->name('perizinan.create');

        Route::get('/perizinan/edit-perizinan/{perizinan}', [KesantrianController::class, 'editPerizinan'])
            ->name('perizinan.edit');

        Route::put('/perizinan/update-perizinan/{perizinan}', [KesantrianController::class, 'updatePerizinan'])
            ->name('perizinan.update');

        Route::post('/perizinan', [KesantrianController::class, 'storePerizinan'])
            ->name('perizinan.store');

       Route::get('/ekskul', [KesantrianController::class, 'ekskul'])
            ->name('ekskul');

       Route::get('/ekskul/tambah-ekskul', [KesantrianController::class, 'createEkskul'])
            ->name('ekskul.create');

       Route::get('/ekskul/edit-ekskul/{ekskul}', [KesantrianController::class, 'editEkskul'])
            ->name('ekskul.edit');

       Route::delete('/ekskul/delete-ekskul/{ekskul}', [KesantrianController::class, 'destroyEkskul'])
            ->name('ekskul.delete');

       Route::put('/ekskul/update-ekskul/{ekskul}', [KesantrianController::class, 'updateEkskul'])
            ->name('ekskul.update');

       Route::get('/ekskul/peserta-ekskul/{ekskul}', [KesantrianController::class, 'pesertaEkskul'])
            ->name('ekskul.member');

       Route::post('/ekskul/simpan-ekskul', [KesantrianController::class, 'storeEkskul'])
            ->name('ekskul.store');

       Route::post('/ekskul/simpan-peserta/{ekskul}', [KesantrianController::class, 'storePesertaEkskul'])
            ->name('ekskul.storePeserta');

       Route::delete('/ekskul/hapus-peserta/{ekskul}/{murid}', [KesantrianController::class, 'hapusPesertaEkskul'])
            ->name('ekskul.deletePeserta');

        Route::get('/ekskul/tambah-jadwal', [KesantrianController::class, 'createJadwalEkskul'])
            ->name('ekskul.createJadwal');

        Route::post('/ekskul/simpan-jadwal', [KesantrianController::class, 'storeJadwalEkskul'])
            ->name('ekskul.storeJadwal');

        Route::get('/ekskul/pembelajaran', [KesantrianController::class, 'pembelajaranEkskul'])
            ->name('ekskul.pembelajaran');

        Route::get('/ekskul/pembelajaran/jurnal/{jadwal}', [KesantrianController::class, 'createJurnalEkskul'])
            ->name('ekskul.jurnal');

         Route::post('/ekskul/simpan-jurnal/{jadwal}', [KesantrianController::class, 'storeJurnalEkskul'])
            ->name('ekskul.storeJurnal');

        Route::put('/ekskul/update-jurnal/{jadwal}/{jurnal}', [KesantrianController::class, 'updateJurnalEkskul'])
            ->name('ekskul.updateJurnal');

    });

    Route::get('/tahfidz', function () {
        return view('pages.tahfidz.index');
    })->name('tahfidz.index');

    Route::prefix('tahfidz')->name('tahfidz.')->group(function () {
        Route::get('/halaqah', [TahfidzController::class, 'halaqahData'])
            ->name('halaqah-data');

        Route::get('/tambah-halaqah', [TahfidzController::class, 'tambahHalaqah'])
            ->name('halaqah-data.create');

        Route::get('/edit-halaqah/{halaqah}', [TahfidzController::class, 'editHalaqah'])
            ->name('halaqah-data.edit');

        Route::post('/update-halaqah/{halaqah}', [TahfidzController::class, 'updateHalaqah'])
            ->name('halaqah-data.update');

        Route::delete('/delete-halaqah/{halaqah}', [TahfidzController::class, 'destroyHalaqah'])
            ->name('halaqah-data.delete');

        Route::post('/simpan-halaqah', [TahfidzController::class, 'storeHalaqah'])
            ->name('halaqah-data.store');

        Route::get('/halaqah/{halaqah}', [TahfidzController::class, 'pesertaHalaqah'])
            ->name('halaqah-data.peserta');

        Route::put('/halaqah/simpan-peserta/{halaqah}', [TahfidzController::class, 'storePesertaHalaqah'])
            ->name('halaqah-data.storePeserta');

        Route::delete('/halaqah/hapus-peserta/{murid}', [TahfidzController::class, 'hapusPesertaHalaqah'])
            ->name('halaqah-data.deletePeserta');

        Route::get('/rekap-mutabaah', [TahfidzController::class, 'rekapMutabaah'])
            ->name('rekap-mutabaah');

        Route::get('/jadwal-halaqah', [TahfidzController::class, 'indexJadwalHalaqah'])
            ->name('jadwal-halaqah');

        Route::get('/jadwal-halaqah/tambah-jam-halaqah', [TahfidzController::class, 'createJamHalaqah'])
            ->name('jadwal-halaqah.jam-halaqah.create');

        Route::post('/jadwal-halaqah/simpan-jam-halaqah', [TahfidzController::class, 'storeJamHalaqah'])
            ->name('jadwal-halaqah.jam-halaqah.store');

        Route::get('/jadwal-halaqah/tambah-jadwal-halaqah', [TahfidzController::class, 'createJadwalHalaqah'])
            ->name('jadwal-halaqah.create');

        Route::post('/jadwal-halaqah/simpan-jadwal-halaqah', [TahfidzController::class, 'storeJadwalHalaqah'])
            ->name('jadwal-halaqah.store');

        Route::get('/pembelajaran-tahfidz', [TahfidzController::class, 'pembelajaranTahfidz'])
            ->name('pembelajaran-tahfidz');
    });


    Route::get('users-list', [AdminController::class, 'listUser']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
