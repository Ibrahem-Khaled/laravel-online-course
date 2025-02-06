<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعدادات الحساب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --main-color: #F39C12;
            --dark-bg: #072D38;
            --secondary-bg: rgba(7, 45, 56, 0.8);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --text-color: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.7);
        }

        body {
            font-family: "Cairo", sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-color);
            margin: 0;
            padding-top: 80px;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--main-color);
            box-shadow: 0 0 20px rgba(243, 156, 18, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-picture:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(243, 156, 18, 0.5);
        }

        .form-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .section-title {
            color: var(--main-color);
            font-size: 1.5rem;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50%;
            height: 3px;
            background: var(--main-color);
            border-radius: 2px;
        }

        .card {
            background: var(--secondary-bg);
            border: none;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        .form-control {
            background: var(--glass-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            border-radius: 10px;
            padding: 10px 15px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--main-color);
            box-shadow: 0 0 10px rgba(243, 156, 18, 0.3);
            background: rgba(255, 255, 255, 0.05);
        }

        .btn {
            background: var(--main-color);
            color: #000;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background: #F8C471;
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .alert {
            border-radius: 10px;
            backdrop-filter: blur(10px);
            background: var(--glass-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')
    <div class="container" dir="rtl">
        <div class="text-center mb-5 fade-in">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : ($user->gender == 'female' ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png' : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png') }}"
                alt="صورة المستخدم" class="profile-picture" id="profilePreview">
            <h3 class="mt-3">{{ $user->name }}</h3>
            <p class="text-muted">{{ $user->email }}</p>
        </div>

        @include('homeComponents.alerts')

        <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" class="fade-in">
            @csrf

            <!-- تغيير الصورة الشخصية -->
            <div class="card p-4 mb-4">
                <h5 class="section-title">تغيير الصورة الشخصية</h5>
                <div class="mb-3">
                    <label class="form-label">رفع صورة جديدة</label>
                    <input type="file" name="image" class="form-control" accept="image/*"
                        onchange="previewImage(event)">
                    <p class="text-muted small mt-2">يسمح فقط بصور بصيغة JPEG, PNG, JPG وحجم أقصى 2 ميجا.</p>
                </div>
            </div>

            <!-- المعلومات الأساسية -->
            <div class="card p-4 mb-4">
                <h5 class="section-title">المعلومات الأساسية</h5>
                <div class="mb-3">
                    <label class="form-label">الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الهاتف</label>
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>
            </div>

            <!-- التفاصيل الشخصية -->
            <div class="card p-4 mb-4">
                <h5 class="section-title">التفاصيل الشخصية</h5>
                <div class="mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">الجنس</label>
                    <select name="gender" class="form-control">
                        <option value="">اختر...</option>
                        <option value="male" {{ $user?->userInfo?->gender == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ $user?->userInfo?->gender == 'female' ? 'selected' : '' }}>أنثى
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">النبذة</label>
                    <textarea name="bio" class="form-control" rows="3">{{ $user?->userInfo?->bio }}</textarea>
                </div>
            </div>

            <!-- التعليم -->
            <div class="card p-4 mb-4">
                <h5 class="section-title">التعليم</h5>
                <div class="mb-3">
                    <label class="form-label">الدرجة العلمية</label>
                    <input type="text" name="degree" class="form-control" value="{{ $user?->userInfo?->degree }}">
                </div>
            </div>

            <button type="submit" class="btn w-100">تحديث البيانات</button>
        </form>
    </div>

    @include('homeComponents.footer')

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profilePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
