<style>
    .info-section {
        padding: 40px 20px;
        text-align: right;
    }

    .info-header {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
        position: relative;
    }

    .info-card {
        width: 220px;
        height: 220px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #055160;
        border-radius: 0 100px 0 100px;
        margin: 10px auto;
        color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .info-card h5 {
        font-size: 18px;
        margin-top: 15px;
        font-weight: bold;
    }

    .info-card p {
        font-size: 16px;
        margin: 5px 0;
    }

    .info-card i {
        font-size: 30px;
        color: #ffcc00;
    }
</style>

<section class="info-section">
    <h2 class="info-header">معلومات عن الفصل</h2>
    <div class="container">
        <div class="row justify-content-center">
            <!-- بطاقة المعلومات الأولى -->
            <div class="col-md-4">
                <div class="info-card">
                    <i class="bi bi-people"></i>
                    <h5>اسم الفصل</h5>
                    <p>{{$section->name}}</p>
                </div>
            </div>
            <!-- بطاقة المعلومات الثانية -->
            <div class="col-md-4">
                <div class="info-card">
                    <i class="bi bi-person-circle"></i>
                    <h5>عدد الطلاب</h5>
                    <p>{{ $section->users->where('role', 'student')->count() }} حاليًا</p>
                </div>
            </div>
            <!-- بطاقة المعلومات الثالثة -->
            <div class="col-md-4">
                <div class="info-card">
                    <i class="bi bi-star"></i>
                    <h5>التقييمات</h5>
                    <p>4.8 (588 تقييم)</p>
                </div>
            </div>
        </div>
    </div>
</section>
