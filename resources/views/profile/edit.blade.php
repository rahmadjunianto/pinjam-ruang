@extends('adminlte::page')

@section('title', 'Edit Profil')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-edit mr-2"></i>Edit Profil</h1>
        <a href="{{ route('profile.show') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Profil
        </a>
    </div>
@endsection

@section('content')
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fas fa-check mr-2"></i>Profil berhasil diperbarui!
        </div>
    @endif

    <div class="row">
        <!-- Profile Information Form -->
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>Informasi Profil
                    </h3>
                </div>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="card-body">
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user mr-2"></i>Nama Lengkap
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   placeholder="Masukkan nama lengkap Anda"
                                   required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- NIP -->
                        <div class="form-group">
                            <label for="nip">
                                <i class="fas fa-id-card mr-2"></i>NIP (Nomor Induk Pegawai)
                            </label>
                            <input type="text"
                                   class="form-control @error('nip') is-invalid @enderror"
                                   id="nip"
                                   name="nip"
                                   value="{{ old('nip', $user->nip) }}"
                                   placeholder="Masukkan NIP 18 digit Anda"
                                   pattern="[0-9]{18}"
                                   maxlength="18"
                                   required>
                            <small class="form-text text-muted">NIP harus 18 digit angka</small>
                            @error('nip')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope mr-2"></i>Alamat Email
                            </label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="Masukkan alamat email Anda"
                                   required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-sm text-warning">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Alamat email Anda belum terverifikasi.
                                        <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-sm text-primary">
                                            Klik di sini untuk mengirim ulang email verifikasi.
                                        </button>
                                    </p>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 text-sm text-success">
                                            Link verifikasi baru telah dikirim ke alamat email Anda.
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-4">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-lock mr-2"></i>Ubah Kata Sandi
                    </h3>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <!-- Current Password -->
                        <div class="form-group">
                            <label for="update_password_current_password">
                                <i class="fas fa-key mr-2"></i>Kata Sandi Saat Ini
                            </label>
                            <input type="password"
                                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                   id="update_password_current_password"
                                   name="current_password"
                                   placeholder="Masukkan kata sandi saat ini"
                                   autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="form-group">
                            <label for="update_password_password">
                                <i class="fas fa-lock mr-2"></i>Kata Sandi Baru
                            </label>
                            <input type="password"
                                   class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                   id="update_password_password"
                                   name="password"
                                   placeholder="Masukkan kata sandi baru"
                                   autocomplete="new-password">
                            @error('password', 'updatePassword')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="update_password_password_confirmation">
                                <i class="fas fa-lock mr-2"></i>Konfirmasi Kata Sandi
                            </label>
                            <input type="password"
                                   class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                   id="update_password_password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Konfirmasi kata sandi baru"
                                   autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key mr-1"></i>Ubah Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-trash mr-2"></i>Hapus Akun
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-sm text-muted">
                        Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.
                        Sebelum menghapus akun, silakan unduh data atau informasi yang ingin Anda simpan.
                    </p>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">
                        <i class="fas fa-trash mr-1"></i>Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Verification Form -->
    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
            @csrf
        </form>
    @endif

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Konfirmasi Hapus Akun
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <p><strong>Apakah Anda yakin ingin menghapus akun Anda?</strong></p>
                        <p class="text-muted">
                            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.
                            Masukkan kata sandi Anda untuk mengkonfirmasi bahwa Anda ingin menghapus akun secara permanen.
                        </p>
                        <div class="form-group">
                            <label for="delete_password">Kata Sandi</label>
                            <input type="password"
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                   id="delete_password"
                                   name="password"
                                   placeholder="Masukkan kata sandi Anda">
                            @error('password', 'userDeletion')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i>Hapus Akun
                        </button>
                    </div>
                </form>
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

    // Show success message for password update
    @if (session('status') === 'password-updated')
        toastr.success('Kata sandi berhasil diubah!');
    @endif

    // Auto-hide alerts
    setTimeout(function() {
        $('.alert-dismissible').fadeOut('slow');
    }, 5000);
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
</style>
@endsection
