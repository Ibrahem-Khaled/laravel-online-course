<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإشعارات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2A3F54;
            --secondary-color: #1ABB9C;
            --accent-color: #ED6B2F;
            --background-dark: #072D38;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--background-dark);
            color: white;
        }

        .notification-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        .notification-header {
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .notification-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            position: relative;
            border-left: 4px solid transparent;
        }

        .notification-item.unread {
            border-left-color: var(--secondary-color);
            background: rgba(26, 187, 156, 0.1);
        }

        .notification-item:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
        }

        .icon-task {
            background: var(--secondary-color);
        }

        .icon-message {
            background: #6c5ce7;
        }

        .icon-system {
            background: var(--accent-color);
        }

        .notification-time {
            font-size: 0.85rem;
            color: #adb5bd;
        }

        .notification-actions {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .notification-item:hover .notification-actions {
            opacity: 1;
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            opacity: 0.7;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')
    <div class="notification-container" dir="rtl">
        <div class="notification-header">
            <h2><i class="fas fa-bell me-2"></i>الإشعارات</h2>
            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('notifications.index', ['filter' => 'all']) }}"
                    class="btn btn-sm btn-outline-secondary {{ $filter === 'all' ? 'active' : '' }}">
                    الكل
                </a>
                <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                    class="btn btn-sm btn-outline-secondary {{ $filter === 'unread' ? 'active' : '' }}">
                    غير المقروءة
                </a>
            </div>
        </div>

        <div class="notification-list" id="notificationList">
            @forelse ($notifications as $notification)
                <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}">
                    <div class="d-flex align-items-center">
                        <div class="notification-icon icon-{{ $notification->type }}">
                            <i class="fas {{ getNotificationIcon($notification->type) }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1" style="color:#ED6B2F ">{{ $notification->message }}</h6>
                            @if ($notification->user)
                                <p class="mb-0 text-white">
                                    من: {{ $notification->user->name }}
                                </p>
                            @endif
                            <small class="notification-time">
                                {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                    <div class="notification-actions">
                        <button class="btn btn-sm btn-outline-danger"
                            onclick="deleteNotification({{ $notification->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                        @if (!$notification->is_read)
                            <button class="btn btn-sm btn-outline-success ms-2"
                                onclick="markAsRead({{ $notification->id }})">
                                <i class="fas fa-check"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-bell-slash fa-3x mb-3"></i>
                    <h4>لا توجد إشعارات جديدة</h4>
                    <p class="text-muted">سيظهر هنا أي إشعارات جديدة تتلقاها</p>
                </div>
            @endforelse
        </div>
    </div>

    @include('homeComponents.footer')

    <script>
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                    }
                });
        }

        function deleteNotification(notificationId) {
            if (confirm('هل أنت متأكد من حذف هذا الإشعار؟')) {
                fetch(`/notifications/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.reload();
                        }
                    });
            }
        }
    </script>
</body>

</html>

<?php
function getNotificationIcon($type)
{
    switch ($type) {
        case 'assignment':
            return 'fa-tasks';
        case 'message':
            return 'fa-envelope';
        case 'comment':
            return 'fa-comment';
        default:
            return 'fa-info-circle';
    }
}
?>
