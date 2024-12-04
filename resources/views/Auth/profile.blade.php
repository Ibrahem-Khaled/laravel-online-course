<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي للمحامي</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-ct.png') }}">

    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #072D38;
            color: white;
            margin: 0;
            padding-top: 100px;
            text-align: right;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <div class="container mt-5">
        <div class="row">
            <!-- القسم الأيمن (الدورات) -->
            <div class="col-lg-8">
                <h3 class="mb-4">دوراتي</h3>
                <div class="row">
                    <!-- البطاقة الأولى -->
                    <div class="col-md-6 mb-4">
                        <div class="card" style="background-color: #06455E; color: white; border: none;">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="تصميم تطوير الويب">
                            <div class="card-body">
                                <h5 class="card-title">تصميم تطوير الويب</h5>
                                <p class="card-text">
                                    <i class="fas fa-user"></i> إعداد: أحمد الله الستين
                                </p>
                                <p class="card-text">
                                    <i class="fas fa-star"></i> 1347 تقييم
                                </p>
                                <p class="card-text">
                                    <i class="fas fa-money-bill"></i> 77.64 ريال
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- البطاقة الثانية -->
                    <div class="col-md-6 mb-4">
                        <div class="card" style="background-color: #06455E; color: white; border: none;">
                            <img src="https://via.placeholder.com/300x200" class="card-img-top"
                                alt="تصميم الويب سريع الاستجابة">
                            <div class="card-body">
                                <h5 class="card-title">تصميم الويب سريع الاستجابة</h5>
                                <p class="card-text">
                                    <i class="fas fa-user"></i> إعداد: يوسف باسم
                                </p>
                                <p class="card-text">
                                    <i class="fas fa-star"></i> 1937 تقييم
                                </p>
                                <p class="card-text">
                                    <i class="fas fa-money-bill"></i> 76.84 ريال
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- القسم الأيسر (المعلومات الجانبية) -->
            <div class="col-lg-4 mt-4">
                <div class="card" style="background-color: #06455E; color: white; border: none;">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4" style="flex-direction: row-reverse;">
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png' }}"
                                class="me-3" alt="صورة المستخدم" width="60" height="60"
                                style="object-fit: cover; border-radius: 10px; margin: 10px;">
                            <div>
                                <h5 class="card-title mb-1">{{ $user->name }}</h5>
                                <p class="small" style="color: #F1F1F1">{{ $user->email }}</p>
                            </div>
                        </div>
                        <button class="btn btn-outline-light w-100 mb-3">إعدادات الحساب</button>
                        <hr style="border-top: 1px solid white;">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="fas fa-graduation-cap me-2"></i> دوراتي
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-comments me-2"></i> التواصل مع المدربين
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-trophy me-2"></i> شهاداتي
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-heart me-2"></i> المفضلة
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('homeComponents.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
