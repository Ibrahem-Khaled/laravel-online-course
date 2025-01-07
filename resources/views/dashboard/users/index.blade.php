@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">
                <form action="{{ route('users.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="بحث عن المستخدمين..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </form>
            </div>
        </div>
        <h2 class="my-4">إدارة المستخدمين</h2>

        <!-- زر لإضافة مستخدم جديد -->
        <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#createUserModal">إضافة مستخدم
            جديد</button>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- التبويبات -->
        <ul class="nav nav-tabs mb-4" id="userRolesTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-teachers" data-toggle="tab" data-target="#teachers"
                    type="button" role="tab" aria-controls="teachers" aria-selected="true">المدرسين</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-students" data-toggle="tab" data-target="#students" type="button"
                    role="tab" aria-controls="students" aria-selected="false">الطلاب</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-supervisors" data-toggle="tab" data-target="#supervisors"
                    type="button" role="tab" aria-controls="supervisors" aria-selected="false">المشرفين</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-admins" data-toggle="tab" data-target="#admins" type="button"
                    role="tab" aria-controls="admins" aria-selected="false">المديرين</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="student-sections" data-toggle="tab" data-target="#studen-section"
                    type="button" role="tab" aria-controls="studen-section" aria-selected="false">طلاب طموح</button>
            </li>
        </ul>

        <!-- محتويات التبويبات -->
        <div class="tab-content" id="userRolesTabContent">
            <!-- تبويب المدرسين -->
            <div class="tab-pane fade show active" id="teachers" role="tabpanel" aria-labelledby="tab-teachers">
                @include('dashboard.users.table', ['users' => $users->where('role', 'teacher')])
            </div>

            <!-- تبويب الطلاب -->
            <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="tab-students">
                @include('dashboard.users.table', ['users' => $users->where('role', 'student')])
            </div>

            <!-- تبويب المشرفين -->
            <div class="tab-pane fade" id="supervisors" role="tabpanel" aria-labelledby="tab-supervisors">
                @include('dashboard.users.table', ['users' => $users->where('role', 'supervisor')])
            </div>

            <!-- تبويب المديرين -->
            <div class="tab-pane fade" id="admins" role="tabpanel" aria-labelledby="tab-admins">
                @include('dashboard.users.table', ['users' => $users->where('role', 'admin')])
            </div>
            <div class="tab-pane fade" id="studen-section" role="tabpanel" aria-labelledby="student-sections">
                @include('dashboard.users.table', [
                    'users' => $studentsWithSections,
                ])
            </div>
        </div>

        <!-- مودال لإضافة مستخدم جديد -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة مستخدم جديد</h5>
                            <button type="button" class="btn-close" data-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('dashboard.users.form', ['user' => null])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
