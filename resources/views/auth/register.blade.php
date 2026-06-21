<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>E-Library | Register</title>

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
        /* Custom Style untuk Register Simple */
        body {
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .register-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 40px 30px;
        }

        .register-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-logo img {
            max-height: 70px;
        }

        .register-title {
            text-align: center;
            font-size: 22px;
            font-weight: 500;
            color: #1a3c6e;
            margin-bottom: 25px;
        }

        .form-group {
            position: relative;
            margin-bottom: 18px;
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

        .form-group .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-group .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .form-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .form-row .form-group {
            flex: 1;
            min-width: 200px;
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

        .btn-register {
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

        .btn-register:hover {
            background: #0f2a4a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 60, 110, 0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: #1a3c6e;
            font-weight: 500;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert-custom {
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error-custom {
            background: #fbe9e7;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        .alert-error-custom ul {
            margin: 0;
            padding-left: 20px;
        }

        .text-muted-custom {
            font-size: 12px;
            color: #888;
            display: block;
            margin-top: 4px;
        }

        .text-muted-custom i {
            margin-right: 4px;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <div class="register-card">

            {{-- Logo --}}
            <div class="register-logo">
                <img src="{{ asset('mega/assets/images/logo-bg-uhs.png') }}" alt="Logo">
            </div>

            {{-- Title --}}
            <div class="register-title">Buat Akun Baru</div>

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="alert-custom alert-error-custom">
                    <strong><i class="fa fa-exclamation-circle"></i> Perhatikan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Register --}}
            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                {{-- Nama Lengkap --}}
                <div class="form-group">
                    <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                           placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required autofocus>
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="Masukkan email" value="{{ old('email') }}" required>
                </div>

                {{-- Password & Konfirmasi --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 6 karakter" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fa fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control" placeholder="Ulangi password" required>
                            <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                <i class="fa fa-eye" id="eyeIconConfirm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Program Studi & Fakultas --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="prodi">Program Studi <span class="text-danger">*</span></label>
                        <input type="text" name="prodi" id="prodi" class="form-control @error('prodi') is-invalid @enderror"
                               placeholder="Contoh: Teknik Informatika" value="{{ old('prodi') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="fakultas">Fakultas <span class="text-danger">*</span></label>
                        <input type="text" name="fakultas" id="fakultas" class="form-control @error('fakultas') is-invalid @enderror"
                               placeholder="Contoh: Teknik" value="{{ old('fakultas') }}" required>
                    </div>
                </div>

                {{-- Kode Akses (Opsional) --}}
                <div class="form-group">
                    <label for="kode_akses">Kode Akses <span class="text-muted">(Opsional)</span></label>
                    <input type="password" name="kode_akses" id="kode_akses" class="form-control"
                           placeholder="Isi jika punya kode akses">
                    <small class="text-muted-custom">
                        <i class="fa fa-info-circle"></i> 
                        Kosongkan jika tidak punya
                    </small>
                </div>

                {{-- Button Register --}}
                <button type="submit" class="btn-register">
                    <i class="fa fa-user-plus"></i> Daftar
                </button>

            </form>

            {{-- Link Login --}}
            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
            </div>

        </div>
    </div>

    {{-- ===== JAVASCRIPT ===== --}}
    <script>
        // Toggle Password (Password)
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            if (type === 'text') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        // Toggle Password (Konfirmasi)
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('password_confirmation');
        const eyeIconConfirm = document.getElementById('eyeIconConfirm');

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);

            if (type === 'text') {
                eyeIconConfirm.classList.remove('fa-eye');
                eyeIconConfirm.classList.add('fa-eye-slash');
            } else {
                eyeIconConfirm.classList.remove('fa-eye-slash');
                eyeIconConfirm.classList.add('fa-eye');
            }
        });
    </script>

</body>

</html>