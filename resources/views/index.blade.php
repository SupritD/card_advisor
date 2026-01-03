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
    <script src="{{ asset('assets/js/mainpage.js') }}"></script>

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
    {{-- <nav id="mainNav" class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
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
    </nav> --}}
    <header class="pr-header">
    <div class="pr-container">

        <!-- Brand -->
        <div class="pr-brand animate pr-fade">
            <a href="{{ url('/') }}" class="pr-logo">
                Card Advisor GPT
            </a>
        </div>

        <!-- Navigation -->
        <nav class="pr-nav animate pr-fade pr-delay-1">
            <a href="#">Explore Cards</a>
            <a href="#">Knowledge Hub</a>
            <a href="#">AI Features</a>
            <a href="#">About</a>
        </nav>

        <!-- Actions -->
        <div class="pr-actions animate pr-fade pr-delay-2">
            <a href="{{ route('login') }}" class="pr-login">
                Login
            </a>
            <a href="{{ route('register') }}" class="pr-primary-btn">
                Get Started
            </a>
        </div>

    </div>
</header>

    {{-- banner area start --}}
    <section class="banner-area">
        <div class="banner-container">

            <!-- Header -->
            <div class="banner-header animate fade-down">
                <h1 class="banner-title">
                    Understand Every Credit & Debit Card,
                    Smarter with AI
                </h1>

                <p class="banner-subtitle">
                    Card Advisor GPT is an AI-powered platform that explains credit and debit
                    cards—fees, tiers, networks, benefits, and offers—clearly and instantly.
                </p>
            </div>

            <!-- Content -->
            <div class="banner-content">

                <!-- Image -->
                <div class="banner-image animate fade-left delay-1">
                    <img src="{{ asset('images/banner/card-advisor.jpg') }}" alt="Card Advisor GPT">
                </div>

                <!-- Info Card -->
                <div class="info-card animate fade-right delay-2">
                    <p>
                        Card Advisor GPT is an AI-powered card knowledge platform that reads, organizes, and explains
                        credit card and debit card details from different banks. It helps users understand card fees,
                        tiers, networks, and benefits—along with the latest offers—without confusion.

                        {{-- <ul class="features">
                    <li>💳 Compare cards across banks & networks</li>
                    <li>📊 Understand fees, rewards & benefits</li>
                    <li>🤖 AI explanations — no confusion</li>
                </ul> --}}

                    <p class="tagline">
                        👉 Know your card. Use it right. Save more.
                    </p>

                    <div class="button-group">
                        <a href="#" class="pr-primary-btn">Explore Cards</a>
                        <a href="#" class="pr-btn-outline">Knowledge Hub</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    {{-- banner area end --}}

    {{-- about feature area start --}}
   <section class="about-floating-area">
    <div class="container">

        <div class="about-floating-layout">

            <!-- Image -->
            <div class="about-floating-image animate fade-left">
                <img
                    src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1200&auto=format&fit=crop"
                    alt="AI simplifying financial information"
                >
            </div>

            <!-- Content -->
            <div class="about-floating-content">

                <span class="card-badge">About Us</span>

                <h2 class="about-floating-title animate fade-up delay-1">
                    Built to Make Cards<br>
                    Simple & Understandable
                </h2>

                <p class="about-floating-text animate fade-up delay-2">
                    Card Advisor GPT is built to solve one simple problem:
                    <strong>people don’t fully understand their cards.</strong>
                </p>

                <p class="about-floating-text animate fade-up delay-3">
                    Banks often explain cards using complex terms. Our AI reads
                    details like <strong>bank name, card type, network, fees,
                    and benefits</strong>, then presents everything in clear,
                    easy language.
                </p>

                <!-- Floating Keywords -->
                <div class="about-floating-tags">
                    <span class="tag animate fade-up delay-4">Education</span>
                    <span class="tag animate fade-up delay-5">Clarity</span>
                    <span class="tag animate fade-up delay-6">AI-Powered</span>
                    <span class="tag animate fade-up delay-7">No Confusion</span>
                </div>

            </div>

        </div>
    </div>
