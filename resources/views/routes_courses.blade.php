<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
            text-align: center;
        }

        .route-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .route-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .route-header p {
            font-size: 1.2rem;
            color: #ccc;
        }

        .nav-tabs {
            border-bottom: 2px solid #0A3D4A;
            margin-bottom: 2rem;
        }

        .nav-tabs .nav-link {
            color: #fff;
            border: none;
            border-radius: 10px 10px 0 0;
            margin-right: 0.5rem;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            background-color: #0A3D4A;
            color: #fff;
            border-bottom: 2px solid #4CAF50;
        }

        .nav-tabs .nav-link:hover {
            background-color: #0A3D4A;
        }

        .course-card {
            background-color: #0A3D4A;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-10px);
        }

        .course-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
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
            -webkit-box-orient: vertical;
            flex-grow: 1;
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

        .icon {
            margin: 0.5rem;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <div class="container my-5" dir="rtl">
        <!-- تفاصيل المسار -->
        <div class="route-header">
            <img src="{{ $route->image ? asset('storage/' . $route->image) : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png' }}"
                alt="{{ $route->name }}" class="route-image">
            <h1>{{ $route->name }}</h1>
            <p class="lead">{{ $route->target_group }}</p>
        </div>

        <!-- تبويبات الوصف والدورات -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-toggle="tab" data-target="#description"
                    type="button" role="tab" aria-controls="description" aria-selected="true">
                    <i class="fas fa-info-circle icon"></i>الوصف
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="courses-tab" data-toggle="tab" data-target="#courses" type="button"
                    role="tab" aria-controls="courses" aria-selected="false">
                    <i class="fas fa-book icon"></i>الدورات
                </button>
            </li>
        </ul>

        <!-- محتوى التبويبات -->
        <div class="tab-content" id="myTabContent">
            <!-- تبويب الوصف -->
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <div class="p-4 rounded">
                    <p>{{ $route->description }}</p>
                </div>
            </div>

            <!-- تبويب الدورات -->
            <div class="tab-pane fade" id="courses" role="tabpanel" aria-labelledby="courses-tab">
                <div class="row">
                    @foreach ($route->courses as $course)
                        <div class="col-md-4 mb-4">
                            <div class="course-card">
                                @if ($course->created_at->diffInWeeks(now()) < 3)
                                    <span class="new-badge">جديد</span>
                                @endif

                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                                    class="course-image">
                                <h3 class="course-title">{{ $course->title }}</h3>
                                <p class="course-description">
                                    {{ Str::limit($course->description, 150, '...') }}
                                </p>
                                <p class="course-difficulty">
                                    <i class="fas fa-tachometer-alt icon"></i>مستوى الصعوبة:
                                    {{ $course->difficulty_level }}
                                </p>
                                <p class="course-language">
                                    <i class="fas fa-language icon"></i>اللغة: {{ $course->language }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('homeComponents.footer')

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
