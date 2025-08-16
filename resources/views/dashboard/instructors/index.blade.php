@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        {{-- عنوان الصفحة ومسار التنقل --}}
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">إدارة مدربي الدورات</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">المدربون</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('components.alerts') {{-- تأكد من وجود هذا الملف لعرض رسائل النجاح والخطأ --}}

        {{-- إحصائيات --}}
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">إجمالي المدربين</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">مدربون مساعدون</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['assistants'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">مدربون شركاء</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['co_trainers'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- بطاقة قائمة المدربين --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">قائمة المدربين</h6>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createInstructorModal">
                    <i class="fas fa-plus"></i> إضافة مدرب لدورة
                </button>
            </div>
            <div class="card-body">
                {{-- تبويب الأدوار --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ $selectedRole === 'all' ? 'active' : '' }}" href="{{ route('instructors.index') }}">الكل</a>
                    </li>
                    @foreach ($roles as $role)
                        <li class="nav-item">
                            <a class="nav-link {{ $selectedRole === $role ? 'active' : '' }}" href="{{ route('instructors.index', ['role' => $role]) }}">
                                {{ $role === 'assistant' ? 'مساعد' : 'شريك' }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- نموذج البحث --}}
                <form action="{{ route('instructors.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="ابحث باسم المدرب أو الدورة..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> بحث</button>
                        </div>
                    </div>
                </form>

                {{-- جدول المدربين --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>المدرب</th>
                                <th>الدورة</th>
                                <th>الدور</th>
                                <th>تاريخ الإضافة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($instructors as $instructor)
                                <tr>
                                    <td>{{ $instructor->user->name ?? 'غير متوفر' }}</td>
                                    <td>{{ $instructor->course->title ?? 'غير متوفر' }}</td>
                                    <td>
                                        @if($instructor->role == 'assistant')
                                            <span class="badge badge-success">مساعد</span>
                                        @else
                                            <span class="badge badge-info">شريك</span>
                                        @endif
                                    </td>
                                    <td>{{ $instructor->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-circle btn-info" data-toggle="modal" data-target="#showInstructorModal{{ $instructor->id }}" title="عرض"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-circle btn-primary" data-toggle="modal" data-target="#editInstructorModal{{ $instructor->id }}" title="تعديل"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-circle btn-danger" data-toggle="modal" data-target="#deleteInstructorModal{{ $instructor->id }}" title="حذف"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد بيانات لعرضها.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- الترقيم --}}
                <div class="d-flex justify-content-center">
                    {{ $instructors->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- تضمين المودالات --}}
    @include('dashboard.instructors.modals.create')
    @foreach ($instructors as $instructor)
        @include('dashboard.instructors.modals.show', ['instructor' => $instructor])
        @include('dashboard.instructors.modals.edit', ['instructor' => $instructor])
        @include('dashboard.instructors.modals.delete', ['instructor' => $instructor])
    @endforeach
@endsection
