<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSectionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user->sections()->exists()) {
            return redirect()->back()->with('error', 'لم يتم تعيينك إلى أي قسم بعد.');
        }
        $courses = Course::where('status', 'draft')->get();
        $section = $user->sections()->first();
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

    public function addCourseFromSection(Request $request)
    {
        $section = Section::findOrFail($request->section_id);
        $section->courses()->attach($request->course_id);
        return redirect()->back()->with('success', 'تم اضافة الدورة بنجاح');
    }

}
