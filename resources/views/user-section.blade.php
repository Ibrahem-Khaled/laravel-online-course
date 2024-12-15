<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <title>{{ $section->name }}</title>
    <style>
        body {
            font-family: "Cairo", serif;
            background-color: #072D38;
            color: #fff;
            padding-top: 100px;
        }

        .hero-section {
            position: relative;
            height: 300px;
            width: 90%;
            margin: 10px auto;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-background {
            background-image: url("https://media.npr.org/assets/img/2017/04/19/students-in-social-studies-class-2_wide-170b4b5454916941b2d3f29c9442f50e9e1c82e5.jpg?s=1400");
            background-color: rgba(147, 53, 0, 0.5);
            /* لون التلوين مع الشفافية */
            background-blend-mode: overlay;
            /* طريقة الدمج */

            background-size: cover;
            background-position: center;
            filter: blur(3px);
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: right;
            padding: 20px;
        }

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
            color: #ff9c00;
            border-bottom: 3px solid #ff9c00;
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
</head>

<body>
    @include('homeComponents.header')

    <section class="hero-section">
        <!-- الخلفية -->
        <div class="hero-background"></div>

        <!-- المحتوى -->
        <div class="hero-content">
            <h1 class="hero-title">{{ $section->name }}</h1>
            <p class="hero-text">{{ $section->description }}</p>
        </div>
    </section>

    <ul class="nav nav-tabs" id="videoTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button"
                role="tab" aria-controls="students" aria-selected="false">الطلاب</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="teachers-tab" data-bs-toggle="tab" data-bs-target="#teachers" type="button"
                role="tab" aria-controls="teachers" aria-selected="false">المعلمين</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sources-tab" data-bs-toggle="tab" data-bs-target="#sources" type="button"
                role="tab" aria-controls="sources" aria-selected="false">
                المنهج والدورات
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                type="button" role="tab" aria-controls="details" aria-selected="true">
                معلومات عن الفصل
            </button>
        </li>
    </ul>
    <div class="tab-content" id="videoTabsContent">
        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
            @include('homeComponents.section.details')
        </div>
        <div class="tab-pane fade" id="sources" role="tabpanel" aria-labelledby="sources-tab">
            <section class="mt-5" style="text-align: right; width: 90%; margin: 10px auto;">
                <h2 class="info-header">المنهج والدورات</h2>
                <div style="display: flex; flex-wrap: wrap; justify-content: space-around;">
                    @foreach ($sectionCourses as $course)
                        @include('homeComponents.home.course-card', ['course' => $course])
                    @endforeach
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="teachers" role="tabpanel" aria-labelledby="teachers-tab">
            <section class="mt-5" style="text-align: right; width: 90%; margin: 10px auto;">
                <h2 class="info-header">معلمين
                    الفصل</h2>
                <div style="display: flex; flex-wrap: wrap; justify-content: space-around;">
                    @foreach ($section->users->where('role', 'teacher') as $user)
                        @include('homeComponents.section.teachers')
                    @endforeach
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
            <section class="mt-5" style="text-align: right; width: 90%; margin: 10px auto;">
                <h2 class="info-header">طلاب</h2>
                @include('homeComponents.section.students', [
                    ($students = $section->users->where('role', 'student')),
                    ($trainer = $section->users->where('role', 'teacher')->first()),
                ])
            </section>
        </div>
    </div>

    @if (Auth::user()->role == 'teacher')
        <button type="button" class="btn btn-floating" data-bs-toggle="modal" data-bs-target="#addCourseModal"
            style="position: fixed; 
        background-color: #ff9c00; bottom: 20px; right: 20px; border-radius: 50%; width: 60px; height: 60px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <i class="bi bi-plus" style="font-size: 24px; color: #fff;"></i>
        </button>

        <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="background-color: #02475E; color: #fff;">
                    <div class="modal-header" style="border-bottom: 1px solid #ff9c00;">
                        <h5 class="modal-title" id="addCourseModalLabel">إدارة الفصل</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs" id="addCourseTabs" role="tablist"
                            style="border-bottom: 1px solid #ff9c00;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="add-course-tab" data-bs-toggle="tab"
                                    data-bs-target="#add-course" type="button" role="tab"
                                    aria-controls="add-course" aria-selected="true"
                                    style="color: #fff; background-color: transparent;">إضافة دورة</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="upload-video-tab" data-bs-toggle="tab"
                                    data-bs-target="#upload-video" type="button" role="tab"
                                    aria-controls="upload-video" aria-selected="false"
                                    style="color: #fff; background-color: transparent;">رفع
                                    فيديوهات</button>
                            </li>
                        </ul>

                        <!-- Tabs Content -->
                        <div class="tab-content" id="addCourseTabsContent">
                            <!-- Add Course Tab -->
                            <div class="tab-pane fade show active" id="add-course" role="tabpanel"
                                aria-labelledby="add-course-tab">
                                <form action="{{ route('addCourseFromSection') }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="courseName" class="form-label">اختر الدورة</label>
                                        <select class="form-select" name="course_id" id="courseName">
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="section_id" value="{{ $section->id }}">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">إضافة</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Upload Video Tab -->
                            <div class="tab-pane fade" id="upload-video" role="tabpanel"
                                aria-labelledby="upload-video-tab">
                                <form action="{{ route('addVideoFromCourse') }}" method="POST"
                                    enctype="multipart/form-data" class="mt-3">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="courseSelect" class="form-label">اختر الدورة</label>
                                        <select class="form-select" name="course_id" id="courseSelect">
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="videoTitle" class="form-label">عنوان الفيديو</label>
                                        <input type="text" class="form-control" id="videoTitle" name="title"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="videoCode" class="form-label">كود الفيديو</label>
                                        <textarea type="text" class="form-control" id="videoTitle" name="video" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="videoDescription" class="form-label">وصف الفيديو</label>
                                        <input type="text" class="form-control" id="videoTitle"
                                            name="description" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="question" class="form-label">سوال الواجب</label>
                                        <input type="text" class="form-control" id="question" name="question">
                                    </div>
                                    <div class="mb-3">
                                        <label for="videoImage" class="form-label">صورة الفيديو</label>
                                        <input type="file" class="form-control" id="videoFile" name="image">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">رفع الفيديو</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #ff9c00;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('homeComponents.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</body>

</html>
