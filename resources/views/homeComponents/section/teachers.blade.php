<style>
    .teacher-card {
        background-color: #055160;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        margin: 30px auto;
        max-width: 600px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        color: #fff;
    }

    .teacher-info {
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .teacher-card img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 3px solid #fff;
    }

    .teacher-card h6 {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .teacher-card span {
        display: inline-block;
        color: #ffffff;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .teacher-card p {
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .social-icons {
        margin-bottom: 20px;
        flex: 1;
        text-align: left;
    }

    .social-icons a {
        color: #fff;
        font-size: 20px;
        margin: 0 10px;
        transition: all 0.3s ease;
    }

    .social-icons a:hover {
        color: #ffcc00;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-top: 20px;
    }

    .stats .stat-card {
        background-color: #4688A0;
        border-radius: 10px;
        padding: 10px;
        text-align: center;
        justify-content: center;
        display: flex;
        flex-direction: column;
        color: #fff;
    }

    .stats .stat-card h4 {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .stats .stat-card span {
        font-size: 18px;
        font-weight: bold;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .teacher-card {
            padding: 20px;
            max-width: 90%;
        }

        .teacher-info {
            flex-direction: column;
            text-align: center;
        }

        .teacher-card img {
            margin-bottom: 15px;
        }

        .social-icons {
            text-align: center;
            margin-top: 10px;
        }

        .stats {
            grid-template-columns: 1fr;
            /* عمود واحد على الشاشات الصغيرة */
        }
    }

    @media (max-width: 480px) {
        .teacher-card h6 {
            font-size: 16px;
        }

        .teacher-card p {
            font-size: 12px;
        }

        .stats .stat-card h4 {
            font-size: 14px;
        }

        .stats .stat-card span {
            font-size: 16px;
        }
    }
</style>

<div class="teacher-card">
    <div class="teacher-info">
        <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://cdn-icons-png.flaticon.com/128/5584/5584877.png' }}"
            alt="Teacher Photo">
        <div style="text-align: right; flex: 2;">
            <h6>{{ $user->name }}</h6>
            <span style="background-color: #FDE8CE; color: #CB4F09;">
                {{ $user->userInfo?->degree ?? 'لا يوجد علم في الملف الشخصي للمعلم' }}
            </span>
        </div>
        <div class="social-icons">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-chat-dots"></i></a>
        </div>
    </div>
    <p>
        {{ $user->userInfo?->bio ?? 'لا يوجد بيو في الملف الشخصي للمعلم' }}
    </p>
    <div class="stats">
        <div class="stat-card">
            <h4>عدد الدورات</h4>
            <span>{{ $user->courses->count() }}</span>
        </div>
        <div class="stat-card">
            <h4>الشهادات</h4>
            <span>4</span>
        </div>
        <div class="stat-card">
            <h4>التقييمات</h4>
            <span>4.4</span>
        </div>
    </div>
</div>
