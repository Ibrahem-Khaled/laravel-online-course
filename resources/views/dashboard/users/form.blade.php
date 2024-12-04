<div class="form-group mb-3">
    <label for="name">الاسم</label>
    <input type="text" name="name" class="form-control" value="{{ $user ? $user->name : old('name') }}" required>
</div>

<div class="form-group mb-3">
    <label for="email">البريد الإلكتروني</label>
    <input type="email" name="email" class="form-control" value="{{ $user ? $user->email : old('email') }}" required>
</div>

<div class="form-group mb-3">
    <label for="phone">الهاتف</label>
    <input type="text" name="phone" class="form-control" value="{{ $user ? $user->phone : old('phone') }}">
</div>

<div class="form-group mb-3">
    <label for="address">العنوان</label>
    <input type="text" name="address" class="form-control" value="{{ $user ? $user->address : old('address') }}">
</div>

<div class="form-group mb-3">
    <label for="role">الدور</label>
    <select name="role" class="form-control">
        <option value="admin" {{ $user && $user->role == 'admin' ? 'selected' : '' }}>مدير</option>
        <option value="supervisor" {{ $user && $user->role == 'supervisor' ? 'selected' : '' }}>مشرف</option>
        <option value="teacher" {{ $user && $user->role == 'teacher' ? 'selected' : '' }}>معلم</option>
        <option value="student" {{ $user && $user->role == 'student' ? 'selected' : '' }}>طالب</option>
    </select>
</div>

<div class="form-group mb-3">
    <label for="status">الحالة</label>
    <select name="status" class="form-control">
        <option value="active" {{ $user && $user->status == 'active' ? 'selected' : '' }}>نشط</option>
        <option value="inactive" {{ $user && $user->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
    </select>
</div>

@if (!$user)
    <div class="form-group mb-3">
        <label for="password">كلمة المرور</label>
        <input type="password" name="password" class="form-control" required>
    </div>
@endif

<div class="form-group mb-3">
    <label for="image">الصورة الشخصية</label>
    <input type="file" name="image" class="form-control">
    @if ($user && $user->image)
        <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png' }}"
            alt="User Image" width="100" class="mt-2">
    @endif
</div>
