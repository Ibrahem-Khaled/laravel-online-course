<style>
    body {
        font-family: 'Cairo', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #072D38;
        color: #fff;
    }

    .hero-section {
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
        justify-content: space-between;
        padding: 50px 5%;
        background-color: #072D38;
    }

    .hero-content {
        max-width: 50%;
        text-align: right;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: bold;
        line-height: 1.5;
        color: #fff;
    }

    .hero-title span {
        color: #F4813E;
    }

    .hero-text {
        font-size: 1.2rem;
        margin-top: 20px;
        margin-bottom: 30px;
        color: #d1d1d1;
    }

    .btn-primary {
        background-color: #F4813E;
        border: none;
        color: #fff;
        padding: 15px 30px;
        font-size: 1.1rem;
        border-radius: 25px;
        margin-right: 10px;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #ffae42;
        color: #fff;
    }

    .btn-outline {
        border: 2px solid #F4813E;
        color: #F4813E;
        padding: 15px 30px;
        font-size: 1.1rem;
        border-radius: 25px;
        transition: all 0.3s ease-in-out;
    }

    .btn-outline:hover {
        background-color: #F4813E;
        color: #fff;
    }

    .hero-image {
        max-width: 45%;
        position: relative;
    }

    .hero-image img {
        width: 100%;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<body>
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">تعلم بطريقة إبداعية مع <span>Al-Ruad Academy</span></h1>
            <p class="hero-text">ابدأ رحلتك التعليمية الآن، واستمتع بمئات الدورات والبرامج التعليمية التي ستأخذك إلى
                مستوى
                جديد من العلم والمعرفة والإبداع.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">تسجيل دخول</a>
            <a href="{{ route('register') }}" class="btn btn-outline">إنشاء حساب</a>
        </div>
        <div class="hero-image">
            <img src="{{ asset('assets/img/hero-section-img.png') }}" alt="Learning">
        </div>
    </section>
</body>
