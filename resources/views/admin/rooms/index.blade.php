@extends('adminlte::page')

@section('title', 'Daftar Ruangan - SIAKAD KEMENAG')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-door-open text-success mr-2"></i>
                Daftar Ruangan
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Daftar Ruangan</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $rooms->count() }}</h3>
                    <p>Total Ruangan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $rooms->sum('capacity') }}</h3>
                    <p>Total Kapasitas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $rooms->where('is_active', true)->count() }}</h3>
                    <p>Ruangan Aktif</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-home mr-2"></i>
                Manajemen Ruangan
            </h3>
            <div class="card-tools">
                <a href="{{ route('admin.rooms.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus mr-1"></i>
                    Tambah Ruangan
                </a>
            </div>
        </div>

        <div class="card-body">
            {{-- Filter Form --}}
            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('admin.rooms.index') }}" class="form-inline">
                        <div class="form-group mr-3">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Cari ruangan..."
                                   value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search"></i>
                            Cari
                        </button>
                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh"></i>
                            Reset
                        </a>
                    </form>
                </div>
            </div>

            {{-- Rooms Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Kode</th>
                            <th width="25%">Nama Ruangan</th>
                            <th width="15%">Kapasitas</th>
                            <th width="25%">Lokasi</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $room)
                            <tr>
                                <td>{{ $loop->iteration + ($rooms->currentPage() - 1) * $rooms->perPage() }}</td>
                                <td>
                                    <strong>{{ $room->code }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $room->name }}</strong>
                                        @if($room->floor)
                                            <br><small class="text-muted">{{ $room->floor }}</small>
                                        @endif
                                        @if($room->description)
                                            <br><small class="text-info">{{ Str::limit($room->description, 50) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $room->capacity }} orang
                                    </span>
                                </td>
                                <td>
                                    {{ $room->location }}
                                    @php
                                        $facilities = $room->facilities;
                                        if (is_string($facilities)) {
                                            $facilities = json_decode($facilities, true) ?: [];
                                        }
                                        $facilities = $facilities ?: [];
                                    @endphp
                                    @if(!empty($facilities))
                                        <br><small class="text-muted">
                                            <i class="fas fa-tools mr-1"></i>
                                            {{ implode(', ', array_slice($facilities, 0, 3)) }}
                                            @if(count($facilities) > 3)
                                                <span class="text-info">+{{ count($facilities) - 3 }} lainnya</span>
                                            @endif
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.rooms.show', $room) }}"
                                           class="btn btn-info btn-sm"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.rooms.edit', $room) }}"
                                           class="btn btn-warning btn-sm"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-danger btn-sm"
                                                title="Hapus"
                                                onclick="confirmDelete({{ $room->id }}, '{{ $room->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Delete Form --}}
                                    <form id="delete-form-{{ $room->id }}"
                                          action="{{ route('admin.rooms.destroy', $room) }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="py-4">
                                        <i class="fas fa-home fa-3x text-muted"></i>
                                        <h5 class="mt-3 text-muted">Tidak ada data ruangan</h5>
                                        <p class="text-muted">Mulai dengan menambahkan ruangan pertama</p>
                                        <a href="{{ route('admin.rooms.create') }}" class="btn btn-success">
                                            <i class="fas fa-plus mr-1"></i>
                                            Tambah Ruangan
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($rooms->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $rooms->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@stop

@section('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus ruangan "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    $('.alert').fadeOut('slow');
}, 5000);
</script>
@stop

@section('plugins.Sweetalert2', true)
