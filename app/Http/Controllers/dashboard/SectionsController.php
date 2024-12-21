<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return view('dashboard.sections.index', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sections|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'meeting_link' => 'nullable|url',
        ]);

        $data = $request->all();

        // معالجة رفع الصورة
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sections/images', 'public');
            $data['image'] = $imagePath;
        }

        Section::create($data);

        return redirect()->route('sections.index')->with('success', 'تم إنشاء القسم بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:sections,name,' . $id . '|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'meeting_link' => 'nullable|url',
        ]);

        $section = Section::findOrFail($id);

        // تحديث البيانات
        $section->name = $request->input('name');
        $section->description = $request->input('description');
        $section->meeting_link = $request->input('meeting_link');

        // معالجة رفع الصورة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($section->image && \Storage::exists($section->image)) {
                \Storage::delete($section->image);
            }

            // رفع الصورة الجديدة وتحديث المسار
            $imagePath = $request->file('image')->store('sections/images', 'public');
            $section->image = $imagePath;
        }

        $section->save();

        return redirect()->route('sections.index')->with('success', 'تم تحديث القسم بنجاح.');
    }

    public function destroy($id)
    {
        $section = Section::findOrFail($id);

        // حذف الصورة إذا وجدت
        if ($section->image && \Storage::exists($section->image)) {
            \Storage::delete($section->image);
        }

        $section->delete();

        return redirect()->route('sections.index')->with('success', 'تم حذف القسم بنجاح.');
    }


    public function showUsers($id)
    {
        $section = Section::with('users')->findOrFail($id);
        $students = User::where('role', 'student')->whereDoesntHave('sections')->get();
        $teachers = User::where('role', 'teacher')->get();
        $courses = Course::all();
        return view('dashboard.sections.show', compact('section', 'students', 'teachers', 'courses'));
    }

    public function addUsers(Request $request, $id)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        $section = Section::findOrFail($id);
        $section->users()->syncWithoutDetaching($request->users);

        return redirect()->back()->with('success', 'Users added to section successfully.');
    }

    public function removeUser($sectionId, $userId)
    {
        $section = Section::findOrFail($sectionId);
        $user = User::findOrFail($userId);

        if ($section->users()->detach($user->id)) {
            return redirect()->back()->with('success', 'تم إزالة المستخدم بنجاح.');
        }
        return redirect()->back()->with('error', 'حدث خطأ أثناء محاولة إزالة المستخدم.');

    }
}
