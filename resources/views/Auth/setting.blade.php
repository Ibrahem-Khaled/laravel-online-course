<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعدادات الحساب - أكاديمية السريع</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --main-color: #F39C12;
            --main-dark: #D68910;
            --dark-bg: #072D38;
            --secondary-bg: rgba(7, 45, 56, 0.8);
            --light-bg: rgba(10, 110, 143, 0.5);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --text-light: #f0f8ff;
            --text-muted: #a8c7d8;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--secondary-bg) 100%);
            color: var(--text-light);
            min-height: 100vh;
            background-attachment: fixed;
            padding-top: 80px;
        }

        /* Profile Picture - Modern Design */
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--main-color);
            box-shadow: 0 0 30px rgba(243, 156, 18, 0.4);
            transition: all 0.4s ease;
            cursor: pointer;
        }

        .profile-picture:hover {
            transform: scale(1.05);
            box-shadow: 0 0 40px rgba(243, 156, 18, 0.6);
            border-color: #F8C471;
        }

        /* Cards - Glassmorphism Effect */
        .card {
            background: rgba(7, 45, 56, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(243, 156, 18, 0.3);
        }

        /* Section Titles - Modern Design */
        .section-title {
            color: var(--main-color);
            font-size: 1.5rem;
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
            font-weight: 700;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--main-color), transparent);
            border-radius: 2px;
        }

        /* Form Elements - Modern Design */
        .form-label {
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-light);
            border-radius: 12px;
            padding: 12px 18px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--main-color);
            box-shadow: 0 0 0 0.25rem rgba(243, 156, 18, 0.25);
            color: var(--text-light);
        }

        textarea.form-control {
            min-height: 120px;
        }

        /* Buttons - Modern Design */
        .btn-main {
            background-color: var(--main-color);
            color: #000;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
            width: 100%;
            margin-top: 10px;
        }

        .btn-main:hover {
            background-color: var(--main-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(243, 156, 18, 0.4);
        }

        .btn-main:active {
            transform: translateY(1px);
        }

        /* File Input - Custom Design */
        .file-input-container {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-container input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            background: rgba(243, 156, 18, 0.1);
            border: 2px dashed var(--main-color);
            border-radius: 12px;
            color: var(--main-color);
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-input-label:hover {
            background: rgba(243, 156, 18, 0.2);
        }

        .file-input-label i {
            margin-left: 10px;
            font-size: 1.2rem;
        }

        /* Animations */
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
            animation: fadeIn 0.6s ease-out forwards;
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .delay-2 {
            animation-delay: 0.4s;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .profile-picture {
                width: 120px;
                height: 120px;
            }

            .section-title {
                font-size: 1.3rem;
            }

            .card {
                padding: 20px !important;
            }
        }

        /* User Info Section */
        .user-info {
            text-align: center;
            margin-bottom: 40px;
        }

        .user-info h3 {
            font-weight: 700;
            margin-top: 15px;
            color: var(--text-light);
        }

        .user-info p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* Alert Messages */
        .alert {
            border-radius: 12px;
            backdrop-filter: blur(10px);
            background: var(--glass-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Select Dropdown */
        .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-light);
            border-radius: 12px;
            padding: 12px 18px;
        }

        .form-select:focus {
            border-color: var(--main-color);
            box-shadow: 0 0 0 0.25rem rgba(243, 156, 18, 0.25);
            background: rgba(255, 255, 255, 0.15);
        }

        /* Helper Text */
        .helper-text {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 5px;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <div class="container" dir="rtl">
        <!-- User Profile Header -->
        <div class="user-info fade-in">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : ($user->gender == 'female' ? 'https://cdn-icons-png.flaticon.com/512/2995/2995462.png' : 'https://cdn-icons-png.flaticon.com/512/2641/2641333.png') }}"
                alt="صورة المستخدم" class="profile-picture" id="profilePreview">
            <h3>{{ $user->name }}</h3>
            <p>{{ $user->email }}</p>
        </div>

        @include('homeComponents.alerts')

        <!-- Main Form -->
        <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data" class="fade-in delay-1">
            @csrf

            <!-- Profile Picture Section -->
            <div class="card p-4">
                <h5 class="section-title">
                    <i class="fas fa-camera me-2"></i>الصورة الشخصية
                </h5>

                <div class="mb-3">
                    <label class="form-label">تغيير الصورة</label>
                    <div class="file-input-container">
                        <label class="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>اختر صورة جديدة</span>
                            <input type="file" name="image" class="form-control" accept="image/*"
                                onchange="previewImage(event)">
                        </label>
                    </div>
                    <p class="helper-text">يسمح فقط بصور بصيغة JPEG, PNG, JPG بحجم أقصى 2 ميجابايت</p>
                </div>
            </div>

            <!-- Basic Information Section -->
            <div class="card p-4">
                <h5 class="section-title">
                    <i class="fas fa-user-circle me-2"></i>المعلومات الأساسية
                </h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم الكامل</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الجنس</label>
                        <select name="gender" class="form-select">
                            <option value="">اختر الجنس...</option>
                            <option value="male" {{ $user?->userInfo?->gender == 'male' ? 'selected' : '' }}>ذكر
                            </option>
                            <option value="female" {{ $user?->userInfo?->gender == 'female' ? 'selected' : '' }}>أنثى
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Personal Details Section -->
            <div class="card p-4">
                <h5 class="section-title">
                    <i class="fas fa-address-card me-2"></i>التفاصيل الشخصية
                </h5>

                <div class="mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">النبذة الشخصية</label>
                    <textarea name="bio" class="form-control" rows="4">{{ $user?->userInfo?->bio }}</textarea>
                    <p class="helper-text">اكتب نبذة مختصرة عن نفسك (اختياري)</p>
                </div>
            </div>

            <!-- Education Section -->
            <div class="card p-4">
                <h5 class="section-title">
                    <i class="fas fa-graduation-cap me-2"></i>المعلومات التعليمية
                </h5>

                <div class="mb-3">
                    <label class="form-label">الدرجة العلمية</label>
                    <input type="text" name="degree" class="form-control" value="{{ $user?->userInfo?->degree }}">
                    <p class="helper-text">مثال: بكالوريوس علوم حاسوب، ماجستير إدارة أعمال، إلخ.</p>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-main">
                <i class="fas fa-save me-2"></i> حفظ التغييرات
            </button>
        </form>
    </div>

    @include('homeComponents.footer')

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profilePreview');
                output.src = reader.result;
                output.classList.add('picture-updated');
                setTimeout(() => {
                    output.classList.add('picture-animated');
                }, 100);
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Add animation to form elements when they come into view
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');

            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = `all 0.5s ease ${index * 0.1}s`;

                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
