@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center mb-4">لوحة التحكم - المنصة التعليمية</h1>

        <!-- الإحصائيات العامة -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">عدد الطلاب</h5>
                        <p class="card-text fs-3">{{ $studentsCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">عدد المعلمين</h5>
                        <p class="card-text fs-3">{{ $teachersCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">عدد الفصول
                            <br>(برنامج طموح)
                        </h5>
                        <p class="card-text fs-3">{{ $sectionsCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">عدد الدروس</h5>
                        <p class="card-text fs-3">{{ $lessonsCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- الدروس والفصول الأخيرة -->
        <div class="row">
            <!-- أحدث الدروس -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>أحدث الدروس</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($latestLessons as $lesson)
                                <li class="list-group-item">
                                    {{ $lesson->title }}
                                    <span
                                        class="badge bg-primary float-end">{{ $lesson->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- أحدث الفصول -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>أحدث الفصول</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($latestSections as $section)
                                <li class="list-group-item">
                                    {{ $section->name }}
                                    <span
                                        class="badge bg-success float-end">{{ $section->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- الروابط السريعة -->
        <div class="row mt-4">
            <div class="col-md-4">
                <a href="{{ route('courses.index') }}" class="btn btn-primary w-100">إضافة درس جديد</a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">إدارة الطلاب</a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">إدارة المعلمين</a>
            </div>
        </div>

        <!-- الإشعارات -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>الإشعارات</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse ($notifications as $notification)
                        <li class="list-group-item">
                            {{ $notification->message }}
                            <span class="badge bg-info float-end">{{ $notification->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">لا توجد إشعارات جديدة</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
