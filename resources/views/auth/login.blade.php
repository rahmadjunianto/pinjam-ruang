<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistem Peminjaman Ruang Kemenag</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #4caf50 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            margin: 20px;
            backdrop-filter: blur(10px);
        }

        .login-header {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="mosque" patternUnits="userSpaceOnUse" width="20" height="20"><path d="M10,2 L18,10 L18,18 L2,18 L2,10 Z" fill="none" stroke="rgba(255,215,0,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23mosque)"/></svg>') repeat;
            opacity: 0.3;
        }

        .login-header h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .login-header .subtitle {
            margin: 0.5rem 0 0;
            font-size: 1rem;
            opacity: 0.9;
            color: #ffd700;
            position: relative;
            z-index: 1;
        }

        .mosque-icon {
            font-size: 3rem;
            color: #ffd700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .login-form {
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #2e7d32;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 2px solid #e8f5e8;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
            background: white;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #4caf50;
            z-index: 2;
        }

        .input-icon .form-control {
            padding-left: 45px;
        }

        .btn-login {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
            width: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.4);
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 0.9rem;
        }

        .remember-me input[type="checkbox"] {
            accent-color: #4caf50;
            transform: scale(1.1);
        }

        .forgot-password {
            color: #4caf50;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #2e7d32;
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.1);
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }

        .alert-danger {
            background: rgba(244, 67, 54, 0.1);
            color: #c62828;
            border-left: 4px solid #f44336;
        }

        .invalid-feedback {
            color: #c62828;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-control.is-invalid {
            border-color: #f44336;
        }

        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-home:hover {
            color: #ffd700;
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            color: #666;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .login-container {
                margin: 10px;
                border-radius: 15px;
            }

            .login-form {
                padding: 1.5rem;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            .mosque-icon {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <a href="{{ url('/') }}" class="back-home">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
    </a>

    <div class="login-container">
        <div class="login-header">
            <div class="mosque-icon">
                <i class="fas fa-mosque"></i>
            </div>
            <h1>Sistem Peminjaman Ruang</h1>
            <p class="subtitle">Kementerian Agama Republik Indonesia</p>
        </div>

        <div class="login-form">
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i>Alamat Email
                    </label>
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                        <input id="email"
                               type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="Masukkan alamat email Anda">
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i>Kata Sandi
                    </label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input id="password"
                               type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required
                               autocomplete="current-password"
                               placeholder="Masukkan kata sandi Anda">
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="remember-me">
                        <input type="checkbox"
                               id="remember_me"
                               name="remember"
                               class="form-check-input">
                        <label for="remember_me">Ingat saya</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            <i class="fas fa-key me-1"></i>Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Masuk ke Sistem
                </button>

                <!-- Register Link -->
                @if (Route::has('register'))
                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <div class="text-center">
                        <p class="mb-2">Belum memiliki akun?</p>
                        <a href="{{ route('register') }}" class="btn btn-outline-success">
                            <i class="fas fa-user-plus me-2"></i>
                            Daftar Akun Baru
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Add smooth focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Show password toggle
        const passwordInput = document.getElementById('password');
        const togglePassword = document.createElement('button');
        togglePassword.type = 'button';
        togglePassword.className = 'btn btn-sm position-absolute';
        togglePassword.style.cssText = 'right: 10px; top: 50%; transform: translateY(-50%); z-index: 3; border: none; background: none; color: #4caf50;';
        togglePassword.innerHTML = '<i class="fas fa-eye"></i>';

        passwordInput.parentElement.appendChild(togglePassword);
        passwordInput.style.paddingRight = '45px';

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        // Add loading state to login button
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('.btn-login');
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sedang masuk...';
            button.disabled = true;
        });
    </script>
</body>
</html>
