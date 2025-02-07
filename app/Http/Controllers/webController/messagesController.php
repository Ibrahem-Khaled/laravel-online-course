<?php

namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class messagesController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // الحصول على جهات الاتصال
        $contactIds = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->select('sender_id', 'receiver_id')
            ->get()
            ->flatMap(fn($msg) => [$msg->sender_id, $msg->receiver_id])
            ->unique()
            ->filter(fn($id) => $id != $user->id);

        $contacts = User::whereIn('id', $contactIds)->withCount([
            'unreadMessages' => function ($query) use ($user) {
                $query->where('receiver_id', $user->id);
            }
        ])->get();

        // الحصول على قائمة المدرسين
        $teachers = User::where('role', 'teacher')
            ->whereNotIn('id', $contactIds)
            ->get();

        return view('chat', compact('contacts', 'teachers'));
    }

    public function getMessages(User $user)
    {
        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }

    public function startChat(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id'
        ]);

        $teacher = User::findOrFail($request->teacher_id);

        // إنشاء رسالة ترحيبية
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $teacher->id,
            'message' => 'مرحبا، أود البدء في محادثة معك'
        ]);

        return response()->json(['success' => true]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return response()->json(['success' => true, 'message' => $message]);
    }
}
