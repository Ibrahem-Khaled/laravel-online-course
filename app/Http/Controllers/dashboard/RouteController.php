<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        $activeRoutes = Route::count();
        $avgCoursesPerRoute = Route::withCount('courses')->get()->avg('courses_count');
        $latestRoute = Route::latest()->first();
        return view('dashboard.routes.index', compact('routes', 'activeRoutes', 'avgCoursesPerRoute', 'latestRoute'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:routes|max:255',
            'target_group' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // نسخ بيانات الطلب إلى مصفوفة قابلة للتعديل
        $data = $request->all();

        // التحقق من وجود ملف صورة في الطلب
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // تخزين الصورة في مجلد "images" داخل "storage/app/public"
            $path = $image->store('images', 'public');
            $data['image'] = $path; // سيتم تخزين مسار الصورة في قاعدة البيانات
        }

        $route = Route::create($data);

        return redirect()->back()->with('success', 'Route added successfully.');
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'name' => 'required|max:255|unique:routes,name,' . $route->id,
            'target_group' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // نسخ بيانات الطلب إلى مصفوفة قابلة للتعديل
        $data = $request->all();

        // التحقق من وجود ملف صورة جديد في الطلب لتحديث الصورة
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // تخزين الصورة في مجلد "images" داخل "storage/app/public"
            $path = $image->store('images', 'public');
            $data['image'] = $path; // تحديث مسار الصورة في قاعدة البيانات

            // إذا كنت تريد حذف الصورة القديمة من التخزين، يمكنك استخدام الكود التالي:
            if ($route->image) {
                Storage::disk('public')->delete($route->image);
            }
        }

        $route->update($data);

        return redirect()->back()->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route)
    {
        // حذف الصورة من التخزين إذا كانت موجودة
        if ($route->image) {
            Storage::disk('public')->delete($route->image);
        }

        $route->delete();

        return redirect()->back()->with('success', 'Route removed successfully.');
    }

}
