@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="my-4">إدارة الدورات</h1>

        <!-- زر إضافة دورة جديدة -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCourseModal">إضافة دورة جديدة</button>
            
        @include('homeComponents.alerts')

        <ul class="nav nav-tabs mb-4" id="courseStatusTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="active-tab" data-toggle="tab" data-target="#active" type="button"
                    role="tab" aria-controls="active" aria-selected="true">نشطة</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="inactive-tab" data-toggle="tab" data-target="#inactive" type="button"
                    role="tab" aria-controls="inactive" aria-selected="false">غير نشطة</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="draft-tab" data-toggle="tab" data-target="#draft" type="button" role="tab"
                    aria-controls="draft" aria-selected="false">دورات برنامج طموح</button>
            </li>
        </ul>
        <div class="tab-content" id="courseStatusTabsContent">
            <!-- تبويب الدورات النشطة -->
            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                @include('dashboard.courses.table', ['courses' => $courses->where('status', 'active')])
            </div>

            <!-- تبويب الدورات غير النشطة -->
            <div class="tab-pane fade" id="inactive" role="tabpanel" aria-labelledby="inactive-tab">
                @include('dashboard.courses.table', ['courses' => $courses->where('status', 'inactive')])
            </div>

            <!-- تبويب الدورات المسودة -->
            <div class="tab-pane fade" id="draft" role="tabpanel" aria-labelledby="draft-tab">
                @include('dashboard.courses.table', ['courses' => $courses->where('status', 'draft')])
            </div>
        </div>
        <!-- Add Course Modal -->
        <div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة دورة جديدة</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">المستخدم</label>
                                <select name="user_id" class="form-select" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">الفئة</label>
                                <select name="category_id" class="form-select" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">العنوان</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">السعر</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="duration_in_hours" class="form-label">المدة (بالساعات)</label>
                                <input type="number" name="duration_in_hours" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="difficulty_level" class="form-label">مستوى الصعوبة</label>
                                <select name="difficulty_level" class="form-select" required>
                                    <option value="beginner">مبتدئ</option>
                                    <option value="intermediate">متوسط</option>
                                    <option value="advanced">متقدم</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="language" class="form-label">اللغة</label>
                                <input type="text" name="language" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">الحالة</label>
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
                                    <option value="question">يجب ان يجيب علي سوال الواجب</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="is_featured" class="form-label">مميز</label>
                                <select name="is_featured" class="form-select" required>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">صورة الدورة</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Excel Modal -->

    </div>
@endsection
