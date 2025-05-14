<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">لوحة التحكم</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Items -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>المنصة التعليمية</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>الرئيسية</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>إدارة المستخدمين</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('categories.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>إدارة التصنيفات</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('courses.index') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>إدارة الدورات</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sections.index') }}">
            <i class="fas fa-fw fa-columns"></i>
            <span>إدارة الفصول<br>(جميع البرامج)</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('contact_us.index') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>إدارة التواصل</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('course_ratings.index') }}">
            <i class="fas fa-fw fa-star"></i>
            <span>إدارة التقييمات</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('course_videos.index') }}">
            <i class="fas fa-fw fa-video"></i>
            <span>إدارة الفيديو للدورات</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('routes.index') }}">
            <i class="fas fa-fw fa-road"></i>
            <span>إدارة المسارات</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
