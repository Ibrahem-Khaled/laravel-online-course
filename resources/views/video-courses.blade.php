<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..800&display=swap" rel="stylesheet">
    <title>{{ $course->title }} - تفاصيل الدورة</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            background-color: #072D38;
            color: #fff;
            margin: 0;
            padding: 0;
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
            margin-bottom: 20px;
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
                            <img src="{{ asset('storage/' . $course->user->image) }}" alt="Trainer Image">
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
                        <h6>|</h6>
                        <span>السعر: ${{ $course->price }}</span>
                    </div>

                </div>

                <!-- تضمين الفيديو -->
                <div class="video-container">
                    {!! $video->video !!}
                </div>
            </div>

            @include('homeComponents.video-courses.sidebar')

        </div>
    </div>
    @include('homeComponents.footer')
</body>

</html>
