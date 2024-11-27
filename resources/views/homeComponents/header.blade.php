<style>
    .navbar {
        background-color: #072D38;
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
        text-decoration: underline;
        border-radius: 5px;
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

<nav class="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/img/logo-ct.png') }}" alt="Logo" style="width: 100px; height: 60px;">
        </a>
        <div class="navbar-nav">
            <a class="nav-link {{ Route::currentRouteName() == 'user-section' ? 'active' : '' }}"
                href="{{ route('user-section') }}">برنامج طموح</a>

            <a class="nav-link {{ Route::currentRouteName() == 'all-courses' ? 'active' : '' }} "
                href="{{ route('all-courses') }}">الدورات</a>
            @php
                $categories = App\Models\Category::all();
            @endphp
            <div class="dropdown">
                <button class="nav-link dropdown-btn">
                    <i class="bi bi-list"></i>
                    البرامج التدريبية
                </button>
                <div class="dropdown-content">
                    @foreach ($categories as $category)
                        <div class="d-flex align-items-center mb-2 justify-content-between ">
                            <a href="#">{{ $category->name }}</a>
                            {{-- <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image"> --}}
                        </div>
                    @endforeach
                </div>
            </div>

            <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                href="{{ route('home') }}">الرئيسية</a>

            @auth
                <div class="dropdown">
                    <button class="btn-action dropdown-btn">الحساب
                        <i class="bi bi-person"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="#">الملف الشخصي</a>
                        <a href="#">إعدادات</a>
                        <a href="#">المساعدة</a>
                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'supervisor' || Auth::user()->role == 'teacher')
                            <a href="{{ route('home.dashboard') }}">لوحة التحكم</a>
                        @endif
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
