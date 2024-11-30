<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $categories = Category::all();

        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();

        $allStudentsCount = $students->count();
        $coursesHours = Course::sum('duration_in_hours');

        return view('home', compact(
            'courses',
            'categories',
            'allStudentsCount',
            'coursesHours',
            'teachers',
            'students',
        ));
    }
    public function dashboard()
    {
        $studentsCount = User::where('role', 'student')->count();
        $teachersCount = User::where('role', 'teacher')->count();
        $sectionsCount = Section::count();
        $lessonsCount = Course::count();

        $latestLessons = Course::latest()->take(5)->get();
        $latestSections = Section::latest()->take(5)->get();
        $notifications = [];
        return view(
            'dashboard.index',
            compact('studentsCount', 'teachersCount', 'sectionsCount', 'lessonsCount', 'latestLessons', 'latestSections', 'notifications')
        );
    }

    public function showVideos(Course $course, CourseVideo $video = null)
    {
        // إذا لم يتم تحديد فيديو معين، نعرض أول فيديو
        $video = $video ?? $course->videos->first();

        // حساب ترتيب الفيديو الحالي في قائمة الفيديوهات
        $currentVideoIndex = $course->videos->search(function ($v) use ($video) {
            return $v->id === $video->id;
        }) + 1; // +1 لأن الترتيب يبدأ من 0

        // إجمالي عدد الفيديوهات
        $totalVideos = $course->videos->count();

        // حساب نسبة الإنجاز
        $progress = ($currentVideoIndex / $totalVideos) * 100;

        return view('video-courses', compact('course', 'video', 'progress', 'currentVideoIndex', 'totalVideos'));
    }

    public function allCourses()
    {
        $courses = Course::paginate(6);
        return view('all-courses', compact('courses'));
    }
}
