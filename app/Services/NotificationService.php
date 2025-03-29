<?php
namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public static function createNotification($userId, $relatedUserId, $type, $message)
    {
        return Notification::create([
            'user_id' => $userId, // المستخدم الذي قام بالفعل
            'related_user_id' => $relatedUserId, // المستلم
            'type' => $type, // نوع الإشعار
            'message' => $message,
        ]);
    }


    public static function getUserNotifications($userId, $filter)
    {
        return Notification::where('related_user_id', $userId)
            ->when($filter == 'unread', function ($query) {
                $query->where('is_read', false);
            })
            ->when($filter == 'read', function ($query) {
                $query->where('is_read', true);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function getSentNotifications($userId)
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public static function markAsRead($userId, $notificationId)
    {
        return Notification::findOrFail($notificationId)->update(['is_read' => true]);
    }

    public static function deleteNotification($userId, $notificationId)
    {
        return Notification::findOrFail($notificationId)->delete();
    }
}

