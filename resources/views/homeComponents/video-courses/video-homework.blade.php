<div class="homework-section mt-4">
    <!-- نموذج رفع الواجب -->
    @if (Auth::check())
        <div class="mb-4 p-4 shadow-sm" style="background-color: #004051; border-radius: 10px;">
            <h5 class="mb-3 text-white">سؤال الواجب</h5>

            @if ($video->question)
                <div class="alert alert-info" style="font-size: 0.95rem;">
                    {{ $video->question }}
                </div>
            @else
                <div class="alert alert-info" style="font-size: 0.95rem;">
                    لم يتم تحديد سؤال لهذا الواجب بعد. يرجى مراجعة المدرس لاحقاً.
                </div>
            @endif

            <!-- عرض إمكانية التعديل فقط للأستاذ أو المشرف أو الأدمن -->
            @if (
                (Auth::check() && Auth::user()->role == 'teacher') ||
                    Auth::user()->role == 'supervisor' ||
                    Auth::user()->role == 'admin')
                <button type="button" class="btn btn-sm mt-3" style="background-color: #ed6b2f; color: #fff;"
                    data-toggle="modal" data-target="#editQuestionModal">
                    @if ($video->question)
                        تعديل السؤال الواجب
                    @else
                        اضافة سؤال الواجب
                    @endif
                </button>

                <!-- Modal لتعديل سؤال الواجب -->
                <div class="modal fade" id="editQuestionModal" tabindex="-1" aria-labelledby="editQuestionModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #02475E; color: #fff;">
                                <h5 class="modal-title" id="editQuestionModalLabel">تعديل سؤال الواجب</h5>
                                <button type="button" class="btn-close" data-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="background-color: #02475E; color: #fff;">
                                <form action="{{ route('updateQuestion', $video->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="question" class="form-label">السؤال الجديد</label>
                                        <textarea class="form-control" id="question" name="question" rows="4" required>{{ $video->question }}</textarea>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary w-100"
                                            style="background-color: #ed6b2f; border: none;">تحديث السؤال</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="mb-4 p-3" style="background-color: #035971; border-radius: 10px;">
            <h5 class="mb-3">رفع الواجب</h5>
            <!-- عرض الأخطاء العامة -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('add-homework') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="homeworkText" class="form-label">كتابة الواجب (اختياري):</label>
                    <textarea id="homeworkText" name="text" class="form-control" rows="3" placeholder="اكتب الواجب هنا..."></textarea>
                </div>
                <div class="mb-3">
                    <label for="homeworkFile" class="form-label">إرفاق ملف (اختياري):</label>
                    <input type="file" id="homeworkFile" name="file" class="form-control">
                </div>
                <input type="hidden" name="course_videos_id" value="{{ $video->id }}">
                <button type="submit" class="btn btn-primary w-100"
                    style="background-color: #ed6b2f; border: none; padding: 10px 20px;">إرسال</button>
            </form>
        </div>
    @endif
 
    <!-- عرض واجبات الطلاب -->
    <h5 class="mt-4 mb-3">واجبات الطلاب ({{ $video->homeWorks->count() }})</h5>
    @foreach ($video->homeWorks as $homework)
        <div class="p-3 mb-3" style="background-color: #004051; border-radius: 10px;">
            @if (Auth::check() && (Auth::user()->role != 'student' || Auth::id() == $homework->user_id))
                <!-- معلومات الطالب -->
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ $homework->user->image
                        ? asset('storage/' . $homework->user->image)
                        : ($homework->user?->userInfo?->gender == 'female'
                            ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png'
                            : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png') }}"
                        alt="User Image" class="rounded-circle" style="width: 40px; height: 40px;">
                    <div class="ms-3" style="margin-right: 10px;">
                        <p class="m-0 text-white">{{ $homework->user->name }}</p>
                        <small class="text-white">{{ $homework->created_at->locale('ar')->diffForHumans() }}</small>
                    </div>
                </div>

                <!-- محتوى الواجب -->
                <div class="p-2 rounded text-white" style="background-color: #035971;">
                    <p class="mb-1">{{ $homework->text ?? 'لا يوجد نص مكتوب' }}</p>
                    @if ($homework->file)
                        <a href="{{ asset('uploads/' . $homework->file) }}" target="_blank"
                            class="btn btn-sm btn-light">
                            <i class="bi bi-file-earmark"></i> عرض الملف
                        </a>
                    @endif
                </div>
            @endif


            <!-- رد الأستاذ أو تقييمه -->
            @if ($homework->reply || $homework->rating)
                <div class="mt-3 p-2 rounded" style="background-color: #022c34; border: 1px solid #035971;">
                    <h6 class="text-warning mb-2">رد الأستاذ:</h6>
                    <p class="text-white mb-1">
                        {{ $homework->reply ?? 'لم يتم إضافة رد بعد.' }}
                    </p>
                    @if ($homework->rating)
                        <p class="text-info mb-0">
                            <i class="bi bi-star-fill text-warning"></i>
                            تقييم: {{ $homework->rating }}/5
                        </p>
                    @endif
                </div>
            @endif

            <!-- نموذج تقييم ورد الأستاذ -->
            @if (
                (Auth::check() && Auth::user()->role == 'teacher') ||
                    Auth::user()->role == 'supervisor' ||
                    Auth::user()->role == 'admin')
                <form action="{{ route('homework.reply', $homework->id) }}" method="POST"
                    class="homework-reply-form mt-3" data-id="{{ $homework->id }}">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="reply_{{ $homework->id }}" class="text-white">رد الأستاذ:</label>
                        <textarea name="reply" id="reply_{{ $homework->id }}" class="form-control" rows="2" style="resize: none;"></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="rating_{{ $homework->id }}" class="text-white">تقييم:</label>
                        <select name="rating" id="rating_{{ $homework->id }}" class="form-control">
                            <option value="" disabled selected>اختر التقييم</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}/5</option>
                            @endfor
                        </select>
                    </div>
                    <button type="button" class="btn btn-sm w-100 btn-success submit-reply"
                        data-id="{{ $homework->id }}">إرسال</button>
                    <span class="text-info d-none" id="success-message-{{ $homework->id }}">تم إرسال التقييم
                        بنجاح</span>
                </form>
            @endif
        </div>
    @endforeach
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.submit-reply').forEach(button => {
                button.addEventListener('click', function() {
                    const homeworkId = this.getAttribute('data-id');
                    const form = document.querySelector(
                        `.homework-reply-form[data-id="${homeworkId}"]`);
                    const reply = form.querySelector(`#reply_${homeworkId}`).value;
                    const rating = form.querySelector(`#rating_${homeworkId}`).value;

                    // إعداد طلب AJAX
                    fetch(`{{ url('homework/reply') }}/${homeworkId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                reply: reply,
                                rating: rating
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // عرض رسالة النجاح
                                document.getElementById(`success-message-${homeworkId}`)
                                    .classList.remove('d-none');
                            } else {
                                alert('حدث خطأ أثناء إرسال التقييم.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
</div>
