<style>
    .course-card {
        --primary-color: #035971;
        --secondary-color: #02475E;
        --accent-color: #ed6b2f;
        --text-color: #fff;
        --text-muted: rgba(255, 255, 255, 0.8);

        width: 100%;
        max-width: 320px;
        height: 420px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        color: var(--text-color);
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
    }

    .course-card-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--text-color);
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
        background: linear-gradient(90deg, var(--accent-color), transparent);
    }

    .course-card span {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .course-description {
        font-size: 0.8rem;
        color: var(--text-muted);
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
        gap: 10px;
        margin-top: 12px;
    }

    .course-details .detail {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        background: rgba(255, 255, 255, 0.1);
        padding: 6px 8px;
        border-radius: 6px;
    }

    .course-details .detail i {
        color: var(--accent-color);
        font-size: 0.9rem;
        min-width: 16px;
    }

    .badge {
        position: absolute;
        top: 15px;
        left: -25px;
        color: white;
        padding: 6px 30px;
        font-size: 0.75rem;
        font-weight: bold;
        transform: rotate(-45deg);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        z-index: 3;
        clip-path: polygon(15% 0%, 100% 0%, 85% 100%, 0% 100%);
    }

    .badge-new {
        background: linear-gradient(45deg, var(--accent-color), #e25822);
    }

    .badge-updated {
        background: linear-gradient(45deg, #4CAF50, #2E7D32);
        top: 45px;
    }

    .course-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }

    .course-btn {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .subscribe-btn {
        background: rgba(237, 107, 47, 0.2);
        color: var(--accent-color);
        border: 1px solid rgba(237, 107, 47, 0.5);
    }

    .subscribe-btn:hover {
        background: rgba(237, 107, 47, 0.3);
    }

    .subscribed-btn {
        background: rgba(76, 175, 80, 0.2);
        color: #4CAF50;
        border: 1px solid rgba(76, 175, 80, 0.5);
        cursor: default;
    }

    .view-btn {
        background: transparent;
        color: var(--text-color);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .view-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--accent-color);
        color: var(--accent-color);
    }

    @media (max-width: 768px) {
        .course-card {
            max-width: 100%;
            height: auto;
            margin: 15px 0;
        }

        .course-details {
            grid-template-columns: 1fr;
        }

        .badge {
            left: -30px;
            padding: 5px 25px;
            font-size: 0.7rem;
        }

        .badge-updated {
            top: 40px;
        }
    }
</style>

<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="course-card">
        @if ($course->updated_at->diffInDays() <= 25)
            <div class="badge badge-new">جديد</div>
        @endif
        @if ($course?->videos()?->latest()?->first()?->updated_at?->diffInDays() <= 25)
            <div class="badge badge-updated">محدث</div>
        @endif

        <img class="card-img-top"
            src="{{ $course->image ? asset('storage/' . $course->image) : asset('assets/img/logo-ct.png') }}"
            alt="{{ $course->title }}" loading="lazy">

        <div class="card-body">
            <h5 class="course-card-title">{{ $course->title }}</h5>
            <p class="course-description">{{ Str::limit($course->description, 150) }}</p>

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
                        @switch($course->difficulty_level)
                            @case('beginner')
                                للمبتدئين
                            @break

                            @case('intermediate')
                                متوسط
                            @break

                            @case('advanced')
                                متقدم
                            @break

                            @default
                                غير محدد
                        @endswitch
                    </span>
                </div>
            </div>

            <div class="course-card-footer">
                @if ($course->user_subscription_from_this_course)
                    <span class="course-btn subscribed-btn">
                        <i class="fas fa-check-circle"></i> مشترك
                    </span>
                @else
                    <button class="course-btn subscribe-btn" data-course-id="{{ $course->id }}"
                        onclick="subscribeToCourse(this)">
                        <i class="fas fa-plus-circle"></i> اشترك الآن
                    </button>
                @endif

                <a href="{{ route('courses.videos', $course->id) }}" class="course-btn view-btn">
                    عرض الكورس <i class="fas fa-arrow-left ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function subscribeToCourse(button) {
        const courseId = button.getAttribute('data-course-id');

        // عرض تحميل أو تعطيل الزر أثناء المعالجة
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الاشتراك...';

        fetch(`/courses/${courseId}/subscribe`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // تحديث واجهة المستخدم بعد الاشتراك الناجح
                    button.classList.remove('subscribe-btn');
                    button.classList.add('subscribed-btn');
                    button.innerHTML = '<i class="fas fa-check-circle"></i> مشترك';

                    // يمكنك إضافة إشعار نجاح هنا
                    // alert('تم الاشتراك في الكورس بنجاح!');
                } else {
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-plus-circle"></i> اشترك الآن';
                    alert(data.message || 'حدث خطأ أثناء الاشتراك');
                }
            })
            .catch(error => {
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-plus-circle"></i> اشترك الآن';
                alert('حدث خطأ في الاتصال بالخادم');
            });
    }
</script>
