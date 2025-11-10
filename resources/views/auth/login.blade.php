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
        <div class="card w-100" style="max-width: 1200px; height: 80vh; backdrop-filter: blur(10px); border-radius: 20px;">
            <div class="row no-gutters h-100">
                <!-- Image Section -->
                <div class="col-lg-6 d-none d-lg-block h-100" style="background: url('img-leftLogin.jpg') no-repeat center center; background-size: cover;">
                </div>

                <!-- Login Form Section -->
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center" style="height: 100%; overflow-y: auto;">
                    <div class="card-body p-4" style="width: 100%; max-width: 500px; height: 100%; overflow-y: auto;">
                        <div class="text-center mb-4">
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="mb-3" style="width: 120px;">
                            <h4 class="font-weight-bold">WELCOME</h4>
                            <p class="text-muted">Fill your data to enter. Thank you!!!</p>
                        </div>
                
                        <!-- Success Message -->
                        @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <em>{!! session('success') !!}</em>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                
                        <!-- Error Message -->
                        @if(Session::has('errors'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <em>{!! $errors->first() !!}</em>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                
                        <!-- Login Form -->
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email_address">Email</label>
                                <input type="email" id="email_address" class="form-control @error('email') is-invalid @enderror" name="email" required autofocus>
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
                
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                                <label class="form-check-label" for="remember">Remember login</label>
                                {{-- <a href="#" class="float-right">Recover password</a> --}}
                            </div>
                
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" style="background-color: #A76D60; border-color: #A76D60;">Login</button>
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

    /* Allow content to scroll but hide the scrollbar */
    .card-body {
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>
@endsection
