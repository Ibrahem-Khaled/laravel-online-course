@extends('layouts.dashboard')

@section('content')
    <div class="container py-4">
        <!-- زر فتح نافذة إضافة المستخدمين -->
        <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#addUsersModal">
            إضافة مستخدمين
        </button>

        <!-- عنوان الفصل والوصف -->
        <h1 class="mb-2">الفصل: {{ $section->name }}</h1>
        <p class="text-muted">{{ $section->description }}</p>

        <!-- عرض أخطاء التحقق -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- نظام التبويبات -->
        <ul class="nav nav-tabs" id="sectionTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-toggle="tab" data-target="#all" type="button"
                    role="tab" aria-controls="all" aria-selected="true">الكل</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="students-tab" data-toggle="tab" data-target="#students" type="button"
                    role="tab" aria-controls="students" aria-selected="false">الطلاب</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="teachers-tab" data-toggle="tab" data-target="#teachers" type="button"
                    role="tab" aria-controls="teachers" aria-selected="false">المعلمين</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="calendar-tab" data-toggle="tab" data-target="#calendar" type="button"
                    role="tab" aria-controls="calendar" aria-selected="false">التقويم</button>
            </li>
        </ul>
        <div class="tab-content mt-3" id="sectionTabsContent">
            <!-- تبويب: الكل -->
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <h3>كل المستخدمين</h3>
                <ul class="list-group">
                    @forelse ($section->users as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $user->name }} ({{ $user->email }})
                            <form
                                action="{{ route('sections.removeUser', ['section' => $section->id, 'user' => $user->id]) }}"
                                method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">حذف</button>
                            </form>
                        </li>
                    @empty
                        <li class="list-group-item">لا يوجد مستخدمون مضافون لهذا الفصل بعد.</li>
                    @endforelse
                </ul>
            </div>

            <!-- تبويب: الطلاب -->
            <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
                <h3>الطلاب</h3>
                <ul class="list-group">
                    @forelse ($section->users->where('role', 'student') as $student)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $student->name }} ({{ $student->email }})
                            <form
                                action="{{ route('sections.removeUser', ['section' => $section->id, 'user' => $student->id]) }}"
                                method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('هل أنت متأكد من حذف هذا الطالب؟')">حذف</button>
                            </form>
                        </li>
                    @empty
                        <li class="list-group-item">لا يوجد طلاب مضافون لهذا الفصل بعد.</li>
                    @endforelse
                </ul>
            </div>

            <!-- تبويب: المعلمين -->
            <div class="tab-pane fade" id="teachers" role="tabpanel" aria-labelledby="teachers-tab">
                <h3>المعلمين</h3>
                <ul class="list-group">
                    @forelse ($section->users->where('role', 'teacher') as $teacher)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $teacher->name }} ({{ $teacher->email }})
                            <form
                                action="{{ route('sections.removeUser', ['section' => $section->id, 'user' => $teacher->id]) }}"
                                method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('هل أنت متأكد من حذف هذا المعلم؟')">حذف</button>
                            </form>
                        </li>
                    @empty
                        <li class="list-group-item">لا يوجد معلمون مضافون لهذا الفصل بعد.</li>
                    @endforelse
                </ul>
            </div>

            <!-- تبويب: التقويم -->
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
                        @foreach ($days as $index => $day)
                            @php
                                $schedules = $section->calendars->where('day_number', $index + 1);
                            @endphp
                            <tr>
                                <td>{{ $day }}</td>
                                <td>
                                    @if ($schedules->isNotEmpty())
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($schedules as $sch)
                                                <li>{{ $sch->course->title }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">إجازة</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($schedules->isNotEmpty())
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($schedules as $sch)
                                                @php
                                                    $time = \Carbon\Carbon::parse($sch->start_time)->format('g:i A');
                                                    $time = str_replace(['AM', 'PM'], ['صباحًا', 'مساءً'], $time);
                                                @endphp
                                                <li>{{ $time }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor')
                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editCalendarModal{{ $index }}">إضافة</button>
                                        @foreach ($schedules as $sch)
                                            <form action="{{ route('section-calendars.destroy', $sch->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                            </form>
                                        @endforeach
                                    @else
                                        <span class="text-muted">غير مسموح</span>
                                    @endif
                                </td>
                            </tr>
                            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor')
                                <!-- مودال تعديل/إضافة للتقويم -->
                                <div class="modal fade" id="editCalendarModal{{ $index }}" tabindex="-1"
                                    aria-labelledby="editCalendarModalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('section-calendars.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="section_id" value="{{ $section->id }}">
                                                <input type="hidden" name="day_number" value="{{ $index + 1 }}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editCalendarModalLabel{{ $index }}">
                                                        جدول {{ $day }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal"
                                                        aria-label="إغلاق"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="course_id{{ $index }}" class="form-label">اختر
                                                            المادة</label>
                                                        <select name="course_id" id="course_id{{ $index }}"
                                                            class="form-select" required>
                                                            @foreach ($courses as $c)
                                                                <option value="{{ $c->id }}">{{ $c->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="start_time{{ $index }}" class="form-label">وقت
                                                            البداية</label>
                                                        <input type="time" name="start_time"
                                                            id="start_time{{ $index }}" class="form-control"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">إلغاء</button>
                                                    <button type="submit" class="btn btn-primary">حفظ</button>
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

    <!-- مودال إضافة المستخدمين -->
    <div class="modal fade" id="addUsersModal" tabindex="-1" aria-labelledby="addUsersModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('sections.addUsers', $section->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUsersModalLabel">إضافة مستخدمين إلى {{ $section->name }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <!-- اختيار الطلاب -->
                        <div class="mb-3">
                            <label for="students" class="form-label">اختر الطلاب</label>
                            <select name="students[]" id="students" class="form-select" multiple>
                                @foreach ($students as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, old('students', [])) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- اختيار المعلمين -->
                        <div class="mb-3">
                            <label for="teachers" class="form-label">اختر المعلمين</label>
                            <select name="teachers[]" id="teachers" class="form-select" multiple>
                                @foreach ($teachers as $user)
                                    <option value="{{ $user->id }}"
                                        {{ in_array($user->id, old('teachers', [])) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-muted">يجب اختيار طالب أو معلم على الأقل.</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">إضافة المستخدمين</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
