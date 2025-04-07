<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif
    <input type="hidden" name="course_id" value="{{ $course->id }}">
    <div class="modal-header">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="part_id" class="form-label">اسم القسم</label>
            <select name="part_id" class="form-select">
                @foreach ($parts as $part)
                    <option value="">-- اختر القسم --</option>
                    <option value="{{ $part->id }}"
                        {{ isset($video) && $video->part_id == $part->id ? 'selected' : '' }}>
                        {{ $part->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">العنوان</label>
            <input type="text" name="title" class="form-control" value="{{ $video->title ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">رابط الفيديو</label>
            <input type="text" name="video" class="form-control" value="{{ $video->video ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" class="form-control" rows="3">{{ $video->description ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label for="question" class="form-label">سوال الواجب</label>
            <input type="text" name="question" class="form-control" value="{{ $video->question ?? '' }}">
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">المدة (ساعات:دقائق:ثواني)</label>
            <input type="text" name="duration" class="form-control" value="{{ $video->duration ?? '' }}"
                placeholder="00:30:00" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">الصورة</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3" hidden>
            <label for="device" class="form-label">جهاز التشغيل</label>
            <select name="device" class="form-select" required>
                <option value="web"
                    {{ (isset($video) && $video->device == 'web') || old('device') == 'web' ? 'selected' : '' }}>ويب
                </option>
                <option value="mobile"
                    {{ (isset($video) && $video->device == 'mobile') || old('device') == 'mobile' ? 'selected' : '' }}>
                    جوال</option>
                <option value="desktop"
                    {{ (isset($video) && $video->device == 'desktop') || old('device') == 'desktop' ? 'selected' : '' }}>
                    كمبيوتر</option>
                <option value="tablet"
                    {{ (isset($video) && $video->device == 'tablet') || old('device') == 'tablet' ? 'selected' : '' }}>
                    تابلت</option>
                <option value="tv"
                    {{ (isset($video) && $video->device == 'tv') || old('device') == 'tv' ? 'selected' : '' }}>تلفزيون
                </option>
                <option value="other"
                    {{ (isset($video) && $video->device == 'other') || old('device') == 'other' ? 'selected' : '' }}>
                    أخرى</option>
                <option value="all"
                    {{ (isset($video) && $video->device == 'all') || old('device') == 'all' ? 'selected' : '' }}>جميع
                    الأجهزة</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
        <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    </div>
</form>
