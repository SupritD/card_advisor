<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom CSS --}}
    <link href="{{ asset('assets/css/dashboard-chat.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <div class="d-flex">
        {{-- SIDEBAR --}}
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-content">
                <div class="top-sidebar">
                    <div class="sidebar-logo">
                        <img src="https://dummyimage.com/140x40/000/fff&text=LOGO" class="logo-full" />
                        <img src="https://dummyimage.com/40x40/000/fff&text=L" class="logo-icon d-none" />
                    </div>
                    {{-- <a href="#" class="menu-title">MAIN</a> --}}

                    <a href="{{ route('dashboard') }}" class="menu-item">
                        <i class="bi bi-house"></i>
                        <span>Home Pages</span>
                    </a>

                    <a href="{{ route('user.cards.index') }}"
                        class="menu-item {{ request()->routeIs('user.cards.*') ? 'active text-primary bg-primary bg-opacity-10' : '' }}">
                        <i class="bi bi-calendar-event"></i>
                        <span>Cards</span>
                    </a>
                    <a href="{{ route('user.chat.index') }}"
                        class="menu-item {{ request()->routeIs('user.chat.index') ? 'active text-primary bg-primary bg-opacity-10' : '' }}">
                        <img src="{{ asset('assets/image/logo/logo-outline-1.svg') }}" alt="AI Advisor" class="ai-icon">
                        <span>AI Advisor</span>
                    </a>


                    {{--
                    <div class="menu-dropdown">
                        <button class="menu-item dropdown-toggle-btn">
                            <i class="bi bi-house"></i>
                            <span>Home Pages</span>
                            <i class="bi bi-chevron-down dropdown-arrow"></i>
                        </button>

                        <div class="submenu">
                            <a href="#" class="submenu-item">Intranet</a>
                            <a href="#" class="submenu-item">Extranet</a>
                            <a href="#" class="submenu-item">Community</a>
                            <a href="#" class="submenu-item">Online Learning</a>
                            <a href="#" class="submenu-item">Social Network</a>
                        </div>
                    </div>
                    --}}
                </div>

                <div class="menu">
                    {{-- <a href="#" class="menu-title">COMMUNITY</a> --}}


                    {{-- <a href="#" class="menu-item">
                        <i class="bi bi-book"></i>
                        <span>Knowledge Base</span>
                    </a> --}}

                    {{-- <a href="#" class="menu-item">
                        <i class="bi bi-activity"></i>
                        <span>Activity</span>
                    </a> --}}



                    {{-- <a href="#" class="menu-item">
                        <i class="bi bi-people"></i>
                        <span>Members</span>
                    </a> --}}

                    {{-- <a href="#" class="menu-item">
                        <i class="bi bi-people-fill"></i>
                        <span>Groups</span>
                    </a> --}}

                    {{-- <a href="#" class="menu-item">
                        <i class="bi bi-calendar-event"></i>
                        <span>Events</span>
                    </a> --}}
                    <div>
                        @php
                            $isChatView =
                                request()->routeIs('user.chat.show') ||
                                (request()->routeIs('user.chat.index') && request()->route('token'));
                        @endphp
                        <div class="menu-dropdown {{ $isChatView ? 'open' : '' }}">
                            <button class="menu-item dropdown-toggle-btn">
                                {{-- <i class="bi bi-house"></i> --}}
                                <i class="bi bi-chat-left-text"></i>
                                <span>Your Chats</span>
                                <i class="bi bi-chevron-down dropdown-arrow"></i>
                            </button>

                            <div class="submenu">
                                @php
                                    $currentToken = request()->route('token');
                                @endphp
                                @forelse ($chatSessions as $session)
                                    <a href="{{ route('user.chat.show', $session->token) }}"
                                        class="submenu-item {{ $currentToken === $session->token ? 'active bg-primary bg-opacity-10 text-primary' : '' }}">
                                        {{ $session->title ?? 'Chat ' . $session->created_at->format('d M') }}
                                    </a>
                                @empty
                                    <span class="submenu-item text-muted">
                                        No chats yet
                                    </span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <div class="overlay-container">
        </div>

        <div class="w-100">
            {{-- TOPBAR --}}
            <nav id="topbar"
                class="topbar d-flex justify-content-between align-items-center px-4 py-3 bg-white bg-opacity-90 shadow-sm">
                <div class="left-items d-flex align-items-center gap-3">
                    <button id="toggleSidebar" class=" btn shadow-sm toggle-btn">
                        <i class="bi bi-list fs-3"></i>
                    </button>

                    {{-- <div class="search-box d-none d-md-flex align-items-center">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Start typing to search…" class="form-control" />
                    </div> --}}
                </div>

                <div class="right-items d-flex align-items-center gap-4">
                    {{-- USER DROPDOWN --}}
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#"
                            data-bs-toggle="dropdown">
                            {{-- Example Avatar --}}

                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-circle"
                                width="36" />
                            <span class="ms-2 fw-semibold d-none d-sm-block">Hi, {{ Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <main id="content" class="content" style="margin-top: 80px;">
                {{-- <h1>hello</h1> --}}


                {{-- <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div id="chatContainer" class="chat-container col-9 mx-auto"></div>
                        </div>
                        <div id="chat-input-section" class="w-100">
                            <div class="row">
                                <div class="col-9">
                                    <div id="centerBox" class="center-box">
                                        <h1 style="font-weight:400;">What’s on your mind today?</h1>
                                    </div>
                                    <div id="inputArea" class="input-area">
                                        <input type="text" id="msgInput" class="input-bar"
                                            placeholder="Ask anything..." />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}




                @yield('content')
            </main>
            <!-- Feedback Button -->
            <div id="feedback-btn">
                <img src="{{ asset('assets/image/logo/feedback-svgrepo-com.svg') }}" alt="Feedback"
                    class="feedback-img">
                <span class="feedback-text">Feedback</span>
            </div>

            <!-- Feedback Form -->
            <div id="feedback-box">
                <div class="feedback-header">
                    <span>
                        <i class="bi bi-chat-dots"></i> Feedback
                    </span>

                    <span id="feedback-close">
                        <i class="fa-solid fa-xmark"></i>
                    </span>
                </div>

                <div class="feedback-body">
                    <input type="text" class="form-control mb-2" placeholder="Your Name">
                    <input type="email" class="form-control mb-2" placeholder="Your Email">

                    <div class="text-center mb-2">
                        <i class="fa-regular fa-star star"></i>
                        <i class="fa-regular fa-star star"></i>
                        <i class="fa-regular fa-star star"></i>
                        <i class="fa-regular fa-star star"></i>
                        <i class="fa-regular fa-star star"></i>
                    </div>

                    <textarea class="form-control mb-3" rows="3" placeholder="Tell us what you think..."></textarea>

                    <button class="btn btn-primary w-100">Send Feedback</button>
                </div>
            </div>

        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Custom JS --}}
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>


    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleSidebar');

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 768) {
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && sidebar.classList
                        .contains('active')) {
                        // Assuming 'active' class toggles visibility. If dashboard.js uses a different class (e.g. 'show'), this needs adjustment.
                        // Triggerting the toggle button is safer if we don't know the exact class logic of dashboard.js
                        toggleBtn.click();
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const btn = document.getElementById('feedback-btn');
            const box = document.getElementById('feedback-box');
            const closeBtn = document.getElementById('feedback-close');
            const stars = document.querySelectorAll('.star');

            btn.addEventListener('click', () => {
                box.classList.toggle('active');
            });

            closeBtn.addEventListener('click', () => {
                box.classList.remove('active');
            });

            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    stars.forEach(s => s.classList.remove('active'));
                    for (let i = 0; i <= index; i++) {
                        stars[i].classList.add('active');
                    }
                });
            });

        });
    </script>



</body>

</html>
