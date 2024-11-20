<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .navbar {
            background-color: #062b3d;
            padding: 1rem;
        }

        .navbar-brand {
            font-weight: bold;
            color: white;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            margin-left: 50%;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            flex-direction: row;
            justify-content: space-evenly;
            width: 80%;
        }

        .navbar-nav .nav-link {
            color: white;
            margin-right: 22px;
            text-decoration: none;
        }

        .navbar-nav .nav-link:hover {
            color: #ed6b2f;
        }

        .navbar-nav .nav-link.active {
            color: #ed6b2f;
            font-weight: bold;
            text-decoration: underline;
        }

        .btn-action {
            background-color: #287c8d;
            color: white;
            padding: 0.5rem 1.2rem;
            border: none;
            border-radius: 20px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-action:hover {
            background-color: #1f6674;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content button {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropdown-btn {
            background-color: #1f6674;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/img/logo-ct.png') }}" alt="Logo" style="width: 100px; height: 60px;">
            </a>
            <div class="navbar-nav">
                <a class="nav-link" href="#">برنامج طموح</a>
                <a class="nav-link {{ Route::currentRouteName() == 'all-courses' ? 'active' : '' }} "
                    href="{{ route('all-courses') }}">الدورات</a>
                <a class="nav-link " href="#">البرامج التدريبية</a>
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                    href="{{ route('home') }}">الرئيسية</a>

                @auth
                    <div class="dropdown">
                        <button class="btn-action dropdown-btn">الحساب</button>
                        <div class="dropdown-content">
                            <a href="#">الملف الشخصي</a>
                            <a href="#">إعدادات</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">تسجيل الخروج</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a class="btn-action" href="{{ route('login') }}">ابدأ النسخة التجريبية</a>
                @endauth
            </div>
        </div>
    </nav>
</body>

</html>
