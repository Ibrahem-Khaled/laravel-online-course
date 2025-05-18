@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="my-4">إدارة الدورات</h1>

        <!-- قسم الإحصائيات -->
        <div class="row mb-4">
            <x-stat-card title="إجمالي الدورات" count="{{ $stats['total_courses'] }}" icon="book" color="primary" />
            <x-stat-card title="دورات نشطة" count="{{ $stats['active_courses'] }}" icon="check-circle" color="success" />
            <x-stat-card title="دورات غير نشطة" count="{{ $stats['inactive_courses'] }}" icon="pause-circle"
                color="warning" />
            <x-stat-card title="دورات مميزة" count="{{ $stats['featured_courses'] }}" icon="star" color="info" />

        </div>

        <!-- فئات شائعة -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">أكثر الفئات شعبية</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($stats['popular_categories'] as $category)
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-folder-open fa-2x text-secondary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">{{ $category->name }}</h6>
                                    <small class="text-muted">{{ $category->courses_count }} دورة</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- زر إضافة دورة جديدة -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCourseModal">
            <i class="fas fa-plus me-2"></i>إضافة دورة جديدة
        </button>

        @include('components.alerts')

        <ul class="nav nav-tabs mb-4" id="courseStatusTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="active-tab" data-toggle="tab" data-target="#active" type="button"
                    role="tab" aria-controls="active" aria-selected="true">نشطة</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="inactive-tab" data-toggle="tab" data-target="#inactive" type="button"
                    role="tab" aria-controls="inactive" aria-selected="false">غير نشطة</button>
            </li>
        </ul>
        <div class="tab-content" id="courseStatusTabsContent">
            <!-- تبويب الدورات النشطة -->
            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                @include('dashboard.courses.table', ['courses' => $activeCourses])
                <div class="d-flex justify-content-center mt-4">
                    {{ $activeCourses->appends(['inactive_page' => request('inactive_page')])->links() }}
                </div>
            </div>

            <!-- تبويب الدورات غير النشطة -->
            <div class="tab-pane fade" id="inactive" role="tabpanel" aria-labelledby="inactive-tab">
                @include('dashboard.courses.table', ['courses' => $inactiveCourses])

                <div class="d-flex justify-content-center mt-4">
                    {{ $inactiveCourses->appends(['active_page' => request('active_page')])->links() }}
                </div>
            </div>
        </div>

        <!-- Pagination -->
        {{-- <div class="d-flex justify-content-center mt-4">
            {{ $courses->links() }}
        </div> --}}

        <!-- Add Course Modal -->
        <div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة دورة جديدة</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">المعلم</label>
                                        <select name="user_id" class="form-select" required>
                                            <option value="">اختر المعلم</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">الفئة</label>
                                        <select name="category_id" class="form-select" required>
                                            <option value="">اختر الفئة</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="title" class="form-label">عنوان الدورة</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="language" class="form-label">اللغة</label>
                                        <input type="text" name="language" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="difficulty_level" class="form-label">مستوى الصعوبة</label>
                                        <select name="difficulty_level" class="form-select" required>
                                            <option value="beginner">مبتدئ</option>
                                            <option value="intermediate">متوسط</option>
                                            <option value="advanced">متقدم</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">حالة الدورة</label>
                                        <select name="status" class="form-select" required>
                                            <option value="active">نشطة</option>
                                            <option value="inactive">غير نشطة</option>
                                            <option value="draft">مسودة</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="type" class="form-label">نوع الدورة</label>
                                        <select name="type" class="form-select" required>
                                            <option value="open">مفتوحة</option>
                                            <option value="closed">مغلقة</option>
                                            <option value="question">مسابقة واجب</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="is_featured" class="form-label">دورة مميزة</label>
                                        <select name="is_featured" class="form-select" required>
                                            <option value="1">نعم</option>
                                            <option value="0">لا</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">وصف الدورة</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">صورة الدورة</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted">الصورة المثالية تكون بأبعاد 800x450 بكسل</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">حفظ الدورة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .stat-card {
            transition: transform 0.3s ease;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .nav-tabs .nav-link {
            font-weight: 600;
        }

        .nav-tabs .nav-link.active {
            border-bottom: 3px solid #0d6efd;
        }
    </style>
@endpush
