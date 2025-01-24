<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Route;
use App\Models\RouteCourse;
use Illuminate\Http\Request;

class RouteCourseController extends Controller
{
    public function index(Route $route)
    {
        $courses = Course::where('status', 'active')->get();

        return view('dashboard.routes.routes_courses', compact('route', 'courses'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        if (RouteCourse::where('route_id', $request->route_id)->where('course_id', $request->course_id)->exists()) {
            return redirect()->back()->withErrors('هذا الكورس مضاف بالفعل إلى المسار.');
        }

        RouteCourse::create($request->all());

        return redirect()->back()->with('success', 'Course added to route successfully.');
    }

    public function update(Request $request, RouteCourse $routeCourse)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $routeCourse->update($request->all());

        return redirect()->back()->with('success', 'Course updated successfully.');
    }

    public function destroy(RouteCourse $routeCourse)
    {
        $routeCourse->delete();

        return redirect()->back()->with('success', 'Course removed from route successfully.');
    }
}