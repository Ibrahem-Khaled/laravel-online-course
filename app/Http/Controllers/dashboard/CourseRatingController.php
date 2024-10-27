<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRating;
use App\Models\User;
use Illuminate\Http\Request;

class CourseRatingController extends Controller
{
    public function index()
    {
        $ratings = CourseRating::with(['user', 'course'])->get();
        $users = User::all();
        $courses = Course::all();

        return view('dashboard.course_ratings', compact('ratings', 'users', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        CourseRating::create($validated);

        return redirect()->back()->with('success', 'تم إضافة التقييم بنجاح!');
    }

    public function update(Request $request, $id)
    {
        $rating = CourseRating::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $rating->update($validated);

        return redirect()->back()->with('success', 'تم تعديل التقييم بنجاح!');
    }

    public function destroy($id)
    {
        $rating = CourseRating::findOrFail($id);
        $rating->delete();

        return redirect()->back()->with('success', 'تم حذف التقييم بنجاح!');
    }
}
