<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('loginPost', [AuthController::class, 'loginPost'])->name('loginPost');

    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('registerPost', [AuthController::class, 'registerPost'])->name('registerPost');

    Route::get('profile', [AuthController::class, 'profile'])->name('user.profile')->middleware('auth');

    Route::post('change-password', [AuthController::class, 'changePassword'])->name('change-password')->middleware('auth');

    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});