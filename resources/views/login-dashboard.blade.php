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
    {{-- <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('assets/css/dashboard-chat.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style3.css') }}" rel="stylesheet">

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
                    
                    <a href="#" class="menu-item">
                        <i class="bi bi-calendar-event"></i>
                        <span>Cards</span>
                    </a>
                    <a href="#" class="menu-item">
                        <i class="bi bi-book"></i>
                        <span>Knowledge Base</span>
                    </a>

                    <a href="#" class="menu-item">
                        <i class="bi bi-activity"></i>
                        <span>Activity</span>
                    </a>

                    <a href="#" class="menu-item">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Messages</span>
                    </a>

                    <a href="#" class="menu-item">
                        <i class="bi bi-people"></i>
                        <span>Members</span>
                    </a>

                    <a href="#" class="menu-item">
                        <i class="bi bi-people-fill"></i>
                        <span>Groups</span>
                    </a>

                    <a href="#" class="menu-item">
                        <i class="bi bi-calendar-event"></i>
                        <span>Events</span>
                    </a>
                </div>
            </div>
        </aside>

        <div class="w-100">
            {{-- TOPBAR --}}
            <nav id="topbar" class="topbar">
                <div class="left-items d-flex align-items-center gap-3">
                    <button id="toggleSidebar" class="btn shadow-sm toggle-btn">
                        <i class="bi bi-list fs-3"></i>
                    </button>

                    <div class="search-box d-none d-md-flex align-items-center">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Start typing to search…" class="form-control" />
                    </div>
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
            <main id="content" class="content d-flex flex-column justify-content-center align-items-center">
                {{-- <h1>hello</h1> --}}
                <div class="row w-100">
                    <div class="col-12">
                        <div id="chatContainer" class="chat-container col-9 mx-auto"></div>
                    </div>
                </div>
                <div id="chat-input-section" class="w-100">
                    <div class="row">
                        <div class="col-9 mx-auto">
                            {{-- <h1>hello</h1> --}}
                            <div id="centerBox" class="center-box">
                                <h1 style="font-weight:400;">What’s on your mind today?</h1>
                            </div>
                            <div id="inputArea" class="input-area">
                                <input type="text" id="msgInput" class="input-bar" placeholder="Ask anything..." />
                            </div>
                        </div>
                    </div>
                </div>

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
        </div>

    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Custom JS --}}
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-chat.js') }}"></script>

    @stack('scripts')
</body>

</html>
