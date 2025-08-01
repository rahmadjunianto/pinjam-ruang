@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user-edit mr-2"></i>Edit User: {{ $user->name }}</h1>
        <div>
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info mr-2">
                <i class="fas fa-eye mr-1"></i>Lihat Detail
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
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

                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    
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
                                   value="{{ old('nip', $user->nip) }}"
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
                                   value="{{ old('name', $user->name) }}"
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
                                   value="{{ old('email', $user->email) }}"
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
                                            {{ old('bidang_id', $user->bidang_id) == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr>

                        <!-- Password Section -->
                        <h5><i class="fas fa-lock mr-2"></i>Ubah Password</h5>
                        <p class="text-muted">Kosongkan jika tidak ingin mengubah password</p>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock mr-2"></i>Password Baru
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password"
                                   placeholder="Masukkan password baru (minimal 8 karakter)">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">
                                <i class="fas fa-lock mr-2"></i>Konfirmasi Password Baru
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- User Info Panel -->
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>Informasi User
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>NIP Saat Ini:</strong></td>
                            <td><code>{{ $user->nip }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Bergabung:</strong></td>
                            <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Update:</strong></td>
                            <td>{{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Peminjaman:</strong></td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $user->bookings()->count() }} peminjaman
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tools mr-2"></i>Aksi Cepat
                    </h3>
                </div>
                <div class="card-body">
                    <button type="button" 
                            class="btn btn-warning btn-block mb-2"
                            onclick="resetPassword({{ $user->id }})">
                        <i class="fas fa-key mr-1"></i>Reset Password ke NIP
                    </button>
                    
                    <button type="button" 
                            class="btn {{ $user->is_active ? 'btn-secondary' : 'btn-success' }} btn-block mb-2"
                            onclick="toggleStatus({{ $user->id }})">
                        <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }} mr-1"></i>
                        {{ $user->is_active ? 'Nonaktifkan User' : 'Aktifkan User' }}
                    </button>

                    @if($user->bookings()->count() == 0)
                        <button type="button" 
                                class="btn btn-danger btn-block"
                                onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')">
                            <i class="fas fa-trash mr-1"></i>Hapus User
                        </button>
                    @else
                        <button type="button" class="btn btn-danger btn-block" disabled>
                            <i class="fas fa-ban mr-1"></i>Tidak Dapat Dihapus
                        </button>
                        <small class="text-muted">User memiliki riwayat peminjaman</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Forms for Actions -->
    <form id="reset-password-form" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <form id="toggle-status-form" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
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

    function resetPassword(userId) {
        if (confirm('Apakah Anda yakin ingin mereset password user ini ke NIP?')) {
            const form = document.getElementById('reset-password-form');
            form.action = `/admin/users/${userId}/reset-password`;
            form.submit();
        }
    }

    function toggleStatus(userId) {
        if (confirm('Apakah Anda yakin ingin mengubah status user ini?')) {
            const form = document.getElementById('toggle-status-form');
            form.action = `/admin/users/${userId}/toggle-status`;
            form.submit();
        }
    }

    function deleteUser(userId, userName) {
        if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?`)) {
            const form = document.getElementById('delete-form');
            form.action = `/admin/users/${userId}`;
            form.submit();
        }
    }
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

    code {
        color: #e83e8c;
        background-color: #f8f9fa;
        padding: 2px 4px;
        border-radius: 3px;
    }
</style>
@endsection
