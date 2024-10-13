<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f9f9f9;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #8B4513;
        }

        .lead {
            color: #6c757d;
        }

        .text-primary {
            color: #8B4513 !important;
        }

        .rounded {
            border-radius: 10px !important;
        }

        .feature-icon {
            font-size: 2rem;
            color: #8B4513;
            margin-right: 15px;
        }

        .feature-box {
            transition: transform 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-10px);
        }

        .about-section img {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <!-- About Section -->
    <section class="py-5 about-section" id="about">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-12 col-lg-6 col-xl-5">
                    <img class="img-fluid rounded" src="{{ asset('assets/img/apple-icon.png') }}" alt="About Us">
                </div>
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="row justify-content-xl-center">
                        <div class="col-12 col-xl-11">
                            <h2 class="section-title mb-3">من نحن؟</h2>
                            <p class="lead fs-4 text-secondary mb-3">نحن منصة تقدم خدمات التواصل مع أفضل المحامين القريبين لمساعدتك في حل القضايا القانونية وتقديم الاستشارات القانونية بشكل احترافي.</p>
                            <p class="mb-4">نسعى لتقديم خدمات قانونية متميزة من خلال ربطك مع محامين متخصصين في مختلف مجالات القانون. سواء كنت بحاجة إلى استشارات قانونية أو تمثيل قانوني، نحن هنا لنساعدك.</p>
                            <div class="row gy-4 gx-xxl-5">
                                <div class="col-12 col-md-6">
                                    <div class="d-flex feature-box">
                                        <i class="fas fa-balance-scale feature-icon"></i>
                                        <div>
                                            <h2 class="h5 mb-2">محامون متخصصون</h2>
                                            <p class="text-secondary mb-0">نقدم لك أفضل المحامين المتخصصين في مختلف المجالات القانونية لضمان الحصول على أفضل خدمة.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex feature-box">
                                        <i class="fas fa-map-marker-alt feature-icon"></i>
                                        <div>
                                            <h2 class="h5 mb-2">محامون قريبون منك</h2>
                                            <p class="text-secondary mb-0">نساعدك في العثور على محامين بالقرب منك لتقديم الخدمة بسرعة وسهولة.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row gy-4 gx-xxl-5 mt-4">
                                <div class="col-12 col-md-6">
                                    <div class="d-flex feature-box">
                                        <i class="fas fa-shield-alt feature-icon"></i>
                                        <div>
                                            <h2 class="h5 mb-2">الأمان والخصوصية</h2>
                                            <p class="text-secondary mb-0">نحرص على تقديم أعلى معايير الأمان وحماية خصوصيتك في التعامل مع القضايا القانونية.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex feature-box">
                                        <i class="fas fa-comments feature-icon"></i>
                                        <div>
                                            <h2 class="h5 mb-2">استشارات قانونية فورية</h2>
                                            <p class="text-secondary mb-0">احصل على استشارات قانونية فورية من محامين محترفين لمساعدتك في حل مشاكلك القانونية.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
