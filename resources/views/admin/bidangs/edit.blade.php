@extends('adminlte::page')

@section('title', 'Edit Seksi - SIMARU KEMENAG')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-edit text-warning mr-2"></i>
                Edit Seksi
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.bidangs.index') }}">Manajemen Seksi</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-2"></i>
                        Form Edit Seksi: {{ $bidang->nama }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.bidangs.index') }}" class="btn btn-tool">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.bidangs.update', $bidang) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle"></i> Terjadi kesalahan:</h6>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode">Kode Seksi <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('kode') is-invalid @enderror"
                                           id="kode"
                                           name="kode"
                                           value="{{ old('kode', $bidang->kode) }}"
                                           placeholder="Contoh: SIKAD"
                                           required>
                                    @error('kode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Kode unik untuk identifikasi seksi (maksimal 10 karakter).
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                                                            <label for="name" class="form-label">Nama Seksi</label>
                                    <input type="text"
                                           class="form-control @error('nama') is-invalid @enderror"
                                           id="nama"
                                           name="nama"
                                           value="{{ old('nama', $bidang->nama) }}"
                                                                                   placeholder="Masukkan nama seksi"
                                           required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Seksi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                      id="deskripsi"
                                      name="deskripsi"
                                      rows="4"
                                      placeholder="Deskripsi tugas dan fungsi seksi...">{{ old('deskripsi', $bidang->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Opsional. Deskripsi singkat tentang tugas dan fungsi seksi ini.
                            </small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Informasi:</strong>
                            Perubahan data seksi akan mempengaruhi semua user dan booking yang terkait dengan seksi ini.
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-1"></i>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.bidangs.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .form-group label {
            font-weight: 600;
        }
        .card-warning .card-header {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            color: #212529;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Auto-focus pada field pertama
            $('#kode').focus();

            // Konfirmasi sebelum submit
            $('form').on('submit', function(e) {
                if (!confirm('Yakin ingin menyimpan perubahan data seksi ini?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@stop
