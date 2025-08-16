<div class="modal fade" id="createInstructorModal" tabindex="-1" role="dialog" aria-labelledby="createInstructorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createInstructorModalLabel">إضافة مدرب جديد لدورة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('instructors.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="course_id">الدورة</label>
                        <select name="course_id" id="course_id" class="form-control" required>
                            <option value="">اختر الدورة</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user_id">المدرب</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">اختر المدرب</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="role">الدور</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="assistant">مساعد</option>
                            <option value="co-trainer">شريك</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
