@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h2 class="my-4">إدارة المستخدمين</h2>

        <!-- زر لإضافة مستخدم جديد -->
        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#createUserModal">إضافة مستخدم
            جديد</button>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الهاتف</th>
                    <th>الدور</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('show.all.user.reports', $user->id) }}">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->status == 'active' ? 'نشط' : 'غير نشط' }}</td>
                        <td>
                            <!-- زر لتعديل المستخدم -->
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editUserModal{{ $user->id }}">تعديل</button>

                            <!-- زر لحذف المستخدم -->
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>

                    <!-- مودال لتعديل المستخدم -->
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                        aria-labelledby="editUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('users.update', $user->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">تعديل المستخدم</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- الحقول المعتادة هنا -->
                                        @include('dashboard.users.form', ['user' => $user])
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- مودال لإضافة مستخدم جديد -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة مستخدم جديد</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- الحقول المعتادة هنا -->
                            @include('dashboard.users.form', ['user' => null])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-primary">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
