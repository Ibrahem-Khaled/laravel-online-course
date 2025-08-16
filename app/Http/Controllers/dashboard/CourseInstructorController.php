<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseInstructor;
use App\Models\User;
use App\Models\Course;
use Illuminate\Validation\Rule;


class CourseInstructorController extends Controller
{
    public function index(Request $request)
    {
        $selectedRole = $request->get('role', 'all');
        $searchQuery = $request->get('search');

        // الاستعلام الأساسي مع جلب العلاقات لتجنب مشكلة N+1
        $query = CourseInstructor::with(['user', 'course']);

        // فلترة حسب الدور
        if ($selectedRole !== 'all') {
            $query->where('role', $selectedRole);
        }

        // بحث باسم المدرب أو اسم الدورة
        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->whereHas('user', function ($userQuery) use ($searchQuery) {
                    $userQuery->where('name', 'like', "%{$searchQuery}%");
                })->orWhereHas('course', function ($courseQuery) use ($searchQuery) {
                    $courseQuery->where('name', 'like', "%{$searchQuery}%");
                });
            });
        }

        $instructors = $query->latest()->paginate(10);

        // حساب الإحصائيات
        $stats = [
            'total' => CourseInstructor::count(),
            'assistants' => CourseInstructor::where('role', 'assistant')->count(),
            'co_trainers' => CourseInstructor::where('role', 'co-trainer')->count(),
        ];

        // جلب كل المستخدمين (المدربين المحتملين) والدورات لإضافتهم في مودال الإنشاء
        $users = User::whereIn('role', ['teacher', 'admin', 'super_admin'])->get(); // يمكنك تعديل الأدوار حسب نظامك
        $courses = Course::all();
        $roles = ['assistant', 'co-trainer'];

        return view('dashboard.instructors.index', compact('instructors', 'stats', 'users', 'courses', 'roles', 'selectedRole'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                // التأكد من أن هذا المستخدم غير مسجل في نفس الدورة بالفعل
                Rule::unique('course_instructors')->where(function ($query) use ($request) {
                    return $query->where('course_id', $request->course_id);
                }),
            ],
            'course_id' => 'required|exists:courses,id',
            'role' => 'required|in:assistant,co-trainer',
        ], [
            'user_id.unique' => 'هذا المدرب مسجل بالفعل في هذه الدورة.',
        ]);

        CourseInstructor::create($request->all());

        return redirect()->route('instructors.index')->with('success', 'تمت إضافة المدرب بنجاح.');
    }

    public function update(Request $request, CourseInstructor $instructor)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                // التأكد من التفرد مع تجاهل السجل الحالي
                Rule::unique('course_instructors')->where(function ($query) use ($request) {
                    return $query->where('course_id', $request->course_id);
                })->ignore($instructor->id),
            ],
            'course_id' => 'required|exists:courses,id',
            'role' => 'required|in:assistant,co-trainer',
        ], [
            'user_id.unique' => 'هذا المدرب مسجل بالفعل في هذه الدورة.',
        ]);

        $instructor->update($request->all());

        return redirect()->route('instructors.index')->with('success', 'تم تعديل بيانات المدرب بنجاح.');
    }

    public function destroy(CourseInstructor $instructor)
    {
        $instructor->delete();
        return redirect()->route('instructors.index')->with('success', 'تم حذف المدرب بنجاح.');
    }
}
