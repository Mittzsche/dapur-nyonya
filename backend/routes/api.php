<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\GaleriController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ============================================
// PUBLIC ROUTES (Tanpa autentikasi)
// ============================================

// Auth routes dengan rate limiting (5 percobaan per menit)
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

// Layanan publik (untuk halaman Layanan Kami)
Route::get('/layanan', [LayananController::class, 'index']);
Route::get('/layanan/{id}', [LayananController::class, 'show']);

// Pemesanan publik (untuk form pemesanan pelanggan)
Route::post('/pemesanan', [PemesananController::class, 'store']);

// Konten publik (untuk halaman publik dinamis)
Route::get('/konten', [KontenController::class, 'index']);
Route::get('/konten/{key}', [KontenController::class, 'show']);

// Seed konten default (one-time setup, public access)
// This will only work if konten table is empty for safety
Route::get('/konten-seed-defaults', [KontenController::class, 'seedDefaults']);
Route::get('/konten-seed-direct', [KontenController::class, 'seedDirect']);

// Testimoni publik
Route::get('/testimoni', [TestimoniController::class, 'index']);

// Galeri publik
Route::get('/galeri', [GaleriController::class, 'index']);

// Health check endpoint for Docker/Kubernetes
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
});

// ============================================
// PROTECTED ROUTES (Butuh autentikasi admin)
// ============================================

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Layanan CRUD (Admin only)
    Route::prefix('admin/layanan')->group(function () {
        Route::get('/', [LayananController::class, 'index']);
        Route::post('/', [LayananController::class, 'store']);
        Route::get('/{id}', [LayananController::class, 'show']);
        Route::put('/{id}', [LayananController::class, 'update']);
        Route::delete('/{id}', [LayananController::class, 'destroy']);
    });

    // Pemesanan CRUD (Admin only)
    Route::prefix('admin/pemesanan')->group(function () {
        Route::get('/', [PemesananController::class, 'index']);
        Route::get('/{id}', [PemesananController::class, 'show']);
        Route::put('/{id}', [PemesananController::class, 'update']);
        Route::patch('/{id}/status', [PemesananController::class, 'updateStatus']);
        Route::delete('/{id}', [PemesananController::class, 'destroy']);
    });

    // Mitra CRUD (Admin only)
    Route::prefix('admin/mitra')->group(function () {
        Route::get('/', [MitraController::class, 'index']);
        Route::post('/', [MitraController::class, 'store']);
        Route::get('/{id}', [MitraController::class, 'show']);
        Route::put('/{id}', [MitraController::class, 'update']);
        Route::delete('/{id}', [MitraController::class, 'destroy']);
    });

    // Penjualan / Laporan (Admin only)
    Route::prefix('admin/penjualan')->group(function () {
        Route::get('/', [PenjualanController::class, 'index']);
        Route::get('/summary', [PenjualanController::class, 'summary']);
    });

    // Konten CRUD (Admin only)
    Route::prefix('admin/konten')->group(function () {
        Route::get('/', [KontenController::class, 'index']);
        Route::put('/{key}', [KontenController::class, 'update']);
        Route::post('/bulk', [KontenController::class, 'bulkUpdate']);
    });

    // Testimoni CRUD (Admin only)
    Route::prefix('admin/testimoni')->group(function () {
        Route::get('/', [TestimoniController::class, 'adminIndex']);
        Route::post('/', [TestimoniController::class, 'store']);
        Route::put('/{id}', [TestimoniController::class, 'update']);
        Route::post('/{id}', [TestimoniController::class, 'update']); // For file upload with PUT
        Route::delete('/{id}', [TestimoniController::class, 'destroy']);
    });

    // Galeri CRUD (Admin only)
    Route::prefix('admin/galeri')->group(function () {
        Route::get('/', [GaleriController::class, 'adminIndex']);
        Route::post('/', [GaleriController::class, 'store']);
        Route::put('/{id}', [GaleriController::class, 'update']);
        Route::post('/{id}', [GaleriController::class, 'update']); // For file upload with PUT
        Route::delete('/{id}', [GaleriController::class, 'destroy']);
    });
});

