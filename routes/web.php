<?php

use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home.dashboard');
});


Route::group(['prefix' => 'dashboard'], function () {

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('home.dashboard');

    //this user controller for dashboard
    Route::resource('users', UserController::class);

    //this category controller for dashboard
    Route::resource('categories', CategoryController::class);
});