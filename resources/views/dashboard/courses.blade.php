@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="my-4">إدارة الدورات</h1>

        <!-- زر إضافة دورة جديدة -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">إضافة دورة جديدة</button>

        <!-- عرض الرسائل -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- جدول عرض الدورات -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>المستخدم</th>
                    <th>الفئة</th>
                    <th>السعر</th>
                    <th>المدة (ساعات)</th>
                    <th>المستوى</th>
                    <th>اللغة</th>
                    <th>الحالة</th>
                    <th>مميز</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td><a href="{{ route('course_videos.by_course', $course->id) }}">{{ $course->title }}</a></td>
                        <td>{{ $course->user->name }}</td>
                        <td>{{ $course->category->name }}</td>
                        <td>{{ $course->price }} $</td>
                        <td>{{ $course->duration_in_hours }}</td>
                        <td>{{ ucfirst($course->difficulty_level) }}</td>
                        <td>{{ $course->language }}</td>
                        <td>{{ ucfirst($course->status) }}</td>
                        <td>{{ $course->is_featured ? 'نعم' : 'لا' }}</td>
                        <td>
                            <!-- زر تعديل الدورة -->
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editCourseModal{{ $course->id }}">تعديل</button>

                            <!-- نموذج حذف الدورة -->
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal تعديل الدورة -->
                    <div class="modal fade" id="editCourseModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('courses.update', $course->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">تعديل الدورة</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="user_id" class="form-label">المستخدم</label>
                                            <select name="user_id" class="form-select" required>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $user->id == $course->user_id ? 'selected' : '' }}>
                                                        {{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">الفئة</label>
                                            <select name="category_id" class="form-select" required>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $course->category_id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="title" class="form-label">العنوان</label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{ $course->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">الوصف</label>
                                            <textarea name="description" class="form-control" rows="3" required>{{ $course->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">السعر</label>
                                            <input type="number" step="0.01" name="price" class="form-control"
                                                value="{{ $course->price }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="duration_in_hours" class="form-label">المدة (بالساعات)</label>
                                            <input type="number" name="duration_in_hours" class="form-control"
                                                value="{{ $course->duration_in_hours }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="difficulty_level" class="form-label">مستوى الصعوبة</label>
                                            <select name="difficulty_level" class="form-select" required>
                                                <option value="beginner"
                                                    {{ $course->difficulty_level == 'beginner' ? 'selected' : '' }}>مبتدئ
                                                </option>
                                                <option value="intermediate"
                                                    {{ $course->difficulty_level == 'intermediate' ? 'selected' : '' }}>
                                                    متوسط</option>
                                                <option value="advanced"
                                                    {{ $course->difficulty_level == 'advanced' ? 'selected' : '' }}>متقدم
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="language" class="form-label">اللغة</label>
                                            <input type="text" name="language" class="form-control"
                                                value="{{ $course->language }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">الحالة</label>
                                            <select name="status" class="form-select" required>
                                                <option value="active" {{ $course->status == 'active' ? 'selected' : '' }}>
                                                    نشطة</option>
                                                <option value="inactive"
                                                    {{ $course->status == 'inactive' ? 'selected' : '' }}>غير نشطة</option>
                                                <option value="draft" {{ $course->status == 'draft' ? 'selected' : '' }}>
                                                    مسودة</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="is_featured" class="form-label">مميز</label>
                                            <select name="is_featured" class="form-select" required>
                                                <option value="1" {{ $course->is_featured ? 'selected' : '' }}>نعم
                                                </option>
                                                <option value="0" {{ !$course->is_featured ? 'selected' : '' }}>لا
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">صورة الدورة</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Add Course Modal -->
        <div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة دورة جديدة</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
