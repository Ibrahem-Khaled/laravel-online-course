@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h2 class="my-4">إدارة الفئات</h2>

        <!-- زر لإضافة فئة جديدة -->
        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#createCategoryModal">إضافة فئة
            جديدة</button>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الوصف</th>
                    <th>الحالة</th>
                    <th>الصورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->status == 'active' ? 'نشط' : 'غير نشط' }}</td>
                        <td>
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" width="50">
                            @else
                                لا توجد صورة
                            @endif
                        </td>
                        <td>
                            <!-- زر لتعديل الفئة -->
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editCategoryModal{{ $category->id }}">تعديل</button>

                            <!-- زر لحذف الفئة -->
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>

                    <!-- مودال لتعديل الفئة -->
                    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1"
                        aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('categories.update', $category->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">تعديل الفئة</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- الحقول المعتادة هنا -->
                                        @include('dashboard.categories.form', [
                                            'category' => $category,
                                        ])
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- مودال لإضافة فئة جديدة -->
        <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة فئة جديدة</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- الحقول المعتادة هنا -->
                            @include('dashboard.categories.form', ['category' => null])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
