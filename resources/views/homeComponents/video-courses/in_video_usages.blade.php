@if (Auth::user()->role == 'admin' || Auth::user()->role == 'supervisor' || Auth::user()->role == 'teacher')
    <!-- زر الفلوت -->
    <button type="button" class="btn btn-floating" data-bs-toggle="modal" data-bs-target="#addUsageModal"
        style="position: fixed; 
background-color: #ff9c00; bottom: 20px; right: 20px; border-radius: 50%; width: 60px; height: 60px; box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);">
        <i class="bi bi-plus" style="font-size: 24px; color: #fff;"></i>
    </button>

    <!-- نافذة Modal -->
    <div class="modal fade" id="addUsageModal" tabindex="-1" aria-labelledby="addUsageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"
                style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);">
                <div class="modal-header" style="background-color: #02475E; color: #ffffff; padding: 20px;">
                    <h5 class="modal-title" id="addUsageModalLabel">إضافة بيانات</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: #ffffff; color: #000;"></button>
                </div>
                <div class="modal-body" style="background-color: #072D38; color: #ffffff;">
                    <!-- نموذج إضافة البيانات -->
                    <form action="{{ route('addVideoUsage') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_video_id" value="{{ $video->id }}">

                        <!-- النوع -->
                        <div class="mb-4">
                            <label for="type" class="form-label" style="font-weight: bold;">النوع</label>
                            <select class="form-select" name="type" id="type" required
                                style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
                                <option value="software">برامج مستخدمة</option>
                                <option value="attachment">مرفقات</option>
                            </select>
                        </div>

                        <!-- العنوان -->
                        <div class="mb-4">
                            <label for="title" class="form-label" style="font-weight: bold;">العنوان</label>
                            <input type="text" class="form-control" id="title" name="title" required
                                style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
                        </div>

                        <!-- الوصف -->
                        <div class="mb-4">
                            <label for="description" class="form-label" style="font-weight: bold;">الوصف</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;"></textarea>
                        </div>

                        <!-- الصورة -->
                        <div class="mb-4">
                            <label for="image" class="form-label" style="font-weight: bold;">الصورة</label>
                            <input type="file" class="form-control" id="image" name="image"
                                style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
                        </div>

                        <!-- الملف -->
                        <div class="mb-4">
                            <label for="file" class="form-label" style="font-weight: bold;">الملف</label>
                            <input type="file" class="form-control" id="file" name="file"
                                style="border: 2px solid #02475E; border-radius: 8px; padding: 10px;">
                        </div>

                        <!-- زر الإضافة -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-100"
                                style="background-color: #ff9c00; border: none; border-radius: 8px; padding: 10px 20px; font-weight: bold;">
                                إضافة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
