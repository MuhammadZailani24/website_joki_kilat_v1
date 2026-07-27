<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;

// ==========================================
// RUTE HALAMAN DEPAN (LANDING PAGE)
// ==========================================
Route::get('/', function () {
    // 1. Ambil maksimal 6 testimoni terbaru yang sudah di-approve Admin
    $reviews = \App\Models\Review::with('user')
                ->where('is_approved', true)
                ->latest()
                ->take(6)
                ->get();

    // 2. Ambil 1 Banner utama yang sedang diaktifkan oleh Admin (jika ada)
    $activeBanner = \App\Models\Banner::where('is_active', true)->first();

    // Lempar data ke halaman welcome.blade.php
    return view('welcome', compact('reviews', 'activeBanner'));
});

// ==========================================
// JALUR OTENTIKASI & LUPA PASSWORD
// ==========================================
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login.process');

// Rute Lupa Password
Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showReset'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'processReset'])->name('password.update');

// Rute Login Google
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// ==========================================
// JALUR UTAMA (WAJIB LOGIN UNTUK USER)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/order/{jenjang}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/detail/{id}', [OrderController::class, 'show'])->name('order.show');
    
    Route::get('/order/payment/{id}', [OrderController::class, 'payment'])->name('order.payment');
    Route::post('/order/payment/{id}', [OrderController::class, 'processPayment'])->name('order.payment.process');
    Route::post('/order/{id}/revisi', [App\Http\Controllers\OrderController::class, 'ajukanRevisi'])->name('order.revisi');

    // Rute Submit Review
    Route::post('/order/{id}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');

    // Rute Chat In-App
    Route::get('/order/{id}/chat', [App\Http\Controllers\ChatController::class, 'fetchMessages']);
    Route::post('/order/{id}/chat', [App\Http\Controllers\ChatController::class, 'sendMessage']);

    // Rute Download Invoice PDF
    Route::get('/order/{id}/invoice', [App\Http\Controllers\InvoiceController::class, 'download'])->name('invoice.download');

    // Rute Cek Voucher
    Route::post('/cek-voucher', [App\Http\Controllers\VoucherController::class, 'cekVoucher'])->name('voucher.cek');

    Route::post('/notifikasi/read', [App\Http\Controllers\NotifikasiController::class, 'tandaiDibaca'])->name('notifikasi.read');

    // Rute untuk melengkapi profil (WA)
    Route::get('/profil/lengkapi', [ProfileController::class, 'lengkapi'])->name('profil.lengkapi');
    Route::post('/profil/lengkapi', [ProfileController::class, 'simpanWa'])->name('profil.simpan_wa');

    Route::get('/order/{id}/invoice', [App\Http\Controllers\OrderController::class, 'downloadInvoice'])->name('order.invoice');

    // ==========================================
    // RUTE KHUSUS ADMIN JOKI KILAT
    // ==========================================
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Order
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('/orders/{id}/hasil', [\App\Http\Controllers\Admin\OrderController::class, 'uploadHasil'])->name('orders.upload-hasil');

        // Manajemen Pembayaran & Keuangan
        Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{id}/invoice', [\App\Http\Controllers\Admin\PaymentController::class, 'invoice'])->name('payments.invoice');

        // Manajemen User
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Manajemen Layanan & Harga
        Route::get('/layanans', [\App\Http\Controllers\Admin\LayananController::class, 'index'])->name('layanans.index');
        Route::post('/layanans', [\App\Http\Controllers\Admin\LayananController::class, 'store'])->name('layanans.store');
        Route::put('/layanans/{id}', [\App\Http\Controllers\Admin\LayananController::class, 'update'])->name('layanans.update');
        Route::delete('/layanans/{id}', [\App\Http\Controllers\Admin\LayananController::class, 'destroy'])->name('layanans.destroy');

        // Manajemen Testimoni (Reviews)
        Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
        Route::put('/reviews/{id}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
        Route::delete('/reviews/{id}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

        // Manajemen Banner & Landing Page
        Route::get('/banners', [\App\Http\Controllers\Admin\BannerController::class, 'index'])->name('banners.index');
        Route::post('/banners', [\App\Http\Controllers\Admin\BannerController::class, 'store'])->name('banners.store');
        Route::put('/banners/{id}/activate', [\App\Http\Controllers\Admin\BannerController::class, 'activate'])->name('banners.activate');
        Route::delete('/banners/{id}', [\App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('banners.destroy');
        
        // Manajemen Laporan
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    });

    // ==========================================
    // JALUR DETEKTIF API GOOGLE GEMINI
    // ==========================================
    Route::get('/test-ai', function () {
        $apiKey = trim(env('GEMINI_API_KEY'));
        
        if (empty($apiKey)) {
            return "API Key kosong! Pastikan sudah diisi di .env dan jalankan 'php artisan config:clear'";
        }

        // Tanya ke Google, model apa saja yang tersedia untuk API Key ini
        $response = Illuminate\Support\Facades\Http::withoutVerifying()
            ->get('https://generativelanguage.googleapis.com/v1beta/models?key=' . $apiKey);
            
        return response()->json([
            'status_kunci' => 'API Key Terbaca: ' . substr($apiKey, 0, 5) . '***' . substr($apiKey, -5),
            'jawaban_google' => $response->json()
        ]);
    });
});