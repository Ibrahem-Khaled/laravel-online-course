<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-ct.png') }}">

    <title>تسجيل الدخول</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #072D38;
            margin: 0;
            padding-top: 100px;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            border-radius: 10px;
            text-align: right;
            background-color: #035971;
            color: #fff;
            border-width: 1px 1px 1px 0;
        }

        .form-control::placeholder {
            color: #ffffff;
            opacity: 0.8;
        }

        .form-control:focus {
            background-color: #035971;
            color: #fff;
            outline: none;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
        }

        .input-group-text {
            background-color: #035971;
            color: #fff;
            border-width: 1px 0 1px 1px;
        }

        .btn-primary {
            background-color: #F48140;
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #ffb68b;
        }

        .login-footer {
            text-align: center;
            margin-top: 15px;
        }

        .login-footer a {
            text-decoration: none;
            color: #F48140;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    @include('homeComponents.header')
    @include('components.alerts')
    <div class="login-container">
        <div class="login-card" style="background-color: #035971;">
            <h3 class="text-center mb-4 text-white">أهلا بعودتك</h3>
            <p class="text-center text-white">يرجى تسجيل الدخول للمتابعة</p>

            <form action="{{ route('loginPost') }}" method="POST">
                @csrf
                <!-- البريد الإلكتروني أو رقم الهاتف -->
                <div class="mb-3">
                    <label for="login" class="form-label text-white">البريد الإلكتروني أو رقم الهاتف</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="login" name="login"
                            placeholder="أدخل بريدك الإلكتروني أو رقم الهاتف" required>
                    </div>
                </div>
                <!-- كلمة المرور -->
                <div class="mb-3">
                    <label for="password" class="form-label text-white">كلمة المرور</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" style="border-width: 1px 0 1px 0" name="password"
                            id="password" placeholder="أدخل كلمة المرور" required>
                        <button type="button" class="input-group-text" style="border-width: 1px 1px 1px 0"
                            id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <!-- خيارات إضافية -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label text-white" for="rememberMe">
                            تذكرني
                        </label>
                    </div>
                    <a href="{{ route('forgot-password') }}" class="text-decoration-none" style="color: #F48140">نسيت
                        كلمة المرور؟</a>
                </div>
                <!-- زر تسجيل الدخول -->
                <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
            </form>
            <!-- رابط التسجيل -->
            <div class="login-footer mt-3">
                <p class="text-white">لا تمتلك حسابًا؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a></p>
            </div>
        </div>
    </div>

    @include('homeComponents.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#password');

        togglePassword.addEventListener('click', () => {
            // Toggle the type attribute
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle the eye icon
            togglePassword.querySelector('i').classList.toggle('fa-eye');
            togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>

</body>

</html>
