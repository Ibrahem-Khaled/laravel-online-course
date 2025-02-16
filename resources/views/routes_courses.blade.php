<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <title>{{ $route->name }}</title>
    <style>
        body {
            font-family: "Cairo", serif;
            background-color: #072D38;
            color: #fff;
        }

        .route-header {
            background-color: #0A3D4A;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }

        .route-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .course-card {
            background-color: #0A3D4A;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
            height: 100%;
            /* تثبيت ارتفاع الكارد */
            display: flex;
            flex-direction: column;
        }

        .course-card:hover {
            transform: translateY(-10px);
        }

        .course-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .course-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .course-description {
            font-size: 1rem;
            color: #ccc;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* عدد الأسطر المطلوبة */
            -webkit-box-orient: vertical;
            flex-grow: 1;
            /* لجعل الوصف يأخذ المساحة المتبقية */
        }

        .course-price {
            font-size: 1.2rem;
            color: #4CAF50;
            font-weight: bold;
        }

        .course-difficulty {
            font-size: 0.9rem;
            color: #FFC107;
        }

        .course-language {
            font-size: 0.9rem;
            color: #03A9F4;
        }

        .new-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #FFC107;
            color: #000;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .card-container {
            position: relative;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <div class="container my-5" dir="rtl">
        <!-- تفاصيل المسار -->
        <div class="route-header text-center">
            <img src="{{ asset('storage/' . $route->image) }}" alt="{{ $route->name }}" class="route-image mb-3">
            <h1>{{ $route->name }}</h1>
            <p class="lead">{{ $route->target_group }}</p>
            <p>{{ $route->description }}</p>
        </div>

        <!-- تفاصيل الدورات -->
        <h2 class="mb-4">الدورات التابعة للمسار</h2>
        <div class="row">
            @foreach ($route->courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card-container">
                        <div class="course-card">
                            <!-- علامة "جديد" إذا كانت الدورة حديثة -->
                            @if ($course->created_at->diffInWeeks(now()) < 3)
                                <span class="new-badge">جديد</span>
                            @endif

                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                                class="course-image mb-3">
                            <h3 class="course-title">{{ $course->title }}</h3>
                            <p class="course-description">
                                {{ Str::limit($course->description, 150, '...') }} <!-- تحديد طول الوصف -->
                            </p>
                            <p class="course-difficulty">مستوى الصعوبة: {{ $course->difficulty_level }}</p>
                            <p class="course-language">اللغة: {{ $course->language }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('homeComponents.footer')

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
