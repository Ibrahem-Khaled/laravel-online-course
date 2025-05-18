<?php

use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\ContactUsController;
use App\Http\Controllers\dashboard\CourseController;
use App\Http\Controllers\dashboard\CourseRatingController;
use App\Http\Controllers\dashboard\CourseVideoController;
use App\Http\Controllers\dashboard\RouteController;
use App\Http\Controllers\dashboard\RouteCourseController;
use App\Http\Controllers\dashboard\SectionCalendarController;
use App\Http\Controllers\dashboard\SectionsController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\webController\messagesController;
use App\Http\Controllers\webController\notificationController;
use App\Http\Controllers\webController\SubscriptionController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/approved/page', [HomeController::class, 'approvedPage'])->name('approved.page')->middleware('auth');

Route::get('coming-soon', function () {
    return redirect()->back()->with('warning', 'الصفحة قيد التطوير.');
})->name('coming-soon');


Route::group(['middleware' => ['auth', 'isActive']], function () {

    Route::get('all-students-sections', [HomeController::class, 'allStudentsSections'])->name('all-students-sections');

    //this routes for video-courses with home works and comments and rating
    Route::get('courses/{course}', [HomeController::class, 'showVideos'])->name('courses.videos');

    //this routes for video-courses with home works and comments and rating
    Route::post('add-homework', [videoCourseController::class, 'addHomework'])->name('add-homework');
    Route::post('homework/reply/{id}', [videoCourseController::class, 'homeworkReply'])->name('homework.reply');
    Route::put('/homework/update/{id}', [videoCourseController::class, 'updateHomework'])->name('update-homework');
    Route::delete('/homework/delete/{id}', [videoCourseController::class, 'deleteHomework'])->name('delete-homework');
    Route::post('add-comment', [videoCourseController::class, 'videoDiscssion'])->name('add-comment');
    Route::post('update-comment/{id}', [videoCourseController::class, 'updateVideoDiscssion'])->name('update-comment');
    Route::delete('delete-comment/{id}', [videoCourseController::class, 'deleteVideoDiscssion'])->name('delete-comment');

    //this routes for video-usage
    Route::get('api/courses/{course}/videos/{video}', [\App\Http\Controllers\api\homeController::class, 'getVideoData'])->name('api.courses.videos');
    Route::get('api/videos/{video}/history', [\App\Http\Controllers\api\homeController::class, 'getVideoHistory'])->name('api.videos.history');
    Route::get('api/videos/history/last-watched', [\App\Http\Controllers\api\homeController::class, 'getLastWatchedVideo'])->name('api.videos.history.last-watched');
    Route::post('api/videos/{video}/progress', [\App\Http\Controllers\api\homeController::class, 'updateProgress'])->name('api.videos.progress');
    Route::post('api/videos/{video}/complete', [\App\Http\Controllers\api\homeController::class, 'complete'])->name('api.videos.complete');

    Route::post('/video-usage/add', [videoCourseController::class, 'addVideoUsage'])->name('addVideoUsage');
    Route::delete('/video-usage/{id}', [videoCourseController::class, 'destroyVideoUsage'])->name('videoUsage.destroy');
    Route::put('/videos/{id?}/update-description', [videoCourseController::class, 'updateDescription'])->name('videos.updateDescription');

    Route::put('/video/{id?}/question', [videoCourseController::class, 'updateQuestion'])->name('updateQuestion');

    //this route geting all courses
    Route::get('all-courses/{category_id?}', [HomeController::class, 'allCourses'])->name('all-courses');

    //this route geting sections
    Route::get('user/section', [UserSectionController::class, 'index'])->name('user-section');
    Route::put('update-user-reports/{student_id}', [UserSectionController::class, 'addStudentReportsDaily'])->name('update-user-reports');
    Route::post('addVideoFromCourse', [UserSectionController::class, 'addVideoFromCourse'])->name('addVideoFromCourse');
    Route::get('/video/{id}', [UserSectionController::class, 'getVideo'])->name('getVideo');
    Route::put('editVideoFromCourse', [UserSectionController::class, 'editVideoFromCourse'])->name('editVideoFromCourse');

    //this routes chat controller
    Route::middleware(['auth'])->group(function () {
        Route::get('/chat', [messagesController::class, 'index'])->name('chat');
        Route::get('/messages/{user}', [messagesController::class, 'getMessages']);
        Route::post('/messages/start-chat', [messagesController::class, 'startChat']);
        Route::post('/messages', [messagesController::class, 'sendMessage']);
    });

    //this routes notification controller
    Route::prefix('notifications')->group(function () {
        Route::get('/', [notificationController::class, 'index'])->name('notifications.index');
        Route::post('/{notification}/read', [notificationController::class, 'markAsRead'])->name('notifications.read');
        Route::delete('/{notification}', [notificationController::class, 'deleteNotification'])->name('notifications.destroy');
    });

    //this routes RoutesCourses controller
    Route::get('/routes/{route}/courses', [HomeController::class, 'showRoutesCourses'])->name('routes.courses');


    Route::post('/courses/{course}/subscribe', [SubscriptionController::class, 'subscribe']);
    Route::delete('/courses/{course}/unsubscribe', [SubscriptionController::class, 'unsubscribe']);
    Route::get('/my-subscriptions', [SubscriptionController::class, 'userSubscriptions']);
});



