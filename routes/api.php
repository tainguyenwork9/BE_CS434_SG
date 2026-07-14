<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\XeMayController;
use App\Http\Controllers\DanhMucXeController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\DonThueController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\GiaoNhanXeController;

// ==========================================
// Public Routes
// ==========================================
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/xe-may', [XeMayController::class, 'index']);
Route::get('/xe-may/{id}', [XeMayController::class, 'show']);
Route::get('/danh-muc-xe', [XeMayController::class, 'danhMuc']);
Route::get('/danh-gia/xe/{maXe}', [DanhGiaController::class, 'byXe']);

// ==========================================
// Authenticated Routes (Sanctum)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    // Auth & Profile
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);
    Route::put('/khach-hang/profile', [KhachHangController::class, 'profileUpdate']);

    // Don Thue
    Route::get('/don-thue', [DonThueController::class, 'index']);
    Route::get('/don-thue/{id}', [DonThueController::class, 'show']);
    Route::post('/don-thue', [DonThueController::class, 'store']);
    Route::put('/don-thue/{id}/huy', [DonThueController::class, 'cancel']);

    // Danh Gia
    Route::post('/danh-gia', [DanhGiaController::class, 'store']);

    // ==========================================
    // Admin Routes
    // ==========================================
    Route::prefix('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);
        // Quản lý xe máy
        Route::post('/xe-may', [XeMayController::class, 'store']);
        Route::put('/xe-may/{id}', [XeMayController::class, 'update']);
        Route::delete('/xe-may/{id}', [XeMayController::class, 'destroy']);

        // Quản lý danh mục xe
        Route::get('/danh-muc-xe', [DanhMucXeController::class, 'index']);
        Route::post('/danh-muc-xe', [DanhMucXeController::class, 'store']);
        Route::put('/danh-muc-xe/{id}', [DanhMucXeController::class, 'update']);
        Route::delete('/danh-muc-xe/{id}', [DanhMucXeController::class, 'destroy']);

        // Quản lý khách hàng
        Route::get('/khach-hang', [KhachHangController::class, 'index']);
        Route::get('/khach-hang/{id}', [KhachHangController::class, 'show']);
        Route::put('/khach-hang/{id}', [KhachHangController::class, 'update']);
        Route::put('/khach-hang/{id}/trang-thai', [KhachHangController::class, 'toggleStatus']);

        // Quản lý đơn thuê
        Route::put('/don-thue/{id}', [DonThueController::class, 'update']);

        // Quản lý đánh giá
        Route::get('/danh-gia', [DanhGiaController::class, 'index']);
        Route::delete('/danh-gia/{id}', [DanhGiaController::class, 'destroy']);

        // Xử lý giao xe, nhận xe
        Route::post('/giao-xe', [GiaoNhanXeController::class, 'giaoXe']);
        Route::post('/nhan-xe', [GiaoNhanXeController::class, 'nhanXe']);
    });
});
