@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">تقييمات المستخدم</h2>

        <!-- إضافة تقييم جديد -->
        <div class="mb-3">
            <h4>إضافة تقييم جديد</h4>
            <form method="POST" action="{{ route('userReports.store') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="teacher_id" class="form-label">اسم المعلم</label>
                        <select class="form-control" name="teacher_id" id="teacher_id" required>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="attendance" class="form-label">الحضور</label>
                        <input type="number" class="form-control" name="attendance" id="attendance" max="10"
                            required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="reactivity" class="form-label">التفاعل</label>
                        <input type="number" class="form-control" name="reactivity" id="reactivity" max="10"
                            required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="homework" class="form-label">الواجبات المنزلية</label>
                        <input type="number" class="form-control" name="homework" id="homework" max="10" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="completion" class="form-label">الإكمال</label>
                        <input type="number" class="form-control" name="completion" id="completion" max="10"
                            required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="creativity" class="form-label">الإبداع</label>
                        <input type="number" class="form-control" name="creativity" id="creativity" max="10"
                            required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="ethics" class="form-label">الأخلاق</label>
                        <input type="number" class="form-control" name="ethics" id="ethics" max="10" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="created_at" class="form-label">تاريخ الإضافة</label>
                        <input type="date" class="form-control" name="created_at" id="created_at" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <button type="submit" class="btn btn-primary mt-4">إضافة</button>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الطالب</th>
                    <th>اسم المعلم</th>
                    <th>الحضور</th>
                    <th>التفاعل</th>
                    <th>الواجبات المنزلية</th>
                    <th>الإكمال</th>
                    <th>الإبداع</th>
                    <th>الأخلاق</th>
                    <th>تاريخ الإضافة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user->userReports as $index => $report)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $report->user->name }}</td>
                        <td>{{ $report->teacher->name }}</td>
                        <td>{{ $report->attendance }}</td>
                        <td>{{ $report->reactivity }}</td>
                        <td>{{ $report->homework }}</td>
                        <td>{{ $report->completion }}</td>
                        <td>{{ $report->creativity }}</td>
                        <td>{{ $report->ethics }}</td>
                        <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('userReports.destroy', $report->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
