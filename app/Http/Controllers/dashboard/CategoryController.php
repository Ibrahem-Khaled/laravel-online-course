<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // التعامل مع رفع الصورة
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->move(public_path('categories'), time() . '.' . $request->file('image')->extension());
        }

        // إنشاء فئة جديدة
        Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة الفئة بنجاح.');
    }

    public function update(Request $request, Category $category)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // تحديث الصورة
        if ($request->hasFile('image')) {
            if ($category->image && File::exists(public_path($category->image))) {
                File::delete(public_path($category->image)); // حذف الصورة القديمة
            }
            $imagePath = $request->file('image')->move(public_path('categories'), time() . '.' . $request->file('image')->extension());
        } else {
            $imagePath = $category->image;
        }

        // تحديث بيانات الفئة
        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'تم تعديل الفئة بنجاح.');
    }

    public function destroy(Category $category)
    {
        if ($category->image && File::exists(public_path($category->image))) {
            File::delete(public_path($category->image)); // حذف الصورة
        }

        $category->delete();

        return redirect()->back()->with('success', 'تم حذف الفئة بنجاح.');
    }
}
