<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-ct.png') }}">
    <title>منصة الرواد التعليمية</title>
    <style>
        body {
            font-family: "Cairo", serif;
            background-color: #072D38;
            color: #fff;
            margin: 0;
            padding-top: 100px;

        }

        h4 {
            color: #F4813E;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            section {
                max-width: 90%;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .hero-text {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    @include('homeComponents.home.hero-section')

    @include('homeComponents.home.card-counter')

    <section class="d-flex flex-column align-items-center justify-content-center mt-5"
        style="text-align: center; max-width: 60%; margin: auto;">
        <div class="mt-4">
            <h4 class="mb-4">ما هو هدف المنصة التعليمية؟</h4>
            <p class="mb-4">
                تهدف المنصة التعليمية للإرتقاء بمستوى التعلم وخلق تجربة تعليمية رائدة كما تعزز إمكانية الوصول للمحتوى
                التعليمي بسهولة وسلاسة
            </p>
        </div>
    </section>

    {{-- <section class="d-flex flex-column align-items-center justify-content-center mt-5"
        style="text-align: center; max-width: 80%; margin: auto;">
        <div class="mt-4">
            <h4 class="mb-4">من خلال الانضمام إلى منصة التعلم الإلكتروني، يمكنك الاستفادة من الكثير من الفوائد.</h4>

            <!-- Carousel -->
            <div id="coursesCarousel" class="carousel slide" data-bs-ride="carousel"
                style="position: relative; height: auto;">
                <div class="carousel-inner">
                    @foreach ($courses->chunk(3) as $chunkIndex => $chunk)
                        <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                            <div class="d-flex justify-content-center">
                                @foreach ($chunk as $course)
                                    @include('homeComponents.home.course-card', ['course' => $course])
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#coursesCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">السابق</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#coursesCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">التالي</span>
                </button>
            </div>
        </div>
    </section> --}}

    <section class="d-flex flex-column align-items-center justify-content-center mt-5" style="text-align: center;">
        <img src="{{ asset('assets/img/medileHero.png') }}" alt="Shape 1" class="img-fluid">
    </section>

    @include('homeComponents.home.best-teachers')

    <section class="d-flex flex-column align-items-center justify-content-center mt-5" style="text-align: center;">
        <h4 class="mb-4" style="color: #F4813E; font-size: 24px;">الفصول الدراسية</h4>
        <div id="sectionsCarousel" class="carousel slide" data-bs-ride="carousel"
            style="position: relative; height: auto; width: 100%;">
            <div class="carousel-inner" style="max-width: 80%; margin: auto;">
                @foreach ($sections->chunk(3) as $chunkIndex => $chunk)
                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                        <div class="row justify-content-center">
                            @foreach ($chunk as $item)
                                <div class="col-md-4">
                                    <div class="card" style="background-color: transparent; height: 100%;">
                                        <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fjooinn.com%2Fimages%2Fprimary-school-classroom-5.jpg&f=1&nofb=1&ipt=d0a230bf6063cbbccf4406ca3e5e8f535a0110357aea1e44cedb46d9629552dc&ipo=images' }}"
                                            class="card-img-top" alt="{{ $item->name }}"
                                            style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title" style="color: #fff; font-weight: bold;">
                                                {{ $item->name }}
                                            </h5>
                                            <p class="card-text" style="color: #aaa;">{{ $item->description }}</p>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div
                                                    style="background-color: #035971; padding: 10px 20px; border-radius: 15px; display: flex; align-items: center;">
                                                    <img src="https://via.placeholder.com/40"
                                                        class="rounded-circle me-2" alt="طالب">
                                                    <img src="https://via.placeholder.com/40"
                                                        class="rounded-circle me-2" alt="طالب">
                                                    <img src="https://via.placeholder.com/40"
                                                        class="rounded-circle me-2" alt="طالب">
                                                    <span
                                                        style="color: white; margin-left: 10px;">+{{ $item->users->where('role', 'student')->count() }}</span>
                                                </div>
                                            </div>
                                            <p class="mt-3" style="color: #fff;">الطلاب المتفاعلون يوميًا</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#sectionsCarousel" data-bs-slide="prev"
                style="position: absolute; top: 6rem; transform: translateY(-50%); z-index: 2; left: -3rem;">
                <span class="carousel-control-prev-icon bg-dark p-3 rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">السابق</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#sectionsCarousel" data-bs-slide="next"
                style="position: absolute; top: 6rem; transform: translateY(-50%); z-index: 2; right: -3rem;">
                <span class="carousel-control-next-icon bg-dark p-3 rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">التالي</span>
            </button>
        </div>
    </section>

    <section class="d-flex flex-column align-items-center justify-content-center mt-5"
        style="text-align: center; max-width: 60%; margin: auto;">
        <img src="{{ asset('assets/img/user-reports.png') }}" alt="Shape 1" class="img-fluid">
    </section>
    <!-- Footer -->
    @include('homeComponents.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>
