<style>
    html,
    body {
        height: 100vh;
    }

    footer {
        flex-shrink: 0;
    }
</style>
<!-- Footer Section -->
<footer style="background-color: #035971; color: white; padding: 1.5rem 0; text-align: center;">
    <div class="container">
        <div class="row gy-3">           
            <!-- Product Section -->
            <div class="col-md-3 col-sm-6">
                <h6 class="fw-bold mb-3">برنامج طموح</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light text-decoration-none small">المسار</a></li>
                    <li><a href="#" class="text-light text-decoration-none small">طلاب طموح</a></li>
                    <li><a href="#" class="text-light text-decoration-none small">اعمال الطلاب</a></li>
                </ul>
            </div>

            <!-- Legal Section -->
            <div class="col-md-3 col-sm-6">
                <h6 class="fw-bold mb-3">السياسات</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light text-decoration-none small">سياسة التسجيل</a></li>
                    <li><a href="#" class="text-light text-decoration-none small">سياسة الاستبعاد</a></li>
                </ul>
            </div>

            <!-- Contact Info Section -->
            <div class="col-md-3 col-sm-6 text-md-end text-sm-start">
                <img src="{{ asset('assets/img/logo-ct.png') }}" alt="Al-Ruad"
                    style="width: 150px; margin-bottom: 1rem;">
                <p class="small mb-1"><i class="bi bi-whatsapp"></i>
                    <a href="https://wa.me/966581870300" target="_blank" class="text-light text-decoration-none">+966 58
                        187 0300</a>
                </p>
                <p class="small mb-1"><i class="bi bi-geo-alt-fill"></i> المملكة العربية السعودية</p>
                <p class="small"><i class="bi bi-envelope-fill"></i> info@alsorayaiacademy.com</p>
            </div>
        </div>
        <hr style="border-color: rgba(255, 255, 255, 0.2); margin: 1rem 0;">
        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-0 small">&copy; {{ date('Y') }} {{ env('APP_NAME') }}. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </div>
</footer>
