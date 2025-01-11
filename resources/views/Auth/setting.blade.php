<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعدادات الحساب</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #072D38;
            color: white;
            margin: 0;
            padding-top: 80px;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #F8C471;
        }

        .form-label {
            color: rgb(175, 175, 175);
        }

        .section-title {
            color: #F8C471;
            font-size: 1.3rem;
            margin-bottom: 20px;
        }

        .card {
            background-color: #035971;
            border: none;
            text-align: right;
        }

        .form-control,
        .btn {
            border-radius: 10px;
        }

        .btn {
            background-color: #F39C12;
            color: black;
            margin: 5px 0 20px 0;
        }

        .btn:hover {
            background-color: #F8C471;
            color: white;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')
    <div class="container">
        <div class="text-center mb-5">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : ($user->gender == 'female' ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png' : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png') }}"
                alt="صورة المستخدم" class="profile-picture">
            <h3 class="mt-3">{{ $user->name }}</h3>
            <p class="text-white">{{ $user->email }}</p>
        </div>

        @include('homeComponents.alerts')

        <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                    <textarea name="bio" class="form-control">{{ $user?->userInfo?->bio }}</textarea>
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
