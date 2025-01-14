<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\Part;
use Illuminate\Http\Request;

class CourseVideoController extends Controller
{
    public function index()
    {
        $videos = CourseVideo::with('course')->paginate(10);
        $courses = Course::all();

        return view('dashboard.course_videos.course_videos', compact('videos', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'part_id' => 'nullable|exists:parts,id',
            'title' => 'required|string|max:255',
            'video' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'question' => 'nullable|string',
            'duration' => 'required|numeric|min:0',
        ]); 

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('course_videos', 'public');
        }

        CourseVideo::create($validated);

        return redirect()->back()->with('success', 'تم إضافة الفيديو بنجاح!');
    }

    public function update(Request $request, $id)
    {
        $video = CourseVideo::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'part_id' => 'nullable|exists:parts,id',
            'video' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'question' => 'nullable|string',
            'duration' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('course_videos', 'public');
        }

        $video->update($validated);

        return redirect()->back()->with('success', 'تم تعديل الفيديو بنجاح!');
    }

    public function showByCourse($courseId)
    {
        // احصل على الدورة مع الفيديوهات المرتبة حسب ranking
        $course = Course::with([
            'videos' => function ($query) {
                $query->orderBy('ranking'); // ترتيب الفيديوهات حسب ranking
            }
        ])->findOrFail($courseId);

        // احصل على الأجزاء (parts) الخاصة بالدورة
        $parts = Part::where('course_id', $courseId)->get();

        // قم بتمرير البيانات إلى العرض
        return view('dashboard.course_videos.index', compact('course', 'parts'));
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $index => $videoId) {
            CourseVideo::where('id', $videoId)->update(['ranking' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
    public function destroy($id)
    {
        $video = CourseVideo::findOrFail($id);
        $video->delete();

        return redirect()->back()->with('success', 'تم حذف الفيديو بنجاح!');
    }
}
