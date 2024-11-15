<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>اتصل بنا - منصة الرواد التعليمية</title>
    <style>
        body {
            font-family: "Cairo", serif;
        }

        .contact-section {
            background-color: #f8f9fa;
            padding: 50px 0;
        }

        .contact-card {
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #3e5fe3;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e9570b;
        }

        .form-control {
            border-radius: 10px;
        }

        .contact-info h5 {
            color: #3e5fe3;
        }
    </style>
</head>

<body>
    <!-- Contact Us Section -->
    <section class="contact-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="contact-card bg-white">
                        <h2 class="text-center mb-4">اتصل بنا</h2>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" id="name" placeholder="أدخل اسمك الكامل"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="email"
                                    placeholder="أدخل بريدك الإلكتروني" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">الموضوع</label>
                                <input type="text" class="form-control" id="subject" placeholder="الموضوع"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">الرسالة</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="اكتب رسالتك هنا..." required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-5">إرسال</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4 text-center">
                    <div class="contact-info">
                        <h5>📍 العنوان</h5>
                        <p>123 شارع التعليم، القاهرة، مصر</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="contact-info">
                        <h5>📧 البريد الإلكتروني</h5>
                        <p>info@alrawd.edu.eg</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="contact-info">
                        <h5>📞 الهاتف</h5>
                        <p>+20 123 456 7890</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
