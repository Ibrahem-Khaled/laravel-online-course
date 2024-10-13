<div class="form-group mb-3">
    <label for="name">اسم الفئة</label>
    <input type="text" name="name" class="form-control" value="{{ $category ? $category->name : old('name') }}"
        required>
</div>

<div class="form-group mb-3">
    <label for="description">الوصف</label>
    <textarea name="description" class="form-control">{{ $category ? $category->description : old('description') }}</textarea>
</div>

<div class="form-group mb-3">
    <label for="status">الحالة</label>
    <select name="status" class="form-control">
        <option value="active" {{ $category && $category->status == 'active' ? 'selected' : '' }}>نشط</option>
        <option value="inactive" {{ $category && $category->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
    </select>
</div>

<div class="form-group mb-3">
    <label for="image">الصورة</label>
    <input type="file" name="image" class="form-control">
    @if ($category && $category->image)
        <img src="{{ asset($category->image) }}" alt="Category Image" width="100" class="mt-2">
    @endif
</div>
