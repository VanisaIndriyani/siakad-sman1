<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\SiswaController;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Pengumuman;
use App\Models\Siswa;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    $pengumumans = Pengumuman::where('is_active', true)->latest()->take(3)->get();

    // Statistics
    $guruCount = Guru::count();
    $siswaCount = Siswa::count();
    $kelasCount = Kelas::count();
    $siswaL = Siswa::where('jenis_kelamin', 'L')->count();
    $siswaP = Siswa::where('jenis_kelamin', 'P')->count();

    // Calculate percentages for progress bars
    $persenL = $siswaCount > 0 ? ($siswaL / $siswaCount) * 100 : 0;
    $persenP = $siswaCount > 0 ? ($siswaP / $siswaCount) * 100 : 0;

    // Get unique Jurusan
    $jurusans = Kelas::select('jurusan')->distinct()->pluck('jurusan');
    $jurusanCount = $jurusans->count();

    return view('welcome', compact('pengumumans', 'guruCount', 'siswaCount', 'kelasCount', 'siswaL', 'siswaP', 'persenL', 'persenP', 'jurusans', 'jurusanCount'));
});

// Authentication Routes
Route::get('/login', [DashboardController::class, 'login'])->name('login');
Route::post('/login', [DashboardController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

Route::get('/assets/html5-qrcode.min.js', function () {
    $version = '2.3.8';
    $cacheFile = storage_path("app/html5-qrcode-{$version}.min.js");

    if (file_exists($cacheFile) && filesize($cacheFile) > 0) {
        $contents = file_get_contents($cacheFile);
        if ($contents !== false) {
            return response($contents, 200, [
                'Content-Type' => 'application/javascript; charset=UTF-8',
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }
    }

    $url = "https://unpkg.com/html5-qrcode@{$version}/html5-qrcode.min.js";
    $res = Http::timeout(15)->get($url);
    if (! $res->successful()) {
        abort(404);
    }

    $contents = (string) $res->body();
    @file_put_contents($cacheFile, $contents);

    return response($contents, 200, [
        'Content-Type' => 'application/javascript; charset=UTF-8',
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->name('assets.html5qrcode');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/guru', [AdminController::class, 'guru'])->name('guru.index');
        Route::post('/guru', [AdminController::class, 'storeGuru'])->name('guru.store');
        Route::post('/guru/import', [AdminController::class, 'importGuruCsv'])->name('guru.import');
        Route::get('/guru/template', [AdminController::class, 'templateGuruCsv'])->name('guru.template');
        Route::put('/guru/{id}', [AdminController::class, 'updateGuru'])->name('guru.update');
        Route::delete('/guru/{id}', [AdminController::class, 'destroyGuru'])->name('guru.destroy');
        Route::get('/siswa', [AdminController::class, 'siswa'])->name('siswa.index');
        Route::post('/siswa', [AdminController::class, 'storeSiswa'])->name('siswa.store');
        Route::get('/siswa/export', [AdminController::class, 'exportSiswa'])->name('siswa.export');
        Route::post('/siswa/import', [AdminController::class, 'importSiswaCsv'])->name('siswa.import');
        Route::get('/siswa/template', [AdminController::class, 'templateSiswaCsv'])->name('siswa.template');
        Route::get('/siswa/{id}', [AdminController::class, 'showSiswa'])->whereNumber('id')->name('siswa.show');
        Route::get('/siswa/{id}/cetak-kartu', [AdminController::class, 'cetakKartuSiswa'])->whereNumber('id')->name('siswa.cetak_kartu');
        Route::get('/siswa/{id}/qr.png', [AdminController::class, 'qrSiswaPng'])->whereNumber('id')->name('siswa.qr.png');
        Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa'])->whereNumber('id')->name('siswa.update');
        Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa'])->whereNumber('id')->name('siswa.destroy');
        Route::get('/kelas', [AdminController::class, 'kelas'])->name('kelas.index');
        Route::post('/kelas', [AdminController::class, 'storeKelas'])->name('kelas.store');
        Route::get('/kelas/{id}', [AdminController::class, 'showKelas'])->name('kelas.show');
        Route::get('/kelas/{id}/cetak-kartu', [AdminController::class, 'cetakKartu'])->name('kelas.cetak_kartu');
        Route::put('/kelas/{id}', [AdminController::class, 'updateKelas'])->name('kelas.update');
        Route::delete('/kelas/{id}', [AdminController::class, 'destroyKelas'])->name('kelas.destroy');
        Route::get('/mapel', [AdminController::class, 'mapel'])->name('mapel.index');
        Route::post('/mapel', [AdminController::class, 'storeMapel'])->name('mapel.store');
        Route::put('/mapel/{id}', [AdminController::class, 'updateMapel'])->name('mapel.update');
        Route::delete('/mapel/{id}', [AdminController::class, 'destroyMapel'])->name('mapel.destroy');
        Route::get('/jadwal', [AdminController::class, 'jadwal'])->name('jadwal.index');
        Route::post('/jadwal', [AdminController::class, 'storeJadwal'])->name('jadwal.store');
        Route::put('/jadwal/{id}', [AdminController::class, 'updateJadwal'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [AdminController::class, 'destroyJadwal'])->name('jadwal.destroy');
        Route::get('/nilai', [AdminController::class, 'nilai'])->name('nilai.index');
        Route::get('/nilai/pdf', [AdminController::class, 'exportNilaiPdf'])->name('nilai.pdf');
        Route::get('/absensi', [AdminController::class, 'absensi'])->name('absensi.index');
        Route::get('/absensi/pdf', [AdminController::class, 'exportAbsensiPdf'])->name('absensi.pdf');
        Route::get('/pengumuman', [AdminController::class, 'pengumuman'])->name('pengumuman.index');
        Route::post('/pengumuman', [AdminController::class, 'storePengumuman'])->name('pengumuman.store');
        Route::put('/pengumuman/{id}', [AdminController::class, 'updatePengumuman'])->name('pengumuman.update');
        Route::delete('/pengumuman/{id}', [AdminController::class, 'destroyPengumuman'])->name('pengumuman.destroy');

        // Profile Settings
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile.index');
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    });

    // Guru Routes
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'guru'])->name('dashboard');
        Route::get('/nilai', [GuruController::class, 'nilai'])->name('nilai.index');
        Route::post('/nilai', [GuruController::class, 'storeNilai'])->name('nilai.store');
        Route::get('/jadwal', [GuruController::class, 'jadwal'])->name('jadwal.index');
        Route::get('/absensi', [GuruController::class, 'absensi'])->name('absensi.index');
        Route::post('/absensi', [GuruController::class, 'storeAbsensi'])->name('absensi.store');
        Route::post('/absensi/scan', [GuruController::class, 'scanAbsensi'])->name('absensi.scan');
        Route::get('/raport', [GuruController::class, 'reviewRaport'])->name('raport.index');
        Route::get('/raport/{id}', [GuruController::class, 'showRaport'])->name('raport.show');
        Route::get('/raport/{id}/pdf', [GuruController::class, 'exportRaportPdf'])->name('raport.pdf');
    });

    // Siswa Routes
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('dashboard');
        Route::get('/profil', [SiswaController::class, 'profil'])->name('profil');
        Route::get('/qr.png', [SiswaController::class, 'qrPng'])->name('qr.png');
        Route::get('/qr.pdf', [SiswaController::class, 'qrPdf'])->name('qr.pdf');
        Route::get('/nilai', [SiswaController::class, 'nilai'])->name('nilai.index');
        Route::get('/jadwal', [SiswaController::class, 'jadwal'])->name('jadwal.index');
        Route::get('/jadwal/pdf', [SiswaController::class, 'exportJadwalPdf'])->name('jadwal.pdf');
        Route::get('/absensi', [SiswaController::class, 'absensi'])->name('absensi.index');
        Route::get('/pengumuman', [SiswaController::class, 'pengumuman'])->name('pengumuman.index');
    });

    // Kepala Sekolah Routes
    Route::prefix('kepala-sekolah')->name('kepala_sekolah.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'kepalaSekolah'])->name('dashboard');
        Route::get('/laporan-akademik', [KepalaSekolahController::class, 'laporanAkademik'])->name('laporan.akademik');
        Route::get('/monitoring-nilai', [KepalaSekolahController::class, 'monitoringNilai'])->name('monitoring.nilai');
        Route::get('/monitoring-absensi', [KepalaSekolahController::class, 'monitoringAbsensi'])->name('monitoring.absensi');
        Route::get('/verifikasi-raport', [KepalaSekolahController::class, 'verifikasiRaport'])->name('raport.verifikasi');
        Route::post('/verifikasi-raport/{id}', [KepalaSekolahController::class, 'doVerifikasiRaport'])->name('raport.do_verifikasi');
    });
});
