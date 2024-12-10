<style>
    .info-section {
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
        padding: 40px 10px;
        margin: 0 auto;
        max-width: 1200px;
    }

    .info-card {
        background-color: #035971;
        width: 200px;
        height: 200px;
        border-radius: 20px;
        text-align: center;
        padding: 20px;
        color: #fff;
        margin: 10px;
        position: relative;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 6px 6px rgba(0, 0, 0, 0.15);
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3), 0 10px 10px rgba(0, 0, 0, 0.2);
    }

    .info-card i {
        font-size: 50px;
        color: #9adcfb;
        margin-bottom: 20px;
    }

    .info-card h2 {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
    }

    .info-card p {
        font-size: 16px;
        margin: 5px 0;
        color: #cdd6e1;
    }
</style>
<section class="info-section">
    <div class="info-card">
        <i class="bi bi-clock"></i>
        <h2>{{ $coursesHours }}+</h2>
        <p>محتوى الساعات</p>
    </div>

    <div class="info-card">
        <i class="bi bi-people"></i>
        <h2>{{ $allStudentsCount }}+</h2>
        <p>الطلاب</p>
    </div>

    <div class="info-card">
        <i class="bi bi-people"></i>
        <h2>{{ $teachers->count() }}+</h2>
        <p>المعلمين</p>
    </div>

    <div class="info-card">
        <i class="bi bi-globe"></i>
        <h2>{{ $courses->count() }}+</h2>
        <p>الدورات</p>
    </div>
</section>
