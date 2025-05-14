<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - أكاديمية السريع</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --main-color: #ed6b2f;
            --main-dark: #d45a23;
            --dark-bg: #072D38;
            --secondary-bg: #06455E;
            --light-bg: #0A6E8F;
            --text-light: #f0f8ff;
            --text-muted: #a8c7d8;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--secondary-bg) 100%);
            color: var(--text-light);
            min-height: 100vh;
            background-attachment: fixed;
        }

        /* Header Section - Modern Design */
        .profile-header {
            background: rgba(7, 45, 56, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 2rem;
            padding: 2rem;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(237, 107, 47, 0.1) 0%, transparent 70%);
            z-index: -1;
        }

        .user-avatar {
            width: 140px;
            height: 140px;
            border: 4px solid var(--main-color);
            box-shadow: 0 0 30px rgba(237, 107, 47, 0.4);
            transition: all 0.3s ease;
            object-fit: cover;
        }

        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 0 40px rgba(237, 107, 47, 0.6);
        }

        /* Stats Cards - Modern Glassmorphism */
        .stats-card {
            background: rgba(6, 69, 94, 0.5);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
            border-color: rgba(237, 107, 47, 0.3);
        }

        .stats-card .card-header {
            background: rgba(237, 107, 47, 0.15);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 1.5rem;
            font-weight: 700;
        }

        /* Progress Bars - Modern Animated */
        .skill-meter {
            height: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .skill-progress {
            height: 100%;
            background: linear-gradient(90deg, var(--main-color), #ff9f6f);
            transition: width 1s ease-in-out;
            position: relative;
        }

        .skill-progress::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg,
                    rgba(255, 255, 255, 0.1) 0%,
                    rgba(255, 255, 255, 0.3) 50%,
                    rgba(255, 255, 255, 0.1) 100%);
            animation: shine 2s infinite;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        /* Rating Badge - Modern Design */
        .rating-badge {
            background: rgba(237, 107, 47, 0.2);
            border: 2px solid var(--main-color);
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .rating-badge:hover {
            background: rgba(237, 107, 47, 0.3);
            transform: scale(1.05);
        }

        /* Course Cards - Modern Design */
        .course-card {
            background: rgba(6, 69, 94, 0.6);
            border: none;
            border-radius: 15px;
            transition: all 0.4s ease;
            overflow: hidden;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            border-color: rgba(237, 107, 47, 0.3);
        }

        .course-card .card-img-top {
            height: 180px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .course-card:hover .card-img-top {
            transform: scale(1.05);
        }

        /* Table - Modern Design */
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .table {
            margin-bottom: 0;
            background: rgba(6, 69, 94, 0.7);
            backdrop-filter: blur(5px);
        }

        .table th {
            background-color: var(--main-color);
            color: #fff;
            font-weight: 700;
            text-align: center;
            padding: 1rem;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
            padding: 0.75rem 1rem;
            border-color: rgba(255, 255, 255, 0.05);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.03);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Buttons - Modern Design */
        .btn-main {
            background-color: var(--main-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(237, 107, 47, 0.3);
        }

        .btn-main:hover {
            background-color: var(--main-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(237, 107, 47, 0.4);
        }

        /* Modal - Modern Design */
        .modal-content {
            background: rgba(6, 69, 94, 0.9);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
        }

        /* Form Inputs - Modern Design */
        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--main-color);
            box-shadow: 0 0 0 0.25rem rgba(237, 107, 47, 0.25);
            color: white;
        }

        /* Section Headers */
        .section-header {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--main-color), transparent);
            border-radius: 2px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .profile-header {
                text-align: center;
            }

            .user-avatar {
                width: 100px;
                height: 100px;
                margin-bottom: 1rem;
            }

            .section-header {
                text-align: center;
            }

            .section-header::after {
                right: 50%;
                transform: translateX(50%);
            }
        }

        /* Animation Effects */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .delay-2 {
            animation-delay: 0.4s;
        }

        .delay-3 {
            animation-delay: 0.6s;
        }

        /* Quick Links - Modern Design */
        .quick-link-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
            border-left: 4px solid transparent;
        }

        .quick-link-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(-5px);
            border-left: 4px solid var(--main-color);
        }

        .quick-link-item i {
            margin-left: 10px;
            color: var(--main-color);
            font-size: 1.2rem;
        }

        /* Empty State Design */
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 15px;
            border: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--main-color);
            margin-bottom: 1rem;
        }
    </style>
</head>

