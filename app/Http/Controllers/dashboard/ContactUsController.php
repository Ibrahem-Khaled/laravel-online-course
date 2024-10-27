<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        $messages = ContactUs::with(['user', 'reportedUser'])->get();
        $users = User::all();

        return view('dashboard.contact-us', compact('messages', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'user_id_is_reported' => 'nullable|exists:users,id',
            'message' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('contact_us', 'public');
        }

        ContactUs::create($validated);

        return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح!');
    }

    public function destroy($id)
    {
        $message = ContactUs::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'تم حذف الرسالة بنجاح!');
    }
}
