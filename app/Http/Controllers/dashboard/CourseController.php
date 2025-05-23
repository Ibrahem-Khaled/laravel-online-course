<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\inVideoUsage;
use App\Models\Part;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $activeCourses = Course::with(['user', 'category'])
            ->where('status', 'active')
            ->paginate(10, ['*'], 'active_page'); // اسم صفحة الباجينيشن لهذا التبويب

        $inactiveCourses = Course::with(['user', 'category'])
            ->where('status', 'inactive')
            ->paginate(10, ['*'], 'inactive_page'); // اسم مختلف لهذا التبويب

        $users = User::where('role', 'teacher')->get();
        $categories = Category::all();

        $stats = [
            'total_courses' => Course::count(),
            'active_courses' => Course::where('status', 'active')->count(),
            'inactive_courses' => Course::where('status', 'inactive')->count(),
            'featured_courses' => Course::where('is_featured', true)->count(),
            'popular_categories' => Category::withCount('courses')
                ->orderBy('courses_count', 'desc')
                ->take(3)
                ->get(),
        ];

        return view('dashboard.courses.index', compact(
            'activeCourses',
            'inactiveCourses',
            'users',
            'categories',
            'stats'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,draft',
            'is_featured' => 'boolean',
            'type' => 'required|in:open,closed,question',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        Course::create($validated);

        return redirect()->back()->with('success', 'تمت إضافة الدورة بنجاح!');
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,draft',
            'is_featured' => 'boolean',
            'device' => 'required|in:web,mobile,desktop,tablet,tv,other,all', // التحقق من القيمة
            'type' => 'required|in:open,closed,question',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $course->update($validated);
        $course->videos()->update(['device' => $validated['device']]);

        return redirect()->back()->with('success', 'تم تعديل الدورة بنجاح!');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->sectionCalendars()->delete();

        $course->delete();

        return redirect()->back()->with('success', 'تم حذف الدورة بنجاح!');
    }

    public function addPart(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
        ]);

        Part::create([
            'course_id' => $request->course_id,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'تم إضافة القسم بنجاح!');
    }

    public function updatePart(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $part = Part::findOrFail($id);
        $part->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'تم تعديل القسم بنجاح!');
    }
    public function reorderParts(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $index => $partId) {
            Part::where('id', $partId)->update(['ranking' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function deletePart($id)
    {
        $part = Part::findOrFail($id);
        $part->delete();

        return redirect()->back()->with('success', 'تم حذف القسم بنجاح!');
    }

    public function addSoftware(Course $course, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        }

        inVideoUsage::create([
            'user_id' => auth()->user()->id,
            'course_video_id' => $course->id,
            'type' => 'software',
            'title' => $request->title,
            'file' => $request->file,
            'image' => $path,
        ]);

        return redirect()->back()->with('success', 'تم إضافة البرنامج بنجاح!');
    }
}
