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
            'duration' => 'required|date_format:H:i:s', // التحقق من التنسيق
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
            'duration' => 'required|date_format:H:i:s', // التحقق من التنسيق
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
            'parts.videos',
            'videos' => function ($query) {
                $query->orderBy('ranking'); // ترتيب الفيديوهات حسب ranking
            }
        ])->findOrFail($courseId);

        // احصل على الأجزاء (parts) الخاصة بالدورة
        $parts = $course->parts;
        $videosWithoutPart = CourseVideo::where('course_id', $courseId)->whereNull('part_id')->paginate(10);

        // قم بتمرير البيانات إلى العرض
        return view('dashboard.course_videos.index', compact('course', 'parts', 'videosWithoutPart'));
    }

    public function addVideoFromCsvFile(Request $request, $courseId)
    {
        // التحقق من صحة الطلب
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048', // تأكد من أن الملف هو CSV
        ]);
        // التحقق من رفع الملف
        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');

            // فتح الملف للقراءة
            if (($handle = fopen($csvFile->getRealPath(), 'r')) !== false) {
                // قراءة عنوان الأعمدة من السطر الأول
                $header = fgetcsv($handle);

                // قراءة باقي الصفوف
                while (($row = fgetcsv($handle)) !== false) {
                    // تحويل الصف إلى مصفوفة مع مفاتيح من العنوان
                    $data = array_combine($header, $row);

                    // هنا يمكنك معالجة البيانات حسب الحاجة
                    // مثلاً: حفظ بيانات الفيديو في قاعدة البيانات وربطها بمعرف الدورة $courseId
                    CourseVideo::create([
                        'course_id' => $courseId,
                        'title' => $data['title'],
                        'video' => $data['video'],
                        'description' => $data['description'],
                        'question' => $data['question'] ?? null,
                        'duration' => $data['duration'],
                    ]);
                }

                fclose($handle);
            }
        }

        return redirect()->back()->with('success', 'تم رفع الملف ومعالجة البيانات بنجاح');
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
