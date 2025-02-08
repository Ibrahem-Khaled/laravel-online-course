<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - أكاديمية السريع</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --main-color: #ed6b2f;
            --dark-bg: #072D38;
            --secondary-bg: #06455E;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--dark-bg);
            color: #fff;
            min-height: 100vh;
        }

        .profile-header {
            background: linear-gradient(45deg, var(--dark-bg) 30%, var(--secondary-bg) 100%);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .user-avatar {
            width: 120px;
            height: 120px;
            border: 3px solid var(--main-color);
            box-shadow: 0 0 20px rgba(237, 107, 47, 0.3);
        }

        .stats-card {
            background: var(--secondary-bg);
            border-radius: 15px;
            transition: transform 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .skill-meter {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .skill-progress {
            height: 100%;
            background: linear-gradient(90deg, var(--main-color), #ff9f6f);
            transition: width 1s ease-in-out;
        }

        .rating-badge {
            background: rgba(237, 107, 47, 0.2);
            border: 2px solid var(--main-color);
            border-radius: 10px;
            padding: 8px 15px;
        }

        .course-card {
            background: var(--secondary-bg);
            border: none;
            border-radius: 15px;
            transition: all 0.3s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }


        /* Add these styles to your existing <style> block */
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .table th {
            background-color: var(--main-color);
            color: #fff;
            font-weight: 700;
        }

        .table td,
        .table th {
            vertical-align: middle;
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="pt-5">
    @include('homeComponents.header')
    <div class="container py-5" dir="rtl">

        @include('homeComponents.alerts')

        <!-- Header Section -->
        <div class="profile-header p-4 mb-5">
            <div class="row align-items-center">
                <div class="col-md-3 text-center">
                    <img src="{{ $user->profile_image }}" class="user-avatar rounded-circle shadow">
                </div>
                <div class="col-md-6">
                    <h4 class="fw-bold mb-3">{{ $user->name }}</h4>
                    <div class="d-flex gap-3 flex-wrap">
                        @if ($user->userReports->isNotEmpty())
                            <div class="rating-badge fade-in">
                                <i class="fas fa-star text-warning"></i>
                                التقييم العام: <span
                                    id="average-rating">{{ round($user->userReports->avg('total'), 1) }}</span>/60
                            </div>
                        @else
                            <div class="rating-badge fade-in">
                                <i class="fas fa-star text-warning"></i>
                                التقييم العام: غير متاح
                            </div>
                        @endif
                    </div>
                    @if ($user->role === 'student' || $user->role === 'teacher')
                        <div class="mt-3">
                            <p class="mb-1"><i class="fas fa-info-circle me-2"></i>البايو:
                                {{ $user->bio ?? 'غير متوفر' }}</p>
                            <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>العنوان:
                                {{ $user->address ?? 'غير متوفر' }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Courses Section -->
            <div class="col-lg-8">
                <h3 class="mb-4 border-bottom pb-3"><i class="fas fa-book-open me-2"></i>الدورات المسجلة</h3>

                <div class="row g-4">
                    @if ($courses->isEmpty())
                        <div class="text-center mt-5">
                            <h3>لا توجد دورات متاحة حالياً</h3>
                            <p>يمكنك التحقق لاحقاً أو التواصل معنا للحصول على المزيد من التفاصيل.</p>
                            <button class="btn mt-3 w-50 text-white" style="background-color: #ed6b2f;"
                                onclick="window.location.href='#'">
                                تواصل معنا
                            </button>
                        </div>
                    @else
                        @foreach ($courses as $course)
                            @include('homeComponents.home.course-card', ['course' => $course])
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Sidebar Section -->
            <div class="col-lg-4" style="margin-top: 110px">
                @if ($user->role === 'student' && $user->userReports->isNotEmpty())
                    <!-- Teacher Ratings -->
                    <div class="stats-card p-4 mb-4">
                        <h5 class="mb-4"><i class="fas fa-chart-line me-2"></i>تقييمات المدرسين</h5>
                        @foreach ($user->userReports as $report)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small">{{ $report->teacher->name }}</span>
                                    <span class="badge bg-warning">{{ $report?->created_at?->diffForHumans() }}</span>
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
                            <hr class="my-4">
                        @endforeach
                    </div>
                @endif

                <!-- Quick Links -->
                <div class="stats-card p-4">
                    <div class="list-group">
                        <a href="{{ route('user.setting') }}"
                            class="justify-content-between d-flex align-items-center
                         list-group-item list-group-item-action border-0 bg-transparent text-white">
                            <i class="fas fa-user-cog me-2"></i>إعدادات الحساب
                        </a>
                        <a href="#"
                            class="justify-content-between d-flex align-items-center
    list-group-item list-group-item-action border-0 bg-transparent text-white"
                            data-toggle="modal" data-target="#changePasswordModal">
                            <i class="fas fa-lock me-2"></i>تغيير كلمة المرور
                        </a>
                    </div>
                </div>
            </div>


            <!-- Add this section inside the main content, after the Courses Section -->
            <div class="col-lg-12 mt-5">
                <h3 class="mb-4 border-bottom pb-3"><i class="fas fa-calendar-alt me-2"></i>جدول الحصص</h3>

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
                                    <td colspan="5" class="text-center">لا توجد بيانات متاحة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Add this modal code before the closing </body> tag -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="background-color: var(--secondary-bg); border: 1px solid rgba(255, 255, 255, 0.1);">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel"><i class="fas fa-lock me-2"></i>تغيير كلمة
                        المرور</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('change-password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label text-white">كلمة المرور
                                الحالية</label>
                            <input type="password" class="form-control" id="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label text-white">كلمة المرور
                                الجديدة</label>
                            <input type="password" class="form-control" id="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label text-white">تأكيد كلمة المرور
                                الجديدة</label>
                            <input type="password" class="form-control" id="confirm_password" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ
                                التغييرات</button>
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
        });
    </script>
</body>

</html>
