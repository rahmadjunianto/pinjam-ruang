@extends('adminlte::page')

@section('title', 'Manajemen User')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-users mr-2"></i>Manajemen User</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i>Tambah User
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

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-2"></i>Daftar User
            </h3>
        </div>

        <!-- Filter and Search -->
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">Pencarian</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Nama, NIP, atau Email...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="bidang_id">Bidang</label>
                            <select class="form-control" id="bidang_id" name="bidang_id">
                                <option value="">Semua Bidang</option>
                                @foreach($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" 
                                            {{ request('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-search mr-1"></i>Cari
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo mr-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Bidang</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                <td>
                                    <code>{{ $user->nip }}</code>
                                </td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>
                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                </td>
                                <td>
                                    @if($user->bidang)
                                        <span class="badge badge-info">{{ $user->bidang->nama }}</span>
                                    @else
                                        <span class="badge badge-secondary">Belum Ditentukan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle mr-1"></i>Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="btn btn-info btn-sm" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="btn btn-primary btn-sm"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-warning btn-sm"
                                                title="Reset Password"
                                                onclick="resetPassword({{ $user->id }})">
                                            <i class="fas fa-key"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn {{ $user->is_active ? 'btn-secondary' : 'btn-success' }} btn-sm"
                                                title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                onclick="toggleStatus({{ $user->id }})">
                                            <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-danger btn-sm"
                                                title="Hapus"
                                                onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <em>Tidak ada data user</em>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $users->appends(request()->query())->links() }}
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
        if (confirm(`Apakah Anda yakin ingin menghapus user "${userName}"?\n\nPerhatian: User yang memiliki riwayat peminjaman tidak dapat dihapus.`)) {
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
    .btn-group .btn {
        margin-right: 2px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    code {
        color: #e83e8c;
        background-color: #f8f9fa;
        padding: 2px 4px;
        border-radius: 3px;
    }
</style>
@endsection
