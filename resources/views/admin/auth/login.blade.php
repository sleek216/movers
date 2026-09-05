<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Movers Freight & Logistics</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/vendors/font-awesome.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/vendors/feather-icon.css') }}">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/style.css') }}">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/responsive.css') }}">
    <style>
        body {
            background: #f5f7fb;
            font-family: 'Montserrat', sans-serif;
        }
        .login-card {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-main {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .btn-primary {
            background-color: #7366ff !important;
            border-color: #7366ff !important;
            padding: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-main">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary">MOVERS</h3>
                <p class="text-muted">Freight & Logistics Admin Control</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-circle me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form class="theme-form" method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <h5 class="mb-1">Sign In</h5>
                <p class="text-muted mb-4 f-12">Enter your admin credentials to access the panel.</p>

                <div class="form-group mb-3">
                    <label class="col-form-label fw-semibold">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input class="form-control" type="text" name="username" value="{{ old('username', 'admin') }}" required placeholder="Enter username">
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="col-form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input class="form-control" type="password" name="password" required placeholder="Enter password">
                    </div>
                </div>

                <div class="form-group mb-0">
                    <button class="btn btn-primary btn-block w-100" type="submit">Sign In to Dashboard</button>
                </div>

                <div class="mt-4 text-center">
                    <small class="text-muted">Default login: <strong>admin</strong> / <strong>admin@123</strong></small>
                </div>
            </form>
        </div>
    </div>

    <!-- latest jquery-->
    <script src="{{ asset('admin_assets/js/jquery-3.5.1.min.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('admin_assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
