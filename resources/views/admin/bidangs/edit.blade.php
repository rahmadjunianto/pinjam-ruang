@extends('adminlte::page')

@section('title', 'Edit Bidang')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-edit text-warning mr-2"></i>
                Edit Bidang
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.bidangs.index') }}">Master Bidang</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Bidang: {{ $bidang->nama }}</h3>
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kode">Kode Bidang <span class="text-danger">*</span></label>
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
                            <small class="form-text text-muted">Kode unik untuk bidang (2-10 karakter)</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Bidang <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   id="nama"
                                   name="nama"
                                   value="{{ old('nama', $bidang->nama) }}"
                                   placeholder="Nama lengkap bidang"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                              id="deskripsi"
                              name="deskripsi"
                              rows="3"
                              placeholder="Deskripsi bidang...">{{ old('deskripsi', $bidang->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kepala_bidang">Kepala Bidang</label>
                            <input type="text"
                                   class="form-control @error('kepala_bidang') is-invalid @enderror"
                                   id="kepala_bidang"
                                   name="kepala_bidang"
                                   value="{{ old('kepala_bidang', $bidang->kepala_bidang) }}"
                                   placeholder="Nama kepala bidang">
                            @error('kepala_bidang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text"
                                   class="form-control @error('telepon') is-invalid @enderror"
                                   id="telepon"
                                   name="telepon"
                                   value="{{ old('telepon', $bidang->telepon) }}"
                                   placeholder="Nomor telepon">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $bidang->email) }}"
                                   placeholder="email@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="is_active">Status</label>
                            <select class="form-control @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', $bidang->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $bidang->is_active) == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if($bidang->bookings_count > 0)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Bidang ini memiliki {{ $bidang->bookings_count }} booking. Pastikan untuk mempertimbangkan dampak perubahan status.
                    </div>
                @endif
            </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.bidangs.index') }}" class="btn btn-default">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
