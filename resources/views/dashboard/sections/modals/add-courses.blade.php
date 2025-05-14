<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('sections.addCourse', $section->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">إضافة كورسات إلى القسم</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <div id="courses-wrapper">
                        <div class="course-group row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">اختر كورس</label>
                                <select name="courses[0][id]" class="form-select" required>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">الحالة</label>
                                <select name="courses[0][status]" class="form-select" required>
                                    <option value="active">مفعل</option>
                                    <option value="draft">مسودة</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-course">حذف</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-more">إضافة كورس آخر</button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">حفظ</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    let courseIndex = 1;

    document.getElementById('add-more').addEventListener('click', function() {
        const wrapper = document.getElementById('courses-wrapper');
        const group = document.createElement('div');
        group.classList.add('course-group', 'row', 'mb-3');
        group.innerHTML = `
      <div class="col-md-6">
        <select name="courses[${courseIndex}][id]" class="form-select" required>
          @foreach ($courses as $course)
            <option value="{{ $course->id }}">{{ $course->title }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <select name="courses[${courseIndex}][status]" class="form-select" required>
          <option value="active">مفعل</option>
          <option value="draft">مسودة</option>
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="button" class="btn btn-danger remove-course">حذف</button>
      </div>
    `;
        wrapper.appendChild(group);
        courseIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-course')) {
            e.target.closest('.course-group').remove();
        }
    });
</script>
