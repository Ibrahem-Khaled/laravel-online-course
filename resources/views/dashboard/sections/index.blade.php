@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">إدارة الأقسام</h2>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createSectionModal">إضافة قسم
            جديد</button>

        <!-- جدول عرض الأقسام -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>الرقم</th>
                    <th>الاسم</th>
                    <th>الوصف</th>
                    <th>رابط الاجتماع</th>
                    <th>الصورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="sectionsTable">
                @foreach ($sections as $section)
                    <tr>
                        <td>{{ $section->id }}</td>
                        <td>
                            <a href="{{ route('sections.show', $section->id) }}">
                                {{ $section->name }}</a>
                        </td>
                        <td>{{ $section->description }}</td>
                        <td>{{ $section->meeting_link }}</td>
                        <td>
                            @if($section->image)
                                <img src="{{ asset('storage/' . $section->image) }}" alt="صورة القسم" style="width: 50px; height: 50px;">
                            @else
                                لا توجد صورة
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#editSectionModal{{ $section->id }}">تعديل</button>
                            <form action="{{ route('sections.destroy', $section->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Modal تعديل القسم -->
                    <div class="modal fade" id="editSectionModal{{ $section->id }}" tabindex="-1"
                        aria-labelledby="editSectionModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('sections.update', $section->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editSectionModalLabel">تعديل القسم</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">اسم القسم</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $section->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">الوصف</label>
                                            <textarea class="form-control" name="description" rows="3">{{ $section->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="meeting_link" class="form-label">رابط الاجتماع</label>
                                            <input type="url" class="form-control" name="meeting_link"
                                                value="{{ $section->meeting_link }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">الصورة</label>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal إضافة قسم جديد -->
    <div class="modal fade" id="createSectionModal" tabindex="-1" aria-labelledby="createSectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('sections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSectionModalLabel">إضافة قسم جديد</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم القسم</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="meeting_link" class="form-label">رابط الاجتماع</label>
                            <input type="url" class="form-control" name="meeting_link">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">الصورة</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">إضافة</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
