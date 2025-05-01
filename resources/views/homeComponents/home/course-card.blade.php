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
        font-size: .9rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: #fff;
        position: relative;
        padding-bottom: 5px;
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
    }

    .course-details .detail i {
        color: #ed6b2f;
        font-size: 0.9rem;
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
        clip-path: polygon(15% 0%, 100% 0%, 85% 100%, 0% 100%);
    }

    .course-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }

    .start-now-btn {
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
            @if ($course->updated_at->diffInDays() <= 25)
                <div class="new-badge">جديد</div>
            @endif
            @if ($course?->videos()?->latest()?->first()?->updated_at?->diffInDays() <= 25)
                <div class="new-badge" style="top: 45px; background: linear-gradient(45deg, #4CAF50, #2E7D32);">محدث</div>
            @endif

            <img class="card-img-top"
                src="{{ $course->image ? asset('storage/' . $course->image) : asset('assets/img/logo-ct.png') }}"
                alt="{{ $course->title }}">

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

                <div class="course-card-footer">
                    <div class="start-now-btn">اشترك الآن</div>
                    <button class="view-btn">عرض الكورس <i class="fas fa-arrow-left ms-1"></i></button>
                </div>
            </div>
        </div>
    </a>
</div>
