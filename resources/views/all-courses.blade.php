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

    <title>{{ env('APP_NAME') }}</title>
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

        .load-more-btn {
            background-color: #ed6b2f;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px auto;
            display: block;
        }

        .load-more-btn:hover {
            background-color: #d45a1f;
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
            <button class="dropdown-toggle-sort" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
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
        <div class="row" style="direction: rtl;" id="courses-container">
            @if ($courses->count() > 0)
                @foreach ($courses as $course)
                    @include('homeComponents.home.course-card')
                @endforeach
            @else
                <div class="text-center mt-5">
                    <h3 style="color: #fed8b1;">لا توجد دورات متاحة حالياً</h3>
                    <p style="color: #ffffff;">يمكنك التحقق لاحقاً أو التواصل معنا للحصول على المزيد من التفاصيل.</p>
                    <button class="btn mt-3 w-50 text-white" style="background-color: #ed6b2f;"
                        onclick="window.location.href='#'">
                        تواصل معنا
                    </button>
                </div>
            @endif
        </div>

        <!-- Load More Button -->
        @if ($courses->count() > 0)
            <button id="load-more-btn" class="load-more-btn w-50 text-white" style="background-color: #ed6b2f;"
                data-page="2">المزيد</button>
        @endif
    </div>

    <!-- Footer -->
    @include('homeComponents.footer')

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#load-more-btn').click(function() {
                var page = $(this).data('page'); // الصفحة التالية
                var url = "{{ route('all-courses') }}?page=" + page; // الرابط مع الصفحة

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.courses.length > 0) {
                            $('#courses-container').append(response
                                .courses); // إضافة الدورات الجديدة
                            $('#load-more-btn').data('page', page + 1); // تحديث الصفحة التالية
                        } else {
                            $('#load-more-btn')
                                .hide(); // إخفاء الزر إذا لم يكن هناك المزيد من الدورات
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });

        if (response.courses.length === 0) {
            $('#load-more-btn').hide();
        }
    </script>
</body>

</html>
