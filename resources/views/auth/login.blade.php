<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>E-Library | Login</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('mega/assets/images/logo-uhs.jpeg') }}" type="image/x-icon">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('mega/assets/css/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('mega/assets/icon/font-awesome/css/font-awesome.min.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('mega/assets/css/style.css') }}">

    <style>
        /* Custom Style untuk Login Simple */
        body {
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 40px 30px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo img {
            max-height: 70px;
        }

        .login-title {
            text-align: center;
            font-size: 22px;
            font-weight: 500;
            color: #1a3c6e;
            margin-bottom: 25px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            display: block;
        }

        .form-group .form-control {
            height: 46px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 0 15px;
            font-size: 14px;
            transition: all 0.3s;
            width: 100%;
        }

        .form-group .form-control:focus {
            border-color: #1a3c6e;
            box-shadow: 0 0 0 3px rgba(26, 60, 110, 0.1);
            outline: none;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #888;
            font-size: 18px;
            padding: 0;
        }

        .password-toggle:hover {
            color: #1a3c6e;
        }

        .btn-login {
            width: 100%;
            height: 46px;
            background: #1a3c6e;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #0f2a4a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 60, 110, 0.3);
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .register-link a {
            color: #1a3c6e;
            font-weight: 500;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .alert-custom {
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success-custom {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-error-custom {
            background: #fbe9e7;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #1a3c6e;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-card">

            {{-- Logo --}}
            <div class="login-logo">
                <img src="{{ asset('mega/assets/images/logo-bg-uhs.png') }}" alt="Logo">
            </div>

            {{-- Title --}}
            <div class="login-title">Selamat Datang</div>

            {{-- Alert Success --}}
            @session('success')
                <div class="alert-custom alert-success-custom">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endsession

            {{-- Alert Error --}}
            @session('error')
                <div class="alert-custom alert-error-custom">
                    <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endsession

            {{-- Form Login --}}
            <form action="{{ route('loginProses') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="Masukkan email" required autofocus>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" class="form-control"
                               placeholder="Masukkan password" required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fa fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" style="margin:0; cursor:pointer;">Ingat saya</label>
                </div>

                {{-- Button Login --}}
                <button type="submit" class="btn-login">
                    <i class="fa fa-sign-in"></i> Login
                </button>

            </form>

            {{-- Link Register --}}
            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>

        </div>
    </div>

    {{-- ===== JAVASCRIPT ===== --}}
    <script>
        // Toggle Password dengan Icon Eye
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Ganti icon
            if (type === 'text') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>

    {{-- Optional: SweetAlert jika masih pakai (bisa dihapus) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @session('success')
        <script>
            Swal.fire({
                title: "Berhasil",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endsession

    @session('error')
        <script>
            Swal.fire({
                title: "Gagal",
                text: "{{ session('error') }}",
                icon: "error",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endsession

</body>

</html>