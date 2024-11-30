<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
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
    <!-- Include Header -->
    @include('homeComponents.header')

    <!-- Hero Section -->
    @include('homeComponents.home.hero-section')

    <!-- Card Counter Section -->
    @include('homeComponents.home.card-counter')

    <!-- هدف المنصة -->
    <section class="d-flex flex-column align-items-center justify-content-center mt-5"
        style="text-align: center; max-width: 60%; margin: auto;">
        <div class="mt-4">
            <h4 class="mb-4">ما هو هدف المنصة التعليمية؟</h4>
            <p class="mb-4">
                تدور مميزات المنصة التعليمية حول الارتقاء بعملية التعلم ككل وتكثير الثمار المرجوة من تجربة التعلم قدر
                الإمكان، فتستهدف المنصة التعليمية تعزيز إمكانية الوصول للمحتوى التعليمي والحرص على شمولية التجربة
                التعليمية، وتوفير تجربة تعليمية مخصصة، وتسهيل التعلم التعاوني، والتقييم المستمر.
            </p>
        </div>
    </section>

    <!-- أفضل المعلمين -->
    @include('homeComponents.home.best-teachers')

    <!-- Footer -->
    @include('homeComponents.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>
