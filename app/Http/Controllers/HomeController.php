<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\Section;
use App\Models\User;
use App\Models\VideoHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $categories = Category::all();
        $sections = Section::all();

        $students = User::where('role', 'student')->whereHas('sections')->get();

        $teachers = User::where('role', 'teacher')->get();

        $allStudentsCount = User::where('role', 'student')->count();

        $coursesHours = 0;
        foreach ($courses as $key => $course) {
            if (is_numeric($course->duration_in_hours)) {
                $coursesHours += $course->duration_in_hours;
            }
        }

        return view('home', compact(
            'courses',
            'categories',
            'sections',
            'allStudentsCount',
            'coursesHours',
            'teachers',
            'students',
        ));
    }

    public function approvedPage()
    {
        return view('approved_page');
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

    public function showVideos(Course $course)
    {
        // تحميل العلاقة قبل التحقق من `isEmpty()`
        $course->load('videos', 'parts.videos', 'user', 'ratings');

        // التحقق مما إذا كان هناك فيديوهات
        if ($course->videos->isEmpty()) {
            return redirect()->back()->with('warning', 'قريباً سيتم إضافة فيديوهات.');
        }

        // return response()->json([
        //     'course' => $course,
        // ]);

        // إرسال البيانات إلى Inertia
        return Inertia::render('Video', [
            'course' => $course,
            'userRole' => auth()->user()->role,
            'duration_in_hours' => $course->duration_in_hours,
            'user' => auth()->user(),
            'rating' => $course->ratings->avg('rating'),
        ]);
    }

    public function allCourses($category_id = null)
    {
        $limit = 12; // عدد الدورات التي يتم تحميلها في كل مرة
        $page = request()->get('page', 1); // الصفحة الحالية

        if ($category_id) {
            $courses = Course::where('status', 'active')
                ->where('category_id', $category_id)
                ->skip(($page - 1) * $limit)
                ->take($limit)
                ->get();
        } else {
            $courses = Course::where('status', 'active')
                ->skip(($page - 1) * $limit)
                ->take($limit)
                ->get();
        }

        if (request()->ajax()) {
            // إذا كان الطلب عبر AJAX، نرجع البيانات كـ JSON
            return response()->json([
                'courses' => view('homeComponents.home.course-card', compact('courses'))->render(),
            ]);
        }

        return view('all-courses', compact('courses', 'page', 'limit'));
    }

    public function allStudentsSections()
    {
        $students = User::where('role', 'student')->whereHas('sections')->get();
        return view('all_students_section', compact('students'));
    }
}
