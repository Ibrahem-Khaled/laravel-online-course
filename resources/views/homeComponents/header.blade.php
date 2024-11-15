<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .navbar {
            background-color: #062b3d;
            padding: 1rem;
        }

        .navbar-brand {
            font-weight: bold;
            color: white;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            margin-left: 50%
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            flex-direction: row;
            justify-content: space-evenly;
            width: 80%;
        }

        .navbar-nav .nav-link {
            color: white;
            margin-right: 22px;
            text-decoration: none;
        }

        .navbar-nav .nav-link:hover {
            color: #ed6b2f;
        }

        .navbar-nav .nav-link.active {
            color: #ed6b2f;
            font-weight: bold;
            text-decoration: underline;
        }

        .btn-action {
            background-color: #287c8d; 
            color: white;
            padding: 0.5rem 1.2rem;
            border: none;
            border-radius: 20px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-action:hover {
            background-color: #1f6674;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/img/logo-ct.png') }}" alt="Logo" style="width: 100px; height: 60px;">
            </a>
            <div class="navbar-nav">
                <a class="nav-link" href="#">برنامج طموح</a>
                <a class="nav-link" href="#">الدورات</a>
                <a class="nav-link" href="#">البرامج التدريبية</a>
                <a class="nav-link active" href="#">الرئيسية</a>
                <a class="btn-action" href="#">ابدأ النسخة التجريبية</a>
            </div>
        </div>
    </nav>
</body>

</html>
