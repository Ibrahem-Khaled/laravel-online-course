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

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        الإدارة الرئيسية
    </div>

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
        <a class="nav-link" href="{{ route('routes.index') }}">
            <i class="fas fa-fw fa-road"></i>
            <span>إدارة المسارات</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu (Courses Management) -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCourses"
            aria-expanded="true" aria-controls="collapseCourses">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>إدارة الدورات والمحتوى</span>
        </a>
        <div id="collapseCourses" class="collapse" aria-labelledby="headingCourses" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">إدارة شاملة للدورات:</h6>
                <a class="collapse-item" href="{{ route('courses.index') }}">
                    <i class="fas fa-fw fa-book"></i>
                    <span>الدورات</span>
                </a>
                <a class="collapse-item" href="{{ route('instructors.index') }}">
                    <i class="fas fa-fw fa-chalkboard-teacher"></i>
                    <span>المدربون</span>
                </a>
                <a class="collapse-item" href="{{ route('sections.index') }}">
                    <i class="fas fa-fw fa-columns"></i>
                    <span>الفصول</span>
                </a>
                <a class="collapse-item" href="{{ route('course_videos.index') }}">
                    <i class="fas fa-fw fa-video"></i>
                    <span>الفيديوهات</span>
                </a>
                <a class="collapse-item" href="{{ route('course_ratings.index') }}">
                    <i class="fas fa-fw fa-star"></i>
                    <span>التقييمات</span>
                </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

     <!-- Heading -->
    <div class="sidebar-heading">
        إضافات أخرى
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('contact_us.index') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>إدارة التواصل</span>
        </a>
    </li>

    <!-- Nav Item - Pages Collapse Menu (Live & Other Additions) -->
    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-tv"></i>
            <span>لايفات وإضافات أخرى</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">اللايفات:</h6>
                <a class="collapse-item" href="{{ route('families.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>العائلات</span>
                </a>
                <a class="collapse-item" href="{{ route('live-streamings.index') }}">
                    <i class="fas fa-fw fa-tv"></i>
                    <span>اللايفات الحية</span>
                </a>
            </div>
        </div>
    </li> --}}


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
