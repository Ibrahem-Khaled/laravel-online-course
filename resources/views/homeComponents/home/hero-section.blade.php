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
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .hero-section {
            flex-direction: column-reverse;
            align-items: center;
            text-align: center;
        }

        .hero-content {
            max-width: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-text {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .hero-image {
            max-width: 80%;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-text {
            font-size: 0.9rem;
        }

        .btn-primary,
        .btn-outline {
            padding: 10px 20px;
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 1.5rem;
        }

        .hero-text {
            font-size: 0.8rem;
        }

        .btn-primary,
        .btn-outline {
            padding: 8px 15px;
            font-size: 0.9rem;
        }

        .hero-image {
            max-width: 100%;
        }
    }
</style>

<body>
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">تعلم بطريقة إبداعية مع <span>أكاديمية السّريع</span></h1>
            <p class="hero-text">انطلق في مسيرتك التعليمية الآن واستمتع بمجموعة متنوعة من الدورات والبرامج التي ستقودك
              . إلى آفاق أرحب من المعرفة والتطور والإبداع
            </p>
            @if (!Auth::check())
                <a href="{{ route('login') }}" class="btn btn-primary">تسجيل دخول</a>
                <a href="{{ route('register') }}" class="btn btn-outline">إنشاء حساب</a>
            @endif
        </div>
        <div class="hero-image">
            <img src="{{ asset('assets/img/hero-section-img.png') }}" alt="Learning">
        </div>
    </section>
</body>
