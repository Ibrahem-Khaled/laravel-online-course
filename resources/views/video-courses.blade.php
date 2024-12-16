<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..800&display=swap" rel="stylesheet">
    <title>{{ $course->title }} - تفاصيل الدورة</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            background-color: #072D38;
            color: #fff;
            margin: 0;
            padding-top: 100px;

        }

        .form-control {
            flex-grow: 1;
            border-width: 0;
            padding: 10px;
            background-color: #072D38;
            color: #fff;
        }

        .form-control::placeholder {
            color: #fff;
            opacity: .5;
        }

        .form-control:focus {
            background-color: #035971;
            color: #fff;
            outline: none;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
        }

        .main-content {
            padding: 30px;
        }

        .course-title {
            color: #ffffff;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .course-info {
            padding: 20px;
            border-radius: 10px;
            position: relative;
        }

        .course-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
            color: #fff;
        }

        .course-meta span {
            display: inline-block;
            margin-right: 10px;
            color: #ffffff;
        }

        .video-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .trainer-info {
            display: flex;
            align-items: center;
        }

        .trainer-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-left: 10px;
        }

        .nav-tabs {
            border-bottom: 2px solid #02475E;
            justify-content: space-around;
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
            color: #ff9c00;
            border-bottom: 3px solid #ff9c00;
            background-color: #072D38;
        }

        .tab-content {
            background-color: #02475E;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')
    <div class="container main-content">
        <!-- معلومات الدورة -->
        <div class="row">
            <div class="col-lg-8">
                <div class="course-info">
                    <h2 class="course-title">{{ $course->title }}</h2>
                    <div class="course-meta">
                        <div class="trainer-info">
                            <img src="{{ $course->user->image ? asset('storage/' . $course->user->image) : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png' }}"
                                alt="Trainer Image">
                            <div>
                                <p class="m-0">{{ $course->user->name }}</p>
                                <small>خبير ومدرب</small>
                            </div>
                        </div>
                        <h6>|</h6>
                        <span>عدد الطلبات: 7555</span>
                        <h6>|</h6>
                        <span>مستوى الدورة:
                            @if ($course->difficulty_level == 'beginner')
                                للمبتدئين
                            @elseif ($course->difficulty_level == 'intermediate')
                                للمتوسطين
                            @elseif ($course->difficulty_level == 'advanced')
                                للمتقدمين
                            @endif
                        </span>
                        <h6>|</h6>
                        <span>({{ $course->ratings?->avg('rating') ?? 0 }}) <span style="color: gold;">⭐</span></span>
                        {{-- <h6>|</h6>
                        <span>السعر: ${{ $course->price }}</span> --}}
                    </div>
                </div>

                <!-- تضمين الفيديو -->
                <div class="video-container">
                    {!! $video->video !!}
                </div>

                <!-- التابات -->
                <ul class="nav nav-tabs" id="videoTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                            type="button" role="tab" aria-controls="details" aria-selected="true">تفاصيل
                            الدورة</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sources-tab" data-bs-toggle="tab" data-bs-target="#sources"
                            type="button" role="tab" aria-controls="sources" aria-selected="false">
                            المرفقات
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="homework-tab" data-bs-toggle="tab" data-bs-target="#homework"
                            type="button" role="tab" aria-controls="homework"
                            aria-selected="false">الواجبات</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="discussion-tab" data-bs-toggle="tab" data-bs-target="#discussion"
                            type="button" role="tab" aria-controls="discussion"
                            aria-selected="false">المناقشة</button>
                    </li>
                </ul>
                <div class="tab-content" id="videoTabsContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <h6 class="text-white text-center mt-3 p-3">{{ $video->description }}</h6>
                    </div>
                    <div class="tab-pane fade" id="sources" role="tabpanel" aria-labelledby="sources-tab">
                        @include('homeComponents.video-courses.video-software')
                    </div>
                    <div class="tab-pane fade" id="homework" role="tabpanel" aria-labelledby="homework-tab">
                        @include('homeComponents.video-courses.video-homework')
                    </div>
                    <div class="tab-pane fade" id="discussion" role="tabpanel" aria-labelledby="discussion-tab">
                        @include('homeComponents.video-courses.video-discussion')
                    </div>
                </div>
            </div>

            @include('homeComponents.video-courses.sidebar')
            @include('homeComponents.video-courses.in_video_usages')
        </div>
    </div>
    @include('homeComponents.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</body>

</html>
