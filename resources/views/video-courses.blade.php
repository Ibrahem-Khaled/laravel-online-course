<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..800&display=swap" rel="stylesheet">
    <title>{{ $course->title }} - تفاصيل الدورة</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            background-color: #072D38;
            color: #fff;
            margin: 0;
            padding-top: 100px;
        }

        .form-control {
            flex-grow: 1;
            border-width: 0;
            padding: 10px;
            background-color: #072D38;
            color: #fff;
        }

        .form-control::placeholder {
            color: #fff;
            opacity: .5;
        }

        .form-control:focus {
            background-color: #035971;
            color: #fff;
            outline: none;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
        }

        .main-content {
            padding: 30px;
        }

        .course-title {
            color: #ffffff;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .course-info {
            padding: 20px;
            border-radius: 10px;
            position: relative;
        }

        .rating-container .rating-text {
            font-size: 1rem;
            font-weight: bold;
        }

        .rating-stars i {
            font-size: 1.2rem;
        }

        .rating-stars .fa-star,
        .rating-stars .fa-star-half-alt {
            animation: shine 1.5s infinite;
        }

        @keyframes shine {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }

            100% {
                opacity: 1;
            }
        }

        .course-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
            color: #fff;
        }

        .course-meta span {
            display: inline-block;
            margin-right: 10px;
            color: #ffffff;
        }

        .video-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .trainer-info {
            display: flex;
            align-items: center;
        }

        .trainer-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-left: 10px;
        }

        .nav-tabs {
            border-bottom: 2px solid #02475E;
            justify-content: space-around;
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
            background-color: #02475E;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')
    @if ($errors->any())
        <div class="alert alert-danger w-50 mx-auto align-self-center">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container main-content">
        <!-- معلومات الدورة -->
        <div class="row">
            <div class="col-lg-8">
                <div class="course-info">
                    <h2 class="course-title">{{ $course->title }}</h2>
                    <div class="course-meta">
                        {{-- <div class="trainer-info">
                            <img src="{{ $course->user->image ? asset('storage/' . $course->user->image) : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png' }}"
                                alt="Trainer Image">
                            <div>
                                <p class="m-0">{{ $course->user->name }}</p>
                                <small>خبير ومدرب</small>
                            </div>
                        </div>
                        <h6>|</h6> --}}
                        <span>المتطلبات:
                            {{ $course->requirements()?->where('type', 'software')->first()?->title ?? 'لا توجد متطلبات حالياً' }}</span>
                        <h6>|</h6>
                        <span>عدد الساعات:
                            {{ $course->duration_in_hours }}</span>
                        <h6>|</h6>
                        <span>مستوى الدورة:
                            @if ($course->difficulty_level == 'beginner')
                                للمبتدئين
                            @elseif ($course->difficulty_level == 'intermediate')
                                للمتوسطين
                            @elseif ($course->difficulty_level == 'advanced')
                                للمتقدمين
                            @endif
                        </span>
                        <h6>|</h6>
                        <div class="d-flex align-items-center gap-2 rating-container">
                            <span class="badge text-white text-dark rating-text" style="background-color: #ed6b2f;">
                                {{ round($course->ratings?->avg('rating') ?? 0, 1) }}
                            </span>
                            <div class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($course->ratings?->avg('rating') ?? 0))
                                        <i class="fas fa-star" style="color: #ed6b2f;"></i>
                                    @elseif ($i - ($course->ratings?->avg('rating') ?? 0) < 1)
                                        <i class="fas fa-star-half-alt" style="color: #ed6b2f;"></i>
                                    @else
                                        <i class="far fa-star text-secondary"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        {{-- <h6>|</h6>
                        <span>السعر: ${{ $course->price }}</span> --}}
                    </div>
                </div>

                <!-- تضمين الفيديو -->
                <div class="video-container">
                    {!! $video->video !!}
                </div>

                <!-- التابات -->
                <ul class="nav nav-tabs" id="videoTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-toggle="tab" data-target="#details"
                            type="button" role="tab" aria-controls="details" aria-selected="true">
                            محتوي الدرس</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sources-tab" data-toggle="tab" data-target="#sources"
                            type="button" role="tab" aria-controls="sources" aria-selected="false">
                            المرفقات
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="homework-tab" data-toggle="tab" data-target="#homework"
                            type="button" role="tab" aria-controls="homework"
                            aria-selected="false">الواجبات</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="discussion-tab" data-toggle="tab" data-target="#discussion"
                            type="button" role="tab" aria-controls="discussion"
                            aria-selected="false">المناقشة</button>
                    </li>
                </ul>
                <div class="tab-content" id="videoTabsContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'supervisor', 'teacher']))
                            <!-- محرر النصوص -->
                            <form action="{{ route('videos.updateDescription', $video->id) }}" method="POST"
                                id="description-form">
                                @csrf
                                @method('PUT')
                                <div id="description-editor" style="height: 300px;">{!! $video->description !!}</div>
                                <input type="hidden" name="description" id="description-input">
                                <button type="submit" class="btn btn-primary mt-3">حفظ التعديلات</button>
                            </form>
                        @else
                            <!-- عرض الوصف فقط -->
                            <h6 class="text-white text-right mt-3 p-3" style="line-height: 2;">{{ $video->description }}
                            </h6>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="sources" role="tabpanel" aria-labelledby="sources-tab">
                        @include('homeComponents.video-courses.video-software')
                    </div>
                    <div class="tab-pane fade" id="homework" role="tabpanel" aria-labelledby="homework-tab">
                        @include('homeComponents.video-courses.video-homework')
                    </div>
                    <div class="tab-pane fade" id="discussion" role="tabpanel" aria-labelledby="discussion-tab">
                        @include('homeComponents.video-courses.video-discussion')
                    </div>
                </div>
            </div>

            @include('homeComponents.video-courses.sidebar')
        </div>
    </div>
    @include('homeComponents.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('description-editor')) {
                var quill = new Quill('#description-editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'], // تنسيقات النصوص
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }], // القوائم
                            ['link'] // الروابط
                        ]
                    }
                });

                // عند إرسال النموذج، قم بنقل محتوى المحرر إلى الحقل المخفي
                document.getElementById('description-form').addEventListener('submit', function(e) {
                    document.getElementById('description-input').value = quill.root.innerHTML;
                });
            }
        });
    </script>
    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

</body>

</html>
