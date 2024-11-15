<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseVideo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $categories = Category::all();
        return view('home', compact('courses', 'categories'));
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
}
