<div class="homework-section mt-4">
    <!-- نموذج رفع الواجب -->
    @if (Auth::check())

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
                <button type="submit" class="btn btn-primary">إرسال</button>
            </form>
        </div>
    @endif

    <!-- عرض واجبات الطلاب -->
    <h5 class="mt-4 mb-3">واجبات الطلاب ({{ $video->homeWorks->count() }})</h5>
    @foreach ($video->homeWorks as $homework)
        <div class="p-3 mb-3" style="background-color: #004051; border-radius: 10px;">
            <div class="d-flex align-items-center mb-2">

                <img src="{{ $homework->user->image
                    ? asset('storage/' . $homework->user->image)
                    : ($homework->user?->userInfo?->gender == 'female'
                        ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png'
                        : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png') }}"

                    alt="User Image" class="rounded-circle" style="width: 40px; height: 40px;">

                <div class="ms-3" style="margin-right: 10px;">
                    <p class="m-0">{{ $homework->user->name }}</p>
                    <small class="text-white">{{ $homework->created_at->locale('ar')->diffForHumans() }}</small>
                </div>
            </div>
            <div class="p-2 rounded text-white" style="background-color: #035971;">
                <p class="mb-1">{{ $homework->text ?? 'لا يوجد نص مكتوب' }}</p>
                @if ($homework->file)
                    <a href="{{ asset('uploads/' . $homework->file) }}" target="_blank" class="btn btn-sm btn-light">
                        <i class="bi bi-file-earmark"></i> عرض الملف
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>
