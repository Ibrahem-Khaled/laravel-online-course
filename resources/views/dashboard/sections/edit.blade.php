<div class="modal fade" id="editSectionModal{{ $section->id }}" tabindex="-1" aria-labelledby="editSectionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSectionModalLabel">تعديل القسم: {{ $section->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sections.update', $section->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">اسم القسم</label>
                                <input type="text" class="form-control" name="name" value="{{ $section->name }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type" class="form-label">نوع القسم</label>
                                <select class="form-select" name="type" required>
                                    <option value="ambitious_program"
                                        {{ $section->type == 'ambitious_program' ? 'selected' : '' }}>البرنامج الطموح 1
                                    </option>
                                    <option value="ambitious_program2"
                                        {{ $section->type == 'ambitious_program2' ? 'selected' : '' }}>البرنامج الطموح 2
                                    </option>
                                    <option value="entrepreneurship_program"
                                        {{ $section->type == 'entrepreneurship_program' ? 'selected' : '' }}>ريادة
                                        الأعمال</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea class="form-control" name="description" rows="3">{{ $section->description }}</textarea>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="meeting_link" class="form-label">رابط الاجتماع</label>
                                <input type="url" class="form-control" name="meeting_link"
                                    value="{{ $section->meeting_link }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image" class="form-label">صورة القسم</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                                @if ($section->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $section->image) }}" width="50"
                                            height="50" class="rounded" alt="صورة القسم الحالية">
                                        <small class="d-block text-muted">الصورة الحالية</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
