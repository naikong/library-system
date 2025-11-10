@extends('auth.layout')

@section('content')
<main class="login-form" style="position: relative; height: 100vh;">
    <!-- Background Image with Blur -->
    <div style="
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('bg-login.jpg') no-repeat center center fixed;
        background-size: cover;
        filter: blur(10px);
        z-index: -1;">
    </div>

    <div class="container d-flex align-items-center justify-content-center h-100">
        <div class="card w-100 " style="max-width: 1200px; height: 80vh; backdrop-filter: blur(10px); border-radius: 20px;">
            <div class="row no-gutters h-100">
                <!-- Image Section -->
                <div class="col-lg-6 d-none d-lg-block h-100" style="background: url('img-leftRegister.jpg') no-repeat center center; background-size: cover;">
                </div>

                <!-- Registration Form Section -->
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center" style="height: 100%; overflow-y: auto;">
                    <div class="card-body p-4" style="width: 100%; max-width: 500px; height: 100%; overflow-y: scroll;">
                        <div class="text-center mb-4">
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="mb-3" style="width: 120px;">
                            <h4 class="font-weight-bold">Register</h4>
                            <p class="text-muted">Create your account. It's free and only takes a minute.</p>
                        </div>
                
                        <!-- Registration Form -->
                        <form action="{{ route('register.post') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" required autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                
                            <div class="form-group">
                                <label for="email_address">E-Mail Address</label>
                                <input type="email" id="email_address" class="form-control @error('email') is-invalid @enderror" name="email" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-block" style="background-color: #A76D60; border-color: #A76D60;">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</main>

<!-- Custom Scrollbar CSS -->
<style>
    /* Hide scrollbar for Webkit browsers */
    .card-body::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .card-body {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
@endsection
