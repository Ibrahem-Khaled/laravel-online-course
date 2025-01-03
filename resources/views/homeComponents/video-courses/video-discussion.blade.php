<div class="discussion-section mt-4">
    <!-- نموذج إضافة تعليق جديد -->
    <div class="mb-4 p-3" style="background-color: #072D38; border-radius: 10px; display: flex; align-items: center;">
        @if (Auth::check())
            <div id="comment-errors" class="alert alert-danger d-none"></div>

            <form id="comment-form" method="POST" action="{{ route('add-comment') }}"
                style="flex-grow: 1; display: flex; align-items: center;">
                @csrf
                <input type="hidden" name="video_id" value="{{ $video->id }}">
                <textarea id="commentText" name="body" class="form-control" rows="1" placeholder="اكتب الاستفسار هنا..."></textarea>
                <button type="button" id="submit-comment" class="btn btn-primary"
                    style="background-color: #ed6b2f; border: none; padding: 10px 20px;">إرسال</button>
            </form>
        @else
            <p class="text-white">يرجى تسجيل الدخول لكتابة الاستفسار.</p>
        @endif
    </div>
    <!-- عرض التعليقات -->
    <h5 class="mt-4 mb-3">الاستفسارات</h5>
    @foreach ($video->videoDiscussions as $comment)
        @if (Auth::check() && (Auth::user()->role != 'student' || Auth::id() == $homework->user_id))
            <div class="p-3 mb-3" style="background-color: #004051; border-radius: 10px;">
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ $comment->user->image
                        ? asset('storage/' . $comment->user->image)
                        : ($comment->user?->userInfo?->gender == 'female'
                            ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png'
                            : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png') }}"
                        alt="User Image" class="rounded-circle" style="width: 40px; height: 40px;">

                    <div class="ms-3" style="margin-right: 10px;">
                        <p class="m-0">{{ $comment->user->name }}</p>
                        <small class="text-white">{{ $comment->created_at->locale('ar')->diffForHumans() }}</small>
                    </div>
                </div>
                <div class="p-2 rounded text-white" style="background-color: #035971;">
                    <p class="mb-1">{{ $comment->body }}</p>
                    {{-- <div class="d-flex justify-content-start mt-2">
                    <button class="btn btn-sm btn-light me-2">👍 {{ 0 }}</button>
                    <button class="btn btn-sm btn-light">💬 {{ 0 }}</button>
                </div> --}}
                </div>
            </div>
        @endif
    @endforeach

    {{-- <!-- زر عرض المزيد من التعليقات -->
    @if ($video->comments->count() > 3)
        <div class="text-center mt-3">
            <button class="btn btn-light">عرض المزيد من التعليقات</button>
        </div>
    @endif --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('submit-comment').addEventListener('click', function() {
                const form = document.getElementById('comment-form');
                const formData = new FormData(form);
                const commentText = document.getElementById('commentText');
                const commentErrors = document.getElementById('comment-errors');

                // إرسال البيانات عبر AJAX
                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // مسح حقل النص وإخفاء الأخطاء
                            commentText.value = '';
                            commentErrors.classList.add('d-none');

                            // إضافة التعليق الجديد إلى قائمة التعليقات
                            const commentsContainer = document.querySelector('.discussion-section');
                            const newComment = `
                        <div class="p-3 mb-3" style="background-color: #004051; border-radius: 10px;">
                            <div class="d-flex align-items-center mb-2">
                                <img src="${data.comment.user_image}" alt="User Image" class="rounded-circle"
                                    style="width: 40px; height: 40px;">
                                <div class="ms-3" style="margin-right: 10px;">
                                    <p class="m-0">${data.comment.user_name}</p>
                                    <small class="text-white">${data.comment.created_at}</small>
                                </div>
                            </div>
                            <div class="p-2 rounded text-white" style="background-color: #035971;">
                                <p class="mb-1">${data.comment.body}</p>
                            </div>
                        </div>`;
                            commentsContainer.insertAdjacentHTML('beforeend', newComment);
                        } else {
                            // عرض الأخطاء
                            commentErrors.innerHTML = data.errors.map(error => `<p>${error}</p>`).join(
                                '');
                            commentErrors.classList.remove('d-none');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</div>