</section>

    {{-- about feature area end --}}

    {{-- product feature area start --}}
    <section class="products-area">
        <div class="products-glow"></div>
          <div class="knowledge-glow-step"></div>

        <div class="container">

            <!-- Section Header -->
            <div class="section-header animate fade-down">
                <span class="section-tag">Products</span>
                <h2 class="section-title">
                    Intelligent Tools for<br>
                    Smarter Card Decisions
                </h2>
                <p class="section-subtitle">
                    Card Advisor GPT offers focused, knowledge-first tools that help
                    users understand cards clearly — without promotions or bias.
                </p>
            </div>

            <!-- Product Cards -->
            <div class="products-grid">

                <!-- Product 1 -->
                <div class="product-card animate fade-up delay-1">
                    <div class="product-icon">🤖</div>
                    <h3 class="title">Card Knowledge AI</h3>
                    <p class="desc">
                        An intelligent GPT-powered chatbot that answers questions
                        about cards instantly and clearly.
                    </p>
                    <ul>
                        <li>Credit & debit cards</li>
                        <li>Card categories & tiers</li>
                        <li>Visa, Mastercard, RuPay</li>
                        <li>Fees & charges explained</li>
                    </ul>
                    <span class="note">Ask questions. Get instant answers.</span>
                </div>

                <!-- Product 2 -->
                <div class="product-card animate fade-up delay-2">
                    <div class="product-icon">📂</div>
                    <h3 class="title">Card Information Directory</h3>
                    <p class="desc">
                        A structured card database that helps users clearly
                        understand what each card offers.
                    </p>
                    <ul>
                        <li>Bank & card name</li>
                        <li>Network & category</li>
                        <li>Joining & annual fees</li>
                        <li>Status, pros & benefits</li>
                    </ul>
                    <span class="note">Know every detail before you use.</span>
                </div>

                <!-- Product 3 -->
                <div class="product-card animate fade-up delay-3">
                    <div class="product-icon">💡</div>
                    <h3 class="title">Offer & Benefit Awareness</h3>
                    <p class="desc">
                        Learn about offers, benefits, and best practices —
                        purely for awareness, not promotions.
                    </p>
                    <ul>
                        <li>Ongoing card offers</li>
                        <li>Cashback & discounts</li>
                        <li>Usage-based advantages</li>
                        <li>Avoid extra charges</li>
                    </ul>
                    <span class="note">Only knowledge — no promotions.</span>
                </div>

            </div>
        </div>
    </section>
    {{-- product feature area end --}}

    {{-- knowledge area start  --}}
    <section class="knowledge-area">
        <div class="products-glow-step"></div>
        <div class="knowledge-glow"></div>

        <div class="container">

            <!-- Section Header -->
            <div class="section-header animate fade-down">
                <span class="section-tag">Knowledge Hub</span>
                <h2 class="section-title">
                    Learn Cards the Right Way,<br>
                    Step by Step
                </h2>
                <p class="section-subtitle">
                    Clear, practical card knowledge designed for beginners and
                    everyday users — no jargon, no confusion.
                </p>
            </div>

            <!-- Knowledge Cards -->
            <div class="knowledge-grid">

                <!-- Card 1 -->
                <div class="knowledge-card animate fade-up delay-1">
                    <span class="card-badge">Basics</span>
                    <h3 class="title">Credit Card Explained</h3>
                    <p class="desc">
                        Learn how credit cards work from the ground up and
                        understand the core concepts every user must know.
                    </p>
                    <ul>
                        <li>What is a credit card?</li>
                        <li>Joining fee vs annual fee</li>
                        <li>Interest & billing cycles</li>
                        <li>Card tiers & networks</li>
                    </ul>
                    <span class="hint">Perfect for beginners & first-time users</span>
                </div>

                <!-- Card 2 -->
                <div class="knowledge-card animate fade-up delay-2">
                    <span class="card-badge">Networks</span>
                    <h3 class="title">Debit Card & Network Types</h3>
                    <p class="desc">
                        Understand how debit cards work and how payment networks
                        power everyday transactions.
                    </p>
                    <ul>
                        <li>Debit card usage rules</li>
                        <li>Visa, Mastercard & RuPay</li>
                        <li>ATM withdrawal limits</li>
                        <li>Online & offline safety</li>
                    </ul>
                </div>

                <!-- Card 3 -->
                <div class="knowledge-card animate fade-up delay-3">
                    <span class="card-badge">Smart Use</span>
                    <h3 class="title">Fees, Status & Smart Usage</h3>
                    <p class="desc">
                        Learn how to use cards wisely and avoid common mistakes
                        that cost money.
                    </p>
                    <ul>
                        <li>Active vs inactive status</li>
                        <li>Avoid unnecessary fees</li>
                        <li>Pros & limitations</li>
                        <li>Smart daily spending habits</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>
    {{-- knowledge area end  --}}


    {{-- user login area start --}}
    {{-- <section class="login-split-area">
        <div class="login-bg-glow"></div>

        <div class="container">

            <div class="login-split">
                <div class="login-text animate fade-left">
                    <span class="card-badge">User Login</span>

                    <h2 class="section-title">
                        One Secure Login.<br>
                        Smarter Card Experience.
                    </h2>

                    <p class="section-subtitle">
                        Create an account to save cards, access deeper knowledge,
                        and stay updated — all with privacy-first security.
                    </p>

                    <a href="{{ route('login') }}" class="login-main-btn">
                        Login to Continue
                    </a>

                    <p class="login-note">
                        New here? <a href="{{ route('register') }}">Create an account</a>
                    </p>
                </div>
                <div class="login-highlights">

                    <div class="highlight-item animate fade-up delay-1">
                        <span class="dot"></span>
                        <p>Save preferred credit & debit cards</p>
                    </div>

                    <div class="highlight-item animate fade-up delay-2">
                        <span class="dot"></span>
                        <p>Access detailed card knowledge</p>
                    </div>

                    <div class="highlight-item animate fade-up delay-3">
                        <span class="dot"></span>
                        <p>Track updates and new card information</p>
                    </div>

                    <div class="highlight-item animate fade-up delay-4">
                        <span class="dot"></span>
                        <p>Secure and privacy-focused login</p>
                    </div>

                </div>

            </div>
        </div>
    </section> --}}
    <section class="cta-area">
    <div class="cta-glow"></div>

    <div class="container">

        <div class="cta-content animate fade-up">
            <span class="cta-tag">Get Started</span>

            <h2 class="cta-title">
                Understand Your Cards.<br>
                Make Smarter Financial Choices.
            </h2>

            <p class="cta-text">
                Card Advisor GPT helps you learn how your cards work,
                avoid unnecessary fees, and use them confidently — all
                through simple AI-powered explanations.
            </p>

            <div class="cta-actions">
                <a href="{{ route('register') }}" class="cta-btn primary">
                    Create Free Account
                </a>
                <a href="{{ route('login') }}" class="cta-btn secondary">
                    Login
                </a>
            </div>
        </div>

    </div>
