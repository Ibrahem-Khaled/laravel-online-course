<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* تخصيصات عامة */
    body {
        padding-top: 70px;
    }

    /* تخصيص شريط التمرير */
    body::-webkit-scrollbar {
        width: 10px;
    }

    body::-webkit-scrollbar-track {
        background: #01222d;
    }

    body::-webkit-scrollbar-thumb {
        background-color: #ed6b2f;
        border: 2px solid #01222d;
        border-radius: 5px;
    }

    /* تصميم النافبار */
    .navbar {
        background: linear-gradient(45deg, #035971, #01222d);
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
        padding: 0.5rem 1rem;
    }

    /* تنسيق اللوجو */
    .navbar-brand img {
        width: 45px;
        transition: transform 0.3s;
    }

    .navbar-brand:hover img {
        transform: rotate(15deg);
    }

    /* تنسيق الأقسام الرئيسية */
    .navbar-content {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    /* القائمة المركزية */
    .main-menu {
        display: flex;
        justify-content: center;
        flex-grow: 1;
    }

    /* الجزء الأيسر (المستخدم) */
    .left-section {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    /* العناصر العامة */
    .nav-item {
        margin: 0 1rem;
    }

    .nav-link {
        color: white !important;
        font-weight: 500;
        transition: all 0.3s;
    }

    .nav-link:hover {
        color: #ed6b2f !important;
        transform: translateY(-2px);
    }

    .nav-link.active {
        color: #ed6b2f !important;
        text-shadow: 0 0 10px rgba(237, 107, 47, 0.5);
        text-decoration: underline;
    }

    /* القوائم المنسدلة */
    .dropdown-menu {
        background: #072D38;
        border: 1px solid #055160;
        border-radius: 10px;
        text-align: right;
    }

    .dropdown-item {
        color: white !important;
        padding: 0.5rem 0.5rem;
        transition: all 0.3s;
        display: flex;
        justify-content: space-between;
    }

    .dropdown-item:hover {
        background: #055160;
        padding-left: 2rem;
    }

    /* الإشعارات والرسائل */
    .notification-badge {
        position: absolute;
        top: -5px;
        left: -5px;
        background: #ff4757;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-icon {
        font-size: 1.3rem;
        color: white;
        position: relative;
        transition: all 0.3s;
    }

    .nav-icon:hover {
        color: #ed6b2f;
        transform: scale(1.1);
    }

    /* تصميم الجوال */
    @media (max-width: 992px) {
        .navbar-content {
            flex-wrap: wrap;
        }

        .main-menu {
            order: 3;
            width: 100%;
            margin-top: 1rem;
            flex-direction: column;
            text-align: center;
        }

        .left-section {
            order: 1;
            margin-left: auto;
        }

        .navbar-brand {
            order: 2;
            margin: 0 auto;
        }

        .navbar-toggler {
            order: 0;
        }

        .nav-item {
            margin: 0.5rem 0;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    @php
        $sections = App\Models\Section::all();
    @endphp
    <div class="container-fluid">
        <div class="navbar-content">
            <!-- الجزء الأيسر (المستخدم) -->
            <div class="left-section">
                @auth
                    <!-- حساب المستخدم -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown">
                            <img src="{{ Auth::user()->profile_image }}" class="rounded-circle user-avatar"
                                style="width:35px;height:35px;object-fit:cover;margin-right:10px;">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i
                                        class="fas fa-user me-2"></i>الملف الشخصي</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.setting') }}"><i
                                        class="fas fa-cog me-2"></i>الإعدادات</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'supervisor')
                                <li><a class="dropdown-item" href="{{ route('home.dashboard') }}"><i
                                            class="fas fa-chart-line me-2"></i>لوحة التحكم</a></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit"><i
                                            class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <!-- الإشعارات -->
                    <a href="#" class="nav-icon position-relative">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </a>

                    <!-- الرسائل -->
                    <a href="{{ route('chat') }}" class="nav-icon position-relative">
                        <i class="fas fa-envelope"></i>
                        <span class="notification-badge">5</span>
                    </a>
                @else
                    <a class="btn btn-action text-white" style="background-color: #ed6b2f" href="{{ route('login') }}">
                        <i class="fas fa-rocket me-2"></i>ابدأ التجربة
                    </a>
                @endauth
            </div>

            <!-- القائمة الرئيسية -->
            <div class="collapse navbar-collapse main-menu">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'all-courses' ? 'active' : '' }}"
                            href="{{ route('all-courses') }}">الدورات</a>
                    </li>
                    <li class="nav-item dropdown">
                        @if (
                            (Auth::check() && Auth::user()->sections->count() > 1) ||
                                Auth::user()?->role === 'admin' ||
                                Auth::user()?->role === 'supervisor')
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                برنامج طموح
                            </a>
                            <ul class="dropdown-menu">
                                @php
                                    $sections =
                                        Auth::user()?->role === 'admin' || Auth::user()?->role === 'supervisor'
                                            ? \App\Models\Section::all()
                                            : Auth::user()->sections;
                                @endphp
                                @foreach ($sections as $section)
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('user-section', ['section_id' => $section->id]) }}">
                                            {{ $section->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a class="nav-link {{ Route::currentRouteName() == 'user-section' ? 'active' : '' }}"
                                href="{{ route('user-section') }}">
                                برنامج طموح
                            </a>
                        @endif
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            البرامج التدريبية
                        </a>
                        <ul class="dropdown-menu">
                            @foreach (App\Models\Category::all() as $category)
                                <li>
                                    <a class="dropdown-item" href="{{ route('all-courses', $category->id) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">المسارات</a>
                        <ul class="dropdown-menu">
                            @foreach (App\Models\Route::all() as $path)
                                <li>
                                    <a class="dropdown-item" href="{{ route('all-courses', $path->id) }}">
                                        {{ $path->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                            href="{{ route('home') }}">الرئيسية</a>
                    </li>
                </ul>
            </div>

            <!-- اللوجو -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo-ct.png') }}" alt="Logo">
            </a>

            <!-- زر القائمة للجوال -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".main-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>
