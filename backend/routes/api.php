<?php
namespace App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// مسارات محمية للمشرف فقط
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});
// مسارات محمية للمستخدم العادي
Route::middleware(['auth:sanctum', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index']);
});
