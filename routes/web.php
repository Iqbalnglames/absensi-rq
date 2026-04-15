<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KesantrianController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('/');

Route::get('/kepegawaian', function () {
    return view('pages.kepegawaian.index');
})->name('kepegawaian.index');

Route::get('/search-murid', [AdminController::class, 'searchMurid'])
    ->name('search-siswa');

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

    Route::post('/perizinan', [KesantrianController::class, 'storePerizinan'])
        ->name('perizinan.store');

   Route::get('/ekskul', [KesantrianController::class, 'ekskul'])
        ->name('ekskul');

});

Route::get('/tahfidz', function () {
    return view('pages.tahfidz.index');
})->name('tahfidz.index');


Route::get('users-list', [AdminController::class, 'listUser']);
