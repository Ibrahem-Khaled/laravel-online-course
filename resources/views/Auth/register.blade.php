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
    <title>إنشاء حساب</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }

        .register-card h3 {
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

        .register-footer {
            text-align: center;
            margin-top: 15px;
        }

        .register-footer a {
            text-decoration: none;
            color: #3e5fe3;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <div class="register-card bg-white">
            <h3 class="text-center mb-4">إنشاء حساب جديد</h3>
            <form action="{{ route('registerPost') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="fullName" class="form-label">الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" id="fullName"
                        placeholder="أدخل اسمك الكامل" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" id="email"
                        placeholder="أدخل بريدك الإلكتروني" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">الهاتف</label>
                    <input type="tel" name="phone" class="form-control" id="phone"
                        placeholder="أدخل رقم الهاتف">
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">العنوان</label>
                    <input type="text" name="address" class="form-control" id="address" placeholder="أدخل العنوان">
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" id="password"
                        placeholder="أدخل كلمة المرور" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control" id="confirmPassword"
                        placeholder="أعد إدخال كلمة المرور" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">إنشاء حساب</button>
                </div>
            </form>

            <div class="register-footer mt-3">
                <p>لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
