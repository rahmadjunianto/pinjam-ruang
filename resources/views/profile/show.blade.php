@extends('adminlte::page')

@section('title', 'Profil Pengguna')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user mr-2"></i>Profil Pengguna</h1>
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <i class="fas fa-edit mr-1"></i>Edit Profil
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <div class="profile-user-img-container mb-3">
                            <i class="fas fa-user-circle profile-user-img" style="font-size: 6rem; color: #28a745;"></i>
                        </div>
                        <h3 class="profile-username text-center">{{ $user->name }}</h3>
                        <p class="text-muted text-center">{{ $user->nip }}</p>
                    </div>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b><i class="fas fa-id-card mr-2"></i>NIP</b>
                            <span class="float-right">{{ $user->nip }}</span>
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
                            <b><i class="fas fa-check-circle mr-2"></i>Status Email</b>
                            <span class="float-right">
                                @if($user->email_verified_at)
                                    <span class="badge badge-success">Terverifikasi</span>
                                @else
                                    <span class="badge badge-warning">Belum Terverifikasi</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Activity Stats -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-2"></i>Statistik Aktivitas
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-calendar-check"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Peminjaman</span>
                                    <span class="info-box-number">
                                        {{ $user->bookings()->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-check"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Peminjaman Disetujui</span>
                                    <span class="info-box-number">
                                        {{ $user->bookings()->where('status', 'approved')->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Menunggu Persetujuan</span>
                                    <span class="info-box-number">
                                        {{ $user->bookings()->where('status', 'pending')->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger">
                                    <i class="fas fa-times"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Peminjaman Ditolak</span>
                                    <span class="info-box-number">
                                        {{ $user->bookings()->where('status', 'rejected')->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>Peminjaman Terbaru
                    </h3>
                </div>
                <div class="card-body">
                    @if($user->bookings()->exists())
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Ruang</th>
                                        <th>Kegiatan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->bookings()->latest()->take(5)->get() as $booking)
                                    <tr>
                                        <td>{{ $booking->booking_date ? $booking->booking_date->format('d/m/Y') : 'N/A' }}</td>
                                        <td>{{ $booking->room->name ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($booking->event_name ?? $booking->title, 30) }}</td>
                                        <td>
                                            @if($booking->status === 'approved')
                                                <span class="badge badge-success">Disetujui</span>
                                            @elseif($booking->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($booking->status === 'rejected')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @else
                                                <span class="badge badge-secondary">{{ ucfirst($booking->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye mr-1"></i>Lihat Semua Peminjaman
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada peminjaman yang dibuat</p>
                            <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i>Buat Peminjaman Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .profile-user-img-container {
        position: relative;
        display: inline-block;
    }
    
    .profile-user-img {
        border: 3px solid #28a745;
        border-radius: 50%;
        padding: 20px;
        background: rgba(40, 167, 69, 0.1);
    }
    
    .info-box {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        border-radius: .25rem;
        background: #fff;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: .5rem;
        position: relative;
        width: 100%;
    }
    
    .info-box .info-box-icon {
        border-radius: .25rem;
        align-items: center;
        display: flex;
        font-size: 1.875rem;
        justify-content: center;
        text-align: center;
        width: 70px;
        color: #fff;
    }
    
    .info-box .info-box-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        line-height: 1.8;
        margin-left: .5rem;
        padding: 0 .5rem;
    }
    
    .info-box .info-box-number {
        display: block;
        font-weight: 700;
        font-size: 1.25rem;
    }
    
    .info-box .info-box-text {
        display: block;
        font-size: .875rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection
