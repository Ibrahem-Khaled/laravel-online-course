<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\Route;
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
        $sections = Section::with('users')->get();

        $students = User::where('role', 'student')->whereHas('sections')->get();

        $teachers = User::where('role', 'teacher')->get();

        $allStudentsCount = User::where('role', 'student')->count();
        $isAuthenticated = auth()->check();

        $coursesHours = 0;
        foreach ($courses as $key => $course) {
            if (is_numeric($course->duration_in_hours)) {
                $coursesHours += $course->duration_in_hours;
            }
        }

        return Inertia::render('Home', [
            'courses' => $courses,
            'categories' => $categories,
            'sections' => $sections,
            'allStudentsCount' => $allStudentsCount,
            'coursesHours' => $coursesHours,
            'teachers' => $teachers,
            'students' => $students,
            'isAuthenticated' => $isAuthenticated,
            'user' => auth()->user(),
        ]);
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
        $course->load('videos', 'parts.videos', 'user', 'ratings', 'softwaresUsages');

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

    public function allCourses(Request $request, $category_id = null)
    {
        $courses = Course::where('status', 'active')
            ->when($category_id, function ($query, $category_id) {
                return $query->where('category_id', $category_id);
            })
            ->paginate(12); // جلب 12 دورة في كل صفحة

        if ($request->ajax()) {
            return response()->json([
                'html' => view('homeComponents.home.courses-list', ['courses' => $courses])->render(),
                'hasMore' => $courses->hasMorePages()
            ]);
        }

        return view('all-courses', compact('courses'));
    }



    public function allStudentsSections()
    {
        $students = User::where('role', 'student')->whereHas('sections')->get();
        return view('all_students_section', compact('students'));
    }

    public function showRoutesCourses(Route $route)
    {
        $courses = $route->courses()->get();
        return view('routes_courses', compact('route', 'courses'));
    }
}
