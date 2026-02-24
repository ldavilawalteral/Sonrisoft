<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        body { min-height: 100vh; background-color: #f8f9fa; }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #212529; /* Dark Sidebar */
            color: #fff;
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 20px;
            font-size: 1.05rem;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255,255,255,0.1);
        }
        .sidebar .nav-link i { width: 25px; text-align: center; margin-right: 10px; }
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .top-navbar {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -260px;
                z-index: 1050;
                height: 100%;
            }
            .sidebar.show { left: 0; }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }
            .sidebar-overlay.show { display: block; }
        }
    </style>
</head>
<body>
    <div id="app" class="d-flex">
        <!-- Sidebar -->
        @auth
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3" id="sidebar">
            <a href="{{ url('/') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <i class="fa-solid fa-tooth fa-2x me-2 text-primary"></i>
                <span class="fs-4 fw-bold">{{ config('app.name', 'Sonrisoft') }}</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('patients.index') }}" class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i> Pacientes
                    </a>
                </li>
                <li>
                    <a href="{{ route('appointments.index') }}" class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                        <i class="fa-regular fa-calendar-check"></i> Citas
                    </a>
                </li>
                <li>
                    <a href="{{ route('treatments.index') }}" class="nav-link {{ request()->routeIs('treatments.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-tooth"></i> Tratamientos
                    </a>
                </li>
                
                @if(Auth::user()->isAdmin())
                <li>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-boxes-stacked"></i> Inventario
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.index') }}" class="nav-link {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-doctor"></i> Personal
                    </a>
                </li>
                <!-- Bloque Reportes y Configuración (Visual placeholder as per request) -->
                 <li>
                    <a href="#" class="nav-link text-muted">
                        <i class="fa-solid fa-chart-line"></i> Reportes
                    </a>
                </li>
                 <li>
                    <a href="#" class="nav-link text-muted">
                        <i class="fa-solid fa-gear"></i> Configuración
                    </a>
                </li>
                @endif
            </ul>
        </div>
        
        <!-- Mobile Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        @endauth

        <!-- Main Content Wrapper -->
        <div class="main-content">
            <!-- Top Navbar -->
            <div class="top-navbar bg-white border-bottom">
                @auth
                <button class="btn btn-outline-secondary d-md-none me-auto" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                @endauth

                <div class="dropdown">
                     @guest
                        @if (Route::has('login'))
                            <a class="btn btn-sm btn-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif
                        @if (Route::has('register'))
                            <a class="btn btn-sm btn-primary ms-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @else
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                             <i class="fa-solid fa-circle-user me-1 text-secondary"></i> {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    @endguest
                </div>
            </div>

            <!-- Content Body -->
            <main class="py-4 px-4">
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
    <script>
        // Simple Sidebar Toggle for Mobile
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if(toggleBtn && sidebar && overlay) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
    </script>
</body>
</html>
