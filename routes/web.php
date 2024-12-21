<?php

use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\ContactUsController;
use App\Http\Controllers\dashboard\CourseController;
use App\Http\Controllers\dashboard\CourseRatingController;
use App\Http\Controllers\dashboard\CourseVideoController;
use App\Http\Controllers\dashboard\SectionCalendarController;
use App\Http\Controllers\dashboard\SectionsController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\webController\UserSectionController;
use App\Http\Controllers\webController\videoCourseController;
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


Route::group([], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    //this routes for video-courses with home works and comments and rating
    Route::get('courses/{course}/videos{video?}', [HomeController::class, 'showVideos'])->name('courses.videos');

    Route::post('add-homework', [videoCourseController::class, 'addHomework'])->name('add-homework')->middleware('auth');
    Route::post('add-comment', [videoCourseController::class, 'videoDiscssion'])->name('add-comment')->middleware('auth');
    Route::post('homework/{id}/reply', [videoCourseController::class, 'homeworkReply'])->name('homework.reply')->middleware('auth');
    Route::post('/video-usage/add', [videoCourseController::class, 'addVideoUsage'])->name('addVideoUsage');
    Route::put('/video/{id}/question', [videoCourseController::class, 'updateQuestion'])->name('updateQuestion');

    //this route geting all courses
    Route::get('all-courses/{category_id?}', [HomeController::class, 'allCourses'])->name('all-courses');

    //this route geting sections
    Route::get('user/section', [UserSectionController::class, 'index'])->name('user-section')->middleware('auth');
    Route::put('update-user-reports/{student_id}', [UserSectionController::class, 'addStudentReportsDaily'])->name('update-user-reports')->middleware('auth');
    Route::post('addVideoFromCourse', [UserSectionController::class, 'addVideoFromCourse'])->name('addVideoFromCourse')->middleware('auth');
    Route::get('/video/{id}', [UserSectionController::class, 'getVideo'])->name('getVideo');
    Route::put('editVideoFromCourse', [UserSectionController::class, 'editVideoFromCourse'])->name('editVideoFromCourse')->middleware('auth');

});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'isAdmin']], function () {

    Route::get('/', [HomeController::class, 'dashboard'])->name('home.dashboard');

    //this user controller for dashboard
    Route::resource('users', UserController::class);
    Route::get('show-all-user-reports/{id}', [UserController::class, 'showAllUserReports'])->name('show.all.user.reports');
    Route::post('/user-reports', [UserController::class, 'storeReport'])->name('userReports.store');
    Route::delete('/user-reports/{id}', [UserController::class, 'destroyReport'])->name('userReports.destroy');
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

    //this routes sectios 
    Route::resource('sections', SectionsController::class);
    Route::get('section/{id}', [SectionsController::class, 'showUsers'])->name('sections.show');
    Route::post('sections/{id}/add-users', [SectionsController::class, 'addUsers'])->name('sections.addUsers');
    Route::resource('section-calendars', SectionCalendarController::class);


});


require __DIR__ . '/auth.php';