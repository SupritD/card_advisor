<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <!-- master stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

    <!-- TOP BAR -->
    <div class="topbar d-none d-lg-flex justify-content-between align-items-center px-4">
        <div class="left-info">
            <span class="me-3"><i class="bi bi-telephone"></i> +91 9876543210</span>
            <span><i class="bi bi-geo-alt"></i> Pune, Maharashtra</span>
        </div>

        <div class="right-social d-flex align-items-center">
            <span class="me-2">Follow Us:</span>
            <a href="#" class="me-2"><i class="bi bi-facebook"></i></a>
            <a href="#" class="me-2"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav id="mainNav" class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid px-4">

            <a class="navbar-brand fw-bold" href="#">YourLogo</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navbarContent" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Products</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.login') }}">Admin Login</a>
                    </li>

                    <!-- Logged In User (Right Side) -->
                    @auth
                        <li class="nav-item ms-lg-3">
                            <span class="nav-link">{{ Auth::user()->name }}</span>
                        </li>
                    @endauth

                </ul>
            </div>

        </div>
    </nav>

    <section class="steps-section py-5">
        <div class="container text-center">
            <div class="row">
                <div class="col-12">
                    <p class="section-subtitle">HOW IT WORKS</p>
                    <h2 class="section-title">3 Simple Steps To Host A Website</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-9 mx-auto">
                    <p class="section-desc mx-auto mb-5">
                        It is a long established fact that a reader will be distracted by the readable content of a page
                        when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <!-- STEP 1 -->
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <img src="https://dummyimage.com/80x80/cccccc/ffffff" alt="">
                        </div>
                        <span class="step-badge">STEP 01</span>

                        <h4 class="step-title">Choose Your Hosting Server</h4>
                        <p class="step-text">
                            It is a long established fact that a reader will be distracted by the readable content
                            of a page when looking at its layout.
                        </p>
                        <a href="#" class="read-more">Read More ↗</a>
                    </div>
                </div>

                <!-- STEP 2 -->
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <img src="https://dummyimage.com/80x80/cccccc/ffffff" alt="">
                        </div>
                        <span class="step-badge">STEP 02</span>

                        <h4 class="step-title">Select Your Web Hosting Plan</h4>
                        <p class="step-text">
                            It is a long established fact that a reader will be distracted by the readable content
                            of a page when looking at its layout.
                        </p>
                        <a href="#" class="read-more">Read More ↗</a>
                    </div>
                </div>

                <!-- STEP 3 -->
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <img src="https://dummyimage.com/80x80/cccccc/ffffff" alt="">
                        </div>
                        <span class="step-badge">STEP 03</span>

                        <h4 class="step-title">Change Your DNS Address</h4>
                        <p class="step-text">
                            It is a long established fact that a reader will be distracted by the readable content
                            of a page when looking at its layout.
                        </p>
                        <a href="#" class="read-more">Read More ↗</a>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- <nav class="flex items-center justify-end gap-4">
        <a href="http://127.0.0.1:8000/login"
            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
            Log in
        </a>

        <a href="http://127.0.0.1:8000/register"
            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
            Register
        </a>
    </nav> --}}

    <script>
        window.addEventListener('scroll', function() {
            let navbar = document.getElementById('mainNav');
            if (window.scrollY > 80) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>
