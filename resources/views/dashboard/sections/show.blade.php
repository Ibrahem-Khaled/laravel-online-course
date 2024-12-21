@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addUsersModal">إضافة
            مستخدمين</button>


        <h1>الفصل: {{ $section->name }}</h1>
        <p>{{ $section->description }}</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- نظام التبويبات -->
        <ul class="nav nav-tabs" id="sectionTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                    role="tab" aria-controls="all" aria-selected="true">الكل</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button"
                    role="tab" aria-controls="students" aria-selected="false">الطلاب</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#teachers" type="button"
                    role="tab" aria-controls="teachers" aria-selected="false">المعلمين</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar" type="button"
                    role="tab" aria-controls="calendar" aria-selected="false">التقويم</button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="sectionTabsContent">
            <!-- عرض الكل -->
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <h3>كل المستخدمين</h3>
                <ul class="list-group">
                    @forelse ($section->users as $user)
                        <li class="list-group-item">{{ $user->name }} ({{ $user->email }})</li>
                    @empty
                        <li class="list-group-item">لا يوجد مستخدمون مضافون لهذا الفصل بعد.</li>
                    @endforelse
                </ul>
            </div>

            <!-- عرض الطلاب -->
            <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
                <h3>الطلاب</h3>
                <ul class="list-group">
                    @forelse ($section->users->where('role', 'student') as $student)
                        <li class="list-group-item">{{ $student->name }} ({{ $student->email }})</li>
                    @empty
                        <li class="list-group-item">لا يوجد طلاب مضافون لهذا الفصل بعد.</li>
                    @endforelse
                </ul>
            </div>

            <!-- عرض المعلمين -->
            <div class="tab-pane fade" id="teachers" role="tabpanel" aria-labelledby="teachers-tab">
                <h3>المعلمين</h3>
                <ul class="list-group">
                    @forelse ($section->users->where('role', 'teacher') as $teacher)
                        <li class="list-group-item">{{ $teacher->name }} ({{ $teacher->email }})</li>
                    @empty
                        <li class="list-group-item">لا يوجد معلمون مضافون لهذا الفصل بعد.</li>
                    @endforelse
                </ul>
            </div>

            <div class="tab-content mt-3" id="sectionTabsContent">
                <!-- تبويب التقويم -->
                <div class="tab-pane fade" id="calendar" role="tabpanel" aria-labelledby="calendar-tab">
                    <h3>التقويم الأسبوعي</h3>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>اليوم</th>
                                <th>المواد</th>
                                <th>الأوقات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
                            @endphp
                            @foreach ($days as $dayIndex => $day)
                                <tr>
                                    <td>{{ $day }}</td>
                                    <td>
                                        @php
                                            $daySchedule = $section->calendars->where('day_number', $dayIndex + 1);
                                        @endphp
                                        @if ($daySchedule->isNotEmpty())
                                            <ul class="list-unstyled">
                                                @foreach ($daySchedule as $schedule)
                                                    <li>{{ $schedule->course->title ?? 'لا توجد مادة' }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">إجازة</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($daySchedule->isNotEmpty())
                                            <ul class="list-unstyled">
                                                @foreach ($daySchedule as $schedule)
                                                    @php
                                                        $time = \Carbon\Carbon::createFromFormat(
                                                            'H:i:s',
                                                            $schedule->start_time,
                                                        )->format('h:i A');
                                                        $timeInArabic = str_replace(
                                                            ['AM', 'PM'],
                                                            ['صباحًا', 'مساءً'],
                                                            $time,
                                                        );
                                                    @endphp
                                                    <li>{{ $timeInArabic }}</li>
                                                @endforeach

                                            </ul>
                                        @else
                                            <span class="text-muted">---</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->isAdmin())
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editCalendarModal{{ $dayIndex + 1 }}">اضافة</button>
                                            @foreach ($daySchedule as $schedule)
                                                <form action="{{ route('section-calendars.destroy', $schedule->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                                </form>
                                            @endforeach
                                        @else
                                            <span class="text-muted">غير مسموح</span>
                                        @endif
                                    </td>
                                </tr>
                                <!-- تعديل التقويم -->
                                @if (auth()->user()->isAdmin())
                                    <div class="modal fade" id="editCalendarModal{{ $dayIndex + 1 }}" tabindex="-1"
                                        aria-labelledby="editCalendarModalLabel{{ $dayIndex + 1 }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('section-calendars.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="section_id" value="{{ $section->id }}">
                                                    <input type="hidden" name="day_number" value="{{ $dayIndex + 1 }}">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editCalendarModalLabel{{ $dayIndex + 1 }}">
                                                            تعديل جدول {{ $day }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="إغلاق"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="course_id">اختر المادة</label>
                                                            <select name="course_id" id="course_id" class="form-control">
                                                                @foreach ($courses as $course)
                                                                    <option value="{{ $course->id }}">
                                                                        {{ $course->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="start_time">وقت البداية</label>
                                                            <input type="time" name="start_time" class="form-control"
                                                                value="{{ old('start_time') }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">حفظ
                                                            التعديلات</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- نافذة إضافة المستخدمين -->
    <div class="modal fade" id="addUsersModal" tabindex="-1" aria-labelledby="addUsersModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('sections.addUsers', $section->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUsersModalLabel">إضافة مستخدمين إلى {{ $section->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <!-- عرض الأخطاء -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- اختيار الطلاب -->
                        <div class="form-group">
                            <label for="students">اختر الطلاب</label>
                            <select name="users[]" id="students" class="form-control" multiple required>
                                @foreach ($students as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, old('users', [])) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">يمكنك اختيار أكثر من مستخدم بالضغط على Ctrl (أو Cmd على Mac).</small>
                        </div>

                        <!-- اختيار المعلمين -->
                        <div class="form-group mt-3">
                            <label for="teachers">اختر المعلمين</label>
                            <select name="users[]" id="teachers" class="form-control" multiple>
                                @foreach ($teachers as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, old('users', [])) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">يمكنك اختيار أكثر من مستخدم بالضغط على Ctrl (أو Cmd على Mac).</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">إضافة المستخدمين</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
