<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-ct.png') }}">

    <title>منصة الرواد التعليمية</title>
    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #072D38;
            color: white;
            margin: 0;
            padding-top: 100px;
            justify-content: space-between;

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

        .dropdown-toggle-sort {
            background-color: #fed8b1;
            color: #a84907;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .dropdown-toggle-sort-sort:hover {
            background-color: #FDE8CE;
        }
    </style>
</head>

<body>
    <!-- Header -->
    @include('homeComponents.header')

    <!-- Sort Section -->
    <div class="sort-section">
        <h5>الدورات</h5>
        <div class="dropdown" style="flex-direction: row-reverse; display: flex; align-items: center;">
            <h3 class="sort-title">ترتيب حسب</h3>
            <button class="dropdown-toggle-sort" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                المضاف حديثاً
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">الأكثر مشاهدة</a></li>
                <li><a class="dropdown-item" href="#">الأعلى تقييمًا</a></li>
                <li><a class="dropdown-item" href="#">الأحدث</a></li>
            </ul>
        </div>
    </div>

    <!-- Courses Section -->
    <div class="container my-4">
        <div class="row" style="direction: rtl;">
            @foreach ($courses as $course)
                @include('homeComponents.home.course-card')
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination">
            {{ $courses->links() }}
        </div>

    </div>

    <!-- Footer -->
    @include('homeComponents.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
