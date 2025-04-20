@extends('layouts.dashboard')

@section('content')
    <div class="container">
        {{-- بحث عن المستخدمين --}}
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

        {{-- زر إضافة مستخدم --}}
        <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#createUserModal">
            إضافة مستخدم جديد
        </button>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- تبويبات الأدوار --}}
        <ul class="nav nav-tabs mb-4" id="userRolesTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-teachers" data-toggle="tab" href="#teachers" role="tab"
                    aria-controls="teachers" aria-selected="true">المدرسين</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-students" data-toggle="tab" href="#students" role="tab"
                    aria-controls="students" aria-selected="false">الطلاب</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-supervisors" data-toggle="tab" href="#supervisors" role="tab"
                    aria-controls="supervisors" aria-selected="false">المشرفين</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-admins" data-toggle="tab" href="#admins" role="tab" aria-controls="admins"
                    aria-selected="false">المديرين</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-ambitious" data-toggle="tab" href="#ambitious-students" role="tab"
                    aria-controls="ambitious-students" aria-selected="false">طلاب طموح</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-entrepreneur" data-toggle="tab" href="#entrepreneur-students" role="tab"
                    aria-controls="entrepreneur-students" aria-selected="false">طلاب ريادة</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-inactive-students" data-toggle="tab" href="#inactive-students" role="tab"
                    aria-controls="inactive-students" aria-selected="false">
                    الطلاب غير النشطين
                    <span class="badge badge-danger">{{ $inactiveStudents->count() }}</span>
                </a>
            </li>
        </ul>

        {{-- محتوى التبويبات --}}
        <div class="tab-content" id="userRolesTabContent">
            <div class="tab-pane fade show active" id="teachers" role="tabpanel" aria-labelledby="tab-teachers">
                @include('dashboard.users.table', ['users' => $users->where('role', 'teacher')])
            </div>
            <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="tab-students">
                @include('dashboard.users.table', ['users' => $studentsWithoutSections])
            </div>
            <div class="tab-pane fade" id="supervisors" role="tabpanel" aria-labelledby="tab-supervisors">
                @include('dashboard.users.table', ['users' => $users->where('role', 'supervisor')])
            </div>
            <div class="tab-pane fade" id="admins" role="tabpanel" aria-labelledby="tab-admins">
                @include('dashboard.users.table', ['users' => $users->where('role', 'admin')])
            </div>
            <div class="tab-pane fade" id="ambitious-students" role="tabpanel" aria-labelledby="tab-ambitious">
                @include('dashboard.users.table', ['users' => $studentsWithSections])
            </div>
            <div class="tab-pane fade" id="entrepreneur-students" role="tabpanel" aria-labelledby="tab-entrepreneur">
                @include('dashboard.users.table', ['users' => $studentsWithEntrepreneurship])
            </div>
            <div class="tab-pane fade" id="inactive-students" role="tabpanel" aria-labelledby="tab-inactive-students">
                @include('dashboard.users.table', ['users' => $inactiveStudents])
            </div>
        </div>

        {{-- مودال إضافة مستخدم جديد --}}
        <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog"
            aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createUserModalLabel">إضافة مستخدم جديد</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('dashboard.users.form', ['user' => null])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
