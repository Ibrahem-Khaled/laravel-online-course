<style>
    .video-list {
        background-color: #035971;
        border-radius: 10px;
        padding: 15px;
        color: #fff;
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

    .video-icon {
        margin-left: 10px;
    }

    .video-status-icon {
        font-size: 1.5rem;
        margin-right: 10px;
    }

    .video-list-item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 5px;
        margin-left: 10px;
    }

    .progress-container {
        margin: 10px;
        color: #fff;
    }

    .progress {
        background-color: #ff9c00;
        height: 5px;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 10px;
    }

    .progress-bar {
        background-color: #072D38;
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

<div class="col-lg-4">
    <!-- قائمة الفيديوهات مع شريط التقدم المدمج -->
    <div class="video-list">
        <div class="progress-container">
            <h5>نسبة الإنجاز: {{ round($progress, 2) }}%</h5>
            <p>الفيديو {{ $currentVideoIndex }} من {{ $totalVideos }}</p>
            <div class="progress">
                <div class="progress-bar" style="width: {{ $progress }}%;"></div>
            </div>
        </div>

        @foreach ($course->videos as $index => $otherVideo)
            <a href="{{ route('courses.videos', ['course' => $course->id, 'video' => $otherVideo->id]) }}"
                class="video-list-item {{ $video->id === $otherVideo->id ? 'active' : '' }}">
                <div class="d-flex align-items-center">
                    @if ($index < $currentVideoIndex - 1)
                        <span class="video-status-icon">✔️</span> <!-- رمز للدرس السابق -->
                    @elseif ($index == $currentVideoIndex - 1)
                        <span class="video-status-icon">▶️</span> <!-- رمز للفيديو الحالي -->
                    @else
                        <span class="video-status-icon">🔒</span> <!-- رمز للدرس التالي -->
                    @endif
                    <span>{{ $index + 1 }}. {{ $otherVideo->title }}</span>
                </div>
                <p class="text-muted m-0">{{ Str::limit($otherVideo->description, 30) }}</p>
            </a>
        @endforeach
    </div>

    <!-- قسم المدرب -->
    <div class="trainer-section">
        <h5>المدربين</h5>
        <div class="trainer-info">
            <img src="{{ asset('storage/' . $course->user->image) }}" alt="Trainer Image">
            <div>
                <p class="m-0">{{ $course->user->name }}</p>
                <small>خبير ومدرب معتمد من أدوي</small>
            </div>
        </div>
        <div class="trainer-buttons">
            <a href="chat_link_here" class="trainer-button">دردشة</a>
            <a href="whatsapp_link_here" class="trainer-button">واتساب</a>
        </div>
    </div>

    <!-- قسم الملحقات / البرامج المستخدمة -->
    <div class="attachments-section">
        <h5>البرامج المستخدمة</h5>
        <div class="d-flex">
            <span class="badge bg-primary me-2">An</span>
            <span class="badge bg-danger">Xd</span>
        </div>
    </div>
</div>
