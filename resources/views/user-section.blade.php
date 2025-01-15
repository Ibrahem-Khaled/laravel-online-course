<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <title>{{ $section->name }}</title>
    <style>
        body {
            font-family: "Cairo", serif;
            background-color: #072D38;
            color: #fff;
            padding-top: 100px;
        }

        .hero-section {
            position: relative;
            height: 300px;
            width: 90%;
            margin: 10px auto;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-background {
            background-image: url("https://media.npr.org/assets/img/2017/04/19/students-in-social-studies-class-2_wide-170b4b5454916941b2d3f29c9442f50e9e1c82e5.jpg?s=1400");
            background-color: rgba(147, 53, 0, 0.5);
            background-blend-mode: overlay;
            background-size: cover;
            background-position: center;
            filter: blur(3px);
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: right;
            padding: 20px;
        }

        .nav-tabs {
            border-bottom: 2px solid #02475E;
            justify-content: space-around;
            width: 90%;
            margin: 10px auto;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #ffffff;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 0;
            background-color: transparent;
        }

        .nav-tabs .nav-link.active {
            color: #ed6b2f;
            border-bottom: 3px solid #ed6b2f;
            background-color: #072D38;
        }

        .tab-content {
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            width: 90%;
            margin: 10px auto;
        }

        /* تصميم الجدول الأسبوعي */
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 20px;
            direction: rtl;
        }

        .calendar-day {
            background-color: #02475E;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .calendar-day:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .calendar-day h4 {
            margin: 0;
            font-size: 18px;
            color: #ed6b2f;
            text-align: center;
        }

        .calendar-day ul {
            list-style: none;
            padding: 0;
            margin: 10px 0 0 0;
        }

        .calendar-day ul li {
            margin-bottom: 10px;
            font-size: 14px;
            color: #fff;
            text-align: center;
        }

        .calendar-day ul li:last-child {
            margin-bottom: 0;
        }

        .calendar-day .time {
            font-size: 12px;
            color: #ccc;
        }

        .calendar-day .holiday {
            color: #ff6b6b;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <section class="hero-section">
        <div class="hero-background"></div>
        <div class="hero-content">
            <h1 class="hero-title">{{ $section->name }}</h1>
            <p class="hero-text">{{ $section->description }}</p>
        </div>
    </section>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <ul class="nav nav-tabs" id="videoTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="students-tab" data-toggle="tab" data-target="#students" type="button"
                role="tab" aria-controls="students" aria-selected="false">الطلاب</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="teachers-tab" data-toggle="tab" data-target="#teachers" type="button"
                role="tab" aria-controls="teachers" aria-selected="false">المعلمين</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="details-tab" data-toggle="tab" data-target="#details" type="button"
                role="tab" aria-controls="details" aria-selected="false">معلومات عن الفصل</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="sources-tab" data-toggle="tab" data-target="#sources" type="button"
                role="tab" aria-controls="sources" aria-selected="true">المنهج والدورات</button>
        </li>
    </ul>
    <div class="tab-content" id="videoTabsContent">
        <div class="tab-pane fade show active" id="sources" role="tabpanel" aria-labelledby="sources-tab">
            <section class="mt-5" style="text-align: right; width: 90%; margin: 10px auto;">
                <h2 class="info-header">المنهج والدورات</h2>
                <div class="row" style="direction: rtl;">
                    @foreach ($sectionCourses as $course)
                        @include('homeComponents.home.course-card', ['course' => $course])
                    @endforeach
                </div>
            </section>
        </div>
        <div class="tab-pane fade " id="details" role="tabpanel" aria-labelledby="details-tab">
            @include('homeComponents.home.best-students', [
                'students' => $sectionStudents,
                'title' => "طلاب فصل {$section->name}",
            ])
            @include('homeComponents.section.details')
            <h3 class="info-header" style="text-align: right;">الجدول الأسبوعي</h3>
            <div class="calendar">
                @php
                    $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                @endphp
                @foreach ($days as $dayIndex => $day)
                    <div class="calendar-day">
                        <h4>{{ $day }}</h4>
                        @php
                            $daySchedule = $sectionCalendars->where('day_number', $dayIndex + 1); // 1 = السبت
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
                                            {{ $timeInArabic }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="holiday">إجازة</span>
                        @endif
                    </div>
                @endforeach
            </div>

        </div>

        <div class="tab-pane fade" id="teachers" role="tabpanel" aria-labelledby="teachers-tab">
            <section class="mt-5" style="text-align: right; width: 90%; margin: 10px auto;">
                <h2 class="info-header">معلمين الفصل</h2>
                <div style="display: flex; flex-wrap: wrap; justify-content: space-around;">
                    @foreach ($section->users->where('role', 'teacher') as $user)
                        @include('homeComponents.section.teachers')
                    @endforeach
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
            <section class="mt-5" style="text-align: right; width: 90%; margin: 10px auto;">
                <h2 class="info-header">طلاب</h2>
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
</body>

</html>
