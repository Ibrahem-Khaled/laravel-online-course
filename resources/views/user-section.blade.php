<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>{{ $section->name }}</title>
    <style>
        :root {
            --primary-dark: #072D38;
            --primary-medium: #02475E;
            --primary-light: #036280;
            --accent-color: #ed6b2f;
            --text-light: #f8f9fa;
            --text-muted: #adb5bd;
            --gold-accent: #FFD700;
            --classic-border: 1px solid rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: "Cairo", serif;
            background-color: var(--primary-dark);
            color: var(--text-light);
            padding-top: 100px;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(7, 45, 56, 0.8) 0%, rgba(2, 71, 94, 0.9) 90%),
                url('https://www.transparenttextures.com/patterns/concrete-wall.png');
        }

        /* Hero Section - Classic Modern */
        .hero-section {
            position: relative;
            height: 350px;
            width: 90%;
            margin: 30px auto;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: var(--classic-border);
            transition: all 0.3s ease;
        }

        .hero-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .hero-background {
            background-image: url('{{ $section->image ? asset('storage/' . $section->image) : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}');
            background-color: rgba(7, 45, 56, 0.7);
            background-blend-mode: overlay;
            background-size: cover;
            background-position: center;
            filter: blur(2px) brightness(0.8);
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            transition: filter 0.5s ease;
        }

        .hero-section:hover .hero-background {
            filter: blur(1px) brightness(0.9);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 40px;
            max-width: 800px;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--text-light);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            position: relative;
            display: inline-block;
        }

        .hero-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 3px;
        }

        .hero-text {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 0;
            color: var(--text-light);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        /* Classic Modern Tabs */
        .nav-tabs {
            border-bottom: none;
            justify-content: center;
            width: 90%;
            margin: 30px auto;
            position: relative;
        }

        .nav-tabs::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(237, 107, 47, 0.5), transparent);
        }

        .nav-tabs .nav-item {
            margin: 0 10px;
        }

        .nav-tabs .nav-link {
            border: none;
            color: var(--text-muted);
            font-weight: 700;
            padding: 15px 25px;
            border-radius: 8px 8px 0 0;
            background-color: transparent;
            position: relative;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }

        .nav-tabs .nav-link:hover {
            color: var(--text-light);
            background-color: rgba(255, 255, 255, 0.05);
        }

        .nav-tabs .nav-link.active {
            color: var(--accent-color);
            background-color: rgba(237, 107, 47, 0.1);
            border-bottom: 3px solid var(--accent-color);
        }

        .nav-tabs .nav-link.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent-color);
            border-radius: 3px 3px 0 0;
        }

        /* Tab Content - Elegant Design */
        .tab-content {
            padding: 30px;
            border-radius: 12px;
            margin-top: 20px;
            width: 90%;
            margin: 20px auto;
            background-color: rgba(2, 71, 94, 0.5);
            backdrop-filter: blur(10px);
            border: var(--classic-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .info-header {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
            color: var(--text-light);
            position: relative;
            padding-bottom: 15px;
        }

        .info-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-color), transparent);
            border-radius: 3px;
        }

        /* Modern Classic Calendar */
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 15px;
            margin-top: 30px;
            direction: rtl;
        }

        .calendar-day {
            background: rgba(3, 98, 128, 0.2);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: var(--classic-border);
            position: relative;
            overflow: hidden;
        }

        .calendar-day::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--primary-light);
        }

        .calendar-day:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            background: rgba(3, 98, 128, 0.3);
        }

        .calendar-day h4 {
            margin: 0 0 15px 0;
            font-size: 1.2rem;
            color: var(--gold-accent);
            text-align: center;
            font-weight: 700;
            position: relative;
            padding-bottom: 10px;
        }

        .calendar-day h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 50%;
            transform: translateX(50%);
            width: 40px;
            height: 2px;
            background: var(--accent-color);
        }

        .calendar-day ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .calendar-day ul li {
            margin-bottom: 15px;
            font-size: 0.95rem;
            color: var(--text-light);
            text-align: center;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .calendar-day ul li:hover {
            background: rgba(237, 107, 47, 0.1);
            transform: scale(1.02);
        }

        .calendar-day .time {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: block;
            margin-top: 5px;
            font-weight: 600;
        }

        .calendar-day .holiday {
            color: var(--gold-accent);
            font-weight: bold;
            text-align: center;
            padding: 15px 0;
            font-size: 1rem;
        }

        /* Teacher & Student Cards */
        .profile-card {
            background: rgba(2, 71, 94, 0.5);
            border-radius: 12px;
            padding: 20px;
            margin: 15px;
            width: 280px;
            text-align: center;
            transition: all 0.3s ease;
            border: var(--classic-border);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            background: rgba(3, 98, 128, 0.3);
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent-color);
            margin: 0 auto 15px;
        }

        .profile-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 5px;
        }

        .profile-role {
            color: var(--accent-color);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .profile-details {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 15px;
        }

        /* Floating Button */
        .float-btn {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--accent-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(237, 107, 47, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
            border: none;
        }

        .float-btn:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 8px 25px rgba(237, 107, 47, 0.6);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .calendar {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 768px) {
            .calendar {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-text {
                font-size: 1rem;
            }

            .nav-tabs .nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .calendar {
                grid-template-columns: 1fr;
            }

            .hero-section {
                height: 250px;
            }

            .nav-tabs {
                flex-wrap: wrap;
            }

            .nav-tabs .nav-item {
                margin: 5px;
            }
        }

        /* Animated Underline */
        .animated-underline {
            position: relative;
            display: inline-block;
        }

        .animated-underline::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--accent-color);
            transition: width 0.3s ease;
        }

        .animated-underline:hover::after {
            width: 100%;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <!-- Hero Section with Classic Elegance -->
    <section class="hero-section">
        <div class="hero-background"></div>
        <div class="hero-content">
            <h1 class="hero-title animated-underline">{{ $section->name }}</h1>
            <p class="hero-text">{!! $section->description !!}</p>
        </div>
    </section>

    @include('homeComponents.alerts')

    <!-- Classic Modern Tabs -->
    <ul class="nav nav-tabs" id="sectionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="students-tab" data-toggle="tab" data-target="#students" type="button"
                role="tab" aria-controls="students" aria-selected="false">
                <i class="fas fa-users me-2"></i>الطلاب
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="teachers-tab" data-toggle="tab" data-target="#teachers" type="button"
                role="tab" aria-controls="teachers" aria-selected="false">
                <i class="fas fa-chalkboard-teacher me-2"></i>المعلمين
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="details-tab" data-toggle="tab" data-target="#details" type="button"
                role="tab" aria-controls="details" aria-selected="false">
                <i class="fas fa-info-circle me-2"></i>معلومات الفصل
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="sources-tab" data-toggle="tab" data-target="#sources"
                type="button" role="tab" aria-controls="sources" aria-selected="true">
                <i class="fas fa-book-open me-2"></i>المنهج والدورات
            </button>
        </li>
    </ul>

    <!-- Tab Content with Elegant Design -->
    <div class="tab-content" id="sectionTabsContent" dir="rtl">
        <!-- Sources Tab -->
        <div class="tab-pane fade show active" id="sources" role="tabpanel" aria-labelledby="sources-tab">
            <section class="mt-4">
                <h2 class="info-header">المنهج والدورات</h2>
                <div class="row g-4">
                    @foreach ($sectionCourses as $course)
                        @include('homeComponents.home.course-card', [
                            'course' => $course,
                        ])
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Details Tab -->
        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
            @include('homeComponents.home.best-students', [
                'students' => $sectionStudents,
                'title' => "طلاب فصل {$section->name}",
            ])

            @include('homeComponents.section.details')

            <h3 class="info-header">الجدول الأسبوعي</h3>
            <div class="calendar">
                @php
                    $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                @endphp
                @foreach ($days as $dayIndex => $day)
                    <div class="calendar-day">
                        <h4>{{ $day }}</h4>
                        @php
                            $daySchedule = $sectionCalendars->where('day_number', $dayIndex + 1);
                        @endphp
                        @if ($daySchedule->isNotEmpty())
                            <ul>
                                @foreach ($daySchedule as $schedule)
                                    <li>
                                        {{ $schedule->course->title ?? 'لا توجد مادة' }}
                                        <div class="time">
                                            @php
                                                $time = \Carbon\Carbon::createFromFormat(
                                                    'H:i:s',
                                                    $schedule->start_time,
                                                )->format('h:i A');
                                                $timeInArabic = str_replace(['AM', 'PM'], ['صباحًا', 'مساءً'], $time);
                                            @endphp
                                            <i class="far fa-clock me-1"></i> {{ $timeInArabic }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="holiday">
                                <i class="fas fa-umbrella-beach"></i> إجازة
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Teachers Tab -->
        <div class="tab-pane fade" id="teachers" role="tabpanel" aria-labelledby="teachers-tab">
            <section class="mt-4">
                <h2 class="info-header">معلمين الفصل</h2>
                <div class="d-flex flex-wrap justify-content-center">
                    @foreach ($section->users->where('role', 'teacher') as $user)
                        <div class="profile-card">
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}"
                                alt="{{ $user->name }}" class="profile-img">
                            <h3 class="profile-name">{{ $user->name }}</h3>
                            <div class="profile-role">معلم {{ $user->specialization ?? 'عام' }}</div>
                            <div class="profile-details">
                                <div><i class="fas fa-envelope me-2"></i> {{ $user->email }}</div>
                                <div><i class="fas fa-phone me-2"></i> {{ $user->phone ?? 'غير متوفر' }}</div>
                            </div>
                            <button class="btn btn-sm btn-outline-accent">عرض الملف الشخصي</button>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Students Tab -->
        <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
            <section class="mt-4">
                <h2 class="info-header">طلاب الفصل</h2>
                @include('homeComponents.section.students', [
                    ($students = $section->users->where('role', 'student')),
                    ($trainer = $section?->users?->where('role', 'teacher')?->first()),
                ])
            </section>
        </div>
    </div>

    @include('homeComponents.video-courses.float_button_add')

    @include('homeComponents.footer')
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <script>
        // Initialize tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Animate elements on scroll
        $(window).scroll(function() {
            $('.calendar-day').each(function() {
                var position = $(this).offset().top;
                var scroll = $(window).scrollTop();
                var windowHeight = $(window).height();

                if (scroll > position - windowHeight + 200) {
                    $(this).css('opacity', '1');
                }
            });
        });

        // Initialize calendar days with fade-in effect
        $(document).ready(function() {
            $('.calendar-day').css('opacity', '0').each(function(i) {
                $(this).delay(i * 150).animate({
                    'opacity': '1'
                }, 300);
            });
        });
    </script>
</body>

</html>
