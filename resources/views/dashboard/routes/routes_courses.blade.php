@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid py-4">
        <!-- عنوان الصفحة مع زر الإضافة -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-book-open text-primary"></i> إدارة كورسات المسار: {{ $route->name }}
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('routes.index') }}">المسارات التعليمية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">كورسات المسار</li>
                    </ol>
                </nav>
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourseModal">
                <i class="fas fa-plus"></i> إضافة كورس جديد
            </button>
        </div>

        @include('homeComponents.alerts')

        <!-- إحصائيات الكورسات -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    إجمالي الكورسات</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $route->courses->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    متوسط الدروس لكل كورس</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $avgLessonsPerCourse }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list-ol fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    أحدث كورس مضاف</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $latestCourse->title ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    كورسات جديدة هذا الشهر</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newCoursesThisMonth }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-star fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول الكورسات -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">قائمة الكورسات</h6>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter"></i> تصفية
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">الكل</a>
                        <a class="dropdown-item" href="#">الأحدث</a>
                        <a class="dropdown-item" href="#">الأكثر تفاعلاً</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="coursesTable" width="100%" cellspacing="0">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>اسم الكورس</th>
                                <th>الوصف</th>
                                <th>تاريخ الإضافة</th>
                                <th width="15%">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($route->courses as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $course->image ?? 'https://via.placeholder.com/40' }}"
                                                alt="{{ $course->title }}" class="rounded-circle mr-3" width="40"
                                                height="40">
                                            <strong>{{ $course->title }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $course->description ? Str::limit($course->description, 70) : 'لا يوجد وصف' }}
                                    </td>
                                    <td>{{ $course->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-sm btn-warning mx-1" data-toggle="modal"
                                                data-target="#editCourseModal{{ $course->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('route_courses.destroy', $course->pivot->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mx-1"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا الكورس من المسار؟')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal تعديل الكورس -->
                                <div class="modal fade" id="editCourseModal{{ $course->id }}" tabindex="-1"
                                    aria-labelledby="editCourseModalLabel{{ $course->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="editCourseModalLabel{{ $course->id }}">
                                                    <i class="fas fa-edit"></i> تعديل الكورس: {{ $course->title }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('route_courses.update', $course->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <input type="hidden" name="route_id" value="{{ $route->id }}">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="course_id">اختر كورس</label>
                                                                <select name="course_id" id="course_id"
                                                                    class="form-control select2" required>
                                                                    @foreach ($courses as $c)
                                                                        <option value="{{ $c->id }}"
                                                                            {{ $c->id == $course->id ? 'selected' : '' }}>
                                                                            {{ $c->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>الحالة الحالية</label>
                                                                <div class="alert alert-info p-2">
                                                                    <i class="fas fa-info-circle"></i> سيتم استبدال الكورس
                                                                    الحالي بالكورس المحدد
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">
                                                        <i class="fas fa-times"></i> إلغاء
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save"></i> حفظ التغييرات
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal إضافة كورس جديد -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addCourseModalLabel">
                        <i class="fas fa-plus"></i> إضافة كورس جديد إلى {{ $route->name }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('route_courses.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="route_id" value="{{ $route->id }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="course_id">اختر كورس</label>
                                    <select name="course_id" id="course_id" class="form-control select2" required>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>عدد الكورسات المتاحة</label>
                                    <div class="alert alert-success p-2">
                                        <i class="fas fa-book"></i> {{ $courses->count() }} كورس متاح
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> إلغاء
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> إضافة الكورس
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // تفعيل Select2
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "اختر كورس",
                language: {
                    noResults: function() {
                        return "لا توجد نتائج";
                    }
                }
            });

            // تفعيل جدول البيانات
            $('#coursesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Arabic.json'
                },
                responsive: true,
                order: [
                    [3, 'desc']
                ]
            });
        });
    </script>
@endsection
