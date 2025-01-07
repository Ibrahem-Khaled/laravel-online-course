<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-ct.png') }}">
    <title>{{ env('APP_NAME') }}</title>
    <style>
        body {
            font-family: "Cairo", serif;
            background-color: #072D38;
            color: #fff;
            margin: 0;
            padding-top: 100px;
        }

        .inactive-container {
            text-align: center;
            padding: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            margin: 50px auto;
            max-width: 500px;
        }

        .inactive-container i {
            font-size: 60px;
            margin-bottom: 20px;
            color: #ed6b2f;
        }

        .inactive-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .inactive-container p {
            font-size: 16px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .inactive-container .btn {
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 25px;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <div class="container">
        <div class="inactive-container">
            <i class="fa-solid fa-user-lock"></i>
            <h1>حسابك غير مفعل</h1>
            <p>يرجى الانتظار حتى يتم تفعيل حسابك بواسطة الإدارة. إذا كنت تواجه مشكلة، يمكنك التواصل معنا.</p>
            <a href="/contact" style="background-color: #ed6b2f;" class="btn text-white">اتصل بالدعم</a>
        </div>
    </div>

    <!-- Footer -->
    @include('homeComponents.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>
