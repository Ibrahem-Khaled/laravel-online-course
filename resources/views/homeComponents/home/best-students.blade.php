<style>
    .student-section {
        text-align: center;
        padding: 50px 0;
        position: relative;
        width: 90%;
        margin: auto;
        overflow: hidden;
    }

    .swiper-wrapper {
        justify-content: center;
        /* يضمن أن الشرائح تبقى في المنتصف */
    }

    .student-section h2 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 30px;
        color: #fff;
    }

    .student-card {
        background-color: #055160;
        border-radius: 50%;
        text-align: center;
        padding: 20px;
        width: 200px;
        height: 200px;
        margin: 20px auto;
        position: relative;
        overflow: hidden;
    }

    .student-card img {
        width: 100%;
        height: auto;
        border-radius: 50%;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
    }

    .student-name {
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 15px;
        color: #fff;
    }

    .student-title {
        font-size: 0.9rem;
        background-color: #035971;
        color: #ffffff;
        padding: 5px 15px;
        border-radius: 8px;
        display: inline-block;
        margin-top: 5px;
    }

    .student-row {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    .swiper-container {
        width: 100%;
        padding: 50px 0;
        position: relative;
        /* لضمان أن الأزرار والباجينيشن داخل القسم */
    }

    .swiper-slide {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: #fff;
        font-size: 2rem;
        position: absolute;
        top: 50%;
        /* لجعلها في منتصف القسم */
        transform: translateY(-50%);
        z-index: 10;
    }

    .swiper-button-next {
        right: 10px;
        /* قربه من الحافة اليمنى */
    }

    .swiper-button-prev {
        left: 10px;
        /* قربه من الحافة اليسرى */
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

@if ($students->count() > 0)
    <section class="student-section">
        <h2>{{ $title ?? 'طلاب برنامج طموح' }}</h2>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($students as $student)
                    <div class="swiper-slide">
                        <div class="student-card">
                            <img src="{{ $student->profile_image }}" alt="Student Image">
                        </div>
                        <h4 class="student-name">{{ $student->name }}</h4>
                    </div>
                @endforeach
            </div>

            <!-- أزرار التنقل -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <!-- (يمكن إضافة pagination إذا رغبت) -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
@else
    <h4 class="text-center mt-5">لا يوجد طلاب برنامج طموح</h4>
@endif

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ضبط عدد الشرائح التي ستظهر في العرض اعتماداً على عدد الطلاب المتوفر
        var slidesToShow = {{ $students->count() < 4 ? $students->count() : 4 }};
        // تعطيل خاصية التكرار (loop) إذا كان عدد الشرائح غير كافٍ
        var loopSetting = {{ $students->count() >= 4 ? 'true' : 'false' }};

        new Swiper('.swiper-container', {
            slidesPerView: slidesToShow, // عدد العناصر في العرض الواحد
            spaceBetween: 30, // المسافة بين العناصر
            loop: loopSetting, // التكرار
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 3000, // المدة بين كل تقليب (بالميلي ثانية)
                disableOnInteraction: false, // استمرار التشغيل التلقائي حتى بعد التفاعل
            },
        });
    });
</script>
