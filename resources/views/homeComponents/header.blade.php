<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/website.css') }}">
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    @php
        $entrepreneurship = App\Models\Section::where('type', 'entrepreneurship_program')->get();
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
                    <a href="{{ route('notifications.index') }}" class="nav-icon position-relative">
                        <i class="fas fa-bell"></i>
                        @if (Auth::user()->user_notifications()->where('is_read', false)->count() > 0)
                            <span
                                class="notification-badge">{{ Auth::user()->user_notifications()->where('is_read', false)->count() }}</span>
                        @endif
                    </a>

                    <!-- الرسائل -->
                    <a href="{{ route('chat') }}" class="nav-icon position-relative">
                        <i class="fas fa-envelope"></i>
                        @if (Auth::user()->unreadMessages()->count() > 0)
                            <span class="notification-badge">{{ Auth::user()->unreadMessages()->count() }}</span>
                        @endif
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
                        <a class="nav-link {{ Route::currentRouteName() == 'all-courses' && !request()->route('category_id') ? 'active' : '' }}"
                            href="{{ route('all-courses') }}">الدورات</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Route::currentRouteName() == 'all-courses' && request()->route('category_id') ? 'active' : '' }}"
                            href="#" data-toggle="dropdown">
                            البرامج التدريبية
                        </a>
                        <ul class="dropdown-menu">
                            @foreach (App\Models\Category::where('status', 'active')->get() as $category)
                                <li>
                                    <a class="dropdown-item {{ request()->route('category_id') == $category->id ? 'active' : '' }}"
                                        href="{{ route('all-courses', $category->id) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">المسارات</a>
                        {{-- <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">برنامج رياده</a> --}}
                        <ul class="dropdown-menu">
                            @foreach (App\Models\Route::all() as $path)
                                <li>
                                    <a class="dropdown-item" href="{{ route('routes.courses', $path->id) }}">
                                        {{ $path->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        @if (
                            (Auth::check() && Auth::user()->entrepreneurshipPrograms->count() > 1) ||
                                Auth::user()?->role === 'admin' ||
                                Auth::user()?->role === 'supervisor')
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                برنامج رياده
                            </a>
                            <ul class="dropdown-menu">
                                @php
                                    $sections =
                                        Auth::user()?->role === 'admin' || Auth::user()?->role === 'supervisor'
                                            ? $entrepreneurship
                                            : Auth::user()->entrepreneurshipPrograms;
                                @endphp
                                @foreach ($entrepreneurship as $section)
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
                                برنامج رياده
                            </a>
                        @endif
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
                                            ? \App\Models\Section::where('type', 'ambitious_program')->get()
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
