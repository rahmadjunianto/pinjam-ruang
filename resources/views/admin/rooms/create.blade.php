@extends('adminlte::page')

@section('title', 'Tambah Ruangan')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-door-open text-success mr-2"></i>
                Tambah Ruangan
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Ruangan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Formulir Tambah Ruangan
                    </h3>
                </div>
                <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Kode Ruangan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">
                                        <i class="fas fa-barcode mr-1"></i>
                                        Kode Ruangan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('code') is-invalid @enderror"
                                           id="code"
                                           name="code"
                                           value="{{ old('code') }}"
                                           placeholder="Contoh: RR-001"
                                           required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Kode unik untuk identifikasi ruangan</small>
                                </div>
                            </div>

                            <!-- Nama Ruangan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="fas fa-tag mr-1"></i>
                                        Nama Ruangan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Contoh: Ruang Rapat Utama"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Kapasitas -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="capacity">
                                        <i class="fas fa-users mr-1"></i>
                                        Kapasitas <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           class="form-control @error('capacity') is-invalid @enderror"
                                           id="capacity"
                                           name="capacity"
                                           value="{{ old('capacity') }}"
                                           min="1"
                                           max="1000"
                                           placeholder="50"
                                           required>
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Jumlah maksimal orang</small>
                                </div>
                            </div>

                            <!-- Lokasi -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="location">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        Lokasi <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('location') is-invalid @enderror"
                                           id="location"
                                           name="location"
                                           value="{{ old('location') }}"
                                           placeholder="Gedung A"
                                           required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Lantai -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="floor">
                                        <i class="fas fa-building mr-1"></i>
                                        Lantai
                                    </label>
                                    <input type="text"
                                           class="form-control @error('floor') is-invalid @enderror"
                                           id="floor"
                                           name="floor"
                                           value="{{ old('floor') }}"
                                           placeholder="Lantai 2">
                                    @error('floor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-group">
                            <label for="description">
                                <i class="fas fa-align-left mr-1"></i>
                                Deskripsi
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3"
                                      placeholder="Deskripsi ruangan, fitur khusus, atau catatan penting">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fasilitas -->
                        <div class="form-group">
                            <label>
                                <i class="fas fa-tools mr-1"></i>
                                Fasilitas yang Tersedia
                            </label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Proyektor" id="proyektor">
                                        <label class="form-check-label" for="proyektor">
                                            <i class="fas fa-video mr-1"></i> Proyektor
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="AC" id="ac">
                                        <label class="form-check-label" for="ac">
                                            <i class="fas fa-snowflake mr-1"></i> AC
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="WiFi" id="wifi">
                                        <label class="form-check-label" for="wifi">
                                            <i class="fas fa-wifi mr-1"></i> WiFi
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Sound System" id="sound">
                                        <label class="form-check-label" for="sound">
                                            <i class="fas fa-volume-up mr-1"></i> Sound System
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Microphone" id="mic">
                                        <label class="form-check-label" for="mic">
                                            <i class="fas fa-microphone mr-1"></i> Microphone
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Whiteboard" id="whiteboard">
                                        <label class="form-check-label" for="whiteboard">
                                            <i class="fas fa-chalkboard mr-1"></i> Whiteboard
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Meja & Kursi" id="furniture">
                                        <label class="form-check-label" for="furniture">
                                            <i class="fas fa-chair mr-1"></i> Meja & Kursi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Toilet" id="toilet">
                                        <label class="form-check-label" for="toilet">
                                            <i class="fas fa-restroom mr-1"></i> Toilet
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="Parkir" id="parking">
                                        <label class="form-check-label" for="parking">
                                            <i class="fas fa-parking mr-1"></i> Area Parkir
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">Pilih fasilitas yang tersedia di ruangan ini</small>
                        </div>

                        <!-- Upload Foto -->
                        <div class="form-group">
                            <label for="image">
                                <i class="fas fa-camera mr-1"></i>
                                Foto Ruangan
                            </label>
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       accept="image/jpeg,image/png,image/jpg">
                                <label class="custom-file-label" for="image">Pilih foto...</label>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                        </div>

                        <!-- Catatan -->
                        <div class="form-group">
                            <label for="notes">
                                <i class="fas fa-sticky-note mr-1"></i>
                                Catatan Tambahan
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes"
                                      name="notes"
                                      rows="2"
                                      placeholder="Catatan khusus, aturan penggunaan, atau informasi penting lainnya">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i>
                                    Simpan Ruangan
                                </button>
                                <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times mr-1"></i>
                                    Batal
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Field dengan tanda * wajib diisi
                                </small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Tips Card -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-lightbulb mr-1"></i>
                        Tips Mengisi Data
                    </h3>
                </div>
                <div class="card-body">
                    <div class="callout callout-info">
                        <h6><i class="fas fa-barcode mr-1"></i> Kode Ruangan</h6>
                        <p class="small mb-2">Gunakan format yang konsisten seperti:<br>
                        • RR-001 (Ruang Rapat)<br>
                        • AL-001 (Aula)<br>
                        • RK-001 (Ruang Kelas)</p>
                    </div>

                    <div class="callout callout-success">
                        <h6><i class="fas fa-users mr-1"></i> Kapasitas</h6>
                        <p class="small mb-2">Pertimbangkan:</p>
                        <ul class="small mb-2">
                            <li>Luas ruangan</li>
                            <li>Tata letak furniture</li>
                            <li>Protokol kesehatan</li>
                        </ul>
                    </div>

                    <div class="callout callout-warning">
                        <h6><i class="fas fa-camera mr-1"></i> Foto Ruangan</h6>
                        <p class="small mb-2">Foto yang baik akan membantu:</p>
                        <ul class="small mb-2">
                            <li>User memilih ruangan</li>
                            <li>Menunjukkan fasilitas</li>
                            <li>Verifikasi kondisi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Fasilitas Umum Card -->
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tools mr-1"></i>
                        Fasilitas Umum
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-2">
                            <i class="fas fa-video text-primary fa-2x"></i>
                            <br><small>Proyektor</small>
                        </div>
                        <div class="col-6 mb-2">
                            <i class="fas fa-snowflake text-info fa-2x"></i>
                            <br><small>AC</small>
                        </div>
                        <div class="col-6 mb-2">
                            <i class="fas fa-wifi text-success fa-2x"></i>
                            <br><small>WiFi</small>
                        </div>
                        <div class="col-6 mb-2">
                            <i class="fas fa-volume-up text-warning fa-2x"></i>
                            <br><small>Sound System</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
.callout {
    margin-bottom: 15px;
    padding: 10px;
    border-left: 4px solid #eee;
    border-radius: 4px;
}

.callout-info {
    border-left-color: #17a2b8;
    background-color: #d1ecf1;
}

.callout-success {
    border-left-color: #28a745;
    background-color: #d4edda;
}

.callout-warning {
    border-left-color: #ffc107;
    background-color: #fff3cd;
}

.form-check {
    margin-bottom: 8px;
}

.form-check-label {
    font-weight: normal;
}
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Custom file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Auto generate code based on name
    $('#name').on('blur', function() {
        let name = $(this).val();
        let code = $('#code').val();

        if (name && !code) {
            let generatedCode = generateRoomCode(name);
            $('#code').val(generatedCode);
        }
    });

    function generateRoomCode(name) {
        // Extract first letters and add random number
        let words = name.split(' ');
        let prefix = '';

        words.forEach(function(word) {
            if (word.length > 0) {
                prefix += word.charAt(0).toUpperCase();
            }
        });

        // Limit to 2-3 characters
        prefix = prefix.substring(0, 3);

        // Add random 3-digit number
        let randomNum = Math.floor(Math.random() * 900) + 100;

        return prefix + '-' + randomNum;
    }

    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;

        // Check required fields
        $('input[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Form Tidak Lengkap',
                text: 'Mohon lengkapi semua field yang wajib diisi!'
            });
        }
    });
});
</script>
@stop
