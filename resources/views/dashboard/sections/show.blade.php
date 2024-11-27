@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1>الفصل: {{ $section->name }}</h1>
        <p>{{ $section->description }}</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
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
        </div>

        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addUsersModal">إضافة مستخدمين</button>
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
                            <select name="users[]" id="teachers" class="form-control" multiple required>
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
