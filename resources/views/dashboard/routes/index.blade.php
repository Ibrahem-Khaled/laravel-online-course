@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid py-4">
        <!-- عنوان الصفحة -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-route text-primary"></i> إدارة المسارات التعليمية
            </h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRouteModal">
                <i class="fas fa-plus"></i> إنشاء مسار جديد
            </button>
        </div>

        @include('homeComponents.alerts')

        <!-- إحصائيات المسارات -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    إجمالي المسارات</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $routes->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-route fa-2x text-gray-300"></i>
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
                                    المسارات النشطة</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeRoutes }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                                    متوسط الدورات لكل مسار</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $avgCoursesPerRoute }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
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
                                    أحدث مسار مضاف</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $latestRoute->name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول المسارات -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">قائمة المسارات التعليمية</h6>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter"></i> تصفية
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">الكل</a>
                        <a class="dropdown-item" href="#">الأكثر نشاطاً</a>
                        <a class="dropdown-item" href="#">الأحدث</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>اسم المسار</th>
                                <th>الفئة المستهدفة</th>
                                <th>الوصف</th>
                                <th>الصورة</th>
                                <th width="20%">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $route)
                                <tr>
                                    <td>{{ $route->id }}</td>
                                    <td>{{ $route->name }}</td>
                                    <td>{{ $route->target_group }}</td>
                                    <td>{!! $route->description !!} </td>
                                    <td class="text-center">
                                        <img src="{{ $route->image ?? 'https://via.placeholder.com/50' }}"
                                            alt="{{ $route->name }}" class="rounded-circle" width="50" height="50">
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-sm btn-warning mx-1" data-toggle="modal"
                                                data-target="#editRouteModal{{ $route->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a class="btn btn-sm btn-info mx-1"
                                                href="{{ route('route_courses.index', $route->id) }}">
                                                <i class="fas fa-book-open"></i>
                                            </a>
                                            <form action="{{ route('routes.destroy', $route->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mx-1"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا المسار؟')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal تعديل المسار -->
                                <div class="modal fade" id="editRouteModal{{ $route->id }}" tabindex="-1"
                                    aria-labelledby="editRouteModalLabel{{ $route->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="editRouteModalLabel{{ $route->id }}">
                                                    <i class="fas fa-edit"></i> تعديل المسار: {{ $route->name }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('routes.update', $route->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="edit_name{{ $route->id }}">اسم
                                                                    المسار</label>
                                                                <input type="text" name="name"
                                                                    id="edit_name{{ $route->id }}"
                                                                    class="form-control" value="{{ $route->name }}"
                                                                    required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_target_group{{ $route->id }}">الفئة
                                                                    المستهدفة</label>
                                                                <input type="text" name="target_group"
                                                                    id="edit_target_group{{ $route->id }}"
                                                                    class="form-control"
                                                                    value="{{ $route->target_group }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>الصورة الحالية</label>
                                                                <img src="{{ $route->image ?? 'https://via.placeholder.com/150' }}"
                                                                    class="img-thumbnail d-block mb-2" width="100">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="edit_image{{ $route->id }}"
                                                                        name="image">
                                                                    <label class="custom-file-label"
                                                                        for="edit_image{{ $route->id }}">اختر صورة
                                                                        جديدة</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit_description{{ $route->id }}">وصف
                                                            المسار</label>
                                                        <textarea name="description" id="edit_description{{ $route->id }}" class="form-control" rows="4">{{ $route->description }}</textarea>
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

    <!-- Modal إنشاء مسار جديد -->
    <div class="modal fade" id="createRouteModal" tabindex="-1" aria-labelledby="createRouteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createRouteModalLabel">
                        <i class="fas fa-plus"></i> إنشاء مسار جديد
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('routes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">اسم المسار</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="target_group">الفئة المستهدفة</label>
                                    <input type="text" name="target_group" id="target_group" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">صورة المسار</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">اختر صورة</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">وصف المسار</label>
                            <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> إلغاء
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> حفظ المسار
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // تفعيل اختيار الملفات
        document.querySelectorAll('.custom-file-input').forEach(function(input) {
            input.addEventListener('change', function(e) {
                var fileName = e.target.files[0] ? e.target.files[0].name : "اختر ملف";
                var label = e.target.nextElementSibling;
                label.textContent = fileName;
            });
        });

        // تفعيل جدول البيانات
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Arabic.json'
                },
                responsive: true
            });
        });
    </script>
@endsection
