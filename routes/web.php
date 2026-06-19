<?php

use App\Http\Controllers\Cetaklaporan;
use App\Http\Controllers\CreateData;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DetailLaporan;
use App\Http\Controllers\DetailRujukan;
use App\Http\Controllers\KirimPesan;
use App\Http\Controllers\Knowledgepublik;
use App\Http\Controllers\Pelaporan;
use App\Http\Controllers\Public\pLogin;
use App\Http\Controllers\Public\pLogout;
use App\Http\Controllers\Publik;
use App\Http\Controllers\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Performance;

// ============================================================
// REDIRECT ROOT
// ============================================================
Route::get('/', function () {
    return redirect('/publik');
});

Route::get('/performance', [Performance::class, 'index']);

// ============================================================
// ROUTE PUBLIK (tanpa login)
// ============================================================
Route::get('/publik', [Publik::class, 'index']);
Route::get('/knowledgepublik', [Knowledgepublik::class, 'index']);

// ============================================================
// ROUTE AUTH (login & logout)
// ============================================================
Route::get('/login', [pLogin::class, 'index'])->middleware('guest')->name('login');
Route::post('/login/post', [pLogin::class, 'login'])->middleware('guest');
Route::post('/logout', [pLogout::class, 'index'])->middleware('auth');

// ============================================================
// ROUTE ADMIN (wajib login)
// ============================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [Dashboard::class, 'index']);
    Route::get('/pelaporan', [Pelaporan::class, 'index']);
    Route::get('/cetak_laporan', [Cetaklaporan::class, 'index']);

    Route::get('/detail_laporan/{id}', [DetailLaporan::class, 'index']);
    Route::post('/detail_laporan/{id}/save', [DetailLaporan::class, 'save']);
    Route::delete('/detail_laporan/{id}/delete', [DetailLaporan::class, 'destroy']);

    Route::get('/detail_rujukan/{id}', [DetailRujukan::class, 'index']);
    Route::post('/detail_rujukan/{id}/save', [DetailRujukan::class, 'save']);
    Route::delete('/detail_rujukan/{id}/delete', [DetailRujukan::class, 'destroy']);

    Route::get('/create_data', [CreateData::class, 'index']);
    Route::post('/create_data/store', [CreateData::class, 'store']);

    Route::get('/kirim_pesan/{id}', [KirimPesan::class, 'index']);
    Route::post('/kirim_pesan/{id}/send', [KirimPesan::class, 'send']);

    Route::get('/seting', [Setting::class, 'index'])->name('seting.index');
    Route::post('/seting', [Setting::class, 'update'])->name('seting.update');

    // Knowledge CRUD routes
    Route::get('/seting/knowledge',           [Setting::class, 'knowledge'])->name('seting.knowledge');

    // Jenis Kasus
    Route::post('/seting/jenis-kasus',        [Setting::class, 'storeJenis'])->name('seting.jenis.store');
    Route::put('/seting/jenis-kasus/{id}',    [Setting::class, 'updateJenis'])->name('seting.jenis.update');
    Route::delete('/seting/jenis-kasus/{id}', [Setting::class, 'destroyJenis'])->name('seting.jenis.destroy');

    // Undang-Undang
    Route::post('/seting/uu',                 [Setting::class, 'storeUU'])->name('seting.uu.store');
    Route::put('/seting/uu/{id}',             [Setting::class, 'updateUU'])->name('seting.uu.update');
    Route::delete('/seting/uu/{id}',          [Setting::class, 'destroyUU'])->name('seting.uu.destroy');

    // FAQ
    Route::post('/seting/faq',                [Setting::class, 'storeFaq'])->name('seting.faq.store');
    Route::put('/seting/faq/{id}',            [Setting::class, 'updateFaq'])->name('seting.faq.update');
    Route::delete('/seting/faq/{id}',         [Setting::class, 'destroyFaq'])->name('seting.faq.destroy');

    // SOP
    Route::post('/seting/sop',                [Setting::class, 'storeSop'])->name('seting.sop.store');
    Route::put('/seting/sop/{id}',            [Setting::class, 'updateSop'])->name('seting.sop.update');
    Route::delete('/seting/sop/{id}',         [Setting::class, 'destroySop'])->name('seting.sop.destroy');

    // Panduan keamanan
    Route::post('/seting/panduan',        [Setting::class, 'storePanduan'])->name('seting.panduan.store');
    Route::put('/seting/panduan/{id}',    [Setting::class, 'updatePanduan'])->name('seting.panduan.update');
    Route::delete('/seting/panduan/{id}', [Setting::class, 'destroyPanduan'])->name('seting.panduan.destroy');
    
    // Kepala UPTD
    Route::post('/seting/kepala',             [Setting::class, 'updateKepala'])->name('seting.kepala.update');
});