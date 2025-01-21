@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="my-4">إدارة فيديوهات الدورات</h1>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addVideoModal">إضافة فيديو جديد</button>

        @include('homeComponents.alerts')
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>الدورة</th>
                    <th>العنوان</th>
                    <th>الفيديو</th>
                    <th>الوصف</th>
                    <th>المدة (ساعات:دقائق:ثواني)</th>
                    <th>الجهاز المستخدم</th>
                    <th>القسم</th>
                    <th>الصورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach ($videos as $video)
                    <tr data-id="{{ $video->id }}">
                        <td>{{ $video->course->title }}</td>
                        <td>{{ $video->title }}</td>
                        <td>{!! $video->video !!}</td>
                        <td>{{ Str::limit($video->description, 50, '...') }}</td>
                        <td>{{ $video->duration }}</td>
                        <td>{{ $video->device }}</td>
                        <td>
                            @if ($video->image)
                                <img src="{{ asset('storage/' . $video->image) }}" alt="صورة الفيديو" width="100">
                            @else
                                لا توجد صورة
                            @endif
                        </td>
                        <td>{{ $video?->part?->name ?? 'لا يوجد' }}</td>
                        <td>
                            <button class="btn btn-warning" data-toggle="modal"
                                data-target="#editVideoModal{{ $video->id }}">تعديل</button>
                            <form action="{{ route('course_videos.destroy', $video->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Video Modal -->
                    <div class="modal fade" id="editVideoModal{{ $video->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('course_videos.update', $video->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">تعديل الفيديو</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="course_id" class="form-label">الدورة</label>
                                            <select name="course_id" class="form-select" required>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}"
                                                        {{ $course->id == $video->course_id ? 'selected' : '' }}>
                                                        {{ $course->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="title" class="form-label">العنوان</label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{ $video->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="video" class="form-label">رابط الفيديو</label>
                                            <input type="text" name="video" class="form-control"
                                                value="{{ $video->video }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">الوصف</label>
                                            <textarea name="description" class="form-control" rows="3" required>{{ $video->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="duration" class="form-label">المدة (ساعات)</label>
                                            <input type="number" name="duration" class="form-control"
                                                value="{{ $video->duration }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">الصورة</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                        <div class="mb-3" hidden>
                                            <label for="device" class="form-label">جهاز التشغيل</label>
                                            <select name="device" class="form-select" required>
                                                <option value="all" {{ $video->device == 'all' ? 'selected' : '' }}>
                                                    جميع الأجهزة
                                                </option>
                                                <option value="web" {{ $video->device == 'web' ? 'selected' : '' }}>ويب
                                                </option>
                                                <option value="mobile" {{ $video->device == 'mobile' ? 'selected' : '' }}>
                                                    جوال</option>
                                                <option value="desktop"
                                                    {{ $video->device == 'desktop' ? 'selected' : '' }}>كمبيوتر
                                                </option>
                                                <option value="tablet" {{ $video->device == 'tablet' ? 'selected' : '' }}>
                                                    تابلت
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $videos->links() }}
        </div>

        <!-- Add Video Modal -->
        <div class="modal fade" id="addVideoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('course_videos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة فيديو جديد</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="course_id" class="form-label">الدورة</label>
                                <select name="course_id" class="form-select" required>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">العنوان</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="video" class="form-label">رابط الفيديو</label>
                                <input type="text" name="video" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="duration" class="form-label">المدة (ساعات)</label>
                                <input type="number" name="duration" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">الصورة</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="mb-3" hidden>
                                <label for="device" class="form-label">جهاز التشغيل</label>
                                <select name="device" class="form-select" required>
                                    <option value="web" {{ old('device') == 'web' ? 'selected' : '' }}>ويب</option>
                                    <option value="mobile" {{ old('device') == 'mobile' ? 'selected' : '' }}>جوال</option>
                                    <option value="desktop" {{ old('device') == 'desktop' ? 'selected' : '' }}>كمبيوتر
                                    </option>
                                    <option value="tablet" {{ old('device') == 'tablet' ? 'selected' : '' }}>تابلت
                                    </option>
                                    <option value="tv" {{ old('device') == 'tv' ? 'selected' : '' }}>تلفزيون</option>
                                    <option value="other" {{ old('device') == 'other' ? 'selected' : '' }}>أخرى</option>
                                    <option value="all" {{ old('device') == 'all' ? 'selected' : '' }}>جميع الأجهزة
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortable = document.getElementById('sortable');

            new Sortable(sortable, {
                animation: 150, // سرعة الحركة
                onEnd: function(event) {
                    const rows = Array.from(sortable.querySelectorAll('tr'));
                    const order = rows.map(row => row.getAttribute('data-id'));

                    // إرسال الترتيب الجديد إلى الخادم
                    fetch("{{ route('course_videos.reorder') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                order
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('تم تحديث الترتيب بنجاح!');
                            } else {
                                alert('حدث خطأ أثناء تحديث الترتيب.');
                            }
                        });
                }
            });
        });
    </script>
@endsection
