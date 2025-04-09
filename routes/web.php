<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KepalaDinasController;
use App\Http\Controllers\KodeRekeningBidangController;
use App\Http\Controllers\KodeRekeningController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanSppdController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PptkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RincianBelanjaSppdController;
use App\Http\Controllers\RincianBelanjaUmumController;
use App\Http\Controllers\SkpdController;
use App\Http\Controllers\SubKegiatanController;
use App\Http\Controllers\BukuPengeluaranBarangController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');







Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('skpd', SkpdController::class);
    Route::resource('program', ProgramController::class);
    Route::get('/program/{program}', [ProgramController::class, 'show'])->name('program.show');
    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('sub_kegiatan', SubKegiatanController::class);
    Route::resource('pptks', PptkController::class);
    Route::resource('kepala_dinas', KepalaDinasController::class);
    Route::resource('bendahara', BendaharaController::class);
    Route::resource('pegawais', PegawaiController::class);
    Route::resource('kode_rekening', KodeRekeningController::class);
    Route::resource('rincian_belanja_umum', RincianBelanjaUmumController::class);
    Route::get('/rincian-belanja-umum/{id}/pdf', [RincianBelanjaUmumController::class, 'exportDetailPdf'])->name('rincian_belanja_umum.pdf.detail');
    Route::resource('rincian_belanja_sppd', RincianBelanjaSppdController::class);
    Route::get('/rincian-belanja-sppd/{id}/pdf', [RincianBelanjaSppdController::class, 'exportDetailPdf'])->name('rincian_belanja_sppd.pdf.detail');

    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan-sppd/cetak', [LaporanSppdController::class, 'cetak'])->name('laporan_sppd.cetak');

    Route::get('/laporansppd', [LaporanSppdController::class, 'index'])->name('laporan_sppd.index');


    Route::resource('barang', BarangController::class);
    Route::get('/barang/{barang_id}/detail/create', [BarangController::class, 'createDetail'])->name('barang.detail.create');
    // Simpan detail barang
    Route::post('/barang/{barang_id}/detail', [BarangController::class, 'storeDetail'])->name('barang.detail.store');


    // Route::prefix('buku-pengeluaran-barang')->group(function () {
    //     Route::get('/', [BukuPengeluaranBarangController::class, 'index'])->name('barang.index');
    //     Route::get('/create', [BukuPengeluaranBarangController::class, 'create'])->name('barang.create');
    //     Route::post('/', [BukuPengeluaranBarangController::class, 'store'])->name('barang.store');
    //     Route::get('/{id}/edit', [BukuPengeluaranBarangController::class, 'edit'])->name('barang.edit');
    //     Route::put('/{id}', [BukuPengeluaranBarangController::class, 'update'])->name('barang.update');
    //     Route::delete('/{id}', [BukuPengeluaranBarangController::class, 'destroy'])->name('barang.destroy');
    // });
});
require __DIR__ . '/auth.php';
