<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <title>{{ $route->name }}</title>
    <style>
        :root {
            --primary-color: #072D38;
            --secondary-color: #0A3D4A;
            --accent-color: #035971;
            --text-color: #FFFFFF;
            --text-secondary: #CCCCCC;
        }

        /* Hero Section with Gradient Overlay */
        .route-hero {
            position: relative;
            height: 70vh;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(135deg, #072D38 0%, #0A3D4A 100%);
        }

        .route-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ $route->image ? asset('storage/' . $route->image) : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}') no-repeat center center;
            background-size: cover;
            opacity: 0.4;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .route-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            background: linear-gradient(to right, #FFFFFF, #E0F7FA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .route-subtitle {
            font-size: 1.5rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* Main Content */
        .main-content {
            position: relative;
            background: linear-gradient(to bottom, var(--primary-color) 0%, #051E26 100%);
            padding: 4rem 0;
            margin-top: -50px;
            border-radius: 30px 30px 0 0;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.3);
        }

        /* Tabs */
        .nav-tabs {
            border-bottom: none;
            justify-content: center;
            margin-bottom: 3rem;
        }

        .nav-tabs .nav-link {
            color: var(--text-secondary);
            border: none;
            border-radius: 20px;
            padding: 12px 25px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            background-color: rgba(10, 61, 74, 0.5);
            width: 250px;
            text-align: center;
            justify-content: space-around;
            display: flex;
            align-items: center;
        }

        .nav-tabs .nav-link.active {
            background-color: var(--accent-color);
            color: #000;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .nav-tabs .nav-link:hover {
            background-color: var(--accent-color);
            color: var(--text-color);
        }

        .tab-content {
            padding: 0 2rem;
        }

        /* Description Section */
        .description-content {
            font-size: 1.2rem;
            line-height: 1.8;
            color: var(--text-secondary);
            max-width: 800px;
            margin: 0 auto;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .route-hero {
                height: 60vh;
            }

            .route-title {
                font-size: 2.2rem;
            }

            .route-subtitle {
                font-size: 1.2rem;
            }

            .main-content {
                padding: 3rem 0;
            }

            .nav-tabs .nav-link {
                padding: 10px 15px;
                font-size: 1rem;
                margin: 0 5px;
            }
        }

        /* Floating Particles Background */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
    </style>
</head>

<body>
    @include('homeComponents.header')

    <!-- Hero Section -->
    <section class="route-hero">
        <div class="particles" id="particles"></div>
        <div class="hero-content">
            <h1 class="route-title">{{ $route->name }}</h1>
            <p class="route-subtitle">{{ $route->target_group }}</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content" dir="rtl">
        <div class="container">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" id="routeTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-toggle="tab" data-target="#description"
                        type="button" role="tab" aria-controls="description" aria-selected="true">
                        <i class="fas fa-info-circle me-2"></i>وصف المسار
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="courses-tab" data-toggle="tab" data-target="#courses" type="button"
                        role="tab" aria-controls="courses" aria-selected="false">
                        <i class="fas fa-book me-2"></i>الدورات التعليمية
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="routeTabsContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description" role="tabpanel"
                    aria-labelledby="description-tab">
                    <div class="description-content">
                        <p>{!! $route->description !!}</p>
                    </div>
                </div>

                <!-- Courses Tab -->
                <div class="tab-pane fade" id="courses" role="tabpanel" aria-labelledby="courses-tab">
                    <div class="row">
                        @foreach ($route->courses as $course)
                            @include('homeComponents.home.course-card', ['course' => $course])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('homeComponents.footer')

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Create floating particles effect
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 30;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Random size between 2px and 6px
                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;

                // Random position
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;

                // Random animation
                const duration = Math.random() * 20 + 10;
                particle.style.animation = `float ${duration}s linear infinite`;

                // Random delay
                particle.style.animationDelay = `${Math.random() * 20}s`;

                particlesContainer.appendChild(particle);
            }

            // Add animation style
            const style = document.createElement('style');
            style.textContent = `
                @keyframes float {
                    0% {
                        transform: translateY(0) translateX(0);
                        opacity: 1;
                    }
                    100% {
                        transform: translateY(-100vh) translateX(20px);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>

</html>
