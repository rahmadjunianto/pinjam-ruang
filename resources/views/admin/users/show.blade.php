@extends('adminlte::page')

@section('title', 'Detail User')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user mr-2"></i>Detail User: {{ $user->name }}</h1>
        <div>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary mr-2">
                <i class="fas fa-edit mr-1"></i>Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fas fa-check mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ asset('images/default-avatar.svg') }}"
                             alt="User profile picture"
                             style="width: 100px; height: 100px;">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">
                        @if($user->bidang)
                            {{ $user->bidang->nama }}
                        @else
                            Bidang belum ditentukan
                        @endif
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b><i class="fas fa-id-card mr-2"></i>NIP</b>
                            <span class="float-right"><code>{{ $user->nip }}</code></span>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-envelope mr-2"></i>Email</b>
                            <span class="float-right">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-calendar mr-2"></i>Bergabung</b>
                            <span class="float-right">{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fas fa-check-circle mr-2"></i>Status</b>
                            <span class="float-right">
                                @if($user->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </span>
                        </li>
                    </ul>

                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                        </div>
                        <div class="col-6">
                            <button type="button" 
                                    class="btn btn-warning btn-block"
                                    onclick="resetPassword({{ $user->id }})">
                                <i class="fas fa-key mr-1"></i>Reset Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cog mr-2"></i>Aksi Admin
                    </h3>
                </div>
                <div class="card-body">
                    <button type="button" 
                            class="btn {{ $user->is_active ? 'btn-secondary' : 'btn-success' }} btn-block mb-2"
                            onclick="toggleStatus({{ $user->id }})">
                        <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }} mr-1"></i>
                        {{ $user->is_active ? 'Nonaktifkan User' : 'Aktifkan User' }}
                    </button>

                    @if($totalBookings == 0)
                        <button type="button" 
                                class="btn btn-danger btn-block"
                                onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')">
                            <i class="fas fa-trash mr-1"></i>Hapus User
                        </button>
                    @else
                        <button type="button" class="btn btn-danger btn-block" disabled>
                            <i class="fas fa-ban mr-1"></i>Tidak Dapat Dihapus
                        </button>
                        <small class="text-muted">User memiliki {{ $totalBookings }} peminjaman</small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics and Activity -->
        <div class="col-md-8">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-calendar-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Peminjaman</span>
                            <span class="info-box-number">{{ $totalBookings }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Disetujui</span>
                            <span class="info-box-number">{{ $approvedBookings }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending</span>
                            <span class="info-box-number">{{ $pendingBookings }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ditolak</span>
                            <span class="info-box-number">{{ $rejectedBookings }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>Riwayat Peminjaman Terbaru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.bookings.index', ['user_id' => $user->id]) }}" class="btn btn-tool">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Ruangan</th>
                                        <th>Acara</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                    <tr>
                                        <td>{{ $booking->booking_date ? $booking->booking_date->format('d/m/Y') : 'N/A' }}</td>
                                        <td>{{ $booking->room->name ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($booking->title, 30) }}</td>
                                        <td>
                                            @switch($booking->status)
                                                @case('approved')
                                                    <span class="badge badge-success">Disetujui</span>
                                                    @break
                                                @case('pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                    @break
                                                @case('rejected')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge badge-secondary">Dibatalkan</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-light">{{ ucfirst($booking->status) }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $booking) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada riwayat peminjaman</p>
                        </div>
                    @endif
                </div>
                @if($totalBookings > 10)
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.bookings.index', ['user_id' => $user->id]) }}" class="btn btn-primary">
                            <i class="fas fa-list mr-1"></i>Lihat Semua Peminjaman ({{ $totalBookings }})
                        </a>
                    </div>
                @endif
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

    // Auto-hide alerts
    setTimeout(function() {
        $('.alert-dismissible').fadeOut('slow');
    }, 5000);
</script>
@endsection

@section('css')
<style>
    .profile-user-img {
        border: 3px solid #adc5e4;
        margin: 0 auto;
        padding: 3px;
        width: 100px;
        height: 100px;
    }
    
    code {
        color: #e83e8c;
        background-color: #f8f9fa;
        padding: 2px 4px;
        border-radius: 3px;
    }

    .info-box {
        margin-bottom: 15px;
    }
</style>
@endsection
