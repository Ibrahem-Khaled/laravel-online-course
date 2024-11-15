<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <title>منصة الرواد التعليمية</title>
    <style>
        body {
            font-family: "Cairo", serif;
            background-color: #072D38;
        }

        .category-card {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .category-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
        }

        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px;
            color: white;
            text-align: center;
        }

        .category-overlay h5 {
            margin: 0;
            font-size: 1.2rem;
        }

        .category-overlay span {
            font-size: 0.9rem;
            color: #f8f9fa;
        }

        .btn-outline {
            border: 2px solid #3e5fe3;
            color: #3e5fe3;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')
    @include('homeComponents.hero-section')

    <div class="container mt-5">
        <!-- قسم الفئات -->
        <h2 class="text-center mb-4">فئات الدورات</h2>
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-md-3 mb-4">
                    <div class="category-card">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                        <div class="category-overlay">
                            <h5>{{ $category->name }}</h5>
                            <span>{{ $category->courses->count() }} دورة متاحة</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- عرض الكورسات -->
        <h2 class="text-center mt-5 mb-4">دوراتنا</h2>
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card course-card">
                        <img src="{{ asset('storage/' . $course->image) }}" style="height: 200px; object-fit: cover"
                            class="card-img-top" alt="Course Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->title }}</h5>
                            <p class="card-text">{{ $course->description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="rating">
                                    @for ($i = 1; $i <= $course->ratings->avg('rating'); $i++)
                                        ⭐
                                    @endfor
                                    ({{ $course->ratings->count() }})
                                </span>
                                <a href="{{ route('courses.videos', $course->id) }}" class="btn btn-outline">تفاصيل
                                    الدورة</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('homeComponents.best-teachers')
    @include('homeComponents.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
