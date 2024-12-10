<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ])->withInput(); // إعادة تعبئة البيانات في حالة الخطأ
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
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);
        $user->userInfo->create([
            'gender' => $request->gender
        ]);

        Auth::login($user); // تسجيل دخول تلقائي بعد التسجيل
        return redirect()->route('home')->with('success', 'تم التسجيل بنجاح');
    }

    // عرض صفحة استعادة كلمة المرور
    public function forgotPassword()
    {
        return view('Auth.forgot-password');
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
