@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="my-4">فيديوهات الدورة: {{ $course->title }}</h1>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addVideoModal">إضافة فيديو جديد</button>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>رابط الفيديو</th>
                    <th>الوصف</th>
                    <th>الصورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($course->videos as $video)
                    <tr>
                        <td>{{ $video->title }}</td>
                        <td> {!! $video->video !!}</td>
                        <td>{{ $video->description }}</td>
                        <td>
                            @if ($video->image)
                                <img src="{{ asset('storage/' . $video->image) }}" alt="صورة الفيديو" width="100">
                            @else
                                لا توجد صورة
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editVideoModal{{ $video->id }}">تعديل</button>
                            <form action="{{ route('course_videos.destroy', $video->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Video Modal -->
                    <div class="modal fade" id="editVideoModal{{ $video->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('course_videos.update', $video->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">تعديل الفيديو</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">العنوان</label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{ $video->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="video" class="form-label">رابط الفيديو</label>
                                            <input type="text" name="video" class="form-control"
                                                value="{{ $video->video }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">الوصف</label>
                                            <textarea name="description" class="form-control" rows="3" required>{{ $video->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="question" class="form-label">سوال الواجب</label>
                                            <input type="text" name="question" class="form-control"
                                                value="{{ $video->question }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">الصورة</label>
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

        <!-- Add Video Modal -->
        <div class="modal fade" id="addVideoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('course_videos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة فيديو جديد</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">العنوان</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="video" class="form-label">رابط الفيديو</label>
                                <input type="text" name="video" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="question" class="form-label">سوال الواجب</label>
                                <input type="text" name="question" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">الصورة</label>
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
