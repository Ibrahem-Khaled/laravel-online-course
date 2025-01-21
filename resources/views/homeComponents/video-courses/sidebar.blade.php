<style>
    .video-list {
        background-color: #035971;
        border-radius: 10px;
        padding: 15px;
        color: #fff;
        height: 60%;
        overflow: auto;
        scrollbar-width: thin;
        scrollbar-color: #035971 #01222d;
    }

    a {
        text-decoration: none;
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
        background-color: #024e66;
        color: #fff;
    }

    .video-list-item:hover {
        background-color: #024e66;
        color: #fff;
    }

    .video-status-icon {
        font-size: 1.2rem;
        margin: 0 10px 0 10px;
    }

    .video-duration {
        font-size: 0.5rem;
        color: #fff;
        align-items: center;
        display: flex;
        gap: 5px;
        width: 100px;
    }

    .video-duration i {
        font-size: 0.5rem;
        color: #fff;
    }

    .part-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #024e66;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
        color: #fff;
    }

    .part-header:hover {
        background-color: #007b8f;
    }

    .part-header .icon {
        font-size: 1rem;
    }

    .video-group {
        margin-left: 20px;
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
        background-color: #28a745;
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

    .attachments-section .list-group-item {
        background-color: #024e66;
        color: #fff;
        border: none;
        margin-bottom: 5px;
        border-radius: 5px;
        padding: 10px;
    }
</style>

<div class="col-lg-4" style="margin-top: 1.5%">
    <!-- قائمة الفيديوهات مع شريط التقدم المدمج -->
    <div class="progress-container">
        <h5>نسبة الإنجاز: {{ round($progress, 2) }}%</h5>
        <div class="progress">
            <div class="progress-bar" style="width: {{ $progress }}%;"></div>
        </div>
    </div>

    <div class="video-list" style="max-height: 470px; overflow-y: auto;">
        @if ($course->parts->count() > 0)
            <!-- إذا كانت الدورة تحتوي على أجزاء -->
            @foreach ($course->parts as $part)
                <div class="part-header" data-toggle="collapse" data-target="#part-{{ $part->id }}">
                    <span>{{ $part->name }}</span>
                    <span class="icon">
                        <i class="fas {{ $loop->first ? 'fa-minus' : 'fa-plus' }}"></i>
                    </span>
                </div>
                <div id="part-{{ $part->id }}" class="collapse video-group {{ $loop->first ? 'show' : '' }}">
                    @foreach ($part->videos->sortBy('ranking') as $otherVideo)
                        @php
                            $history = $videoHistories->get($otherVideo->id);
                            $isCompleted = $history && $history->pivot->completed;
                            $isViewed = $history && !$history->pivot->completed;
                        @endphp
                        <a href="{{ route('courses.videos', ['course' => $course->id, 'video' => $otherVideo->id]) }}"
                            class="video-list-item {{ $video->id === $otherVideo->id ? 'active' : '' }}">
                            <div class="d-flex align-items-center">
                                <!-- التحقق من حالة الفيديو -->
                                @if ($otherVideo->id === $video->id)
                                    <span class="video-status-icon">
                                        <i class="fas fa-play-circle" style="color: #fff;"></i>
                                    </span>
                                @elseif ($isCompleted)
                                    <span class="video-status-icon">
                                        <i class="fas fa-check-circle" style="color: #28a745;"></i>
                                    </span>
                                @elseif ($isViewed)
                                    <span class="video-status-icon">
                                        <i class="fas fa-clock" style="color: #fff;"></i>
                                    </span>
                                @else
                                    <span class="video-status-icon">
                                        <i class="fas fa-lock" style="color: #fff;"></i>
                                    </span>
                                @endif
                                <span>{{ $loop->index + 1 }}. {{ $otherVideo->title }}</span>
                                <span class="video-duration">
                                    (<i class="fas fa-clock"></i>
                                    {{ $otherVideo->duration }} دقيقة)
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        @else
            <!-- إذا لم تكن الدورة تحتوي على أجزاء -->
            @foreach ($course->videos->sortBy('ranking') as $otherVideo)
                @php
                    $history = $videoHistories->get($otherVideo->id);
                    $isCompleted = $history && $history->pivot->completed;
                    $isViewed = $history && !$history->pivot->completed;
                @endphp
                <a href="{{ route('courses.videos', ['course' => $course->id, 'video' => $otherVideo->id]) }}"
                    class="video-list-item {{ $otherVideo->id === $video->id ? 'active' : '' }}">
                    <div class="d-flex align-items-center">
                        <!-- التحقق من حالة الفيديو -->
                        @if ($otherVideo->id === $video->id)
                            <span class="video-status-icon">
                                <i class="fas fa-play-circle" style="color: #fff;"></i>
                            </span>
                        @elseif ($isCompleted)
                            <span class="video-status-icon">
                                <i class="fas fa-check-circle" style="color: #28a745;"></i>
                            </span>
                        @elseif ($isViewed)
                            <span class="video-status-icon">
                                <i class="fas fa-clock" style="color: #fff;"></i>
                            </span>
                        @else
                            <span class="video-status-icon">
                                <i class="fas fa-lock" style="color: #fff;"></i>
                            </span>
                        @endif
                        <span>{{ $loop->index + 1 }}. {{ $otherVideo->title }}</span>
                        <span class="video-duration">
                            (<i class="fas fa-clock"></i>
                            {{ $otherVideo->duration }} دقيقة)
                        </span>
                    </div>
                </a>
            @endforeach
        @endif
    </div>



    <!-- قسم المدرب -->
    <div class="trainer-section text-white p-3 rounded mt-3">
        <h5 class="mb-3">المدربين</h5>
        <div class="d-flex align-items-start mb-3 justify-content-around">
            <img src="{{ $course->user->image
                ? asset('storage/' . $course->user->image)
                : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png' }}"
                alt="Trainer Image" class="rounded-circle me-3" style="width: 60px; height: 60px;">
            <div class="ms-3">
                <p class="m-0 fw-bold">{{ $course->user->name }}</p>
                <small>{{ $course->user()?->userInfo?->bio ?? 'لا توجد معلومات متاحة' }}</small>
            </div>
            <div class="d-flex gap-2 ">
                <a href="chat_link_here" class="d-flex justify-content-center align-items-center text-white"
                    style="width: 40px; height: 40px; font-size: 25px;">
                    <i class="fas fa-comment"></i>
                </a>
                <a href="https://wa.me/{{ $course->user->phone }}" target="_blank"
                    class="d-flex justify-content-center align-items-center text-white" text-white
                    style="width: 40px; height: 40px; font-size: 25px;">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
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

    <script>
        document.querySelectorAll('.part-header').forEach(header => {
            header.addEventListener('click', function() {
                const icon = this.querySelector('.icon i');
                icon.classList.toggle('fa-plus');
                icon.classList.toggle('fa-minus');
            });
        });
    </script>
</div>