///////////////////////////////////////{this routes for dashboard}\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'check.role:admin,supervisor']], function () {

    Route::get('/', [HomeController::class, 'dashboard'])->name('home.dashboard');

    //this user controller for dashboard
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/change-status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::put('/users/{id}/change-password', [UserController::class, 'changePassword'])->name('users.changePassword');
    Route::get('show-all-user-reports/{id}', [UserController::class, 'showAllUserReports'])->name('show.all.user.reports');
    Route::post('/user-reports', [UserController::class, 'storeReport'])->name('userReports.store');
    Route::delete('/user-reports/{id}', [UserController::class, 'destroyReport'])->name('userReports.destroy');
    //this category controller for dashboard
    Route::resource('categories', CategoryController::class);
    Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    //this course controller for dashboard
    Route::resource('courses', CourseController::class);
    Route::post('/course-parts', [CourseController::class, 'addPart'])->name('course_parts.store');
    Route::put('/course_parts/{id}', [CourseController::class, 'updatePart'])->name('course_parts.update');
    Route::post('/course-parts/reorder', [CourseController::class, 'reorderParts'])->name('course_parts.reorder');
    Route::delete('/course_parts/{id}', [CourseController::class, 'deletePart'])->name('course_parts.destroy');
    Route::post('/corse/{course}/add-software', [CourseController::class, 'addSoftware'])->name('courses.addSoftware');

    //this contact-us controller for dashboard
    Route::resource('contact_us', ContactUsController::class);

    //this course-rating controller for dashboard
    Route::resource('course_ratings', CourseRatingController::class);

    //this course-video controller for dashboard
    Route::resource('course_videos', CourseVideoController::class);
    Route::get('/courses/{course}/videos', [CourseVideoController::class, 'showByCourse'])->name('course_videos.by_course');
    Route::post('/course/{courseId}/upload-csv', [CourseVideoController::class, 'addVideoFromCsvFile'])->name('course.addVideoFromCsvFile');
    Route::post('/course-videos/reorder', [CourseVideoController::class, 'reorder'])->name('course_videos.reorder');

    //this routes sectios 
    Route::resource('sections', SectionsController::class);
    Route::get('section/{id}', [SectionsController::class, 'showUsers'])->name('sections.show');
    Route::post('sections/{section}/add-users', [SectionsController::class, 'addUsers'])->name('sections.addUsers');
    Route::delete('sections/{section}/users/{user}', [SectionsController::class, 'removeUser'])->name('sections.removeUser');
    Route::post('sections/{section}/add-courses', [SectionsController::class, 'addCourse'])->name('sections.addCourse');
    Route::delete('sections/{section}/{course}/remove', [SectionsController::class, 'removeCourse'])->name('sections.removeCourse');
    Route::get('/sections/{section}/courses', [SectionsController::class, 'showCourses'])->name('sections.courses');

    Route::resource('section-calendars', SectionCalendarController::class);

    //this routes route
    Route::resource('routes', RouteController::class);

    Route::get('/routes/{route}/courses', [RouteCourseController::class, 'index'])->name('route_courses.index');
    Route::post('/route-courses', [RouteCourseController::class, 'store'])->name('route_courses.store');
    Route::put('/route-courses/{routeCourse}', [RouteCourseController::class, 'update'])->name('route_courses.update');
    Route::delete('/route-courses/{routeCourse}', [RouteCourseController::class, 'destroy'])->name('route_courses.destroy');
});


require __DIR__ . '/auth.php';
