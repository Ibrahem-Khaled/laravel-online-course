<div class="modal fade" id="editInstructorModal{{ $instructor->id }}" tabindex="-1" role="dialog" aria-labelledby="editInstructorModalLabel{{ $instructor->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInstructorModalLabel{{ $instructor->id }}">تعديل بيانات المدرب</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('instructors.update', $instructor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                     <div class="form-group">
                        <label for="course_id_{{ $instructor->id }}">الدورة</label>
                        <select name="course_id" id="course_id_{{ $instructor->id }}" class="form-control" required>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $instructor->course_id == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user_id_{{ $instructor->id }}">المدرب</label>
                        <select name="user_id" id="user_id_{{ $instructor->id }}" class="form-control" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $instructor->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="role_{{ $instructor->id }}">الدور</label>
                        <select name="role" id="role_{{ $instructor->id }}" class="form-control" required>
                            <option value="assistant" {{ $instructor->role == 'assistant' ? 'selected' : '' }}>مساعد</option>
                            <option value="co-trainer" {{ $instructor->role == 'co-trainer' ? 'selected' : '' }}>شريك</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">تحديث</button>
                </div>
            </form>
        </div>
    </div>
</div>
