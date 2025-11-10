<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- SEO Meta Tags -->
    <meta name="description" content="Library Management System - Manage your library, books, and student records efficiently." />
    <meta name="keywords" content="library, management, system, books, students, NPIC, backend" />
    <meta name="author" content="Your Name" />

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="NPIC Library Management System" />
    <meta property="og:description" content="Manage your library, books, and student records efficiently through the NPIC Library Management System." />
    <meta property="og:image" content="https://cdn.pixabay.com/photo/2024/08/08/16/24/16-24-13-872_960_720.png" />
    <meta property="og:url" content="https://fbc5-175-100-11-120.ngrok-free.app/" />
    <meta property="og:type" content="website" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="NPIC Library Management System" />
    <meta name="twitter:description" content="Manage your library, books, and student records efficiently through the NPIC Library Management System." />
    <meta name="twitter:image" content="https://cdn.pixabay.com/photo/2024/08/08/16/24/16-24-13-872_960_720.png" />
    <meta name="twitter:site" content="@YourTwitterHandle" />

    <!-- Favicon -->
    <link rel="icon" href="https://cdn.pixabay.com/photo/2024/08/08/15/58/hero-8954978_960_720.png" type="image/x-icon" />

    <title>Npic Library</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/c3a6b79c4e.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/framer-motion/5.4.5/framer-motion.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .my-navbar {
            flex-shrink: 0;
        }
        #layoutSidenav {
            display: flex;
            flex: 1;
            overflow: hidden;
        }
      
        #layoutSidenav_nav {
            flex-shrink: 0;
            background-color: rgba(255, 255, 255, 0.973);
            z-index: 2;
            min-width: 250px;
        }
        #layoutSidenav_content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        main {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }
    </style>
</head>
<body>
    <nav class="my-navbar">
        <!-- Sidebar Toggle -->
        <div class="logo-menu">
            <i class="menu-toggle fas fa-bars" id="sidebarToggle"></i>
            <!-- Navbar Brand -->
            <span class="navbar-brand">
                <img width="60px" src="{{ asset('logo.png') }}" alt="Logo">
                Library System
            </span>
        </div>

        <!-- Dark Mode Toggle Icon -->
        

        <!-- Navbar -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 d-flex align-items-center">
            <!-- Dark Mode Toggle Icon -->
            <div class="ms-auto me-3" id="darkModeContainer" style="cursor: pointer;">
                <i class="fa-solid fa-moon" id="darkModeIcon"></i>
            </div>
            
            <!-- User Dropdown Menu -->
            <li class="nav-item dropdown">   
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>             
                <ul class="dropdown-menu dropdown-menu-end my-dropdown-menu" aria-labelledby="navbarDropdown">
                    <!-- User Info Section -->
                    <li class="dropdown-item py-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-circle fa-2x me-2"></i>
                            <div>
                                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                <small>{{ Auth::user()->email }}</small>
                            </div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <!-- Logout Link -->
                    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a></li>
                </ul>
            </li>
        </ul>
        
        <!-- Hidden Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        
        
        <!-- Hidden Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-white" id="sidenavAccordion"style="">
                <div class="sb-sidenav-menu border-top-0 border border-right">
                    <div class="my-sidenav">
                        <a class="text-dark d-flex {{ request()->is('attendent') ? 'active' : '' }}" href="/attendent">
                            <div class="sb-text-dark-icon"><i class="fa-solid fa-calendar-check"></i></div>
                            វត្តមានសិស្ស
                        </a>
                        <a class="text-dark d-flex {{ request()->is('student') ? 'active' : '' }}" href="/student">
                            <div class="sb-text-dark-icon"><i class="fa-solid fa-user-graduate"></i></div>
                            គ្រប់គ្រងសិស្ស
                        </a>
                        <a class="text-dark d-flex {{ request()->is('book') ? 'active' : '' }}" href="/book">
                            <div class="sb-text-dark-icon"><i class="fa-solid fa-book"></i></div>
                            គ្រប់គ្រងសៀវភៅ
                        </a>
                        <a class="text-dark d-flex {{ request()->is('borrow') ? 'active' : '' }}" href="/borrow">
                            <div class="sb-text-dark-icon"><i class="fa-solid fa-right-left"></i></div>
                            គ្រប់គ្រងការខ្ចីសៀវភៅ
                        </a>
                        <a class="text-dark d-flex {{ request()->is('reports') ? 'active' : '' }}" href="/reports">
                            <div class="sb-text-dark-icon"><i class="fa-solid fa-file-lines"></i></div>
                            របាយការណ៍
                        </a>                        
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const darkModeIcon = document.getElementById('darkModeIcon');
            const darkModeContainer = document.getElementById('darkModeContainer');
            const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;

            // Apply the current theme on load
            if (currentTheme) {
                document.body.classList.add(currentTheme);
                if (currentTheme === 'dark-mode') {
                    darkModeIcon.classList.remove('fa-moon');
                    darkModeIcon.classList.add('fa-sun');
                }
            }

            // Toggle dark mode on icon click with animation
            darkModeContainer.addEventListener('click', function () {
                if (document.body.classList.contains('dark-mode')) {
                    document.body.classList.remove('dark-mode');
                    localStorage.setItem('theme', 'light-mode');
                    darkModeIcon.classList.remove('fa-sun');
                    darkModeIcon.classList.add('fa-moon');
                } else {
                    document.body.classList.add('dark-mode');
                    localStorage.setItem('theme', 'dark-mode');
                    darkModeIcon.classList.remove('fa-moon');
                    darkModeIcon.classList.add('fa-sun');
                }

            });

           
        });
    </script>
</body>
</html>
