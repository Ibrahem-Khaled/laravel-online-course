@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1>الكورسات الخاصة بالمسار: {{ $route->name }}</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCourseModal">
            إضافة كورس
        </button>
        @include('homeComponents.alerts')
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الكورس</th>
                    <th>الوصف</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($route->courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->description ? substr($course->description, 0, 100) . '...' : 'لا يوجد وصف' }}</td>
                        <td>
                            <button class="btn btn-warning" data-toggle="modal"
                                data-target="#editCourseModal{{ $course->id }}">
                                تعديل
                            </button>
                            <form action="{{ route('route_courses.destroy', $course->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الكورس؟')">حذف</button>
                            </form>
                        </td>
                    </tr>

                    <!-- نافذة التعديل لكل كورس -->
                    <div class="modal fade" id="editCourseModal{{ $course->id }}" tabindex="-1"
                        aria-labelledby="editCourseModalLabel{{ $course->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCourseModalLabel{{ $course->id }}">تعديل الكورس</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="إغلاق"></button>
                                </div>
                                <form action="{{ route('route_courses.update', $course->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <input type="hidden" name="route_id" value="{{ $route->id }}">
                                        <div class="form-group">
                                            <label for="course_id">الكورس</label>
                                            <select name="course_id" id="course_id" class="form-control" required>
                                                @foreach ($courses as $c)
                                                    <option value="{{ $c->id }}"
                                                        {{ $c->id == $course->id ? 'selected' : '' }}>{{ $c->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-primary">تحديث</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- نافذة إضافة كورس -->
        <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCourseModalLabel">إضافة كورس إلى {{ $route->name }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <form action="{{ route('route_courses.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="route_id" value="{{ $route->id }}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="course_id">الكورس</label>
                                <select name="course_id" id="course_id" class="form-control" required>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
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
