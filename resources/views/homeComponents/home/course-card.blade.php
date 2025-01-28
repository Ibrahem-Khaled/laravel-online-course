<style>
    .course-card {
        width: 100%;
        max-width: 286px;
        height: 380px;
        background-color: #035971;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
        text-align: right;
        margin: 10px;
    }

    .course-card:hover {
        transform: translateY(-5px);
    }

    .course-card .card-img-top {
        height: 150px;
        object-fit: cover;
        width: 100%;
    }

    .course-card .card-body {
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .course-card-title {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .course-card span {
        font-size: 0.65rem;
    }

    .favorite-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.8);
        border: none;
        color: red;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .favorite-btn:hover {
        background: rgba(255, 255, 255, 1);
    }

    .course-details {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .course-details .detail {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        flex: 1 1 calc(50% - 10px);
        /* يجعل كل عنصرين في صف واحد */
    }

    .course-details .detail i {
        color: #ed6b2f;
    }

    .trainer-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
    }

    .trainer-info img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-left: 5px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .course-card {
            width: 100%;
            max-width: 100%;
            margin: 15px 0;
        }

        .course-details .detail {
            flex: 1 1 100%;
            /* يجعل كل عنصر في سطر منفصل على الشاشات الصغيرة */
        }
    }
</style>

<div class="col-lg-3 col-md-4 col-sm-6">
    <a href="{{ route('courses.videos', $course->id) }}" class="text-decoration-none">
        <div class="course-card">
            <!-- زر الإعجاب -->
            <button class="favorite-btn">
                <i class="fas {{ $course?->is_favorite ? 'fa-heart' : 'fa-heart' }}"></i>
            </button>

            <!-- صورة الكورس -->
            <img class="card-img-top"
                src="{{ $course->image ? asset('storage/' . $course->image) : asset('assets/img/logo-ct.png') }}"
                alt="Course Image">

            <!-- محتوى الكارد -->
            <div class="card-body">
                <!-- عنوان الكورس -->
                <h5 class="course-card-title">{{ $course->title }}</h5>

                <!-- وصف الكورس -->
                <p class="" style="font-size: 0.8rem; color: aliceblue;">
                    {{ Str::limit($course->description, 200) }}
                </p>

                <!-- تفاصيل الكورس -->
                <div class="course-details">
                    <div class="detail">
                        <i class="fas fa-clock"></i>
                        <span>{{ $course->duration_in_hours ?? 'غير محدد' }} ساعة</span>
                    </div>
                    <!-- الفئة المستهدفة -->
                    <div class="detail">
                        <i class="fas fa-users"></i>
                        <span>{{ $course->target_audience ?? 'غير محدد' }}</span>
                    </div>

                    <!-- عدد الدروس -->
                    <div class="detail">
                        <i class="fas fa-book"></i>
                        <span>{{ $course->videos->count() ?? 'غير محدد' }}</span>
                    </div>

                    <!-- المستوى -->
                    <div class="detail">
                        <i class="fas fa-signal"></i>
                        <span>
                            @if ($course->difficulty_level == 'beginner')
                                للمبتدئين
                            @elseif ($course->difficulty_level == 'intermediate')
                                للمتوسطين
                            @elseif ($course->difficulty_level == 'advanced')
                                للمتقدمين
                            @endif
                        </span>
                    </div>
                </div>

                <!-- معلومات المدرب -->
                {{-- <div class="trainer-info">
                    <span style="font-size: 11px">{{ $course->user->name }}</span>
                    <img src="{{ $course->user->image ? asset('storage/' . $course->user->image) : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png' }}"
                        alt="Trainer Image">
                </div> --}}
            </div>
        </div>
    </a>
</div>
