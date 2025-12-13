<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">


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

                    {{-- <a href="{{ route('dashboard') }}" class="menu-item">
                        <i class="bi bi-house"></i>
                        <span>Card</span>
                    </a> --}}
                    <a href="{{ route('admin.cards.index') }}" class="menu-item">
                        <i class="bi bi-house"></i>
                        <span>Cards</span>
                    </a>

                </div>

                <div class="menu">
                    {{-- <a href="#" class="menu-title">COMMUNITY</a> --}}

                    <a href="{{ route('admin.users.index') }}" class="menu-item">
                        <i class="bi bi-people"></i>
                        <span>User</span>
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

                            <img src="https://ui-avatars.com/api/?name={{ auth('admin')->user()->name }}"
                                class="rounded-circle" width="36" />
                            <span class="ms-2 fw-semibold d-none d-sm-block">Hi,
                                {{ auth('admin')->user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            {{-- <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                            </li> --}}
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <main id="content" class="p-5">


                @yield('content')
            </main>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-chat.js') }}"></script>



    @stack('scripts')
</body>

</html>
