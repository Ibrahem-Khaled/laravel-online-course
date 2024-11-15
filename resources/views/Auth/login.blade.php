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
    <title>تسجيل الدخول</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
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

        .login-card h3 {
            color: #3e5fe3;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #3e5fe3;
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #e9570b;
        }

        .login-footer {
            text-align: center;
            margin-top: 15px;
        }

        .login-footer a {
            text-decoration: none;
            color: #3e5fe3;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-card bg-white">
            <h3 class="text-center mb-4">تسجيل الدخول</h3>
            <form action="{{ route('loginPost') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="أدخل بريدك الإلكتروني"
                        required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="أدخل كلمة المرور" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                            تذكرني
                        </label>
                    </div>
                    <a href="{{ route('forgot-password') }}" class="text-decoration-none">نسيت كلمة المرور؟</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
            </form>
            <div class="login-footer mt-3">
                <p>لا تمتلك حسابًا؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
