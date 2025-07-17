<?php

use App\Http\Controllers\BiodataController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailAlatController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipCustomerController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PelatihController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SyaratKetentuanController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;


// Rute Halaman Depan
Route::get('/', [WelcomeController::class, 'index']);

// Rute yang Memerlukan Autentikasi
Route::middleware(['auth', 'verified'])->group(function () {

    // PERUBAHAN UTAMA: Route Dashboard sekarang diarahkan ke Controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk mengelola profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Grup Route untuk Admin
    Route::middleware(['role:admin'])->group(function () {
        // sk
        Route::get('/syarat', [SyaratKetentuanController::class, 'index'])->name('syarat.index');
        Route::post('/syarat/store', [SyaratKetentuanController::class, 'store'])->name('syarat.store');
        Route::put('/syarat/{syarat}', [SyaratKetentuanController::class, 'update'])->name('syarat.update');
        Route::delete('/syarat/{id}', [SyaratKetentuanController::class, 'destroy'])->name('syarat.destroy');

        // fasilitas
        Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
        Route::post('/fasilitas/store', [FasilitasController::class, 'store'])->name('fasilitas.store');
        Route::put('/fasilitas/{fasilitas}', [FasilitasController::class, 'update'])->name('fasilitas.update');
        Route::delete('/fasilitas/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');

        //detail
        Route::post('/detail-alat', [DetailAlatController::class, 'store'])->name('detail-alat.store');

        //customer
        Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
        Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
        Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
        Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
        Route::get('/customer/cetak-pdf', [CustomerController::class, 'cetakPdf'])->name('customer.cetakPdf');


        //membership
        Route::prefix('membership')->name('membership.')->group(function () {
            Route::get('/gym', [MembershipController::class, 'gym'])->name('gym');
            Route::get('/muaythai', [MembershipController::class, 'muaythai'])->name('muaythai');
            Route::get('/boxing', [MembershipController::class, 'boxing'])->name('boxing');
            
            // Mengubah route store agar lebih umum dan tidak spesifik ke gym
            Route::post('/store', [MembershipController::class, 'store'])->name('store');
            Route::put('/status/{id}', [MembershipController::class, 'updateStatus'])->name('update_status');
            Route::put('/{id}/update-status-selesai', [MembershipController::class, 'updateStatusSelesai'])->name('update_status_selesai');

            // PDF Routes
            Route::get('/gym/cetak-pdf', [MembershipController::class, 'cetakPdfGym'])->name('gym.cetak_pdf');
            Route::get('/muaythai/cetak-pdf', [MembershipController::class, 'cetakPdfMuayThai'])->name('muaythai.cetak_pdf');
            Route::get('/boxing/cetak-pdf', [MembershipController::class, 'cetakPdfBoxing'])->name('boxing.cetak_pdf');
            
         });

        //paket
        Route::resource('paket', PaketController::class)->except(['create', 'show', 'edit']);

        //pelatih
        Route::resource('pelatih', PelatihController::class)->except(['create', 'show', 'edit']);
    });

    // Grup Route untuk Owner
    Route::middleware(['role:owner'])->prefix('owner')->name('owner.')->group(function () {
        // Dashboard Owner juga diarahkan ke controller yang sama jika tampilannya identik
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/customers', [CustomerController::class, 'indexForOwner'])->name('customer.index');
        Route::get('/customers/cetak-pdf', [CustomerController::class, 'cetakPdfForOwner'])->name('customer.cetak.pdf');
        Route::get('/membership/report-pdf', [CustomerController::class, 'reportPdf'])->name('membership.pdf');

        Route::get('/memberships/report', [MembershipController::class, 'reportForOwner'])->name('membership.report');
    
        // Route::get('/laporan/tahunan', [LaporanController::class, 'tahunan'])->name('laporan.tahunan');
        // Route::post('/laporan/tahunan', [LaporanController::class, 'storeTahunan'])->name('laporan.tahunan.store');

        Route::get('/laporan/tahunan', [LaporanController::class, 'tahunan'])->name('laporan.tahunan');
        Route::post('/laporan/tahunan', [LaporanController::class, 'storeTahunan'])->name('laporan.tahunan.store');

    });

    // Grup Route untuk Customer
    Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard',[DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/biodata', [BiodataController::class, 'index'])->name('biodata');
        Route::get('/biodata2', [BiodataController::class, 'index'])->name('biodata2');
        Route::post('/biodata', [BiodataController::class, 'update'])->name('biodata.update');

        
        //membership
        Route::prefix('membership')->name('membership.')->group(function () {
        Route::get('/gym', [MembershipCustomerController::class, 'createGym'])->name('gym.create');
        Route::get('/muaythai', [MembershipCustomerController::class, 'createMuayThai'])->name('muaythai.create');
        Route::get('/boxing', [MembershipCustomerController::class, 'createBoxing'])->name('boxing.create');
        Route::post('/', [MembershipCustomerController::class, 'store'])->name('store');
    });
        // TAMBAHKAN GRUP ROUTE INI UNTUK BUKTI RESERVASI
    Route::prefix('reservasi')->name('reservasi.')->group(function() {
        Route::get('/', [MembershipCustomerController::class, 'index'])->name('index');
        Route::get('/{membership}', [MembershipCustomerController::class, 'show'])->name('show');
        Route::get('/{membership}/edit', [MembershipCustomerController::class, 'edit'])->name('edit');
        Route::put('/{membership}', [MembershipCustomerController::class, 'update'])->name('update');
        Route::put('/{membership}/selesai', [MembershipCustomerController::class, 'markAsComplete'])->name('complete');
    });
    });

});

require __DIR__ . '/auth.php';
