<style>
    .video-list {
        background-color: #035971;
        border-radius: 10px;
        padding: 15px;
        color: #fff;
        max-height: 60%;
        overflow: auto;
        scrollbar-width: thin;
        /* لتحديد عرض شريط التمرير في فايرفوكس */
        scrollbar-color: #035971 #01222d;
        /* لتحديد ألوان شريط التمرير في فايرفوكس */
    }

    /* تخصيص شريط التمرير في المتصفحات التي تدعم webkit */
    .video-list::-webkit-scrollbar {
        width: 8px;
        /* عرض شريط التمرير */
    }

    .video-list::-webkit-scrollbar-track {
        background: #01222d;
        /* لون المسار */
        border-radius: 10px;
        /* جعل الحواف دائرية */
    }

    .video-list::-webkit-scrollbar-thumb {
        background-color: #2e8b57;
        /* لون مقبض التمرير */
        border-radius: 10px;
        /* جعل الحواف دائرية */
        border: 2px solid #01222d;
        /* إضافة حد للمقبض */
    }

    .video-list::-webkit-scrollbar-thumb:hover {
        background-color: #45a76b;
        /* لون المقبض عند التمرير */
    }

    .video-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 10px;
        transition: background-color 0.3s;
        cursor: pointer;
        background-color: #007b8f;
        color: #fff;
        text-decoration: none;
    }

    .video-list-item.active {
        background-color: #ff9c00;
        color: #fff;
    }

    .video-list-item:hover {
        background-color: #ff9c00;
        color: #fff;
    }

    .video-status-icon {
        font-size: 1.5rem;
        margin: 0 10px 0 10px;
    }

    .video-list-item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 5px;
        margin-left: 10px;
    }

    .progress-container {
        margin: 16.5px 0;
        color: #fff;
        background-color: #035971;
        padding: 10px;
        border-radius: 10px;
    }

    .progress {
        background-color: #072D38;
        height: 5px;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 10px;
    }

    .progress-bar {
        background-color: #ff9c00;
        height: 100%;
    }

    .trainer-section,
    .attachments-section {
        background-color: #035971;
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
        color: #fff;
    }

    .trainer-info {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .trainer-info img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-right: 15px;
        border: 2px solid #ff9c00;
    }

    .trainer-buttons {
        margin: 20px 10px;
    }

    .trainer-button {
        background-color: #007b8f;
        color: #fff;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        margin-right: 5px;
        transition: background-color 0.3s;
    }

    .trainer-button:hover {
        background-color: #ff9c00;
        color: #fff;
    }

    .attachments-section .list-group-item {
        background-color: #024e66;
        color: #fff;
        border: none;
        margin-bottom: 5px;
        border-radius: 5px;
        padding: 10px;
    }
</style>

<div class="col-lg-4" style="margin-top: 5%">
    <!-- قائمة الفيديوهات مع شريط التقدم المدمج -->
    <div class="progress-container">
        <h5>نسبة الإنجاز: {{ round($progress, 2) }}%</h5>
        <div class="progress">
            <div class="progress-bar" style="width: {{ $progress }}%;"></div>
        </div>
    </div>
    <div class="video-list" style="max-height: 470px; overflow-y: auto;">
        @foreach ($course->videos as $index => $otherVideo)
            @php
                $history = $videoHistories->get($otherVideo->id);
                $isCompleted = $history && $history->pivot->completed;
                $isViewed = $history && !$history->pivot->completed;
            @endphp

            <a href="{{ route('courses.videos', ['course' => $course->id, 'video' => $otherVideo->id]) }}"
                class="video-list-item {{ $video->id === $otherVideo->id ? 'active' : '' }}">
                <div class="d-flex align-items-center">
                    <!-- التحقق من حالة الفيديو -->
                    @if ($video->id === $otherVideo->id)
                        <!-- أيقونة للفيديو الذي يتم تشغيله حالياً -->
                        <span class="video-status-icon">
                            <i class="fas fa-play-circle" style="color: #007bff;"></i>
                        </span>
                    @elseif ($isCompleted)
                        <!-- أيقونة للفيديو المكتمل -->
                        <span class="video-status-icon">
                            <i class="fas fa-check-circle" style="color: #28a745;"></i>
                        </span>
                    @elseif ($isViewed)
                        <!-- أيقونة للفيديو المشاهد -->
                        <span class="video-status-icon">
                            <i class="fas fa-clock" style="color: #ffc107;"></i>
                        </span>
                    @else
                        <!-- أيقونة للفيديو غير المشاهد -->
                        <span class="video-status-icon">
                            <i class="fas fa-lock" style="color: #dc3545;"></i>
                        </span>
                    @endif
                    <span>{{ $index + 1 }}. {{ $otherVideo->title }}</span>
                </div>
            </a>
        @endforeach
    </div>

    <!-- قسم المدرب -->
    <div class="trainer-section">
        <h5>المدربين</h5>
        <div class="trainer-info">
            <img src="{{ $course->user->image ? asset('storage/' . $course->user->image) : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png' }}"
                alt="Trainer Image">
            <div>
                <p class="m-0">{{ $course->user->name }}</p>
                <small>خبير ومدرب معتمد من أدوي</small>
            </div>
        </div>
        <div class="trainer-buttons">
            <a href="chat_link_here" class="trainer-button">دردشة</a>
            <a href="https://wa.me/{{ $course->user->phone }}" target="_blank" class="trainer-button">واتساب</a>
        </div>
    </div>

    <!-- قسم الملحقات / البرامج المستخدمة -->
    <div class="attachments-section" style="margin: 20px 0;">
        @if ($video->videoUsage->where('type', 'software')->count() > 0)
            <h5 class="text-white" style=" font-weight: bold; margin-bottom: 15px;">البرامج المستخدمة</h5>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                @foreach ($video->videoUsage->where('type', 'software') as $item)
                    <div class="col">
                        <div class="card text-center"
                            style="border: none; background-color: transparent; box-shadow: none;">
                            <a href="{{ $item->url }}" target="_blank">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2F2.bp.blogspot.com%2F-dJ9XpH5XOm8%2FU8ZFngrXs2I%2FAAAAAAAAAWw%2FHbIA6HLu7QQ%2Fs1600%2Fred%2Bcircle%2Bexited%2Bicon%2Bfree%2Bicon%2Bexit%2Bbutton.png&f=1&nofb=1&ipt=e2b3f2629cfc19afe7bb74591e0bde4a8bc36c2c81989bc737afcad55c850e46&ipo=images' }}"
                                    alt="{{ $item->title }}" class="card-img-top img-fluid"
                                    style="border-radius: 12px; max-height: 150px; object-fit: cover;">
                            </a>
                            <div class="card-body" style="padding: 10px 0;">
                                <h6 class="card-title text-white" style="font-weight: bold; font-size: 14px;">
                                    {{ $item->title }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h5 class="text-white text-center">لا يوجد برامج مستخدمة</h5>
        @endif
    </div>


</div>
