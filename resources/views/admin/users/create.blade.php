@extends('adminlte::page')

@section('title', 'Tambah User')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user-plus mr-2"></i>Tambah User</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>Informasi User
                    </h3>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    
                    <div class="card-body">
                        <!-- NIP -->
                        <div class="form-group">
                            <label for="nip">
                                <i class="fas fa-id-card mr-2"></i>NIP (Nomor Induk Pegawai) <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nip') is-invalid @enderror" 
                                   id="nip" 
                                   name="nip" 
                                   value="{{ old('nip') }}"
                                   placeholder="Masukkan NIP 18 digit"
                                   pattern="[0-9]{18}"
                                   maxlength="18"
                                   required>
                            <small class="form-text text-muted">NIP harus 18 digit angka</small>
                            @error('nip')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user mr-2"></i>Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope mr-2"></i>Alamat Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="Masukkan alamat email"
                                   required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Bidang -->
                        <div class="form-group">
                            <label for="bidang_id">
                                <i class="fas fa-building mr-2"></i>Bidang
                            </label>
                            <select class="form-control @error('bidang_id') is-invalid @enderror" 
                                    id="bidang_id" 
                                    name="bidang_id">
                                <option value="">-- Pilih Bidang --</option>
                                @foreach($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" 
                                            {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Bidang dapat dikosongkan dan diatur kemudian</small>
                            @error('bidang_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock mr-2"></i>Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password"
                                   placeholder="Masukkan password (minimal 8 karakter)"
                                   required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">
                                <i class="fas fa-lock mr-2"></i>Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   placeholder="Ulangi password"
                                   required>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Simpan User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Panel -->
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>Panduan
                    </h3>
                </div>
                <div class="card-body">
                    <h6><i class="fas fa-id-card text-primary mr-2"></i>NIP (Nomor Induk Pegawai)</h6>
                    <p class="text-sm text-muted mb-3">
                        NIP harus berupa 18 digit angka. NIP akan digunakan sebagai username untuk login.
                    </p>

                    <h6><i class="fas fa-lock text-warning mr-2"></i>Password Default</h6>
                    <p class="text-sm text-muted mb-3">
                        Password dapat direset menjadi NIP kapan saja melalui tombol "Reset Password" di daftar user.
                    </p>

                    <h6><i class="fas fa-building text-success mr-2"></i>Bidang</h6>
                    <p class="text-sm text-muted mb-3">
                        Bidang digunakan untuk kategorisasi user dan pelaporan. Bidang dapat dikosongkan terlebih dahulu.
                    </p>

                    <h6><i class="fas fa-check-circle text-info mr-2"></i>Status User</h6>
                    <p class="text-sm text-muted">
                        User baru akan aktif secara otomatis. Status dapat diubah melalui tombol toggle di daftar user.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
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

    // Auto-generate email suggestion based on name
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    
    nameInput.addEventListener('blur', function() {
        if (this.value && !emailInput.value) {
            // Generate email suggestion
            const nameParts = this.value.toLowerCase().split(' ');
            const emailSuggestion = nameParts.join('.') + '@kemenag.go.id';
            emailInput.value = emailSuggestion;
        }
    });

    // Password confirmation validation
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    confirmPasswordInput.addEventListener('input', function() {
        if (this.value && passwordInput.value) {
            if (this.value === passwordInput.value) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        }
    });
</script>
@endsection

@section('css')
<style>
    .form-control.is-valid {
        border-color: #28a745;
        background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'><path fill='%2328a745' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26l2.974 2.99L8 2.193z'/></svg>");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px;
    }
    
    .text-danger {
        color: #dc3545 !important;
    }
</style>
@endsection