</section>

    {{-- user login area end --}}






    {{-- <section class="steps-section py-5">
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
    </section> --}}

    <footer class="pf-footer">
    <div class="pf-container">

        <!-- Top CTA (Soft, Footer-Style) -->
        <div class="pf-footer-cta animate pf-fade-up">
            <h3 class="text-white">Start using your cards smarter</h3>
            <a href="{{ route('register') }}" class="pf-cta-btn">
                Create Free Account
            </a>
        </div>

        <!-- Main Footer -->
        <div class="pf-footer-main animate pf-fade-up pf-delay-1">

            <!-- Brand -->
            <div class="pf-footer-brand">
                <h4 class="text-white">Card Advisor GPT</h4>
                <p>
                    An AI-powered card knowledge platform built to help users
                    understand credit and debit cards clearly — without sales,
                    bias, or confusion.
                </p>
            </div>

            <!-- Links -->
            <div class="pf-footer-cols">
                <div class="pf-col">
                    <span>Product</span>
                    <a href="#">Explore Cards</a>
                    <a href="#">Knowledge Hub</a>
                    <a href="#">AI Features</a>
                </div>

                <div class="pf-col">
                    <span>Company</span>
                    <a href="#">About Us</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Use</a>
                </div>

                <div class="pf-col">
                    <span>Account</span>
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Create Account</a>
                </div>
            </div>

        </div>

        <!-- Bottom -->
        <div class="pf-footer-bottom animate pf-fade-up pf-delay-2">
            © {{ date('Y') }} Card Advisor GPT. All rights reserved.
        </div>

    </div>
</footer>




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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
