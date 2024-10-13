<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المستخدمين</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Fonts and icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #f8f9fa;
        }

        .user-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .user-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.2);
        }

        .user-card img {
            border-radius: 50%;
            margin-bottom: 15px;
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .user-card h5 {
            font-weight: 700;
            color: #333;
        }

        .user-card p {
            color: #777;
            margin-bottom: 10px;
        }

        .user-card .btn {
            background-color: #8B4513;
            color: #fff;
            border-radius: 10px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .user-card .btn:hover {
            background-color: #6c3413;
            color: #fff;
        }

        .user-container {
            padding: 50px 0;
            flex-direction: column;
        }

        .user-container h2 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: 700;
            color: #8B4513;
        }

        .search-filter {
            margin-bottom: 30px;
        }

        .search-filter input,
        .search-filter select {
            border-radius: 10px;
            padding: 10px;
            margin-right: 10px;
        }

        .search-filter button {
            border-radius: 10px;
            padding: 10px 20px;
            background-color: #8B4513;
            color: white;
        }
    </style>
</head>

<body>
    @include('homeLayouts.nav-bar')
    @include('homeLayouts.hero-section')
    @include('homeLayouts.about-us')

    <div class="container user-container">
        <h2>قائمة المحامين</h2>

        <!-- مربع البحث والفلترة -->
        <div class="row search-filter">
            <form action="{{ route('home') }}" method="GET" class="d-flex">
                <input type="text" name="name" class="form-control me-2" placeholder="ابحث عن الاسم"
                    value="{{ request('name') }}">
                <input type="text" name="email" class="form-control me-2" placeholder="ابحث عن البريد الإلكتروني"
                    value="{{ request('email') }}">
                <input type="text" name="username" class="form-control me-2" placeholder="ابحث عن اسم المستخدم"
                    value="{{ request('username') }}">
                <input type="text" name="city" class="form-control me-2" placeholder="ابحث عن المدينة"
                    value="{{ request('city') }}">
                <select name="country" class="form-control me-2">
                    <option value="">اختر الدولة</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->country }}"
                            {{ request('country') == $country->country ? 'selected' : '' }}>
                            {{ $country->country }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn">بحث</button>
            </form>
        </div>

        <div class="row">
            @foreach ($users as $user)
                <div class="col-md-4 mb-4">
                    <div class="user-card">
                        <img src="{{ $user->avatar ? asset( $user->avatar) : asset('assets/img/logo-ct.png') }}"
                            alt="User Image">
                        <h5>{{ $user->name }}</h5>
                        <p>{{ $user->email }}</p>
                        <p>{{ $user->city }}, {{ $user->country }}</p>
                        <p>+{{ $user->phone }}</p>
                        <a href="{{ route('profile', $user->id) }}" class="btn">التفاصيل</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('homeLayouts.subscription-section', ['plans' => $plans])
    @include('homeLayouts.contact-us')
    @include('homeLayouts.footer')

    <!-- جافا سكريبت -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
