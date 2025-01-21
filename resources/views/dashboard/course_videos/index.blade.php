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

        <!-- Edit Part Modal -->
        <div class="modal fade" id="editPartModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editPartForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">تعديل القسم</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_part_name" class="form-label">اسم القسم</label>
                                <input type="text" name="name" class="form-control" id="edit_part_name" required>
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

        <!-- Delete Part Modal -->
        <div class="modal fade" id="deletePartModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="deletePartForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">حذف القسم</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>هل أنت متأكد من حذف هذا القسم؟</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-danger">حذف</button>
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
                                // alert('تم تحديث الترتيب بنجاح!');
                            } else {
                                alert('حدث خطأ أثناء تحديث الترتيب.');
                            }
                        });
                }
            });
        });

        function openEditPartModal(partId, partName) {
            document.getElementById('edit_part_name').value = partName;
            document.getElementById('editPartForm').action = `/dashboard/course_parts/${partId}`;
            new bootstrap.Modal(document.getElementById('editPartModal')).show();
        }

        function openDeletePartModal(partId) {
            document.getElementById('deletePartForm').action = `/dashboard/course_parts/${partId}`;
            new bootstrap.Modal(document.getElementById('deletePartModal')).show();
        }
    </script>
@endsection
