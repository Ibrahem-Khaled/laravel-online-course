<style>
    .navbar {
        background-color: #035971;
        direction: rtl;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 999;
    }

    .navbar-brand {
        margin-left: auto;
        /* يجعل اللوجو في أقصى اليمين */
    }

    .navbar-brand img {
        width: 150px;
        height: auto;
    }

    .navbar-nav {
        margin: auto;
        width: 80%;
        justify-content: space-between;
    }

    .nav-link {
        color: white !important;
        margin-left: 10px;
        /* لإضافة مسافة بين الروابط */
    }

    .nav-link:hover {
        color: #ed6b2f !important;
    }

    .nav-link.active {
        color: #ed6b2f !important;
        text-decoration: underline;
    }

    .dropdown-menu {
        background-color: #072D38;
        text-align: right;
        /* يجعل النصوص في القوائم المنسدلة تظهر على اليمين */
    }

    .dropdown-menu .dropdown-item {
        color: white !important;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #055160;
    }

    .btn-action {
        background-color: #287c8d;
        color: white;
        border-radius: 20px;
        padding: 5px 15px;
    }

    .btn-action:hover {
        background-color: #1f6674;
    }

    /* التخصيص لنسخة الجوال */
    @media (max-width: 768px) {
        .navbar {
            text-align: center;
        }

        .navbar-nav {
            margin: 0 auto;
        }

        .dropdown-menu {
            width: 100%;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <!-- اللوجو -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo-ct.png') }}" alt="Logo">
        </a>

        <!-- زر القائمة للهاتف -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- عناصر القائمة -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                        href="{{ route('home') }}">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'all-courses' ? 'active' : '' }}"
                        href="{{ route('all-courses') }}">الدورات</a>
                </li>
                <li class="nav-item dropdown">
                    @if (
                        (Auth::check() && Auth::user()->sections->count() > 1) ||
                            Auth::user()?->role === 'admin' ||
                            Auth::user()?->role === 'supervisor')
                        <a class="nav-link dropdown-toggle" href="#" id="userSections" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            برنامج طموح
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userSections">
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
                    <a class="nav-link dropdown-toggle" href="#" id="programDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        البرامج التدريبية
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="programDropdown">
                        @php
                            $categories = App\Models\Category::all();
                        @endphp
                        @foreach ($categories as $category)
                            <li><a class="dropdown-item"
                                    href="{{ route('all-courses', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}">الملف الشخصي</a></li>
                            <li><a class="dropdown-item" href="#">إعدادات</a></li>
                            <li><a class="dropdown-item" href="#">المساعدة</a></li>

                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'supervisor')
                                <li><a class="dropdown-item" href="{{ route('home.dashboard') }}">لوحة التحكم</a></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">تسجيل الخروج</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-action" href="{{ route('login') }}">ابدأ النسخة التجريبية</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
