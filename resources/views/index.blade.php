<!DOCTYPE html>

<html class="dark scroll-smooth scroll-pt-32" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Card Advisor</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@300;400;500;600&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-tertiary-container": "#5d1471",
                        "inverse-primary": "#005db9",
                        "primary-fixed-dim": "#4593ff",
                        "on-background": "#ffffff",
                        "surface-container": "#1a1a1a",
                        "secondary-container": "#705d00",
                        "on-tertiary-fixed": "#400050",
                        "error": "#ff716c",
                        "primary-container": "#64a1ff",
                        "surface-container-highest": "#262626",
                        "primary-fixed": "#64a1ff",
                        "tertiary": "#f4b2ff",
                        "surface-dim": "#0e0e0e",
                        "tertiary-dim": "#e190f1",
                        "outline-variant": "#484847",
                        "on-surface-variant": "#adaaaa",
                        "inverse-on-surface": "#565555",
                        "secondary-dim": "#efc900",
                        "secondary-fixed-dim": "#efc900",
                        "tertiary-fixed-dim": "#e190f1",
                        "outline": "#767575",
                        "secondary-fixed": "#ffd709",
                        "surface-bright": "#2c2c2c",
                        "inverse-surface": "#fcf9f8",
                        "on-primary": "#002e60",
                        "on-secondary": "#5b4b00",
                        "surface-tint": "#7fafff",
                        "surface-container-low": "#131313",
                        "primary": "#7fafff",
                        "primary-dim": "#0073e0",
                        "on-secondary-fixed-variant": "#665500",
                        "on-surface": "#ffffff",
                        "on-tertiary-fixed-variant": "#681f7a",
                        "surface-container-lowest": "#000000",
                        "error-container": "#9f0519",
                        "on-secondary-container": "#fff7e6",
                        "secondary": "#ffd709",
                        "on-error-container": "#ffa8a3",
                        "background": "#0e0e0e",
                        "tertiary-fixed": "#ef9dff",
                        "on-secondary-fixed": "#453900",
                        "tertiary-container": "#ef9dff",
                        "surface-variant": "#262626",
                        "on-primary-container": "#00224b",
                        "surface-container-high": "#20201f",
                        "error-dim": "#d7383b",
                        "on-primary-fixed": "#000000",
                        "on-error": "#490006",
                        "surface": "#0e0e0e",
                        "on-primary-fixed-variant": "#002b5c",
                        "on-tertiary": "#68207b"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        .glass {
            background: rgba(38, 38, 38, 0.6);
            backdrop-filter: blur(12px);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glow-primary {
            box-shadow: 0 0 20px rgba(127, 175, 255, 0.2);
        }

        .editorial-text {
            letter-spacing: -0.02em;
        }

        .premium-metadata {
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.75rem;
        }
    </style>
</head>

<body class="bg-background text-on-background font-body selection:bg-primary selection:text-on-primary">
    <!-- TopNavBar -->
    <nav class="fixed top-0 w-full z-50 bg-[#0e0e0e]/80 backdrop-blur-xl shadow-2xl shadow-black/40">
        <div class="flex justify-between items-center px-4 md:px-8 py-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-2 md:gap-4">
                <img src="{{ asset('assets/image/logo/Card_Advisor_logo.png') }}" alt="Card Advisor Logo"
                    class="h-10 md:h-[5rem]" style="height: auto; max-height: 5rem;">
                <span
                    class="bg-secondary-container text-secondary text-[10px] font-black px-2 py-0.5 rounded-full premium-metadata hidden sm:inline-block">100%
                    Free</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a class="text-gray-400 font-medium hover:text-white transition-colors font-headline tracking-tight text-sm"
                    href="#cards">Cards</a>
                <a class="text-gray-400 font-medium hover:text-white transition-colors font-headline tracking-tight text-sm"
                    href="#dashboard">Dashboard</a>
                <a class="text-gray-400 font-medium hover:text-white transition-colors font-headline tracking-tight text-sm"
                    href="#chat">Chat</a>
                <a class="text-gray-400 font-medium hover:text-white transition-colors font-headline tracking-tight text-sm"
                    href="#features">Features</a>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <span class="material-symbols-outlined text-primary" data-icon="verified">verified</span>
                <a href="{{ route('login') }}"
                    class="text-gray-400 font-medium hover:text-white transition-colors font-headline text-sm">Sign
                    In</a>
                <a href="{{ route('register') }}"
                    class="bg-primary text-on-primary px-5 py-2 rounded-xl font-headline font-bold text-sm hover:scale-95 transition-transform duration-300 inline-block">Get
                    Started</a>
            </div>
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-btn" class="text-white focus:outline-none p-2">
                    <span class="material-symbols-outlined text-3xl" data-icon="menu">menu</span>
                </button>
            </div>
        </div>
        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu"
            class="invisible opacity-0 -translate-y-4 transition-all duration-300 md:hidden bg-[#0e0e0e]/95 backdrop-blur-3xl border-t border-outline-variant/10 absolute w-full left-0 shadow-2xl">
            <div class="flex flex-col px-6 py-6 gap-6">
                <a class="text-gray-400 hover:text-white transition-colors font-headline font-bold text-lg border-b border-outline-variant/10 pb-4"
                    href="#cards">Cards</a>
                <a class="text-gray-400 hover:text-white transition-colors font-headline font-bold text-lg border-b border-outline-variant/10 pb-4"
                    href="#dashboard">Dashboard</a>
                <a class="text-gray-400 hover:text-white transition-colors font-headline font-bold text-lg border-b border-outline-variant/10 pb-4"
                    href="#chat">Chat</a>
                <a class="text-gray-400 hover:text-white transition-colors font-headline font-bold text-lg border-b border-outline-variant/10 pb-4"
                    href="#features">Features</a>
                <div class="pt-4 flex flex-col gap-4">
                    <a href="{{ route('login') }}"
                        class="text-center text-white border border-outline-variant/20 rounded-xl py-3 font-headline font-bold hover:bg-surface-container-highest transition-colors">Sign
                        In</a>
                    <a href="{{ route('register') }}"
                        class="text-center bg-primary text-on-primary rounded-xl py-3 font-headline font-bold hover:bg-primary/90 transition-colors">Get
                        Started</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="pt-32 overflow-hidden">
        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-8 grid lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-8">
                <h1 class="text-6xl md:text-7xl font-black font-headline editorial-text leading-[1.1]">
                    Find the perfect card for <span class="text-primary">every purchase</span>
                </h1>
                <p class="text-on-surface-variant text-xl max-w-lg leading-relaxed">
                    Ask our AI which card maximises rewards on your next spend. Unlock thousands in annual savings with
                    curated recommendations.
                </p>
                <div class="flex flex-wrap gap-4">
                    <button
                        class="bg-gradient-to-br from-primary to-primary-container text-on-primary px-8 py-4 rounded-xl font-headline font-bold flex items-center justify-center gap-3 hover:scale-95 transition-transform"
                        onclick="window.location.hash='#chat'">
                        <span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span>
                        <a href="{{ route('register') }}"> Chat with CardBot</a>
                    </button>
                    <button
                        class="bg-surface-container-highest px-8 py-4 rounded-xl font-headline font-bold border border-outline-variant/15 hover:bg-surface-bright transition-colors flex items-center justify-center"
                        onclick="window.location.hash='#cards'">
                        <a href="#cards">Explore Cards</a>
                    </button>
                </div>
            </div>
            <div class="relative min-h-[500px] flex items-center justify-center">
                <!-- Floating Elements -->
                <div
                    class="absolute top-4 right-10 glass p-4 rounded-xl z-20 shadow-2xl animate-bounce duration-[4000ms] mt-2">
                    <div class="flex items-center gap-3">
                        <div class="bg-secondary/20 p-2 rounded-lg">
                            <span class="material-symbols-outlined text-secondary" data-icon="savings">savings</span>
                        </div>
                        <div>
                            <p class="premium-metadata text-secondary">Saved This Month</p>
                            <p class="text-xl font-bold font-headline">+2,400</p>
                        </div>
                    </div>
                </div>
                <!-- Overlapping Cards Stack -->
                <div class="relative w-full h-[400px]">
                    <div class="absolute top-0 right-0 w-80 h-48 bg-gradient-to-br from-[#ffd709] to-[#b89b00] rounded-2xl shadow-2xl rotate-12 z-10 p-6 flex flex-col justify-between"
                        data-alt="premium gold metal credit card with minimalist luxury design and elegant texture">
                        <div class="flex justify-between items-start">
                            <span class="material-symbols-outlined text-black/50 text-4xl"
                                data-icon="contactless">contactless</span>
                            <span class="text-black font-black font-headline italic">GOLD</span>
                        </div>
                        <div class="text-black/80 font-mono tracking-widest">**** **** **** 8888</div>
                    </div>
                    <div class="absolute top-12 left-10 w-80 h-48 bg-gradient-to-br from-primary to-primary-dim rounded-2xl shadow-2xl -rotate-6 z-20 p-6 flex flex-col justify-between"
                        data-alt="vibrant blue modern credit card with holographic accents and sleek typography">
                        <div class="flex justify-between items-start">
                            <span class="material-symbols-outlined text-white/50 text-4xl"
                                data-icon="token">token</span>
                            <span class="text-white font-black font-headline italic">PLATINUM</span>
                        </div>
                        <div class="text-white/80 font-mono tracking-widest">**** **** **** 1234</div>
                    </div>
                    <div class="absolute bottom-0 right-10 w-80 h-48 bg-gradient-to-br from-tertiary to-on-tertiary rounded-2xl shadow-2xl rotate-3 z-30 p-6 flex flex-col justify-between"
                        data-alt="sophisticated purple credit card with glass texture and futuristic glowing edges">
                        <div class="flex justify-between items-start">
                            <span class="material-symbols-outlined text-white/50 text-4xl"
                                data-icon="diamond">diamond</span>
                            <span class="text-white font-black font-headline italic">ELITE</span>
                        </div>
                        <div class="text-white/80 font-mono tracking-widest">**** **** **** 5678</div>
                        <div
                            class="absolute -top-4 -right-4 bg-tertiary text-on-tertiary text-xs font-bold px-3 py-1 rounded-full">
                            5x on Dining</div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Filter Bar -->
        <section id="cards" class="max-w-7xl mx-auto px-4 md:px-8 mt-20 md:mt-32">
            <div
                class="bg-surface-container-low p-4 md:p-6 rounded-2xl flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6 md:gap-8">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6 w-full xl:w-auto">
                    <span class="premium-metadata text-on-surface-variant whitespace-nowrap">Card Type</span>
                    <div class="flex flex-wrap gap-2">
                        <button data-filter-type="all"
                            class="filter-btn bg-secondary-container text-secondary px-6 py-2 rounded-full text-sm font-bold">All</button>
                        <button data-filter-type="credit"
                            class="filter-btn bg-surface-container-highest text-on-surface-variant px-6 py-2 rounded-full text-sm font-bold hover:bg-surface-bright transition-colors">Credit</button>
                        <button data-filter-type="debit"
                            class="filter-btn bg-surface-container-highest text-on-surface-variant px-6 py-2 rounded-full text-sm font-bold hover:bg-surface-bright transition-colors">Debit</button>
                    </div>
                </div>
                <div
                    class="flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6 w-full xl:w-auto mt-2 xl:mt-0 pt-4 xl:pt-0 border-t border-outline-variant/10 xl:border-none">
                    <span class="premium-metadata text-on-surface-variant whitespace-nowrap">Network</span>
                    <div class="flex flex-wrap gap-2">
                        <button data-filter-network="all"
                            class="filter-net-btn bg-transparent border border-white text-white px-6 py-2 rounded-full text-sm font-bold transition-colors">All</button>
                        <button data-filter-network="visa"
                            class="filter-net-btn bg-surface-container-highest text-on-surface-variant px-6 py-2 rounded-full text-sm font-bold flex items-center gap-2 hover:bg-surface-bright transition-colors">
                            <span class="material-symbols-outlined text-xs" data-icon="credit_card">credit_card</span>
                            Visa
                        </button>
                        <button data-filter-network="mastercard"
                            class="filter-net-btn bg-surface-container-highest text-on-surface-variant px-6 py-2 rounded-full text-sm font-bold hover:bg-surface-bright transition-colors">Mastercard</button>
                        <button data-filter-network="amex"
                            class="filter-net-btn bg-surface-container-highest text-on-surface-variant px-6 py-2 rounded-full text-sm font-bold hover:bg-surface-bright transition-colors">Amex</button>
                        <button data-filter-network="rupay"
                            class="filter-net-btn bg-surface-container-highest text-on-surface-variant px-6 py-2 rounded-full text-sm font-bold hover:bg-surface-bright transition-colors">RuPay</button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Card Showcase -->
        <section class="max-w-7xl mx-auto px-8 mt-8 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="card-item bg-surface-container p-8 rounded-xl border border-outline-variant/10 hover:border-primary/30 transition-all group"
                data-type="credit" data-network="visa">
                <div class="mb-6 aspect-[1.6/1] rounded-xl flex items-center justify-center relative overflow-hidden">
                    <img src="{{ asset('assets/image/cards/HDFC-Bank-Regalia-Gold-Credit-Card.png') }}"
                        alt="HDFC Regalia Gold"
                        class="w-full h-full object-contain drop-shadow-2xl transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold font-headline">HDFC Regalia Gold</h3>
                            <p class="text-on-surface-variant text-sm">HDFC Bank • Credit</p>
                        </div>
                        <span class="material-symbols-outlined text-secondary" data-icon="star"
                            data-weight="fill">star</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-md text-xs font-bold">5x Dining</span>
                        <span class="bg-tertiary/10 text-tertiary px-3 py-1 rounded-md text-xs font-bold">3x
                            Travel</span>
                    </div>
                    <a href="{{ route('register') }}"
                        class="w-full mt-4 py-3 bg-surface-container-highest rounded-xl text-sm font-bold group-hover:bg-primary group-hover:text-on-primary transition-all flex items-center justify-center gap-2 inline-block">
                        <span class="material-symbols-outlined text-sm" data-icon="smart_toy">smart_toy</span> Ask Bot
                    </a>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="card-item bg-surface-container p-8 rounded-xl border border-outline-variant/10 hover:border-primary/30 transition-all group"
                data-type="credit" data-network="amex">
                <div class="mb-6 aspect-[1.6/1] rounded-xl flex items-center justify-center relative overflow-hidden">
                    <img src="{{ asset('assets/image/cards/american.jpg') }}" alt="American Express"
                        class="w-full h-full object-contain drop-shadow-2xl transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-bold font-headline">American Express</h3>
                        <p class="text-on-surface-variant text-sm">American Express • Credit</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-md text-xs font-bold">10x
                            Hotels</span>
                        <span class="bg-secondary/10 text-secondary px-3 py-1 rounded-md text-xs font-bold">Lounge
                            Access</span>
                    </div>
                    <a href="{{ route('register') }}"
                        class="w-full mt-4 py-3 bg-surface-container-highest rounded-xl text-sm font-bold group-hover:bg-primary group-hover:text-on-primary transition-all flex items-center justify-center gap-2 inline-block">
                        <span class="material-symbols-outlined text-sm" data-icon="smart_toy">smart_toy</span> Ask Bot
                    </a>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="card-item bg-surface-container p-8 rounded-xl border border-outline-variant/10 hover:border-primary/30 transition-all group"
                data-type="credit" data-network="mastercard">
                <div class="mb-6 aspect-[1.6/1] rounded-xl flex items-center justify-center relative overflow-hidden">
                    <img src="{{ asset('assets/image/cards/axis-magnus-card-img.jpg') }}" alt="Axis Magnus"
                        class="w-full h-full object-contain drop-shadow-2xl transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-bold font-headline">Axis Magnus</h3>
                        <p class="text-on-surface-variant text-sm">Axis Bank • Credit</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-tertiary/10 text-tertiary px-3 py-1 rounded-md text-xs font-bold">Milestone
                            Bonus</span>
                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-md text-xs font-bold">5x
                            Lifestyle</span>
                    </div>
                    <a href="{{ route('register') }}"
                        class="w-full mt-4 py-3 bg-surface-container-highest rounded-xl text-sm font-bold group-hover:bg-primary group-hover:text-on-primary transition-all flex items-center justify-center gap-2 inline-block">
                        <span class="material-symbols-outlined text-sm" data-icon="smart_toy">smart_toy</span> Ask Bot
                    </a>
                </div>
            </div>
            <!-- Row 2 -->
            <!-- Card 4 -->
            <div class="card-item bg-surface-container p-8 rounded-xl border border-outline-variant/10 hover:border-primary/30 transition-all group"
                data-type="credit" data-network="visa">
                <div class="mb-6 aspect-[1.6/1] rounded-xl flex items-center justify-center relative overflow-hidden">
                    <img src="{{ asset('assets/image/cards/SBI-Cashback-Credit-Card.png') }}" alt="SBI Cashback"
                        class="w-full h-full object-contain drop-shadow-2xl transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-bold font-headline">SBI Cashback</h3>
                        <p class="text-on-surface-variant text-sm">SBI • Credit</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-md text-xs font-bold">5%
                            Cashback</span>
                        <span
                            class="bg-secondary/10 text-secondary px-3 py-1 rounded-md text-xs font-bold">Waiver</span>
                    </div>
                    <a href="{{ route('register') }}"
                        class="w-full mt-4 py-3 bg-surface-container-highest rounded-xl text-sm font-bold group-hover:bg-primary group-hover:text-on-primary transition-all flex items-center justify-center gap-2 inline-block">
                        <span class="material-symbols-outlined text-sm" data-icon="smart_toy">smart_toy</span> Ask Bot
                    </a>
                </div>
            </div>
            <!-- Card 5 -->
            <div class="card-item bg-surface-container p-8 rounded-xl border border-outline-variant/10 hover:border-primary/30 transition-all group"
                data-type="credit" data-network="mastercard">
                <div class="mb-6 aspect-[1.6/1] rounded-xl flex items-center justify-center relative overflow-hidden">
                    <img src="{{ asset('assets/image/cards/ICICI-Bank-Coral-Credit-Card.png') }}" alt="ICICI Coral"
                        class="w-full h-full object-contain drop-shadow-2xl transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-bold font-headline">ICICI Coral</h3>
                        <p class="text-on-surface-variant text-sm">ICICI Bank • Credit</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-md text-xs font-bold">Reward
                            Points</span>
                        <span class="bg-tertiary/10 text-tertiary px-3 py-1 rounded-md text-xs font-bold">Dining
                            Offers</span>
                    </div>
                    <a href="{{ route('register') }}"
                        class="w-full mt-4 py-3 bg-surface-container-highest rounded-xl text-sm font-bold group-hover:bg-primary group-hover:text-on-primary transition-all flex items-center justify-center gap-2 inline-block">
                        <span class="material-symbols-outlined text-sm" data-icon="smart_toy">smart_toy</span> Ask Bot
                    </a>
                </div>
            </div>
            <!-- Card 6 -->
            <div class="card-item bg-surface-container p-8 rounded-xl border border-outline-variant/10 hover:border-primary/30 transition-all group"
                data-type="credit" data-network="visa">
                <div class="mb-6 aspect-[1.6/1] rounded-xl flex items-center justify-center relative overflow-hidden">
                    <img src="{{ asset('assets/image/cards/IDFC-Wealth-Credit-Card.png') }}" alt="IDFC Wealth"
                        class="w-full h-full object-contain drop-shadow-2xl transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-bold font-headline">IDFC First Wealth</h3>
                        <p class="text-on-surface-variant text-sm">IDFC • Credit</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-secondary/10 text-secondary px-3 py-1 rounded-md text-xs font-bold">Lifetime
                            Free</span>
                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-md text-xs font-bold">10x
                            Rewards</span>
                    </div>
                    <a href="{{ route('register') }}"
                        class="w-full mt-4 py-3 bg-surface-container-highest rounded-xl text-sm font-bold group-hover:bg-primary group-hover:text-on-primary transition-all flex items-center justify-center gap-2 inline-block">
                        <span class="material-symbols-outlined text-sm" data-icon="smart_toy">smart_toy</span> Ask Bot
                    </a>
                </div>
            </div>
        </section>
        <!-- Dashboard Preview -->
        <section id="dashboard" class="max-w-7xl mx-auto px-4 md:px-8 mt-20 md:mt-32">
            <div
                class="bg-surface-container-low rounded-3xl md:rounded-[2.5rem] p-6 md:p-12 border border-outline-variant/10 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/5 blur-[120px] rounded-full -mr-64 -mt-64">
                </div>
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
                    <div class="lg:col-span-1 space-y-6 md:space-y-8 text-center lg:text-left">
                        <h2 class="text-3xl md:text-4xl font-black font-headline editorial-text">Your Dashboard</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-surface-container p-6 rounded-2xl">
                                <p class="premium-metadata text-on-surface-variant mb-2">Total Saved</p>
                                <p class="text-2xl font-bold font-headline text-secondary">$12,450</p>
                            </div>
                            <div class="bg-surface-container p-6 rounded-2xl">
                                <p class="premium-metadata text-on-surface-variant mb-2">Points</p>
                                <p class="text-2xl font-bold font-headline text-primary">840K</p>
                            </div>
                            <div class="bg-surface-container p-6 rounded-2xl">
                                <p class="premium-metadata text-on-surface-variant mb-2">Active</p>
                                <p class="text-2xl font-bold font-headline">4 Cards</p>
                            </div>
                            <div class="bg-surface-container p-6 rounded-2xl">
                                <p class="premium-metadata text-on-surface-variant mb-2">Best</p>
                                <p class="text-lg font-bold font-headline">Regalia</p>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-2 bg-surface-container p-6 md:p-8 rounded-3xl space-y-6 md:space-y-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <h3 class="text-xl font-bold font-headline">Spend Breakdown</h3>
                            <select
                                class="bg-surface-container-highest text-sm rounded-lg px-4 py-2 border-none ring-1 ring-outline-variant/20 focus:ring-primary">
                                <option>Last 30 Days</option>
                            </select>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-on-surface-variant">Dining</span>
                                    <span class="font-bold">$4,200</span>
                                </div>
                                <div class="h-2 w-full bg-surface-container-highest rounded-full overflow-hidden">
                                    <div class="h-full bg-primary glow-primary" style="width: 75%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-on-surface-variant">Shopping</span>
                                    <span class="font-bold">$2,850</span>
                                </div>
                                <div class="h-2 w-full bg-surface-container-highest rounded-full overflow-hidden">
                                    <div class="h-full bg-secondary" style="width: 45%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-on-surface-variant">Travel</span>
                                    <span class="font-bold">$1,900</span>
                                </div>
                                <div class="h-2 w-full bg-surface-container-highest rounded-full overflow-hidden">
                                    <div class="h-full bg-tertiary" style="width: 30%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-on-surface-variant">Fuel</span>
                                    <span class="font-bold">$550</span>
                                </div>
                                <div class="h-2 w-full bg-surface-container-highest rounded-full overflow-hidden">
                                    <div class="h-full bg-on-surface-variant" style="width: 15%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- AI Chat Interface -->
        <section id="chat" class="max-w-7xl mx-auto px-8 mt-32">
            <div class="grid lg:grid-cols-5 gap-12 items-center">
                <div class="lg:col-span-2 space-y-6">
                    <h2 class="text-4xl font-black font-headline leading-tight">Your Personal Financial <span
                            class="text-primary">Super-Advisor</span></h2>
                    <p class="text-on-surface-variant text-lg">CardBot remembers your spending habits and analyzes
                        millions of data points to find you the absolute best value in seconds.</p>
                </div>
                <div
                    class="lg:col-span-3 bg-surface-container-low rounded-[2rem] p-4 border border-outline-variant/10 shadow-3xl">
                    <div class="bg-surface-container rounded-[1.5rem] overflow-hidden flex flex-col h-[500px]">
                        <!-- Chat Header -->
                        <div
                            class="p-6 bg-surface-container-highest border-b border-outline-variant/10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary"
                                        data-icon="smart_toy">smart_toy</span>
                                </div>
                                <div>
                                    <p class="text-sm font-black font-headline">CARDBOT — YOUR AI ADVISOR</p>
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                        <span class="text-[10px] text-on-surface-variant font-bold">ONLINE</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Chat Body -->
                        <div class="flex-1 p-6 space-y-6 overflow-y-auto">
                            <div class="flex justify-end">
                                <div
                                    class="bg-primary/10 border border-primary/20 p-4 rounded-2xl rounded-tr-none max-w-[80%]">
                                    <p class="text-sm">I'm at the grocery store right now. Which of my cards should I
                                        use for a $150 bill?</p>
                                </div>
                            </div>
                            <div class="flex justify-start">
                                <div
                                    class="bg-surface-container-highest p-4 rounded-2xl rounded-tl-none max-w-[80%] space-y-3">
                                    <p class="text-sm">Based on your wallet, I recommend the <span
                                            class="text-primary font-bold">HDFC Regalia Gold</span>.</p>
                                    <div
                                        class="bg-background/50 p-3 rounded-lg border border-outline-variant/10 flex items-center gap-3">
                                        <span class="material-symbols-outlined text-secondary"
                                            data-icon="auto_awesome">auto_awesome</span>
                                        <p class="text-xs font-bold text-secondary">You'll earn 5x points on this
                                            purchase (approx. $7.50 in value).</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Input -->
                        <div class="p-4 bg-surface-container-highest">
                            <div class="relative">
                                <input
                                    class="w-full bg-background border-none rounded-xl py-4 pl-4 pr-12 text-sm focus:ring-1 focus:ring-primary"
                                    placeholder="Ask anything about your cards..." type="text" />
                                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-primary">
                                    <span class="material-symbols-outlined" data-icon="send">send</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Feature Highlights -->
        <section id="features" class="max-w-7xl mx-auto px-8 mt-32 text-center">
            <h2 class="text-4xl font-black font-headline mb-16">The CardWise Ecosystem</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="p-8 bg-surface-container rounded-2xl text-left space-y-4 hover:translate-y-[-8px] transition-transform duration-300">
                    <div class="w-12 h-12 bg-primary/20 rounded-xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-primary" data-icon="privacy_tip">privacy_tip</span>
                    </div>
                    <h3 class="text-xl font-bold font-headline">Zero card details needed</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">We never ask for your card numbers or
                        CVV. Your privacy is our priority.</p>
                </div>
                <div
                    class="p-8 bg-surface-container rounded-2xl text-left space-y-4 hover:translate-y-[-8px] transition-transform duration-300">
                    <div class="w-12 h-12 bg-secondary/20 rounded-xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-secondary" data-icon="forum">forum</span>
                    </div>
                    <h3 class="text-xl font-bold font-headline">AI-powered chat advisor</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">Real-time financial guidance powered by
                        our advanced proprietary LLM.</p>
                </div>
                <div
                    class="p-8 bg-surface-container rounded-2xl text-left space-y-4 hover:translate-y-[-8px] transition-transform duration-300">
                    <div class="w-12 h-12 bg-tertiary/20 rounded-xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-tertiary" data-icon="history">history</span>
                    </div>
                    <h3 class="text-xl font-bold font-headline">Full chat history</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">Never lose a recommendation. All your
                        advice history is synced and secured.</p>
                </div>
                <div
                    class="p-8 bg-surface-container rounded-2xl text-left space-y-4 hover:translate-y-[-8px] transition-transform duration-300">
                    <div class="w-12 h-12 bg-primary/20 rounded-xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-primary" data-icon="database">database</span>
                    </div>
                    <h3 class="text-xl font-bold font-headline">200+ card database</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">We track every perk, reward, and fee for
                        hundreds of global cards.</p>
                </div>
                <div
                    class="p-8 bg-surface-container rounded-2xl text-left space-y-4 hover:translate-y-[-8px] transition-transform duration-300">
                    <div class="w-12 h-12 bg-secondary/20 rounded-xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-secondary" data-icon="add_card">add_card</span>
                    </div>
                    <h3 class="text-xl font-bold font-headline">Apply for new cards</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">One-click applications for the cards that
                        actually fit your spending profile.</p>
                </div>
                <div
                    class="p-8 bg-surface-container rounded-2xl text-left space-y-4 hover:translate-y-[-8px] transition-transform duration-300">
                    <div class="w-12 h-12 bg-tertiary/20 rounded-xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-tertiary" data-icon="tune">tune</span>
                    </div>
                    <h3 class="text-xl font-bold font-headline">Filter by type &amp; network</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">Find exactly what you need with granular
                        filtering for every lifestyle.</p>
                </div>
            </div>
        </section>
        <!-- Final CTA Section -->
        <section class="max-w-7xl mx-auto px-8 mt-24 mb-24">
            <div
                class="bg-gradient-to-br from-primary-dim to-primary p-12 md:p-20 rounded-[3rem] text-center space-y-10 relative overflow-hidden">
                <div
                    class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_white_0%,_transparent_100%)] pointer-events-none">
                </div>
                <h2 class="text-4xl md:text-6xl font-black font-headline text-on-primary-container relative z-10">Want more benefits?
                    <br />Apply for a new card.
                </h2>
                <div class="flex flex-wrap justify-center items-center gap-12 opacity-60 relative z-10">
                    <span class="text-on-primary-container font-black text-2xl tracking-tighter">VISA</span>
                    <span class="text-on-primary-container font-black text-2xl tracking-tighter">Mastercard</span>
                    <span class="text-on-primary-container font-black text-2xl tracking-tighter">AMEX</span>
                    <span class="text-on-primary-container font-black text-2xl tracking-tighter">RuPay</span>
                </div>
                <a href="{{ route('register') }}"
                    class="bg-on-primary-container text-white px-10 py-5 rounded-2xl font-black text-lg hover:scale-105 transition-transform inline-block relative z-10">
                    Find my ideal card
                </a>
                
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-[#131313] w-full pb-10 pt-20 px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8">
            <div class="col-span-2">
                <img src="{{ asset('assets/image/logo/Card_Advisor_logo.png') }}" alt="Card Advisor Logo" class=" mb-4"
                    style="height: 6rem;">
                <p class="text-gray-500 text-sm max-w-xs">The premium financial advisor built for the modern digital
                    era. Smarter spending, automated.</p>
            </div>
            <div>
                <span class="font-inter text-md tracking-wide uppercase text-white-800 mb-6 block">Company</span>
                <ul class="space-y-3">
                    <li><a class="text-gray-500 hover:text-blue-400 transition-colors hover:translate-x-1 inline-block duration-200"
                            href="#">About Us</a></li>
                    <li><a class="text-gray-500 hover:text-blue-400 transition-colors hover:translate-x-1 inline-block duration-200"
                            href="#">Security</a></li>
                </ul>
            </div>
            <div>
                <span class="font-inter text-md tracking-wide uppercase text-white-800 mb-6 block">Product</span>
                <ul class="space-y-3">
                    <li><a class="text-gray-500 hover:text-blue-400 transition-colors hover:translate-x-1 inline-block duration-200"
                            href="#cards">Cards</a></li>
                    <li><a class="text-gray-500 hover:text-blue-400 transition-colors hover:translate-x-1 inline-block duration-200"
                            href="#dashboard">Dashboard</a></li>
                    <li><a class="text-gray-500 hover:text-blue-400 transition-colors hover:translate-x-1 inline-block duration-200"
                            href="#chat">Card</a></li>
                    <li><a class="text-gray-500 hover:text-blue-400 transition-colors hover:translate-x-1 inline-block duration-200"
                            href="#features">Features</a></li>
                </ul>
            </div>
            <div>
                <span class="font-inter text-md tracking-wide uppercase text-white-800 mb-6 block">Legal</span>
                <ul class="space-y-3">
                    <li><a class="text-gray-500 hover:text-blue-400 transition-colors hover:translate-x-1 inline-block duration-200"
                            href="#">Privacy Policy</a></li>
                    <li><a class="text-gray-500 hover:text-blue-400 transition-colors hover:translate-x-1 inline-block duration-200"
                            href="#">Terms of Service</a></li>
                </ul>
            </div>
            <div>
                <span class="font-inter text-md tracking-wide uppercase text-white-800 mb-6 block">Support</span>
                <ul class="space-y-3">
                    <li><a class="text-gray-500 hover:text-blue-400 transition-colors hover:translate-x-1 inline-block duration-200"
                            href="#">Help Center</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-16 pt-8 border-t border-outline-variant/100">
            <p class="font-inter text-xs tracking-wide uppercase text-gray-500">© Copyright 2026 Infinity Plus 1</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuIcon = mobileMenuBtn ? mobileMenuBtn.querySelector('span') : null;
            const mobileLinks = mobileMenu ? mobileMenu.querySelectorAll('a') : [];

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    const isOpen = mobileMenu.classList.contains('opacity-100');
                    if (isOpen) {
                        mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                        mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-4');
                        mobileMenuIcon.textContent = 'menu';
                    } else {
                        mobileMenu.classList.remove('opacity-0', 'invisible', '-translate-y-4');
                        mobileMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
                        mobileMenuIcon.textContent = 'close';
                    }
                });

                mobileLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                        mobileMenu.classList.add('opacity-0', 'invisible', '-translate-y-4');
                        mobileMenuIcon.textContent = 'menu';
                    });
                });
            }

            const typeBtns = document.querySelectorAll('.filter-btn');
            const netBtns = document.querySelectorAll('.filter-net-btn');
            const cards = document.querySelectorAll('.card-item');

            let activeType = 'all';
            let activeNetwork = 'all';

            function filterCards() {
                cards.forEach(card => {
                    const cardType = card.getAttribute('data-type');
                    const cardNetwork = card.getAttribute('data-network');

                    let showType = (activeType === 'all' || activeType === cardType);
                    let showNet = (activeNetwork === 'all' || activeNetwork === cardNetwork);

                    if (showType && showNet) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            typeBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    typeBtns.forEach(b => {
                        b.className = 'filter-btn bg-surface-container-highest text-on-surface-variant px-6 py-2 rounded-full text-sm font-bold hover:bg-surface-bright transition-colors';
                    });
                    btn.className = 'filter-btn bg-secondary-container text-secondary px-6 py-2 rounded-full text-sm font-bold';

                    activeType = btn.getAttribute('data-filter-type');
                    filterCards();
                });
            });

            netBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    netBtns.forEach(b => {
                        b.className = 'filter-net-btn bg-surface-container-highest text-on-surface-variant px-6 py-2 rounded-full text-sm font-bold hover:bg-surface-bright transition-colors' + (b.innerHTML.includes('credit_card') ? ' flex items-center gap-2' : '');
                    });
                    btn.className = 'filter-net-btn bg-transparent border border-white text-white px-6 py-2 rounded-full text-sm font-bold transition-colors' + (btn.innerHTML.includes('credit_card') ? ' flex items-center gap-2' : '');

                    activeNetwork = btn.getAttribute('data-filter-network');
                    filterCards();
                });
            });
        });
    </script>

</body>

</html>