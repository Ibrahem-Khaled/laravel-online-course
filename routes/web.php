<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\ContactUsController;
use App\Http\Controllers\dashboard\CourseController;
use App\Http\Controllers\dashboard\CourseRatingController;
use App\Http\Controllers\dashboard\CourseVideoController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\HomeController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('loginPost', [AuthController::class, 'loginPost'])->name('loginPost');

    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('registerPost', [AuthController::class, 'registerPost'])->name('registerPost');

    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('courses/{course}/videos{video?}', [HomeController::class, 'showVideos'])->name('courses.videos');

Route::group(['prefix' => 'dashboard'], function () {

    Route::get('/', function () {
        return view('dashboard.index');
    })->name('home.dashboard');

    //this user controller for dashboard
    Route::resource('users', UserController::class);

    //this category controller for dashboard
    Route::resource('categories', CategoryController::class);

    //this course controller for dashboard
    Route::resource('courses', CourseController::class);

    //this contact-us controller for dashboard
    Route::resource('contact_us', ContactUsController::class);

    //this course-rating controller for dashboard
    Route::resource('course_ratings', CourseRatingController::class);

    //this course-video controller for dashboard
    Route::resource('course_videos', CourseVideoController::class);
    Route::get('/courses/{course}/videos', [CourseVideoController::class, 'showByCourse'])->name('course_videos.by_course');

});