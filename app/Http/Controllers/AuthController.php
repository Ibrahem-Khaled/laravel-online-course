<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // عرض صفحة تسجيل الدخول
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('Auth.login');
    }

    // تنفيذ عملية تسجيل الدخول
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // لتأمين الجلسة
            return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح');
        }

        return redirect()->back()->with('error', 'البريد الإلكتروني او كلمة المرور غير صحيحة');
    }

    // عرض صفحة التسجيل
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('Auth.register');
    }

    // تنفيذ عملية التسجيل
    public function registerPost(Request $request)
    {
        $fullPhoneNumber = $request->input('country_code') . $request->input('phone');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|unique:users',
            'address' => 'nullable|string|max:255',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required|in:male,female',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $fullPhoneNumber,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        DB::table('user_infos')->insert([
            'user_id' => $user->id,
            'gender' => $request->gender,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'تم التسجيل بنجاح');
    }

    // عرض صفحة استعادة كلمة المرور
    public function forgotPassword()
    {
        return view('Auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return redirect()->route('login')->with('success', 'تم ارسال رابط استعادة كلمة المرور لبريدك الإلكتروني');
        }
        return redirect()->back()->with('error', 'البريد الإلكتروني غير موجود في قاعدة البيانات.');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'تم تحديث كلمة المرور بنجاح!');
    }


    // تنفيذ تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // إبطال الجلسة
        $request->session()->regenerateToken(); // إعادة توليد التوكن

        return redirect()->back()->with('success', 'تم تسجيل الخروج بنجاح');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('Auth.profile', compact('user'));
    }
}
