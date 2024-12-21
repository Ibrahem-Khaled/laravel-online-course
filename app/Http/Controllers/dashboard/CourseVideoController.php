<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseVideo;
use Illuminate\Http\Request;

class CourseVideoController extends Controller
{
    public function index()
    {
        $videos = CourseVideo::with('course')->get();
        $courses = Course::all();

        return view('dashboard.course_videos.course_videos', compact('videos', 'courses'));
    }

    public function store(Request $request)
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

    public function update(Request $request, $id)
    {
        $video = CourseVideo::findOrFail($id);

        $validated = $request->validate([
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

    public function showByCourse($courseId)
    {
        $course = Course::with('videos')->findOrFail($courseId);

        return view('dashboard.course_videos.index', compact('course'));
    }

    public function destroy($id)
    {
        $video = CourseVideo::findOrFail($id);
        $video->delete();

        return redirect()->back()->with('success', 'تم حذف الفيديو بنجاح!');
    }
}
