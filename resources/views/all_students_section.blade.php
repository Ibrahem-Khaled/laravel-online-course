<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <title>{{ env('APP_NAME') }}</title>
    <style>
        body {
            font-family: "Cairo", serif;
            background-color: #072D38;
            color: #fff;
            margin: 0;
            padding-top: 50px;
        }

        .student-section {
            text-align: center;
            padding: 50px 0;
            position: relative;
        }

        .student-card {
            background-color: #055160;
            border-radius: 15px;
            text-align: center;
            padding: 20px;
            width: 100%;
            height: auto;
            margin: 15px 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .student-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.5);
        }

        .student-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid #fff;
            object-fit: cover;
        }

        .student-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
        }

        .student-title {
            font-size: 0.9rem;
            background-color: #035971;
            color: #ffffff;
            padding: 5px 15px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <section class="student-section container">
        <h2>قائمة الطلاب</h2>
        <div class="row">
            @foreach ($students as $student)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="student-card">
                        <img src="{{ $student->image
                            ? asset('storage/' . $student->image)
                            : ($student->userInfo?->gender == 'female'
                                ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png'
                                : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png') }}"
                            alt="Student Image">
                        <h4 class="student-name">{{ $student->name }}</h4>
                        <span class="student-title">{{ $student->userInfo?->role ?? 'طالب' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    @include('homeComponents.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>
