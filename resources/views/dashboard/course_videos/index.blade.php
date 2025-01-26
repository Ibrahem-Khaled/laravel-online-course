@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="my-4">فيديوهات الدورة: {{ $course->title }}</h1>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addVideoModal">إضافة فيديو جديد</button>
        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addPartModal">إضافة قسم جديد</button>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- عرض الأقسام -->
        @foreach ($course->parts as $part)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center" data-toggle="collapse"
                    data-target="#part-{{ $part->id }}">
                    <span>{{ $part->name }}</span>
                    <button class="btn btn-sm btn-info" data-toggle="modal"
                        data-target="#reorderVideosModal{{ $part->id }}">إعادة ترتيب الفيديوهات</button>
                </div>
                <div id="part-{{ $part->id }}" class="collapse">
                    <div class="card-body">
                        <ul class="list-group sortable-part" data-part-id="{{ $part->id }}">
                            @foreach ($part->videos->sortBy('ranking') as $video)
                                <li class="list-group-item" data-video-id="{{ $video->id }}">
                                    {{ $video->title }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- مودال إعادة ترتيب الفيديوهات داخل القسم -->
            <div class="modal fade" id="reorderVideosModal{{ $part->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">إعادة ترتيب الفيديوهات في قسم: {{ $part->name }}</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group sortable-part-modal" data-part-id="{{ $part->id }}">
                                @foreach ($part->videos->sortBy('ranking') as $video)
                                    <li class="list-group-item" data-video-id="{{ $video->id }}">
                                        {{ $video->title }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="button" class="btn btn-primary" onclick="saveOrder({{ $part->id }})">حفظ
                                الترتيب</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- باقي الكود الخاص بإضافة الفيديوهات والأقسام -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>رابط الفيديو</th>
                    <th>الوصف</th>
                    <th>الصورة</th>
                    <th>المدة (ساعات:دقائق:ثواني)</th>
                    <th>الجهاز المستخدم</th>
                    <th>القسم</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach ($course->videos as $video)
                    <tr data-id="{{ $video->id }}">
                        <td>{{ $video->title }}</td>
                        <td>{!! $video->video !!}</td>
                        <td>{{ \Illuminate\Support\Str::limit($video->description, 50, '...') }}</td>
                        <td>
                            @if ($video->image)
                                <img src="{{ asset('storage/' . $video->image) }}" alt="صورة الفيديو" width="100">
                            @else
                                لا توجد صورة
                            @endif
                        </td>
                        <td>{{ $video->duration }}</td>
                        <td>{{ $video->device }}</td>
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
                                @include('dashboard.course_videos.form', [
                                    'action' => route('course_videos.update', $video->id),
                                    'method' => 'PUT',
                                    'title' => 'تعديل الفيديو',
                                    'buttonText' => 'حفظ التعديلات',
                                    'video' => $video,
                                    'parts' => $parts,
                                    'course' => $course,
                                ])
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Add Part Modal -->
        <div class="modal fade" id="addPartModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('course_parts.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة قسم جديد</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">اسم القسم</label>
                                <input type="text" name="name" class="form-control" required>
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

        <!-- Add Video Modal -->
        <div class="modal fade" id="addVideoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    @include('dashboard.course_videos.form', [
                        'action' => route('course_videos.store'),
                        'method' => 'POST',
                        'title' => 'إضافة فيديو جديد',
                        'buttonText' => 'إضافة',
                        'video' => null,
                        'parts' => $parts,
                        'course' => $course,
                    ])
                </div>
            </div>
        </div>
    </div>

    <!-- SortableJS Script -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تفعيل إعادة الترتيب داخل المودال
            document.querySelectorAll('.sortable-part-modal').forEach(sortableElement => {
                new Sortable(sortableElement, {
                    animation: 150,
                    onEnd: function(event) {
                        // يمكنك إضافة أي كود إضافي هنا إذا لزم الأمر
                    }
                });
            });

            // تفعيل إعادة الترتيب داخل القسم نفسه
            document.querySelectorAll('.sortable-part').forEach(sortableElement => {
                new Sortable(sortableElement, {
                    animation: 150,
                    onEnd: function(event) {
                        // يمكنك إضافة أي كود إضافي هنا إذا لزم الأمر
                    }
                });
            });
        });

        // دالة لحفظ الترتيب الجديد
        function saveOrder(partId) {
            const order = Array.from(document.querySelector(`.sortable-part-modal[data-part-id="${partId}"]`).children).map(
                item => item.getAttribute('data-video-id'));

            fetch("{{ route('course_videos.reorder') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        part_id: partId,
                        order
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('تم تحديث الترتيب بنجاح!');
                        location.reload(); // إعادة تحميل الصفحة لتحديث العرض
                    } else {
                        alert('حدث خطأ أثناء تحديث الترتيب.');
                    }
                });
        }
    </script>
@endsection
