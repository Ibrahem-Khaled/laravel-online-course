<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دردشة الفصل الدراسي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2A3F54;
            --secondary-color: #ED6B2F;
            --accent-color: #ED6B2F;
            --background-dark: #072D38;
            --background-light: #F5F7FA;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--background-dark);
            height: 100vh;
            margin-top: 5px;
        }

        .chat-container {
            height: calc(100vh - 80px);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        /* سايدبار الاتصالات */
        .contacts-sidebar {
            background: var(--primary-color);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px;
            height: 100%;
        }

        .search-bar {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 8px 15px;
            margin-bottom: 20px;
        }

        .search-input {
            background: transparent;
            border: none;
            color: white;
            width: 100%;
        }

        .contact-list {
            height: calc(100% - 60px);
            overflow-y: auto;
        }

        .contact-item {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
        }

        .contact-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(-5px);
        }

        .contact-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
        }

        /* منطقة الدردشة الرئيسية */
        .chat-area {
            background: var(--background-dark);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: var(--primary-color);
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: linear-gradient(to bottom right, #072D38, #02475E);
        }

        .message-input-area {
            background: var(--primary-color);
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* تصميم الرسائل */
        .message {
            max-width: 70%;
            margin-bottom: 15px;
            padding: 12px 18px;
            border-radius: 15px;
            position: relative;
            animation: slideIn 0.3s ease;
        }

        .incoming {
            background: var(--primary-color);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-right: auto;
        }

        .outgoing {
            background: var(--secondary-color);
            margin-left: auto;
        }

        .message-time {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 5px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* مؤشرات الحالة */
        .online-status {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            position: absolute;
            bottom: 0;
            right: 0;
            border: 2px solid white;
        }

        .online {
            background: #1ABB9C;
        }

        .offline {
            background: #ED6B2F;
        }

        .no-contacts {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }

        .start-chat-btn {
            background: var(--secondary-color);
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .start-chat-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(26, 187, 156, 0.3);
        }

        .teacher-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <div class="container-fluid chat-container" dir="rtl">
        <div class="row h-100">
            <!-- سايدبار جهات الاتصال -->
            <div class="col-md-4 col-lg-3 contacts-sidebar">
                <div class="search-bar d-flex align-items-center justify-content-between">
                    <input type="text" class="search-input" placeholder="ابحث عن جهة اتصال..."
                        onkeyup="filterContacts(this)">
                    <i class="fas fa-search text-muted"></i>
                </div>

                <div class="contact-list" id="contactList">
                    @forelse ($contacts as $contact)
                        <div class="contact-item" onclick="loadChat({{ $contact->id }})">
                            <div class="d-flex align-items-center">
                                <div class="contact-avatar">
                                    <img src="{{ $contact->profile_image }}" alt="{{ $contact->name }}" width="40" height="40">
                                </div>
                                <div class="contact-info">
                                    <h6 class="mb-0 text-white">{{ $contact->name }}</h6>
                                    <small class="text-muted">{{ $contact->email }}</small>
                                </div>
                                <div class="online-status {{ $contact->is_online ? 'online' : 'offline' }} ms-auto">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="no-contacts">
                            <p class="text-muted mb-4">لا يوجد لديك أي محادثات حالية</p>
                            <button class="start-chat-btn text-white" data-bs-toggle="modal"
                                data-bs-target="#selectTeacherModal">
                                بدء محادثة جديدة
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- منطقة الدردشة الرئيسية -->
            <div class="col-md-8 col-lg-9 chat-area">
                <div class="chat-header">
                    <div class="d-flex align-items-center" id="currentChatHeader">
                        <div class="contact-avatar me-3">
                            <i class="fas fa-comments text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">مرحبا بك في الدردشة</h5>
                            <small class="text-muted">اختر محادثة لبدء الدردشة</small>
                        </div>
                    </div>
                </div>

                <div class="messages-container" id="messagesContainer">
                    <div class="no-chat-selected text-center mt-5">
                        <i class="fas fa-comment-slash fa-3x text-muted"></i>
                        <p class="mt-3">الرجاء اختيار محادثة لعرض الرسائل</p>
                    </div>
                </div>

                <div class="message-input-area" style="display: none;" id="messageInputArea">
                    <div class="input-group">
                        <input type="text" class="form-control" id="messageInput" placeholder="اكتب رسالتك هنا..."
                            aria-label="Message input">
                        <button class="btn btn-primary" type="button" onclick="sendMessage()">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- مودال اختيار المدرس -->
    <div class="modal fade" id="selectTeacherModal" tabindex="-1" aria-labelledby="selectTeacherModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">اختر مدرسًا للدردشة</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($teachers as $teacher)
                            <div class="col-md-6 mb-3">
                                <div class="teacher-item p-3 rounded hover-effect"
                                    onclick="startNewChat({{ $teacher->id }})">
                                    <div class="d-flex align-items-center">
                                        <div class="contact-avatar me-3">
                                            <img src="{{ $teacher->profile_image }}" class="img-fluid rounded-circle"
                                                alt="{{ $teacher->name }}">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $teacher->name }}</h6>
                                            <small
                                                class="text-white">{{ $teacher->userInfo->bio ?? 'لا يوجد بيو في الملف الشخصي للمعلم' }}
                                                -
                                                {{ $teacher->email }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('homeComponents.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentChatId = null;

        function loadChat(contactId) {
            currentChatId = contactId;
            document.getElementById('messageInputArea').style.display = 'block';
            fetch(`/messages/${contactId}`)
                .then(response => response.json())
                .then(messages => {
                    const container = document.getElementById('messagesContainer');
                    container.innerHTML = messages.map(msg => `
                        <div class="message ${msg.sender_id == {{ auth()->id() }} ? 'outgoing' : 'incoming'}">
                            <p class="mb-0 text-white">${msg.message}</p>
                            <div class="message-time">${new Date(msg.created_at).toLocaleTimeString('ar-EG')}</div>
                        </div>
                    `).join('');
                    container.scrollTop = container.scrollHeight;
                });
        }

        function startNewChat(teacherId) {
            fetch(`/messages/start-chat`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        teacher_id: teacherId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                });
        }

        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (message && currentChatId) {
                fetch('/messages', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            receiver_id: currentChatId,
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            messageInput.value = '';
                            loadChat(currentChatId);
                        }
                    });
            }
        }
    </script>
</body>

</html>
