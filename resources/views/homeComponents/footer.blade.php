<style>
    .footer {
        background: linear-gradient(160deg, #035971 0%, #01222d 100%);
        color: #fff;
        padding: 4rem 0 0;
        position: relative;
        overflow: hidden;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: -50px;
        left: 0;
        width: 100%;
        height: 100px;
    }

    .footer-section {
        margin-bottom: 2.5rem;
    }

    .footer h6 {
        color: #ed6b2f;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .footer h6::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 2px;
        background: #ed6b2f;
    }

    .footer-links {
        list-style: none;
        padding: 0;
    }

    .footer-links li {
        margin-bottom: 0.8rem;
        transition: transform 0.3s ease;
    }

    .footer-links li:hover {
        transform: translateX(5px);
    }

    .footer-links a {
        color: #fff;
        text-decoration: none;
        position: relative;
        font-size: 0.95rem;
    }

    .footer-links a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 1px;
        background: #ed6b2f;
        transition: width 0.3s ease;
    }

    .footer-links a:hover::after {
        width: 100%;
    }

    .contact-info {
        text-align: right;
    }

    .footer-logo {
        width: 180px;
        margin-bottom: 1.5rem;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    .social-icons {
        margin-top: 1.5rem;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .social-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        background: #ed6b2f;
        transform: translateY(-3px);
    }

    .copyright {
        background: rgba(0, 0, 0, 0.15);
        padding: 1.5rem 0;
        margin-top: 3rem;
        text-align: center;
        font-size: 0.9rem;
        position: relative;
    }

    @media (max-width: 768px) {
        .contact-info {
            text-align: center;
            margin-top: 2rem;
        }

        .social-icons {
            justify-content: center;
        }

        .footer::before {
            top: -30px;
            height: 60px;
        }
    }
</style>

<footer class="footer">
    <div class="container">
        <div class="row gy-5">
            <!-- Product Section -->
            <div class="col-lg-3 col-md-6 footer-section">
                <h6>اكتشف طموح</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('coming-soon') }}">المسار التعليمي</a></li>
                    <li><a href="{{ route('all-students-sections') }}">طلاب طموح</a></li>
                    <li><a href="{{ route('coming-soon') }}">معرض الأعمال</a></li>
                    <li><a href="{{ route('coming-soon') }}">الفعاليات</a></li>
                </ul>
            </div>

            <!-- Legal Section -->
            <div class="col-lg-3 col-md-6 footer-section">
                <h6>السياسات</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('coming-soon') }}">الشروط والأحكام</a></li>
                    <li><a href="{{ route('coming-soon') }}">سياسة الخصوصية</a></li>
                    <li><a href="{{ route('coming-soon') }}">سياسة الاسترجاع</a></li>
                    <li><a href="{{ route('coming-soon') }}">الأسئلة الشائعة</a></li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="col-lg-6 footer-section contact-info">
                <img src="{{ asset('assets/img/logo-ct-dark.png') }}" alt="Al-Ruad" class="footer-logo">
                <div class="contact-details">
                    <p class="d-flex align-items-center justify-content-end gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="#ed6b2f">
                            <path
                                d="M20 22.621l-3.521-6.795c-.008.004-1.974.97-2.064 1.011-2.24 1.086-6.799-7.82-4.609-8.994l2.083-1.026-3.493-6.817-2.106 1.039c-7.202 3.755 4.233 25.982 11.6 22.615.121-.055 2.102-1.029 2.11-1.033z" />
                        </svg>
                        <a href="https://wa.me/966581870300" target="_blank" class="text-light">+966 58 187 0300</a>
                    </p>
                    <p class="d-flex align-items-center justify-content-end gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="#ed6b2f">
                            <path
                                d="M12 0c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602zm0 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z" />
                        </svg>
                        المملكة العربية السعودية
                    </p>
                    <p class="d-flex align-items-center justify-content-end gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="#ed6b2f">
                            <path
                                d="M12 12.713l-11.985-9.713h23.97l-11.985 9.713zm0 2.574l-12-9.725v15.438h24v-15.438l-12 9.725" />
                        </svg>
                        <a href="mailto:info@alsorayaiacademy.com" class="text-light">info@alsorayaiacademy.com</a>
                    </p>
                </div>

                <div class="social-icons">
                    <a href="{{ route('coming-soon') }}" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="#fff">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                    <a href="{{ route('coming-soon') }}" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="#fff">
                            <path
                                d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z" />
                        </svg>
                    </a>
                    <a href="{{ route('coming-soon') }}" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="#fff">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="copyright">
            &copy; {{ date('Y') }} {{ env('APP_NAME') }}. جميع الحقوق محفوظة.
        </div>
    </div>
</footer>
