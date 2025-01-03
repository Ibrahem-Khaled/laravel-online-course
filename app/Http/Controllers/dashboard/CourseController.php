<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Part;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $users = User::where('role', 'teacher')->get();
        $categories = Category::all();
        return view('dashboard.courses.index', compact('courses', 'users', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'duration_in_hours' => 'required|integer|min:0',
            'language' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,draft',
            'is_featured' => 'boolean',
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
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'duration_in_hours' => 'required|integer|min:0',
            'language' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,draft',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $course->update($validated);

        return redirect()->back()->with('success', 'تم تعديل الدورة بنجاح!');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
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
}
