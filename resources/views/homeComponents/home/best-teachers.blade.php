<style>
    .teacher-section {
        text-align: center;
        padding: 50px 0;
        margin: 50px 0;
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
        width: 250px;
        height: 250px;
        margin: auto;
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

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(1);
    }
</style>

<section class="teacher-section">
    <h2>تعلم على يد أفضل المعلمين</h2>
    <div id="teacherCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($teachers as $teacher)
                <!-- الشريحة الأولى -->
                <div class="carousel-item active">
                    <div class="teacher-card">
                        <img src="{{ asset('storage/' . $teacher->image) }}" alt="Teacher Image">
                    </div>
                    <h4 class="teacher-name">{{ $teacher->name }}</h4>
                    <p class="teacher-title"> {{ $teacher->userInfo?->degree ?? 'لا يوجد علم في الملف الشخصي للمعلم' }}
                    </p>
                </div>
            @endforeach

        </div>
        <!-- أزرار التحكم -->
        <button class="carousel-control-prev" type="button" data-bs-target="#teacherCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">السابق</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#teacherCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">التالي</span>
        </button>
    </div>
</section>
