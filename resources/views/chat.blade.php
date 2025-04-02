<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دردشة الفصل الدراسي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    @include('homeComponents.header')

    <div class="container-fluid chat-container" dir="rtl">
        <div class="row h-100">
            <!-- سايدبار جهات الاتصال -->
            <div class="col-md-4 col-lg-3 contacts-sidebar">
                <div class="search-bar d-flex align-items-center">
                    <i class="fas fa-search text-muted me-2"></i>
                    <input type="text" class="search-input" placeholder="ابحث عن مدرس أو طالب..."
                        onkeyup="filterContacts(this)">
                </div>

                <div class="contact-list" id="contactList">
                    @forelse ($contacts as $contact)
                        <div class="contact-item" onclick="loadChat({{ $contact->id }}, this)">
                            <div class="d-flex align-items-center">
                                <div class="contact-avatar">
                                    <img src="{{ $contact->profile_image }}" alt="{{ $contact->name }}">
                                </div>
                                <div class="contact-info">
                                    <h6 class="mb-0 text-white">{{ $contact->name }}</h6>
                                    <small class="text-muted">{{ $contact->userInfo->bio ?? 'طالب' }}</small>
                                </div>
                                <div class="online-status {{ $contact->is_online ? 'online' : 'offline' }} ms-auto">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="no-contacts">
                            <i class="fas fa-comments no-contacts-icon"></i>
                            <p class="mb-4">لا توجد محادثات حالية</p>
                        </div>
                    @endforelse
                </div>

                <!-- زر بدء محادثة جديدة -->
                <div class="new-chat-btn-container">
                    <button class="btn new-chat-btn text-white" data-toggle="modal"
                        data-target="#selectTeacherModal">
                        <i class="fas fa-plus-circle"></i>
                        اختر مدرسًا للتحدث معه
                    </button>
                </div>
            </div>

            <!-- منطقة الدردشة الرئيسية -->
            <div class="col-md-8 col-lg-9 chat-area">
                <div class="chat-header">
                    <div class="d-flex align-items-center" id="currentChatHeader">
                        <div class="contact-avatar me-3">
                            <i class="fas fa-comments text-white"></i>
                        </div>
                        <div class="chat-header-info">
                            <h5 class="mb-0 text-white">مرحبًا بك في دردشة الفصل</h5>
                            <small class="text-muted">اختر محادثة لبدء الدردشة</small>
                        </div>
                        <div class="chat-header-actions">
                            <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-phone-alt"></i></button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-video"></i></button>
                            <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-info-circle"></i></button>
                        </div>
                    </div>
                </div>

                <div class="messages-container" id="messagesContainer">
                    <div class="welcome-message">
                        <div class="welcome-icon">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <h3 class="welcome-title">دردشة الفصل الدراسي</h3>
                        <p class="welcome-subtitle">تواصل مع معلميك وزملائك بسهولة وأمان</p>
                        <button class="btn new-chat-btn text-white" data-toggle="modal"
                            data-target="#selectTeacherModal">
                            <i class="fas fa-plus-circle"></i>
                            بدء محادثة جديدة
                        </button>
                    </div>
                </div>

                <div class="message-input-area" style="display: none;" id="messageInputArea">
                    <div class="input-group">
                        <input type="text" class="form-control message-input" id="messageInput"
                            placeholder="اكتب رسالتك هنا..." aria-label="Message input">
                        <button class="btn send-btn" type="button" onclick="sendMessage()">
                            <i class="fas fa-paper-plane text-white"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- مودال اختيار المدرس -->
    <div class="modal fade teacher-modal" id="selectTeacherModal" tabindex="-1"
        aria-labelledby="selectTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">اختر مدرسًا للدردشة</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($teachers as $teacher)
                            <div class="col-md-6 mb-3">
                                <div class="teacher-item hover-effect" onclick="startNewChat({{ $teacher->id }})">
                                    <div class="d-flex align-items-center">
                                        <div class="teacher-avatar me-3">
                                            <img src="{{ $teacher->profile_image }}" alt="{{ $teacher->name }}">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $teacher->name }}</h6>
                                            <small
                                                class="teacher-specialty">{{ $teacher->userInfo->bio ?? 'مدرس' }}</small>
                                            <div class="d-flex align-items-center mt-1">
                                                <span
                                                    class="badge bg-{{ $teacher->is_online ? 'success' : 'secondary' }} me-2">
                                                    {{ $teacher->is_online ? 'متصل الآن' : 'غير متصل' }}
                                                </span>
                                                <small class="text-white">{{ $teacher->email }}</small>
                                            </div>
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

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        let currentChatId = null;
        let currentActiveItem = null;

        function loadChat(contactId, element) {
            // إزالة التنشيط من العنصر السابق
            if (currentActiveItem) {
                currentActiveItem.classList.remove('active');
            }

            // تنشيط العنصر الجديد
            currentActiveItem = element;
            element.classList.add('active');

            currentChatId = contactId;
            document.getElementById('messageInputArea').style.display = 'block';

            // تحديث رأس المحادثة
            const contactName = element.querySelector('.contact-info h6').textContent;
            const contactAvatar = element.querySelector('.contact-avatar img').src;
            updateChatHeader(contactName, contactAvatar);

            fetch(`/messages/${contactId}`)
                .then(response => response.json())
                .then(messages => {
                    const container = document.getElementById('messagesContainer');
                    container.innerHTML = '';

                    if (messages.length === 0) {
                        container.innerHTML = `
                            <div class="system-message">
                                <p>هذه بداية المحادثة مع ${contactName}</p>
                            </div>
                        `;
                    } else {
                        messages.forEach(msg => {
                            const messageDiv = document.createElement('div');
                            messageDiv.className =
                                `message ${msg.sender_id == {{ auth()->id() }} ? 'outgoing' : 'incoming'}`;
                            messageDiv.innerHTML = `
                                <p class="mb-0 text-white">${msg.message}</p>
                                <span class="message-time">
                                    <i class="far fa-clock"></i> ${new Date(msg.created_at).toLocaleTimeString('ar-EG', {hour: '2-digit', minute:'2-digit'})}
                                </span>
                            `;
                            container.appendChild(messageDiv);
                        });
                    }

                    container.scrollTop = container.scrollHeight;
                });
        }

        function updateChatHeader(name, avatar) {
            const header = document.getElementById('currentChatHeader');
            header.innerHTML = `
                <div class="contact-avatar me-3">
                    <img src="${avatar}" alt="${name}" width="40" height="40">
                </div>
                <div class="chat-header-info">
                    <h5 class="mb-0 text-white">${name}</h5>
                    <small class="text-muted">يكتب الآن...</small>
                </div>
             
            `;
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
                            loadChat(currentChatId, currentActiveItem);
                        }
                    });
            }
        }

        // إمكانية إرسال الرسالة بالضغط على Enter
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // فلترة جهات الاتصال
        function filterContacts(input) {
            const filter = input.value.toUpperCase();
            const contacts = document.querySelectorAll('.contact-item');

            contacts.forEach(contact => {
                const name = contact.querySelector('.contact-info h6').textContent.toUpperCase();
                if (name.includes(filter)) {
                    contact.style.display = '';
                } else {
                    contact.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>
