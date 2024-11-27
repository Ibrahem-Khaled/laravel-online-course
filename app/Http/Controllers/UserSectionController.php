<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSectionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user->sections()->exists()) {
            return redirect()->back()->with('error', 'لم يتم تعيينك إلى أي قسم بعد.');
        }
        $section = $user->sections()->first();
        return view('user-section', compact('section'));
    }
}
