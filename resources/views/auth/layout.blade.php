<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Npic Library</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Library Management System - Login and Register">
    <meta name="keywords" content="library, management, system, login, register, books, students, NPIC">
    <meta name="author" content="Your Name">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="NPIC Library - Login and Register">
    <meta property="og:description" content="Access the NPIC Library Management System. Login or Register to manage your library records.">
    <meta property="og:image" content="https://cdn.pixabay.com/photo/2024/08/08/16/24/16-24-13-872_960_720.png">
    <meta property="og:url" content="https://fbc5-175-100-11-120.ngrok-free.app/">
    <meta property="og:type" content="website">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="NPIC Library - Login and Register">
    <meta name="twitter:description" content="Access the NPIC Library Management System. Login or Register to manage your library records.">
    <meta name="twitter:image" content="https://cdn.pixabay.com/photo/2024/08/08/16/24/16-24-13-872_960_720.png">
    <meta name="twitter:site" content="@YourTwitterHandle">
    
    <!-- Favicon -->
    <link rel="icon" href="https://cdn.pixabay.com/photo/2024/08/08/15/58/hero-8954978_960_720.png" type="image/x-icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style type="text/css">
        body {
            margin: 0;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #f5f8fa;
            height: 100vh;
            overflow: hidden;
        }
        .navbar-laravel {
            box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
            background-color: #ffffff;
        }
        .navbar-brand,
        .nav-link {
            font-family: Raleway, sans-serif;
            font-size: 1rem;
            padding: 10px 15px;
            color: #5a5a5a;
        }
        .nav-link:hover {
            color: #000000;
        }
        .my-form,
        .login-form {
            font-family: Raleway, sans-serif;
        }
        .my-form {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .my-form .row {
            margin-left: 0;
            margin-right: 0;
        }
        .login-form {
            padding-top: 0;
            padding-bottom: 0;
            height: 100vh;
        }
        .login-form .row {
            margin-left: 0;
            margin-right: 0;
        }
        .card {
            width: 100%;
            max-width: 900px; /* Adjust max-width */
            height: auto;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
        }
        .card-body {
            padding: 2rem;
        }
    </style>
    
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="#">NPIC Library</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Dropdown link
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{!! url('/dashboard') !!}">Profile</a>
                            <a class="dropdown-item" href="{{--route('profile.edit',$user)--}}">Update profile</a>
                            <a class="dropdown-item" href="{{--route('form.password')--}}">Change password</a>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

</body>

</html>
