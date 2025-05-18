@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <!-- رأس الصفحة -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h3 mb-2">دورات قسم: <span class="text-primary">{{ $section->name }}</span></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sections.index') }}">الأقسام</a></li>
                        <li class="breadcrumb-item active" aria-current="page">دورات القسم</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('sections.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>العودة للأقسام
            </a>
        </div>

        <!-- إحصائيات القسم -->
        <div class="row mb-5">
            <x-stat-card title="إجمالي الدورات" count="{{ $stats['total_courses'] }}" icon="book" color="primary" />
            <x-stat-card title="دورات نشطة" count="{{ $stats['active_courses'] }}" icon="check-circle" color="success" />
            <x-stat-card title="  إجمالي الطلاب" count="{{ $stats['total_students'] }}" icon="users" color="info" />
        </div>

        <!-- محتوى الصفحة -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">قائمة الدورات</h6>
                <div class="d-flex gap-2">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" id="searchInput" class="form-control" placeholder="بحث في الدورات...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($courses->isEmpty())
                    <div class="text-center py-5">
                        <img src="{{ asset('assets/img/empty.svg') }}" alt="لا يوجد دورات" style="height: 150px;"
                            class="mb-4">
                        <h5 class="text-gray-800">لا توجد دورات في هذا القسم</h5>
                        <p class="text-muted">يمكنك إضافة دورات جديدة باستخدام زر "إضافة دورة" بالأعلى</p>
                    </div>
                @else
                    <div class="row">
                        @foreach ($courses as $course)
                            <div class="col-lg-4 col-md-6 mb-4 course-card">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('assets/img/logo-ct.png') }}"
                                            loading="lazy" class="card-img-top" alt="{{ $course->title }}"
                                            style="height: 180px; object-fit: cover;">
                                        <span
                                            class="position-absolute top-0 end-0 m-2 badge bg-{{ $course->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ $course->status == 'active' ? 'نشطة' : 'غير نشطة' }}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title mb-0">{{ $course->title }}</h5>
                                            @if ($course->is_featured)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-star"></i> مميزة
                                                </span>
                                            @endif
                                        </div>
                                        <p class="card-text text-muted small">
                                            {{ Str::limit($course->description, 100) }}
                                        </p>
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ $course->user->avatar_url ?: asset('assets/img/avatar-placeholder.png') }}"
                                                alt="{{ $course->user->name }}" class="rounded-circle me-2" width="30"
                                                height="30">
                                            <small class="text-muted">{{ $course->user->name }}</small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-light text-dark me-2">
                                                    <i class="fas fa-play-circle text-primary me-1"></i>
                                                    {{ $course->lessons_count }} دروس
                                                </span>
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-users text-info me-1"></i>
                                                    {{ $course->enrollments_count }} طلاب
                                                </span>
                                            </div>
                                            <span class="badge bg-light text-dark">
                                                {{ ucfirst($course->difficulty_level) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                                        <a href="{{ route('courses.show', $course) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> عرض
                                        </a>
                                        <form
                                            action="{{ route('sections.removeCourse', ['section' => $section, 'course' => $course]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('هل أنت متأكد من إزالة هذه الدورة من القسم؟')">
                                                <i class="fas fa-times me-1"></i> إزالة
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- الترقيم -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $courses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }

            .course-card .card-img-top {
                transition: opacity 0.3s ease;
            }

            .course-card:hover .card-img-top {
                opacity: 0.9;
            }

            .breadcrumb {
                background-color: transparent;
                padding: 0;
            }

            .border-start-lg {
                border-left-width: 0.25rem !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // عرض وصف الدورة عند الاختيار
            document.getElementById('course_id').addEventListener('change', function() {
                const descriptionBox = document.getElementById('courseDescription');
                const descriptionText = document.getElementById('selectedCourseDescription');

                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    descriptionText.textContent = selectedOption.getAttribute('data-desc');
                    descriptionBox.style.display = 'block';
                } else {
                    descriptionBox.style.display = 'none';
                }
            });

            // وظيفة البحث في الدورات
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const courseCards = document.querySelectorAll('.course-card');

                courseCards.forEach(card => {
                    const title = card.querySelector('.card-title').textContent.toLowerCase();
                    const description = card.querySelector('.card-text').textContent.toLowerCase();

                    if (title.includes(searchTerm) || description.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection
