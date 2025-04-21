<style>
    .course-card {
        width: 100%;
        max-width: 320px;
        height: 420px;
        background: linear-gradient(135deg, #035971 0%, #02475E 100%);
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        color: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-align: right;
        margin: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        font-family: "Cairo", sans-serif;
    }

    .course-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .course-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
        z-index: 1;
    }

    .course-card .card-img-top {
        height: 160px;
        object-fit: cover;
        width: 100%;
        filter: brightness(0.9);
        transition: all 0.4s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .course-card:hover .card-img-top {
        filter: brightness(1);
        transform: scale(1.05);
    }

    .course-card .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: calc(100% - 160px);
        position: relative;
        z-index: 2;
    }

    .course-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: #fff;
        position: relative;
        padding-bottom: 8px;
    }

    .course-card-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 50px;
        height: 2px;
        background: linear-gradient(90deg, #ed6b2f, transparent);
    }

    .course-card span {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .favorite-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.5);
        border: none;
        color: #fff;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 3;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .favorite-btn:hover {
        background: rgba(0, 0, 0, 0.7);
        transform: scale(1.1);
    }

    .favorite-btn .fa-heart {
        color: #ff6b6b;
        text-shadow: 0 0 5px rgba(255, 107, 107, 0.5);
    }

    .course-description {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.5;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .course-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-top: 10px;
    }

    .course-details .detail {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.70rem;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .course-details .detail:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .course-details .detail i {
        color: #ed6b2f;
        font-size: 0.9rem;
    }

    .trainer-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 15px;
        padding-top: 10px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .trainer-info span {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .trainer-info img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-left: 8px;
        border: 2px solid #ed6b2f;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    @keyframes pulse {
        0% {
            transform: rotate(-45deg) scale(1);
            opacity: 0.9;
        }

        50% {
            transform: rotate(-45deg) scale(1.05);
            opacity: 1;
        }

        100% {
            transform: rotate(-45deg) scale(1);
            opacity: 0.9;
        }
    }

    @keyframes float {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }

        100% {
            transform: translateY(0);
        }
    }

    .new-badge {
        position: absolute;
        top: 15px;
        left: -25px;
        background: linear-gradient(45deg, #ed6b2f, #e25822);
        color: white;
        padding: 8px 35px;
        font-size: 0.75rem;
        font-weight: bold;
        transform: rotate(-45deg);
        box-shadow: 0 3px 10px rgba(226, 88, 34, 0.4);
        z-index: 3;
        animation: pulse 2s infinite, float 3s ease-in-out infinite;
        clip-path: polygon(15% 0%, 100% 0%, 85% 100%, 0% 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        letter-spacing: 1px;
    }

    .new-badge::before {
        content: '✨';
        margin-left: 5px;
    }

    .course-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }

    .course-price {
        background: rgba(237, 107, 47, 0.2);
        color: #ed6b2f;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        border: 1px solid rgba(237, 107, 47, 0.5);
    }

    .view-btn {
        background: transparent;
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.7rem;
        transition: all 0.3s ease;
    }

    .view-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #ed6b2f;
        color: #ed6b2f;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .course-card {
            max-width: 100%;
            height: auto;
            margin: 15px 0;
        }

        .course-details {
            grid-template-columns: 1fr;
        }

        .new-badge {
            left: -30px;
            padding: 6px 30px;
            font-size: 0.7rem;
        }
    }
</style>

<div class="col-lg-3 col-md-4 col-sm-6">
    <a href="{{ route('courses.videos', $course->id) }}" class="text-decoration-none">
        <div class="course-card">
            <!-- شارة جديدة -->
            @if ($course->updated_at->diffInDays() <= 25)
                <div class="new-badge">
                    جديد
                </div>
            @endif
            @if ($course?->videos()?->latest()?->first()?->updated_at?->diffInDays() <= 25)
                <div class="new-badge" style="top: 45px; background: linear-gradient(45deg, #4CAF50, #2E7D32);">
                    محدث
                </div>
            @endif

            <!-- زر المفضلة -->
            <button class="favorite-btn" onclick="event.preventDefault(); toggleFavorite(this, {{ $course->id }});">
                <i class="fas {{ $course?->is_favorite ? 'fa-heart' : 'fa-heart' }}"></i>
            </button>

            <!-- صورة الكورس -->
            <img class="card-img-top"
                src="{{ $course->image ? asset('storage/' . $course->image) : asset('assets/img/logo-ct.png') }}"
                alt="{{ $course->title }}">

            <!-- محتوى الكارد -->
            <div class="card-body">
                <!-- عنوان الكورس -->
                <h5 class="course-card-title" >{{ $course->title }}</h5>

                <!-- وصف الكورس -->
                <p class="course-description">
                    {{ Str::limit($course->description, 150) }}
                </p>

                <!-- تفاصيل الكورس -->
                <div class="course-details">
                    <div class="detail" data-toggle="tooltip" title="مدة الكورس">
                        <i class="fas fa-clock"></i>
                        <span>{{ $course->duration_in_hours ?? 'غير محدد' }} ساعة</span>
                    </div>

                    <div class="detail" data-toggle="tooltip" title="الفئة المستهدفة">
                        <i class="fas fa-users"></i>
                        <span>{{ $course->target_audience ?? 'الكل' }}</span>
                    </div>

                    <div class="detail" data-toggle="tooltip" title="عدد الدروس">
                        <i class="fas fa-book"></i>
                        <span>{{ $course->videos->count() ?? 0 }} دروس</span>
                    </div>

                    <div class="detail" data-toggle="tooltip" title="مستوى الصعوبة">
                        <i class="fas fa-signal"></i>
                        <span>
                            @if ($course->difficulty_level == 'beginner')
                                للمبتدئين
                            @elseif ($course->difficulty_level == 'intermediate')
                                متوسط
                            @elseif ($course->difficulty_level == 'advanced')
                                متقدم
                            @else
                                غير محدد
                            @endif
                        </span>
                    </div>
                </div>

                <!-- قسم سفلي -->
                <div class="course-card-footer">
                    <div class="course-price">
                        {{ $course->price > 0 ? $course->price . ' ر.س' : 'مجاني' }}
                    </div>
                    <button class="view-btn">
                        عرض الكورس <i class="fas fa-arrow-left ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </a>
</div>

<script>
    function toggleFavorite(button, courseId) {
        // هنا كود Ajax لتغيير حالة المفضلة
        const icon = button.querySelector('i');
        if (icon.classList.contains('fa-heart')) {
            icon.classList.remove('fa-heart');
            icon.classList.add('fa-heart');
            // إرسال طلب لإضافة إلى المفضلة
        } else {
            icon.classList.remove('fa-heart');
            icon.classList.add('fa-heart');
            // إرسال طلب لإزالة من المفضلة
        }

        // تأثير عند النقر
        button.style.transform = 'scale(1.3)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 300);
    }

    // تهيئة أدوات التلميح
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>