<style>
    .nav-tabs {
        border-bottom: 2px solid #02475E;
        justify-content: space-around;
        width: 90%;
        margin: 10px auto;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #ffffff;
        font-weight: bold;
        padding: 10px 15px;
        border-radius: 0;
        background-color: transparent;
    }

    .nav-tabs .nav-link.active {
        color: #ed6b2f;
        border-bottom: 3px solid #ed6b2f;
        background-color: #072D38;
    }

    .tab-content {
        padding: 15px;
        border-radius: 10px;
        margin-top: 10px;
        width: 90%;
        margin: 10px auto;
    }
</style>

@if (Auth::user()->role == 'teacher' || Auth::user()->role == 'admin' || Auth::user()->role == 'supervisor')
    <button type="button" class="btn btn-floating" data-toggle="modal" data-target="#addCourseModal"
        style="position: fixed; 
background-color: #ed6b2f; bottom: 20px; right: 20px; border-radius: 50%; width: 60px; height: 60px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <i class="bi bi-plus" style="font-size: 24px; color: #fff;"></i>
    </button>

    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: #02475E; color: #fff;">
                <div class="modal-header" style="border-bottom: 1px solid #ed6b2f;">
                    <h5 class="modal-title" id="addCourseModalLabel">إدارة الدرس</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="addCourseTabs" role="tablist"
                        style="border-bottom: 1px solid #ed6b2f;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upload-video-tab" data-toggle="tab"
                                data-target="#upload-video" type="button" role="tab"
                                aria-controls="upload-video" aria-selected="true">رفع دروس</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="edit-video-tab" data-toggle="tab"
                                data-target="#edit-video" type="button" role="tab" aria-controls="edit-video"
                                aria-selected="false">تحرير دروس</button>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content" id="addCourseTabsContent">
                        <!-- Upload Video Tab -->
                        <div class="tab-pane fade show active" id="upload-video" role="tabpanel"
                            aria-labelledby="upload-video-tab">
                            <form action="{{ route('addVideoFromCourse') }}" method="POST"
                                enctype="multipart/form-data" class="mt-3">
                                @csrf
                                <input type="hidden" name="section_id" value="{{ $section->id }}">
                                <!-- اختيار أو إنشاء دورة -->
                                <div class="mb-3">
                                    <label for="courseOption" class="form-label">إجراء الدورة</label>
                                    <select class="form-select" id="courseOption" name="course_option" required>
                                        <option value="existing">اختر دورة موجودة</option>
                                        <option value="new">إنشاء دورة جديدة</option>
                                    </select>
                                </div>

                                <!-- اختيار دورة موجودة -->
                                <div class="mb-3" id="existingCourseDiv">
                                    <label for="courseSelect" class="form-label">اختر الدورة</label>
                                    <select class="form-select" name="course_id" id="courseSelect">
                                        @foreach ($sectionCourses as $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- إنشاء دورة جديدة -->
                                <div id="newCourseDiv" style="display: none;">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">اختر الفئة</label>
                                        <select class="form-select" name="category_id" id="category_id" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="newCourseTitle" class="form-label">عنوان الدورة</label>
                                        <input type="text" class="form-control" id="newCourseTitle"
                                            name="new_course_title">
                                    </div>
                                    <div class="mb-3">
                                        <label for="newCourseDescription" class="form-label">وصف الدورة</label>
                                        <textarea class="form-control" id="newCourseDescription" name="new_course_description"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="newCourseImage" class="form-label">صورة الدورة</label>
                                        <input type="file" class="form-control" id="newCourseImage"
                                            name="new_course_image">
                                    </div>
                                </div>

                                <!-- باقي الحقول الخاصة بالفيديو -->
                                <div class="mb-3">
                                    <label for="videoTitle" class="form-label">عنوان الفيديو</label>
                                    <input type="text" class="form-control" id="videoTitle" name="title"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="videoCode" class="form-label">كود الفيديو</label>
                                    <textarea class="form-control" id="videoCode" name="video" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="videoDescription" class="form-label">وصف الفيديو</label>
                                    <input type="text" class="form-control" id="videoDescription"
                                        name="description" required>
                                </div>
                                <div class="mb-3">
                                    <label for="question" class="form-label">سؤال الواجب</label>
                                    <input type="text" class="form-control" id="question" name="question">
                                </div>
                                <div class="mb-3">
                                    <label for="videoImage" class="form-label">صورة الفيديو</label>
                                    <input type="file" class="form-control" id="videoImage" name="image">
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning w-100"
                                        style="background-color: #ed6b2f; color: #fff;">رفع الفيديو</button>
                                </div>
                            </form>
                        </div>


                        <!-- Edit Video Tab -->
                        <div class="tab-pane fade" id="edit-video" role="tabpanel" aria-labelledby="edit-video-tab">
                            @php
                                $videos = App\Models\CourseVideo::whereHas('course', function ($query) {
                                    $query->where('user_id', auth()->id());
                                })->get();
                            @endphp
                            <form action="{{ route('editVideoFromCourse') }}" method="POST"
                                enctype="multipart/form-data" class="mt-3">
                                @method('PUT')
                                @csrf
                                <input type="hidden" id="course_id" name="course_id">
                                <div class="mb-3">
                                    <label for="editCourseSelect" class="form-label">اختر الفيديو للتحرير</label>
                                    <select class="form-select" name="video_id" id="editCourseSelect">
                                        @foreach ($videos as $video)
                                            <option value="{{ $video->id }}">{{ $video->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editVideoTitle" class="form-label">عنوان الفيديو</label>
                                    <input type="text" class="form-control" id="editVideoTitle" name="title">
                                </div>
                                <div class="mb-3">
                                    <label for="editVideoCode" class="form-label">كود الفيديو</label>
                                    <textarea class="form-control" id="editVideoCode" name="video"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="editVideoDescription" class="form-label">وصف الفيديو</label>
                                    <input type="text" class="form-control" id="editVideoDescription"
                                        name="description">
                                </div>
                                <div class="mb-3">
                                    <label for="question" class="form-label">سؤال الواجب</label>
                                    <input type="text" class="form-control" id="question" name="question">
                                </div>
                                <div class="mb-3">
                                    <label for="editVideoImage" class="form-label">صورة الفيديو</label>
                                    <input type="file" class="form-control" id="editVideoImage" name="image">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success  w-100">تحرير الفيديو</button>
                                </div>
                            </form>
                        </div>



                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #ed6b2f;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endif
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const courseId = document.getElementById('course_id');
        const videoSelect = document.getElementById('editCourseSelect');
        const videoTitle = document.getElementById('editVideoTitle');
        const videoCode = document.getElementById('editVideoCode');
        const videoDescription = document.getElementById('editVideoDescription');
        const videoQuestion = document.getElementById('question');

        videoSelect.addEventListener('change', function() {
            const videoId = this.value;

            if (videoId) {
                fetch(`/video/${videoId}`)
                    .then(response => response.json())
                    .then(data => {
                        courseId.value = data.course_id;
                        videoTitle.value = data.title;
                        videoCode.value = data.video;
                        videoDescription.value = data.description;
                        videoQuestion.value = data.question;
                    })
                    .catch(error => console.error('Error fetching video data:', error));
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const courseOption = document.getElementById("courseOption");
        const existingCourseDiv = document.getElementById("existingCourseDiv");
        const newCourseDiv = document.getElementById("newCourseDiv");

        courseOption.addEventListener("change", function() {
            if (this.value === "new") {
                existingCourseDiv.style.display = "none";
                newCourseDiv.style.display = "block";
            } else {
                existingCourseDiv.style.display = "block";
                newCourseDiv.style.display = "none";
            }
        });
    });
</script>
