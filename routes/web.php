<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('/');

Route::get('/kepegawaian', function () {
    return view('pages.kepegawaian.index');
})->name('kepegawaian.index');

Route::prefix('kepegawaian')->name('kepegawaian.')->group(function () {

    // CRUD User
    Route::resource('users', UserController::class);
    Route::get('users/{user}/roles', [UserController::class, 'editRole'])->name('users.role');
    Route::put('users/{user}/roles', [UserController::class, 'updateRole'])->name('users.roles.update');

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

Route::prefix('kurikulum')->name('kurikulum.')->group(function() {

    Route::get('/wali-kelas', [AdminController::class, 'indexWaliKelas'])
        ->name('wali-kelas');

        // kelas dan jenjang
    Route::get('/jurnal', [AdminController::class, 'indexJurnal'])
        ->name('jurnal');

    Route::get('/kelas', [AdminController::class, 'indexKelas'])
        ->name('kelas');

    Route::get('/kelas/tambah-kelas', [AdminController::class, 'createKelas'])
        ->name('kelas.create');

    Route::post('/kelas/tambah-kelas', [AdminController::class, 'storeKelas'])
        ->name('kelas.store');

    Route::get('/kelas/tambah-jenjang', [AdminController::class, 'createJenjang'])
        ->name('jenjang.create');

    Route::post('/kelas/tambah-jenjang', [AdminController::class, 'storeJenjang'])
        ->name('jenjang.store');

    Route::get('/kelas/edit-kelas/{kelas}', [AdminController::class, 'editKelas'])
        ->name('kelas.edit');

    Route::put('/kelas/update-kelas/{kelas}', [AdminController::class, 'updateKelas'])
        ->name('kelas.update');

    Route::delete('/kelas/delete-kelas/{kelas}', [AdminController::class, 'destroyKelas'])
        ->name('kelas.delete');

    Route::get('/siswa', [AdminController::class, 'indexSiswa'])
        ->name('siswa');

    Route::get('/mapel-guru', [AdminController::class, 'indexMapelGuru'])
        ->name('mapel-guru');

        // jadwal mengajar
    Route::get('/jadwal', [AdminController::class, 'indexJadwalMengajar'])
    ->name('jadwal');

    Route::get('/jadwal/buat-jam-pelajaran', [AdminController::class, 'tambahJamPelajaran'])
        ->name('jadwal.jam-pelajaran');

    Route::post('/jadwal/buat-jam-pelajaran', [AdminController::class, 'storeJamPelajaran'])
        ->name('jadwal.store-jam-pelajaran');

    Route::get('/jadwal/buat-jadwal', [AdminController::class, 'createJadwalMengajar'])
        ->name('jadwal.create');

    Route::get('/jadwal/edit-jadwal/{jadwal}', [AdminController::class, 'editJadwalMengajar'])
        ->name('jadwal.edit');

    Route::put('/jadwal/update-jadwal/{jadwal}', [AdminController::class, 'updateJadwalMengajar'])
        ->name('jadwal.update');

    Route::post('/jadwal/buat-jadwal', [AdminController::class, 'storeJadwalMengajar'])
        ->name('jadwal.store');

    Route::delete('/jadwal/delete-jadwal/{jadwal}', [AdminController::class, 'destroyJadwalMengajar'])
        ->name('jadwal.delete');

        // data murid
    Route::get('/siswa', [AdminController::class, 'indexSiswa'])
    ->name('siswa');

    Route::get('/siswa/tambah-siswa', [AdminController::class, 'createSiswa'])
    ->name('siswa.create');

    Route::post('/siswa/simpan-siswa', [AdminController::class, 'storeSiswa'])
    ->name('siswa.store');

    Route::get('/siswa/edit-siswa/{siswa}', [AdminController::class, 'editSiswa'])
    ->name('siswa.edit');

    Route::put('/siswa/update-siswa/{siswa}', [AdminController::class, 'updateSiswa'])
    ->name('siswa.update');

    Route::delete('/siswa/delete-siswa/{siswa}', [AdminController::class, 'destroySiswa'])
    ->name('siswa.delete');

    // wali kelas
    Route::get('/edit-wali-kelas/{kelas}', [AdminController::class, 'editWaliKelas'])
    ->name('wali-kelas.edit');

    Route::patch('/update-wali-kelas/{kelas}', [AdminController::class, 'updateWaliKelas'])
    ->name('wali-kelas.update');

});

Route::get('/tahfidz', function () {
    return view('pages.tahfidz.index');
})->name('tahfidz.index');

Route::get('/kesantrian', function () {
    return view('pages.kesantrian.index');
})->name('kesantrian.index');

Route::get('users-list', [AdminController::class, 'listUser']);
