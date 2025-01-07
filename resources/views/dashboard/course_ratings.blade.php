@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="my-4">إدارة التقييمات</h1>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addRatingModal">إضافة تقييم جديد</button>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>الدورة</th>
                    <th>التقييم</th>
                    <th>التعليق</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ratings as $rating)
                    <tr>
                        <td>{{ $rating->user->name }}</td>
                        <td>{{ $rating->course->title }}</td>
                        <td>{{ $rating->rating }}</td>
                        <td>{{ $rating->comment }}</td>
                        <td>
                            <button class="btn btn-warning" data-toggle="modal"
                                data-target="#editRatingModal{{ $rating->id }}">تعديل</button>
                            <form action="{{ route('course_ratings.destroy', $rating->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Rating Modal -->
                    <div class="modal fade" id="editRatingModal{{ $rating->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('course_ratings.update', $rating->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">تعديل التقييم</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="user_id" class="form-label">المستخدم</label>
                                            <select name="user_id" class="form-select" required>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ $user->id == $rating->user_id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="course_id" class="form-label">الدورة</label>
                                            <select name="course_id" class="form-select" required>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}"
                                                        {{ $course->id == $rating->course_id ? 'selected' : '' }}>
                                                        {{ $course->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="rating" class="form-label">التقييم</label>
                                            <input type="number" name="rating" class="form-control"
                                                value="{{ $rating->rating }}" min="1" max="5" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="comment" class="form-label">التعليق</label>
                                            <textarea name="comment" class="form-control" rows="3">{{ $rating->comment }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Add Rating Modal -->
        <div class="modal fade" id="addRatingModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('course_ratings.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة تقييم جديد</h5>
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
                                <label for="course_id" class="form-label">الدورة</label>
                                <select name="course_id" class="form-select" required>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="rating" class="form-label">التقييم</label>
                                <input type="number" name="rating" class="form-control" min="1" max="5"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">التعليق</label>
                                <textarea name="comment" class="form-control" rows="3"></textarea>
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
    </div>
@endsection
