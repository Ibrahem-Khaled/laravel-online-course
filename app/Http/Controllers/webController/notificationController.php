<?php

namespace App\Http\Controllers\webController;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class notificationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');
        if (auth()->user()->role == 'admin') {
            $notifications = Notification::all();
        } else {
            $notifications = NotificationService::getUserNotifications(Auth::id(), $filter);
        }

        return view('notification', compact('notifications', 'filter'));
    }

    public function markAsRead($id)
    {
        NotificationService::markAsRead(Auth::id(), $id);
        return response()->json(['success' => true]);
    }

    public function deleteNotification($id)
    {
        NotificationService::deleteNotification(Auth::id(), $id);
        return response()->json(['success' => true]);
    }
}