<body class="pt-5">
    @include('homeComponents.header')

    <div class="container py-5" dir="rtl">
        @include('components.alerts')

        <!-- Header Section - Redesigned -->
        <div class="profile-header fade-in">
            <div class="row align-items-center">
                <div class="col-md-3 text-center">
                    <img src="{{ $user->profile_image }}" class="user-avatar rounded-circle shadow">
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3">{{ $user->name }}</h2>
                    <div class="d-flex gap-3 flex-wrap mb-3">
                        @if ($user->userReports->isNotEmpty())
                            <div class="rating-badge fade-in delay-1">
                                <i class="fas fa-star text-warning me-1"></i>
                                التقييم العام: <span
                                    id="average-rating">{{ round($user->userReports->avg('total'), 1) }}</span>/60
                            </div>
                        @else
                            <div class="rating-badge fade-in delay-1">
                                <i class="fas fa-star text-warning me-1"></i>
                                التقييم العام: غير متاح
                            </div>
                        @endif
                    </div>

                    @if ($user->role === 'student' || $user->role === 'teacher')
                        <div class="user-details fade-in delay-2">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-info-circle me-2 text-muted"></i>
                                <span>البايو: {{ $user->bio ?? 'غير متوفر' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                <span>العنوان: {{ $user->address ?? 'غير متوفر' }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-3 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-main" onclick="window.location.href='{{ route('user.setting') }}'">
                        <i class="fas fa-cog me-1"></i> تعديل الملف
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content - Redesigned -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Courses Section -->
                <div class="mb-5 fade-in delay-1">
                    <h3 class="section-header">
                        <i class="fas fa-book-open me-2"></i>الدورات المسجلة
                    </h3>

                    @if ($courses->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-book"></i>
                            <h4>لا توجد دورات متاحة حالياً</h4>
                            <p class="text-muted">يمكنك التحقق لاحقاً أو التواصل معنا للحصول على المزيد من التفاصيل.</p>
                            <button class="btn btn-main mt-3" onclick="window.location.href='#'">
                                تواصل معنا
                            </button>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach ($courses as $course)
                                @include('homeComponents.home.course-card', ['course' => $course])
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Schedule Section -->
                <div class="fade-in delay-2">
                    <h3 class="section-header">
                        <i class="fas fa-calendar-alt me-2"></i>جدول الحصص
                    </h3>

                    <div class="table-responsive">
                        <table class="table table-dark table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>القسم</th>
                                    <th>الدورة</th>
                                    <th>اليوم</th>
                                    <th>وقت البدء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sectionCalendars as $calendar)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $calendar->section->name }}</td>
                                        <td>{{ $calendar->course->name ?? 'بدون دورة' }}</td>
                                        <td>{{ $calendar->day_name }}</td>
                                        <td>{{ $calendar->start_time }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-calendar-times me-2"></i>لا توجد بيانات متاحة
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                @if ($user->role === 'student' && $user->userReports->isNotEmpty())
                    <!-- Teacher Ratings -->
                    <div class="stats-card fade-in delay-2">
                        <div class="card-header d-flex align-items-center">
                            <i class="fas fa-chart-line me-2"></i>
                            <h5 class="mb-0">تقييمات المدرسين</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($user->userReports as $report)
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">{{ $report->teacher->name }}</h6>
                                        <span
                                            class="badge bg-warning">{{ $report?->created_at?->diffForHumans() }}</span>
                                    </div>
                                    @foreach (['attendance', 'reactivity', 'homework', 'completion', 'creativity', 'ethics'] as $field)
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between small mb-1">
                                                <span>@lang("fields.$field")</span>
                                                <span>{{ $report->$field }}/10</span>
                                            </div>
                                            <div class="skill-meter">
                                                <div class="skill-progress" style="width: 0"
                                                    data-width="{{ $report->$field * 10 }}"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if (!$loop->last)
                                    <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quick Links -->
                <div class="stats-card fade-in delay-3">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-link me-2"></i>
                        <h5 class="mb-0">روابط سريعة</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('user.setting') }}" class="quick-link-item">
                            <i class="fas fa-user-cog"></i>
                            <span>إعدادات الحساب</span>
                        </a>
                        <a href="#" class="quick-link-item" data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">
                            <i class="fas fa-lock"></i>
                            <span>تغيير كلمة المرور</span>
                        </a>
                        <a href="#" class="quick-link-item">
                            <i class="fas fa-question-circle"></i>
                            <span>المساعدة والدعم</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal - Redesigned -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-lock me-2"></i>تغيير كلمة المرور
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('change-password') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="new_password" class="form-label">كلمة المرور الجديدة</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">تأكيد كلمة المرور الجديدة</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-main">
                                <i class="fas fa-save me-1"></i> حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('homeComponents.footer')

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Animate skill progress bars
            $('.skill-progress').each(function() {
                $(this).css('width', $(this).data('width') + '%');
            });

            // Animate average rating
            const averageRating = parseFloat($('#average-rating').text());
            if (!isNaN(averageRating)) {
                let currentRating = 0;
                const ratingInterval = setInterval(() => {
                    if (currentRating >= averageRating) {
                        clearInterval(ratingInterval);
                    } else {
                        currentRating += 0.1;
                        $('#average-rating').text(currentRating.toFixed(1));
                    }
                }, 50);
            }

            // Add hover effect to course cards
            $('.course-card').hover(
                function() {
                    $(this).find('.card-img-top').css('transform', 'scale(1.05)');
                },
                function() {
                    $(this).find('.card-img-top').css('transform', 'scale(1)');
                }
            );
        });
    </script>
</body>

</html>
