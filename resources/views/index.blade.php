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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- master stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body>
    <div class="pr-main-wrapper">
        <div class="glow-bg"></div>
        
        <!-- HEADER -->
        <header class="pr-header">
            <div class="pr-container">
                <div class="pr-brand animate pr-fade">
                    <a href="{{ url('/') }}" class="pr-logo">
                        Card Advisor<span class="text-primary">.</span>
                    </a>
                </div>

                <nav class="pr-nav animate pr-fade pr-delay-1">
                    <a href="#">Cards</a>
                    <a href="#">Compare</a>
                    <a href="#">Benefits</a>
                    <a href="#">Learn</a>
                </nav>

                <div class="pr-actions animate pr-fade pr-delay-2">
                    <a href="{{ route('login') }}" class="pr-login">Log In</a>
                    <a href="{{ route('register') }}" class="pr-primary-btn">Get Started</a>
                </div>
            </div>
        </header>

        <!-- HERO SECTION -->
        <section class="hero-section">
            <div class="pr-container">
                <div class="hero-content">
                    <h1 class="hero-title animate fade-up">
                        The Future of <br>
                        <span class="text-gradient">Credit Card Intelligence</span>
                    </h1>
                    <p class="hero-desc animate fade-up delay-1">
                        Stop guessing. Start knowing. Our AI analyzes HDFC, SBI, Axis, and ICICI cards
                        to find the perfect match for your lifestyle.
                    </p>
                    <div class="hero-btns animate fade-up delay-2">
                        <a href="{{ route('register') }}" class="pr-primary-btn">Find My Card</a>
                        <a href="#" class="pr-btn-text">How it works <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>

                <div class="hero-visual animate fade-left delay-2">
                    <!-- Main Hero Card -->
                    <div class="hero-card-wrapper">
                        <img src="{{ asset('assets/image/banner/card-premium.png') }}" class="hero-card-img floating" alt="Premium Card" style="border-radius: 20px;">
                        <div class="hero-card-glow"></div>
                        
                        <!-- Floating Badges -->
                        <div class="chk-badge badge-1">
                            <i class="bi bi-check-circle-fill text-success"></i> 5X Rewards
                        </div>
                        <div class="chk-badge badge-2">
                            <i class="bi bi-check-circle-fill text-success"></i> Lounge Access
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- REAL CARDS SHOWCASE -->
        <section class="cards-showcase">
            <div class="pr-container">
                <div class="section-head text-center animate fade-up">
                    <span class="tag-pill">Premium Selection</span>
                    <h2 class="section-title">Real Cards. Real Benefits.</h2>
                    <p class="section-desc">Explore India's most popular credit cards, deconstructed by AI.</p>
                </div>

                <div class="cards-grid">
                    
                    <!-- HDFC Card -->
                    <div class="bank-card-item animate fade-up delay-1">
                        <div class="card-visual">
                            <img src="{{ asset('assets/image/banner/card-travel.png') }}" alt="HDFC Regalia">
                        </div>
                        <div class="card-details">
                            <h3>HDFC Regalia Gold</h3>
                            <span class="card-type">Travel & Lifestyle</span>
                            <ul class="card-benefits">
                                <li>The Gold Standard for travelers</li>
                                <li>Comp. Airport Lounge Access</li>
                                <li>5X Reward Points on Retail</li>
                            </ul>
                        </div>
                    </div>

                    <!-- SBI Card -->
                    <div class="bank-card-item animate fade-up delay-2">
                        <div class="card-visual">
                            <img src="{{ asset('assets/image/banner/card-cashback.png') }}" alt="SBI Cashback">
                        </div>
                        <div class="card-details">
                            <h3>SBI Cashback</h3>
                            <span class="card-type">Online Shopping</span>
                            <ul class="card-benefits">
                                <li>5% Cashback on ANY site</li>
                                <li>No Merchant Restrictions</li>
                                <li>Auto-Credit to Statement</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Axis Card -->
                    <div class="bank-card-item animate fade-up delay-3">
                        <div class="card-visual">
                            <img src="{{ asset('assets/image/banner/card-premium.png') }}" alt="Axis Magnus">
                        </div>
                        <div class="card-details">
                            <h3>Axis Magnus</h3>
                            <span class="card-type">Super Premium</span>
                            <ul class="card-benefits">
                                <li>Metal Card Exclusivity</li>
                                <li>Unlimited Lounge + Concierge</li>
                                <li>Up to 12% Reward Rate</li>
                            </ul>
                        </div>
                    </div>

                    <!-- ICICI Card -->
                    <div class="bank-card-item animate fade-up delay-4">
                        <div class="card-visual">
                            <img src="{{ asset('assets/image/banner/card-shopping.png') }}" alt="ICICI Coral">
                        </div>
                        <div class="card-details">
                            <h3>ICICI Coral</h3>
                            <span class="card-type">Everyday Essentials</span>
                            <ul class="card-benefits">
                                <li>Buy 1 Get 1 Movie Tickets</li>
                                <li>Dining Discounts</li>
                                <li>Reliable Fuel Surcharge Waiver</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ABOUT SECTION (Restored & Modernized) -->
        <section class="about-section">
            <div class="pr-container">
                <div class="about-wrapper animate fade-up">
                    <div class="about-text">
                        <span class="tag-pill">About Us</span>
                        <h2 class="section-title">Built to Make Cards <br> <span class="text-primary">Simple & Clear.</span></h2>
                        <p class="section-desc">
                            Card Advisor GPT is built to solve one simple problem: <strong>people don’t fully understand their cards.</strong>
                            <br><br>
                            Banks often explain cards using complex terms. Our AI reads details like bank name, card type, network, fees, and benefits, then presents everything in clear, easy language.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- PRODUCTS SECTION (Restored & Modernized) -->
        <section class="products-section">
            <div class="pr-container">
                <div class="section-head text-center animate fade-up">
                    <span class="tag-pill">Our Tools</span>
                    <h2 class="section-title">Intelligent Features</h2>
                    <p class="section-desc">Tools designed to help you make smarter financial decisions.</p>
                </div>

                <div class="products-grid">
                    <!-- Product 1 -->
                    <div class="product-box animate fade-up delay-1">
                        <div class="p-icon"><i class="bi bi-robot"></i></div>
                        <h3>Card Knowledge AI</h3>
                        <p>An intelligent GPT-powered chatbot that answers questions about cards instantly and clearly.</p>
                        <ul class="mini-list">
                            <li><i class="bi bi-check2"></i> Credit & debit cards</li>
                            <li><i class="bi bi-check2"></i> Card categories & tiers</li>
                        </ul>
                    </div>
                    <!-- Product 2 -->
                    <div class="product-box animate fade-up delay-2">
                        <div class="p-icon"><i class="bi bi-folder2-open"></i></div>
                        <h3>Card Directory</h3>
                        <p>A structured database that helps users clearly understand what each card offers.</p>
                        <ul class="mini-list">
                            <li><i class="bi bi-check2"></i> Bank & card name</li>
                            <li><i class="bi bi-check2"></i> Joining & annual fees</li>
                        </ul>
                    </div>
                    <!-- Product 3 -->
                    <div class="product-box animate fade-up delay-3">
                        <div class="p-icon"><i class="bi bi-lightbulb"></i></div>
                        <h3>Offer Awareness</h3>
                        <p>Learn about offers, benefits, and best practices — purely for awareness, not promotions.</p>
                        <ul class="mini-list">
                            <li><i class="bi bi-check2"></i> Ongoing card offers</li>
                            <li><i class="bi bi-check2"></i> Usage-based advantages</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- KNOWLEDGE HUB SECTION (Restored & Modernized) -->
        <section class="knowledge-section">
            <div class="pr-container">
                <div class="section-head text-center animate fade-up">
                    <span class="tag-pill">Knowledge Hub</span>
                    <h2 class="section-title">Learn the Basics</h2>
                    <p class="section-desc">Clear, practical card knowledge designed for beginners.</p>
                </div>

                <div class="knowledge-grid">
                    <!-- Card 1 -->
                    <div class="knowledge-box animate fade-up delay-1">
                        <span class="k-badge">Basics</span>
                        <h3>Credit Card Explained</h3>
                        <p>Learn how credit cards work from the ground up and understand the core concepts.</p>
                    </div>
                    <!-- Card 2 -->
                    <div class="knowledge-box animate fade-up delay-2">
                        <span class="k-badge">Networks</span>
                        <h3>Debit Card Types</h3>
                        <p>Understand how debit cards work and how payment networks power transactions.</p>
                    </div>
                    <!-- Card 3 -->
                    <div class="knowledge-box animate fade-up delay-3">
                        <span class="k-badge">Smart Use</span>
                        <h3>Fees & Habits</h3>
                        <p>Learn how to use cards wisely and avoid common mistakes that cost money.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURES / HOW IT WORKS -->
        <section class="features-section">
            <div class="pr-container">
                <div class="features-grid">
                    <div class="feature-box animate fade-right">
                        <div class="f-icon"><i class="bi bi-robot"></i></div>
                        <h4>AI-Powered Analysis</h4>
                        <p>Our AI reads the fine print so you don't have to. Understand fees and hidden charges in seconds.</p>
                    </div>
                    <div class="feature-box animate fade-right delay-1">
                        <div class="f-icon"><i class="bi bi-layers"></i></div>
                        <h4>Side-by-Side Compare</h4>
                        <p>Compare HDFC vs SBI vs Axis instantly. See which card actually puts more money in your pocket.</p>
                    </div>
                    <div class="feature-box animate fade-right delay-2">
                        <div class="f-icon"><i class="bi bi-shield-check"></i></div>
                        <h4>Unbiased Trust</h4>
                        <p>We don't sell cards. We explain them. Get 100% neutral advice based on data, not commissions.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- GLOW CTA SECTION -->
        <section class="cta-section">
            <div class="glow-orb"></div>
            <div class="pr-container">
                <div class="cta-content animate fade-up">
                    <h2 class="cta-title">Ready to Master Your Wallet?</h2>
                    <p class="cta-desc">
                        Join 50,000+ users who are saving money everyday with smart card choices.
                        No spam. No bias. Just pure financial intelligence.
                    </p>
                    <a href="{{ route('register') }}" class="cta-btn-large">
                        Start Your Journey <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- MEGA FOOTER -->
        <footer class="mega-footer">
            <div class="pr-container">
                <div class="footer-grid">
                    <!-- Column 1: Brand -->
                    <div class="footer-col brand-col animate fade-up">
                        <a href="#" class="footer-logo">Card Advisor<span class="text-primary">.</span></a>
                        <p class="footer-mission">
                            Empowering millions to understand, compare, and maximize their credit card rewards through AI-driven insights.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>

                    <!-- Column 2: Explore -->
                    <div class="footer-col animate fade-up delay-1">
                        <h4>Explore</h4>
                        <ul class="footer-links">
                            <li><a href="#">Best Credit Cards</a></li>
                            <li><a href="#">Card Comparison</a></li>
                            <li><a href="#">Reward Calculator</a></li>
                            <li><a href="#">Lounge Access</a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Company -->
                    <div class="footer-col animate fade-up delay-2">
                        <h4>Company</h4>
                        <ul class="footer-links">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Our Ethics</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Service</a></li>
                        </ul>
                    </div>

                    <!-- Column 4: Newsletter -->
                    <div class="footer-col animate fade-up delay-3">
                        <h4>Stay Updated</h4>
                        <p class="newsletter-text">Get the latest card devaluation alerts straight to your inbox.</p>
                        <form class="newsletter-form">
                            <input type="email" placeholder="Your email address">
                            <button type="submit"><i class="bi bi-send"></i></button>
                        </form>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} Card Advisor GPT. Built for smart financial decisions.</p>
                </div>
            </div>
        </footer>
    </div>




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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"
        integrity="sha512-NcZdtrT77bJr4STcmsGAESr06BYGE8woZdSdEgqnpyqac7sugNO+Tr4bGwGF3MsnEkGKhU2KL2xh6Ec+BqsaHA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="{{ asset('assets/js/mainpage.js') }}"></script>

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
    <script>
        (() => {
            const dot = document.querySelector('.ux-cursor-dot');
            const ring = document.querySelector('.ux-cursor-ring');

            let mouseX = window.innerWidth / 2;
            let mouseY = window.innerHeight / 2;
            let ringX = mouseX;
            let ringY = mouseY;

            // Track mouse
            document.addEventListener('mousemove', e => {
                mouseX = e.clientX;
                mouseY = e.clientY;

                dot.style.left = mouseX + 'px';
                dot.style.top = mouseY + 'px';
            });

            // Smooth follow (ONLY follows mouse — no snapping)
            function animate() {
                ringX += (mouseX - ringX) * 0.18;
                ringY += (mouseY - ringY) * 0.18;

                ring.style.left = ringX + 'px';
                ring.style.top = ringY + 'px';

                requestAnimationFrame(animate);
            }
            animate();

            /* Hover states (NO position manipulation) */
            const hoverEls = 'a, button, .btn, [role="button"]';
            const textEls = 'input, textarea, select, p, h1, h2, h3, h4, h5, h6, span';

            document.querySelectorAll(hoverEls).forEach(el => {
                el.addEventListener('mouseenter', () =>
                    document.body.classList.add('cursor-hover')
                );
                el.addEventListener('mouseleave', () =>
                    document.body.classList.remove('cursor-hover')
                );
            });

            document.querySelectorAll(textEls).forEach(el => {
                el.addEventListener('mouseenter', () =>
                    document.body.classList.add('cursor-text')
                );
                el.addEventListener('mouseleave', () =>
                    document.body.classList.remove('cursor-text')
                );
            });

            // Hide when leaving window
            document.addEventListener('mouseleave', () => {
                dot.style.opacity = 0;
                ring.style.opacity = 0;
            });

            document.addEventListener('mouseenter', () => {
                dot.style.opacity = 1;
                ring.style.opacity = 1;
            });
        })();
    </script>


</body>

</html>
