<?php

namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;

use App\Models\Category;
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

        // السماح للمستخدم إذا كان لديه دور "أدمن" أو "مشرف"
        if ($user->role === 'admin' || $user->role === 'supervisor') {
            $sections = Section::all(); // جلب جميع الأقسام
            $section = $request->has('section_id')
                ? Section::find($request->query('section_id'))
                : $sections->first();

            if (!$section) {
                return redirect()->back()->with('error', 'القسم المطلوب غير موجود.');
            }
        } else {
            // التحقق إذا كان المستخدم ينتمي إلى أي قسم
            if (!$user->sections()->exists()) {
                return redirect()->back()->with('error', 'لم يتم تعيينك إلى أي قسم بعد.');
            }

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
        }

        // جلب الكورسات الخاصة بالقسم
        $courses = Course::where('status', 'draft')->get();
        $sectionCourses = $section->courses()->get();
        $sectionCalendars = $section->calendars;
        $categories = Category::all();
        $sectionStudents = $section->users()->where('role', 'student')->get();

        return view('user-section', compact(
            'section',
            'courses',
            'sectionCourses',
            'categories',
            'sectionStudents',
            'sectionCalendars'
        ));
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
        $section = Section::findOrFail($request->section_id);

        $validated = $request->validate([
            'course_option' => 'required|in:existing,new',
            'category_id' => 'required_if:course_option,new|exists:categories,id',
            'course_id' => 'required_if:course_option,existing|exists:courses,id',
            'new_course_title' => 'exclude_unless:course_option,new|string|max:255',
            'new_course_description' => 'exclude_unless:course_option,new|string',
            'new_course_image' => 'nullable|image|max:2048',
            'title' => 'required|string|max:255',
            'video' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'question' => 'nullable|string',
        ]);


        if ($request->course_option === 'new') {
            $newCourseData = [
                'title' => $validated['new_course_title'],
                'description' => $validated['new_course_description'],
                'category_id' => $validated['category_id'],
                'image' => $request->hasFile('new_course_image') ? $request->file('new_course_image')->store('courses', 'public') : null,
                'user_id' => Auth::user()->id,
                'status' => 'draft',
            ];
            $course = Course::create($newCourseData);
            $validated['course_id'] = $course->id;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('course_videos', 'public');
        }
        if (!$section->courses()->where('courses.id', $validated['course_id'])->exists()) {
            $section->courses()->attach($validated['course_id']);
        }
        CourseVideo::create($validated);

        return redirect()->back()->with('success', 'تم إضافة الفيديو بنجاح!');
    }

    public function editVideoFromCourse(Request $request)
    {
        $video = CourseVideo::findOrFail($request->video_id);

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

        $video->update($validated);

        return redirect()->back()->with('success', 'تم تعديل الفيديو بنجاح!');
    }

    public function getVideo($id)
    {
        $video = CourseVideo::findOrFail($id);
        return response()->json($video);
    }

}
