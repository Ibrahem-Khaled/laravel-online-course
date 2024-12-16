<style>
    .teacher-section {
        text-align: center;
        padding: 50px 0;
        position: relative;
        width: 90%;
        margin: auto;
        overflow: hidden;
    }

    .teacher-section h2 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 30px;
        color: #fff;
    }

    .teacher-card {
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

    .teacher-card img {
        width: 100%;
        height: auto;
        border-radius: 50%;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
    }

    .teacher-name {
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 15px;
        color: #fff;
    }

    .teacher-title {
        font-size: 0.9rem;
        background-color: #035971;
        color: #ffffff;
        padding: 5px 15px;
        border-radius: 8px;
        display: inline-block;
        margin-top: 5px;
    }

    .teacher-row {
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

@if ($students->count() > 0)
    <section class="teacher-section">
        <h2>طلاب برنامج طموح</h2>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($students as $teacher)
                    <div class="swiper-slide">
                        <div class="teacher-card">
                            <img src="{{ $teacher->image
                                ? asset('storage/' . $teacher->image)
                                : ($teacher->userInfo?->gender == 'female'
                                    ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png'
                                    : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png') }}"
                                alt="Teacher Image">
                        </div>
                        <h4 class="teacher-name">{{ $teacher->name }}</h4>
                    </div>
                @endforeach
            </div>

            <!-- أزرار التنقل -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>


        </div>
    </section>
@else
    <h4 class="text-center mt-5">لا يوجد طلاب برنامج طموح</h4>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Swiper('.swiper-container', {
            slidesPerView: 4, // عدد العناصر في العرض الواحد
            spaceBetween: 30, // المسافة بين العناصر
            loop: true, // التكرار
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
            }
        });
    });
</script>
