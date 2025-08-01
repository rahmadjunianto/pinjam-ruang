<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Sistem Peminjaman Ruang Kemenag</title>

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
            padding: 20px 0;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            margin: 20px;
            backdrop-filter: blur(10px);
        }

        .register-header {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .register-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="mosque" patternUnits="userSpaceOnUse" width="20" height="20"><path d="M10,2 L18,10 L18,18 L2,18 L2,10 Z" fill="none" stroke="rgba(255,215,0,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23mosque)"/></svg>') repeat;
            opacity: 0.3;
        }

        .register-header h1 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .register-header .subtitle {
            margin: 0.5rem 0 0;
            font-size: 0.9rem;
            opacity: 0.9;
            color: #ffd700;
            position: relative;
            z-index: 1;
        }

        .mosque-icon {
            font-size: 2.5rem;
            color: #ffd700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .register-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-label {
            color: #2e7d32;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
        }

        .form-control {
            border: 2px solid #e8f5e8;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.9rem;
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
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #4caf50;
            z-index: 2;
        }

        .input-icon .form-control {
            padding-left: 40px;
        }

        .btn-register {
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

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 125, 50, 0.4);
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background: rgba(244, 67, 54, 0.1);
            color: #c62828;
            border-left: 4px solid #f44336;
        }

        .invalid-feedback {
            color: #c62828;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .form-control.is-invalid {
            border-color: #f44336;
        }

        .back-login {
            color: #4caf50;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            text-align: center;
            display: block;
            margin-top: 1rem;
        }

        .back-login:hover {
            color: #2e7d32;
            text-decoration: underline;
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

        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 4px;
            border-radius: 2px;
            background: #e0e0e0;
            overflow: hidden;
        }

        .strength-bar-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-text {
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            .register-container {
                margin: 10px;
                border-radius: 15px;
            }

            .register-form {
                padding: 1.5rem;
            }

            .register-header h1 {
                font-size: 1.4rem;
            }

            .mosque-icon {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <a href="{{ url('/') }}" class="back-home">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
    </a>

    <div class="register-container">
        <div class="register-header">
            <div class="mosque-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1>Daftar Akun Baru</h1>
            <p class="subtitle">Sistem Peminjaman Ruang Kemenag RI</p>
        </div>

        <div class="register-form">
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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-2"></i>Nama Lengkap
                    </label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input id="name"
                               type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               autocomplete="name"
                               placeholder="Masukkan nama lengkap Anda">
                    </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- NIP -->
                <div class="form-group">
                    <label for="nip" class="form-label">
                        <i class="fas fa-id-card me-2"></i>NIP (Nomor Induk Pegawai)
                    </label>
                    <div class="input-icon">
                        <i class="fas fa-id-card"></i>
                        <input id="nip"
                               type="text"
                               name="nip"
                               class="form-control @error('nip') is-invalid @enderror"
                               value="{{ old('nip') }}"
                               required
                               autocomplete="username"
                               pattern="[0-9]{18}"
                               maxlength="18"
                               placeholder="Masukkan NIP 18 digit Anda">
                    </div>
                    <small class="text-muted">NIP harus 18 digit angka</small>
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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
                               autocomplete="new-password"
                               placeholder="Buat kata sandi yang kuat">
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-bar-fill" id="strengthBar"></div>
                        </div>
                        <div class="strength-text" id="strengthText"></div>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock me-2"></i>Konfirmasi Kata Sandi
                    </label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input id="password_confirmation"
                               type="password"
                               name="password_confirmation"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               required
                               autocomplete="new-password"
                               placeholder="Ulangi kata sandi Anda">
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn btn-register">
                    <i class="fas fa-user-plus me-2"></i>
                    Daftar Sekarang
                </button>

                <!-- Login Link -->
                <a href="{{ route('login') }}" class="back-login">
                    <i class="fas fa-sign-in-alt me-1"></i>
                    Sudah punya akun? Masuk di sini
                </a>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = [];

            if (password.length >= 8) strength += 1;
            else feedback.push('minimal 8 karakter');

            if (/[a-z]/.test(password)) strength += 1;
            else feedback.push('huruf kecil');

            if (/[A-Z]/.test(password)) strength += 1;
            else feedback.push('huruf besar');

            if (/[0-9]/.test(password)) strength += 1;
            else feedback.push('angka');

            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            else feedback.push('karakter khusus');

            return { strength, feedback };
        }

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const { strength, feedback } = checkPasswordStrength(password);

            const percentage = (strength / 5) * 100;
            strengthBar.style.width = percentage + '%';

            if (strength <= 2) {
                strengthBar.style.backgroundColor = '#f44336';
                strengthText.innerHTML = '<span style="color: #f44336;">Lemah</span>';
                if (feedback.length > 0) {
                    strengthText.innerHTML += ' - Perlu: ' + feedback.join(', ');
                }
            } else if (strength <= 3) {
                strengthBar.style.backgroundColor = '#ff9800';
                strengthText.innerHTML = '<span style="color: #ff9800;">Sedang</span>';
                if (feedback.length > 0) {
                    strengthText.innerHTML += ' - Perlu: ' + feedback.join(', ');
                }
            } else if (strength <= 4) {
                strengthBar.style.backgroundColor = '#4caf50';
                strengthText.innerHTML = '<span style="color: #4caf50;">Kuat</span>';
            } else {
                strengthBar.style.backgroundColor = '#2e7d32';
                strengthText.innerHTML = '<span style="color: #2e7d32;">Sangat Kuat</span>';
            }
        });

        // Password confirmation validation
        const confirmPasswordInput = document.getElementById('password_confirmation');

        confirmPasswordInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.setCustomValidity('Kata sandi tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });

        // Add loading state to register button
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('.btn-register');
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sedang mendaftar...';
            button.disabled = true;
        });

        // Add smooth focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // NIP formatting and validation
        const nipInput = document.getElementById('nip');
        nipInput.addEventListener('input', function() {
            // Remove non-numeric characters
            this.value = this.value.replace(/\D/g, '');
            
            // Limit to 18 digits
            if (this.value.length > 18) {
                this.value = this.value.substr(0, 18);
            }
            
            // Visual feedback for valid NIP length
            if (this.value.length === 18) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                if (this.value.length > 0) {
                    this.classList.add('is-invalid');
                }
            }
        });
    </script>
</body>
</html>
