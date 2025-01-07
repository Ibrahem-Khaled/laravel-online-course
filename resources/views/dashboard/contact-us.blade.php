@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="my-4">إدارة الرسائل</h1>

        <!-- زر إضافة رسالة جديدة -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMessageModal">إرسال رسالة
            جديدة</button>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- جدول عرض الرسائل -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>المستخدم المبلغ عنه</th>
                    <th>الرسالة</th>
                    <th>الصورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                    <tr>
                        <td>{{ $message->user->name }}</td>
                        <td>{{ $message->reportedUser ? $message->reportedUser->name : 'لا يوجد' }}</td>
                        <td>{{ $message->message }}</td>
                        <td>
                            @if ($message->image)
                                <img src="{{ asset('storage/' . $message->image) }}" alt="صورة" width="100">
                            @else
                                لا توجد صورة
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('contact_us.destroy', $message->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal لإرسال رسالة جديدة -->
        <div class="modal fade" id="addMessageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('contact_us.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إرسال رسالة جديدة</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">المستخدم</label>
                                <select name="user_id" class="form-select" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="user_id_is_reported" class="form-label">المستخدم المبلغ عنه</label>
                                <select name="user_id_is_reported" class="form-select">
                                    <option value="">لا يوجد</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">الرسالة</label>
                                <textarea name="message" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">الصورة</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">إرسال</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
