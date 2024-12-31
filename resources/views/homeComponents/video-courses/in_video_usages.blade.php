@if (Auth::user()->role == 'admin' || Auth::user()->role == 'supervisor' || Auth::user()->role == 'teacher')
    <!-- زر الإضافة -->
    <button type="button" class="btn" style="background-color: #ed6b2f; color: #fff;" data-bs-toggle="modal"
        data-bs-target="#addUsageModal" style="margin-bottom: 20px;">
        إضافة مرفقات الدرس
    </button>

    <!-- نافذة Modal -->
    <div class="modal fade" id="addUsageModal" tabindex="-1" aria-labelledby="addUsageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header" style="background-color: #02475E; color: #ffffff;">
                    <h5 class="modal-title" id="addUsageModalLabel">إضافة مرفقات الدرس</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: #ffffff; color: #000;"></button>
                </div>
                <div class="modal-body" style="background-color: #072D38; color: #ffffff;">
                    <!-- نموذج إضافة البيانات -->
                    <form action="{{ route('addVideoUsage') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_video_id" value="{{ $video->id }}">

                        <div id="dynamic-fields">
                            <div class="field-group">
                                <!-- النوع -->
                                <div class="mb-4">
                                    <label for="type" class="form-label" style="font-weight: bold;">النوع</label>
                                    <select class="form-select" name="usages[0][type]" required
                                        style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
                                        <option value="attachment">مرفقات</option>
                                    </select>
                                </div>

                                <!-- العنوان -->
                                <div class="mb-4">
                                    <label for="title" class="form-label" style="font-weight: bold;">العنوان</label>
                                    <input type="text" class="form-control" name="usages[0][title]" required
                                        style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
                                </div>

                                <!-- الوصف -->
                                <div class="mb-4">
                                    <label for="description" class="form-label" style="font-weight: bold;">الوصف</label>
                                    <textarea class="form-control" name="usages[0][description]" rows="3"
                                        style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;"></textarea>
                                </div>

                                <!-- الصورة -->
                                <div class="mb-4">
                                    <label for="image" class="form-label" style="font-weight: bold;">الصورة</label>
                                    <input type="file" class="form-control" name="usages[0][image]"
                                        style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
                                </div>

                                <!-- الملفات -->
                                <div class="mb-4">
                                    <label for="files" class="form-label" style="font-weight: bold;">الملفات</label>
                                    <input type="file" class="form-control" name="usages[0][files][]" multiple
                                        style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
                                    <small class="text-muted">يمكنك رفع أكثر من ملف (PDF, DOC, ZIP, TXT).</small>
                                </div>
                            </div>
                        </div>

                        <!-- زر إضافة حقل جديد -->
                        <div class="mb-4">
                            <button type="button" id="add-field" class="btn btn-secondary">إضافة حقل جديد</button>
                        </div>

                        <!-- زر الإضافة -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-100"
                                style="background-color: #ed6b2f; border: none; border-radius: 8px; padding: 10px 20px; font-weight: bold;">
                                إضافة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let fieldIndex = 1;

            document.getElementById('add-field').addEventListener('click', function() {
                const fieldsContainer = document.getElementById('dynamic-fields');
                const newFieldGroup = document.createElement('div');
                newFieldGroup.className = 'field-group';

                newFieldGroup.innerHTML = `
            <hr>
            <!-- النوع -->
            <div class="mb-4">
                <label class="form-label" style="font-weight: bold;">النوع</label>
                <select class="form-select" name="usages[${fieldIndex}][type]" required
                    style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
                    <option value="attachment">مرفقات</option>
                </select>
            </div>

            <!-- العنوان -->
            <div class="mb-4">
                <label class="form-label" style="font-weight: bold;">العنوان</label>
                <input type="text" class="form-control" name="usages[${fieldIndex}][title]" required
                    style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
            </div>

            <!-- الوصف -->
            <div class="mb-4">
                <label class="form-label" style="font-weight: bold;">الوصف</label>
                <textarea class="form-control" name="usages[${fieldIndex}][description]" rows="3"
                    style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;"></textarea>
            </div>

            <!-- الصورة -->
            <div class="mb-4">
                <label class="form-label" style="font-weight: bold;">الصورة</label>
                <input type="file" class="form-control" name="usages[${fieldIndex}][image]"
                    style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
            </div>

            <!-- الملفات -->
            <div class="mb-4">
                <label class="form-label" style="font-weight: bold;">الملفات</label>
                <input type="file" class="form-control" name="usages[${fieldIndex}][files][]" multiple
                    style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
                <small class="text-muted">يمكنك رفع أكثر من ملف (PDF, DOC, ZIP, TXT).</small>
            </div>
        `;

                fieldsContainer.appendChild(newFieldGroup);
                fieldIndex++;
            });
        });
    </script>
@endif
