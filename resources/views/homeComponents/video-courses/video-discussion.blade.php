<div class="discussion-section mt-4">
    <!-- نموذج إضافة تعليق جديد -->
    <div class="mb-4 p-3" style="background-color: #072D38; border-radius: 10px; display: flex; align-items: center;">
        @if (Auth::check())
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

            <!-- عرض صورة المستخدم -->
            {{-- <div style="margin-right: 15px;">
                <img src="{{ asset('storage/' . Auth::user()->image ?? 'default-avatar.png') }}" alt="User Image"
                    class="rounded-circle" style="width: 50px; height: 50px; border: 3px solid #ed6b2f;">
            </div> --}}
            <form method="POST" action="{{ route('add-comment') }}"
                style="flex-grow: 1; display: flex; align-items: center;">
                @csrf
                <input type="hidden" name="video_id" value="{{ $video->id }}">
                <textarea id="commentText" name="body" class="form-control" rows="1" placeholder="اكتب تعليقك هنا..."
                    style="flex-grow: 1; border-width: 0; padding: 10px; background-color: #072D38; color: #fff;"></textarea>
                <button type="submit" class="btn btn-primary"
                    style="background-color: #ed6b2f; border: none; border-radius: 20px; padding: 10px 20px;">إرسال</button>
            </form>
        @else
            <p class="text-white">يرجى تسجيل الدخول لكتابة تعليق.</p>
        @endif
    </div>



    <!-- عرض التعليقات -->
    <h5 class="mt-4 mb-3">التعليقات</h5>
    @foreach ($video->videoDiscussions as $comment)
        <div class="p-3 mb-3" style="background-color: #004051; border-radius: 10px;">
            <div class="d-flex align-items-center mb-2">
                @if ($comment->user->image == null)
                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                        style="width: 40px; height: 40px;">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                    </div>
                @else
                    <img src="{{ asset('storage/' . $comment->user->image) }}" alt="User Image" class="rounded-circle"
                        style="width: 40px; height: 40px;">
                @endif
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
    @endforeach

    {{-- <!-- زر عرض المزيد من التعليقات -->
    @if ($video->comments->count() > 3)
        <div class="text-center mt-3">
            <button class="btn btn-light">عرض المزيد من التعليقات</button>
        </div>
    @endif --}}
</div>
