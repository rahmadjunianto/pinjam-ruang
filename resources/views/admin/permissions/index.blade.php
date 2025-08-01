@extends('adminlte::page')

@section('title', 'Manajemen Hak Akses')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-key mr-2"></i>Manajemen Hak Akses</h1>
        <a href="{{ route('admin.permissions.roles') }}" class="btn btn-info">
            <i class="fas fa-users-cog mr-1"></i>Kelola Role
        </a>
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
        <!-- Role Overview Cards -->
        <div class="col-md-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $users->where('role', 'admin')->count() }}</h3>
                    <p>Administrator</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $users->where('role', 'user')->count() }}</h3>
                    <p>User Biasa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $users->where('role', 'viewer')->count() }}</h3>
                    <p>Viewer</p>
                </div>
                <div class="icon">
                    <i class="fas fa-eye"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- User Permissions Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-2"></i>Daftar User dan Hak Akses
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Bidang</th>
                            <th>Role Saat Ini</th>
                            <th>Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </td>
                                <td><code>{{ $user->nip }}</code></td>
                                <td>
                                    @if($user->bidang)
                                        <span class="badge badge-info">{{ $user->bidang->nama }}</span>
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($user->role)
                                        @case('admin')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-user-shield mr-1"></i>Administrator
                                            </span>
                                            @break
                                        @case('user')
                                            <span class="badge badge-success">
                                                <i class="fas fa-user mr-1"></i>User Biasa
                                            </span>
                                            @break
                                        @case('viewer')
                                            <span class="badge badge-info">
                                                <i class="fas fa-eye mr-1"></i>Viewer
                                            </span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">Unknown</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button"
                                                class="btn btn-primary btn-sm dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fas fa-cog mr-1"></i>Ubah Role
                                        </button>
                                        <div class="dropdown-menu">
                                            <form method="POST" action="{{ route('admin.permissions.update-role', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="role" value="admin">
                                                <button type="submit"
                                                        class="dropdown-item {{ $user->role === 'admin' ? 'active' : '' }}"
                                                        {{ $user->role === 'admin' ? 'disabled' : '' }}>
                                                    <i class="fas fa-user-shield mr-2"></i>Administrator
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.permissions.update-role', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="role" value="user">
                                                <button type="submit"
                                                        class="dropdown-item {{ $user->role === 'user' ? 'active' : '' }}"
                                                        {{ $user->role === 'user' ? 'disabled' : '' }}>
                                                    <i class="fas fa-user mr-2"></i>User Biasa
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.permissions.update-role', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="role" value="viewer">
                                                <button type="submit"
                                                        class="dropdown-item {{ $user->role === 'viewer' ? 'active' : '' }}"
                                                        {{ $user->role === 'viewer' ? 'disabled' : '' }}>
                                                    <i class="fas fa-eye mr-2"></i>Viewer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="btn btn-info btn-sm ml-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <em>Tidak ada data user</em>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Role Information -->
    <div class="row">
        <div class="col-md-4">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-shield mr-2"></i>Administrator
                    </h3>
                </div>
                <div class="card-body">
                    <p><strong>Hak Akses:</strong></p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success mr-2"></i>Semua fitur sistem</li>
                        <li><i class="fas fa-check text-success mr-2"></i>Manajemen user</li>
                        <li><i class="fas fa-check text-success mr-2"></i>Persetujuan booking</li>
                        <li><i class="fas fa-check text-success mr-2"></i>Backup & restore</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>User Biasa
                    </h3>
                </div>
                <div class="card-body">
                    <p><strong>Hak Akses:</strong></p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success mr-2"></i>Lihat dashboard</li>
                        <li><i class="fas fa-check text-success mr-2"></i>Buat peminjaman</li>
                        <li><i class="fas fa-check text-success mr-2"></i>Edit profil sendiri</li>
                        <li><i class="fas fa-times text-danger mr-2"></i>Manajemen user</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye mr-2"></i>Viewer
                    </h3>
                </div>
                <div class="card-body">
                    <p><strong>Hak Akses:</strong></p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success mr-2"></i>Lihat dashboard</li>
                        <li><i class="fas fa-check text-success mr-2"></i>Lihat kalender</li>
                        <li><i class="fas fa-times text-danger mr-2"></i>Buat peminjaman</li>
                        <li><i class="fas fa-times text-danger mr-2"></i>Edit data</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    // Auto-hide alerts
    setTimeout(function() {
        $('.alert-dismissible').fadeOut('slow');
    }, 5000);
</script>
@endsection
