<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRepots as UserReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $users = $query->get();
        $studentsWithSections = User::where('role', 'student')->whereHas('sections')->get();

        return view('dashboard.users.index', compact('users', 'studentsWithSections'));
    }

    public function changeStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        $message = $user->status !== 'active' ? 'تم تعطيل المستخدم بنجاح' : 'تم تفعيل المستخدم بنجاح';

        return redirect()->back()->with('success', $message);
    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users',
            'phone' => 'nullable|string|unique:users',
            'address' => 'nullable|string',
            'role' => 'required|in:admin,supervisor,teacher,student',
            'status' => 'required|in:active,inactive',
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // في وظيفة التخزين
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('avatars', 'public');
        } else {
            $imagePath = null;
        }


        // إنشاء مستخدم جديد
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role' => $validated['role'],
            'status' => $validated['status'],
            'password' => Hash::make($validated['password']),
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'تم إضافة المستخدم بنجاح.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|unique:users,phone,' . $id,
            'address' => 'nullable|string',
            'role' => 'required|in:admin,supervisor,teacher,student',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // في وظيفة التحديث
        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $imagePath = $request->file('image')->store('avatars', 'public');
        } else {
            $imagePath = $user->image;
        }

        // تحديث بيانات المستخدم
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role' => $validated['role'],
            'status' => $validated['status'],
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'تم تعديل المستخدم بنجاح.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // في وظيفة الحذف
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->back()->with('success', 'تم حذف المستخدم بنجاح.');
    }

    public function showAllUserReports($id)
    {
        $user = User::with('userReports')->findOrFail($id);
        $teachers = User::where('role', 'teacher')->get();
        return view('dashboard.users.reports', compact('user', 'teachers'));
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح.');
    }


    public function storeReport(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'attendance' => 'required|integer|min:0|max:10',
            'reactivity' => 'required|integer|min:0|max:10',
            'homework' => 'required|integer|min:0|max:10',
            'completion' => 'required|integer|min:0|max:10',
            'creativity' => 'required|integer|min:0|max:10',
            'ethics' => 'required|integer|min:0|max:10',
        ]);

        UserReport::create([
            'user_id' => $request->user_id,
            'teacher_id' => $request->teacher_id,
            'attendance' => $request->attendance,
            'reactivity' => $request->reactivity,
            'homework' => $request->homework,
            'completion' => $request->completion,
            'creativity' => $request->creativity,
            'ethics' => $request->ethics,
            'created_at' => $request->created_at,
        ]);

        return redirect()->back()->with('success', 'تم إضافة التقييم بنجاح');
    }

    // حذف التقييم
    public function destroyReport($id)
    {
        $report = UserReport::findOrFail($id);
        $report->delete();

        return redirect()->back()->with('success', 'تم حذف التقييم بنجاح');
    }
}
