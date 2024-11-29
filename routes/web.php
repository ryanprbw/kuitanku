<?php

use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KepalaDinasController;
use App\Http\Controllers\KodeRekeningBidangController;
use App\Http\Controllers\KodeRekeningController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PptkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RincianBelanjaSppdController;
use App\Http\Controllers\RincianBelanjaUmumController;

use App\Http\Controllers\SkpdController;
use App\Http\Controllers\SubKegiatanController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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
    






    });






    



require __DIR__.'/auth.php';
