@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">إدارة الفئات</h6>
                        </div>
                    </div>

                    <!-- إحصائيات سريعة -->
                    <div class="row px-4 pt-3">
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">إجمالي الفئات</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $totalCategories }}
                                                    <span class="text-success text-sm font-weight-bolder">+5%</span>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="fas fa-layer-group text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">فئات نشطة</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $activeCategories }}
                                                    <span
                                                        class="text-success text-sm font-weight-bolder">+{{ round(($activeCategories / $totalCategories) * 100) }}%</span>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                                <i class="fas fa-check-circle text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">فئات غير نشطة</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    {{ $inactiveCategories }}
                                                    <span
                                                        class="text-danger text-sm font-weight-bolder">-{{ round(($inactiveCategories / $totalCategories) * 100) }}%</span>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                                <i class="fas fa-ban text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                                <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
                                <span class="alert-text">{{ session('success') }}</span>
                                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center px-3 mb-3">
                            <div class="input-group input-group-outline" style="width: 300px;">
                                <label class="form-label">بحث...</label>
                                <input type="text" class="form-control" id="searchInput">
                            </div>
                            <button class="btn btn-primary mb-0" data-toggle="modal"
                                data-target="#createCategoryModal">
                                <i class="fas fa-plus me-2"></i> إضافة فئة جديدة
                            </button>
                        </div>

                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            الفئة</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            الوصف</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            الحالة</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            الصورة</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        @if ($category->image)
                                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                                class="avatar avatar-sm me-3 border-radius-lg"
                                                                alt="category-image">
                                                        @else
                                                            <div
                                                                class="avatar avatar-sm me-3 border-radius-lg bg-gradient-dark">
                                                                <i class="fas fa-layer-group"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $category->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $category->slug }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ Str::limit($category->description, 50) }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <form action="{{ route('categories.toggle-status', $category->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm status-toggle">
                                                        <span
                                                            class="badge badge-sm bg-gradient-{{ $category->status == 'active' ? 'success' : 'secondary' }}">
                                                            {{ $category->status == 'active' ? 'نشط' : 'غير نشط' }}
                                                        </span>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($category->image)
                                                    <img src="{{ asset('storage/' . $category->image) }}"
                                                        class="avatar avatar-md rounded-circle shadow"
                                                        alt="category-image">
                                                @else
                                                    <span class="text-xs text-secondary">بدون صورة</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <button class="btn btn-sm btn-warning mb-0 px-2 py-1"
                                                    data-toggle="modal"
                                                    data-target="#editCategoryModal{{ $category->id }}"
                                                    title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <form action="{{ route('categories.destroy', $category->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger mb-0 px-2 py-1"
                                                        title="حذف"
                                                        onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>

                                                <button class="btn btn-sm btn-info mb-0 px-2 py-1" title="عرض التفاصيل"
                                                    data-toggle="modal"
                                                    data-target="#detailsModal{{ $category->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- مودال تعديل الفئة -->
                                        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">تعديل الفئة: {{ $category->name }}</h5>
                                                        <button type="button" class="btn-close" data-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('categories.update', $category->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    @include('dashboard.categories.form', [
                                                                        'category' => $category,
                                                                    ])
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="text-center mb-3">
                                                                        @if ($category->image)
                                                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                                                id="editImagePreview"
                                                                                class="img-thumbnail"
                                                                                style="max-height: 200px;">
                                                                        @else
                                                                            <img src="https://via.placeholder.com/200"
                                                                                id="editImagePreview"
                                                                                class="img-thumbnail"
                                                                                style="max-height: 200px;">
                                                                        @endif
                                                                    </div>
                                                                    <div class="form-check form-switch ps-0">
                                                                        <input class="form-check-input ms-auto"
                                                                            type="checkbox"
                                                                            id="featuredCheck{{ $category->id }}"
                                                                            name="is_featured"
                                                                            {{ $category->is_featured ? 'checked' : '' }}>
                                                                        <label class="form-check-label text-body ms-3"
                                                                            for="featuredCheck{{ $category->id }}">مميزة</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary">حفظ
                                                                التغييرات</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- مودال عرض التفاصيل -->
                                        <div class="modal fade" id="detailsModal{{ $category->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">تفاصيل الفئة</h5>
                                                        <button type="button" class="btn-close" data-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center mb-4">
                                                            @if ($category->image)
                                                                <img src="{{ asset('storage/' . $category->image) }}"
                                                                    class="img-fluid rounded shadow-lg"
                                                                    style="max-height: 200px;">
                                                            @else
                                                                <div class="bg-gradient-dark text-white rounded shadow-lg p-4"
                                                                    style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                                                    <i class="fas fa-layer-group fa-4x opacity-10"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <ul class="list-group">
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                <span>الاسم:</span>
                                                                <span
                                                                    class="font-weight-bold">{{ $category->name }}</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                <span>الرابط:</span>
                                                                <span
                                                                    class="font-weight-bold">{{ $category->slug }}</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                <span>الحالة:</span>
                                                                <span
                                                                    class="badge bg-gradient-{{ $category->status == 'active' ? 'success' : 'secondary' }}">{{ $category->status == 'active' ? 'نشط' : 'غير نشط' }}</span>
                                                            </li>
                                                            <li
                                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                                <span>التاريخ:</span>
                                                                <span
                                                                    class="font-weight-bold">{{ $category->created_at->format('Y/m/d') }}</span>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <h6 class="mb-2">الوصف:</h6>
                                                                <p>{{ $category->description ?? 'لا يوجد وصف' }}</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">إغلاق</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="px-4 pt-3">
                            {{ $categories->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- مودال إضافة فئة جديدة -->
        <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة فئة جديدة</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @include('dashboard.categories.form', ['category' => null])
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center mb-3">
                                        <img src="https://via.placeholder.com/200" id="imagePreview"
                                            class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                    <div class="form-check form-switch ps-0">
                                        <input class="form-check-input ms-auto" type="checkbox" id="featuredCheck"
                                            name="is_featured">
                                        <label class="form-check-label text-body ms-3" for="featuredCheck">مميزة</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">إضافة الفئة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // عرض صورة الفئة قبل الرفع
        function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(previewId).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function() {
            readURL(this, '#imagePreview');
        });

        $("input[name='image']").on('change', function() {
            readURL(this, '#editImagePreview');
        });

        // البحث الفوري
        $('#searchInput').keyup(function() {
            var value = $(this).val().toLowerCase();
            $('table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // تغيير لون زر الحالة عند التحويم
        $(document).on('mouseenter', '.status-toggle', function() {
            const badge = $(this).find('.badge');
            if (badge.hasClass('bg-gradient-success')) {
                badge.removeClass('bg-gradient-success').addClass('bg-gradient-secondary');
                badge.text('غير نشط');
            } else if (badge.hasClass('bg-gradient-secondary')) {
                badge.removeClass('bg-gradient-secondary').addClass('bg-gradient-success');
                badge.text('نشط');
            }
        }).on('mouseleave', '.status-toggle', function() {
            const badge = $(this).find('.badge');
            if (badge.hasClass('bg-gradient-success')) {
                badge.removeClass('bg-gradient-secondary').addClass('bg-gradient-success');
                badge.text('نشط');
            } else if (badge.hasClass('bg-gradient-secondary')) {
                badge.removeClass('bg-gradient-success').addClass('bg-gradient-secondary');
                badge.text('غير نشط');
            }
        });
    </script>
@endpush