<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSectionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // التحقق إذا كان المستخدم ينتمي إلى أي قسم
        if (!$user->sections()->exists()) {
            return redirect()->back()->with('error', 'لم يتم تعيينك إلى أي قسم بعد.');
        }

        $courses = Course::where('status', 'draft')->get();

        // التحقق من القسم المُرسل عبر الطلب
        if ($request->has('section_id')) {
            $section = $user->sections()->where('section_id', $request->query('section_id'))->first();

            // إذا كان القسم غير موجود ضمن أقسام المستخدم
            if (!$section) {
                return redirect()->back()->with('error', 'غير مصرح لك بالدخول إلى هذا الفصل.');
            }
        } else {
            // إذا لم يُرسل section_id وكان المستخدم لديه قسم واحد
            $section = $user->sections()->first();
        }

        // جلب الكورسات الخاصة بالقسم
        $sectionCourses = $section->courses()->get();

        return view('user-section', compact('section', 'courses', 'sectionCourses'));
    }


    public function addStudentReportsDaily(Request $request, $student_id)
    {
        // البحث عن الطالب
        $student = User::findOrFail($student_id);

        // البحث عن آخر تقييم لهذا الطالب
        $lastReport = $student->userReports()->latest()->first();

        if ($lastReport && $lastReport->created_at->isToday()) {
            // إذا كان هناك تقييم لليوم الحالي، نقوم بتحديثه
            $lastReport->update([
                'attendance' => $request->input('attendance', $lastReport->attendance),
                'reactivity' => $request->input('reactivity', $lastReport->reactivity),
                'homework' => $request->input('homework', $lastReport->homework),
                'completion' => $request->input('completion', $lastReport->completion),
                'creativity' => $request->input('creativity', $lastReport->creativity),
                'ethics' => $request->input('ethics', $lastReport->ethics),
                'teacher_id' => Auth::user()->id
            ]);
        } else {
            // إذا لم يكن هناك تقييم لليوم الحالي، نقوم بإضافة تقييم جديد
            $student->userReports()->create([
                'attendance' => $request->input('attendance', 0),
                'reactivity' => $request->input('reactivity', 0),
                'homework' => $request->input('homework', 0),
                'completion' => $request->input('completion', 0),
                'creativity' => $request->input('creativity', 0),
                'ethics' => $request->input('ethics', 0),
                'teacher_id' => Auth::user()->id

            ]);
        }

        return redirect()->back()->with('success', 'تم حفظ التقييم بنجاح');
    }

    public function addVideoFromCourse(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'question' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('course_videos', 'public');
        }

        CourseVideo::create($validated);

        return redirect()->back()->with('success', 'تم إضافة الفيديو بنجاح!');
    }

    public function editVideoFromCourse(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'question' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('course_videos', 'public');
        }

        CourseVideo::create($validated);

        return redirect()->back()->with('success', 'تم إضافة الفيديو بنجاح!');
    }

    public function getVideo($id)
    {
        $video = CourseVideo::findOrFail($id);
        return response()->json($video);
    }

}
