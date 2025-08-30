@extends('adminlte::page')

@section('title', 'Manajemen Bidang')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-building text-success mr-2"></i>
                Manajemen Bidang
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Master Bidang</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Bidang</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <form method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control float-right" placeholder="Cari bidang..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-tools" style="margin-right: 260px;">
                        <a href="{{ route('admin.bidangs.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Bidang
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($bidangs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nama Bidang</th>
                                        <th>Deskripsi</th>
                                        <th style="width: 120px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bidangs as $index => $bidang)
                                        <tr>
                                            <td>{{ $bidangs->firstItem() + $index }}</td>
                                            <td><strong>{{ $bidang->nama }}</strong></td>
                                            <td>{{ $bidang->deskripsi ? Str::limit($bidang->deskripsi, 50) : '-' }}</td>

                                            <td>
                                                <a href="{{ route('admin.bidangs.edit', $bidang) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.bidangs.destroy', $bidang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus bidang ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($bidangs->hasPages())
                            <div class="mt-3">
                                {{ $bidangs->appends(request()->query())->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-building fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada bidang</h5>
                            <p class="text-muted">Silakan tambah bidang baru untuk mulai mengelola data bidang.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
