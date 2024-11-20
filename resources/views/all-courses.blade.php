<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <title>منصة الرواد التعليمية</title>
    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #072D38;
            color: white;
            margin: 0;
            padding: 0;
        }

        .sort-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 85%;
            padding: 10px 20px;
            border-radius: 10px;
            margin: auto;
            flex-direction: row-reverse;
        }

        .sort-title {
            color: #ffffff;
            margin: 5px;
            font-size: 14px;
        }

        .dropdown-toggle {
            background-color: #fed8b1;
            color: #a84907;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .dropdown-toggle:hover {
            background-color: #FDE8CE;
        }

        .course-card {
            width: 286px;
            background-color: #145466;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            text-align: right;
        }

        .course-card:hover {
            transform: translateY(-5px);
        }

        .course-card .card-img-top {
            height: 150px;
            object-fit: cover;
            width: 100%;
        }

        .course-card .card-body {
            padding: 15px;
        }

        .course-card-title {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .course-card .rating {
            color: gold;
            margin-bottom: -10px;
        }

        .course-card .price {
            color: #ed6b2f;
            font-weight: bold;
            margin-top: 5px;
            background-color: #0B495B;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.8);
            border: none;
            color: red;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .favorite-btn:hover {
            background: rgba(255, 255, 255, 1);
        }

        .trainer-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
        }

        .trainer-info img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-left: 5px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <div class="sort-section">
        <h5>الدورات</h5>
        <div class="dropdown" style="flex-direction: row-reverse; display: flex; align-items: center;">
            <h3 class="sort-title">ترتيب حسب</h3>
            <button class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                المضاف حديثاً
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">الأكثر مشاهدة</a></li>
                <li><a class="dropdown-item" href="#">الأعلى تقييمًا</a></li>
                <li><a class="dropdown-item" href="#">الأحدث</a></li>
            </ul>
        </div>
    </div>

    <div class="container my-4">
        <div class="row">
            @foreach ($courses as $course)
                <div class="course-card">
                    <button class="favorite-btn">

                        <i class="fas {{ $course?->is_favorite ? 'fa-heart' : 'fa-heart-o' }}"></i>
                    </button>
                    <img class="card-img-top" src="{{ asset('storage/' . $course->image) }}" alt="Course Image">
                    <div class="card-body">
                        <h5 class="course-card-title">{{ $course->title }}</h5>
                        <div class="trainer-info">
                            <p class="rating">
                                @for ($i = 1; $i <= $course->ratings->avg('rating'); $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                ({{ $course->ratings->count() }})
                            </p>
                            <div class="trainer-info">
                                <span style="font-size: 11px">{{ $course->user->name }}</span>
                                <img src="{{ asset('storage/' . $course->user->image) }}" alt="Trainer Image">
                            </div>
                        </div>

                        <div class="trainer-info">
                            <p style="color: #ed6b2f">{{ $course->user->count() ?? 0 }}
                                <i class="fas fa-user"></i>
                            </p>
                            <p class="price">{{ $course->price }} ريال</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $courses->links() }}
        </div>

    </div>

    @include('homeComponents.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
