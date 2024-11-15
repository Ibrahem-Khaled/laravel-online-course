<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard.users.index', compact('users'));
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
}
