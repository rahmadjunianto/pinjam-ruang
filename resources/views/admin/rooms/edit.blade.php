@extends('adminlte::page')

@section('title', 'Edit Ruangan')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-edit text-warning mr-2"></i>
                Edit Ruangan
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Ruangan</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit mr-1"></i>
                        Edit Ruangan: {{ $room->name }}
                    </h3>
                </div>
                <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                           value="{{ old('code', $room->code) }}"
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
                                           value="{{ old('name', $room->name) }}"
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
                                           value="{{ old('capacity', $room->capacity) }}"
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
                                           value="{{ old('location', $room->location) }}"
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
                                           value="{{ old('floor', $room->floor) }}"
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
                                      placeholder="Deskripsi ruangan, fitur khusus, atau catatan penting">{{ old('description', $room->description) }}</textarea>
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
                                @php
                                    $currentFacilities = old('facilities', $room->facilities ?? []);
                                    $availableFacilities = [
                                        'Proyektor' => 'fas fa-video',
                                        'AC' => 'fas fa-snowflake',
                                        'WiFi' => 'fas fa-wifi',
                                        'Sound System' => 'fas fa-volume-up',
                                        'Microphone' => 'fas fa-microphone',
                                        'Whiteboard' => 'fas fa-chalkboard',
                                        'Meja & Kursi' => 'fas fa-chair',
                                        'Toilet' => 'fas fa-restroom',
                                        'Parkir' => 'fas fa-parking'
                                    ];
                                @endphp

                                <div class="col-md-4">
                                    @foreach(array_slice($availableFacilities, 0, 3, true) as $facility => $icon)
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="facilities[]"
                                                   value="{{ $facility }}"
                                                   id="{{ Str::slug($facility) }}"
                                                   {{ in_array($facility, $currentFacilities) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ Str::slug($facility) }}">
                                                <i class="{{ $icon }} mr-1"></i> {{ $facility }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    @foreach(array_slice($availableFacilities, 3, 3, true) as $facility => $icon)
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="facilities[]"
                                                   value="{{ $facility }}"
                                                   id="{{ Str::slug($facility) }}"
                                                   {{ in_array($facility, $currentFacilities) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ Str::slug($facility) }}">
                                                <i class="{{ $icon }} mr-1"></i> {{ $facility }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    @foreach(array_slice($availableFacilities, 6, 3, true) as $facility => $icon)
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="facilities[]"
                                                   value="{{ $facility }}"
                                                   id="{{ Str::slug($facility) }}"
                                                   {{ in_array($facility, $currentFacilities) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ Str::slug($facility) }}">
                                                <i class="{{ $icon }} mr-1"></i> {{ $facility }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <small class="text-muted">Pilih fasilitas yang tersedia di ruangan ini</small>
                        </div>

                        <!-- Foto Saat Ini -->
                        @if($room->image)
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-image mr-1"></i>
                                    Foto Saat Ini
                                </label>
                                <div class="mb-2">
                                    <img src="{{ Storage::url($room->image) }}"
                                         alt="{{ $room->name }}"
                                         class="img-thumbnail"
                                         style="max-width: 200px; max-height: 150px;">
                                </div>
                            </div>
                        @endif

                        <!-- Upload Foto Baru -->
                        <div class="form-group">
                            <label for="image">
                                <i class="fas fa-camera mr-1"></i>
                                {{ $room->image ? 'Ganti Foto Ruangan' : 'Foto Ruangan' }}
                            </label>
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       accept="image/jpeg,image/png,image/jpg">
                                <label class="custom-file-label" for="image">
                                    {{ $room->image ? 'Pilih foto baru...' : 'Pilih foto...' }}
                                </label>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Format: JPG, JPEG, PNG. Maksimal 2MB.
                                {{ $room->image ? 'Kosongkan jika tidak ingin mengganti foto.' : '' }}
                            </small>
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
                                      placeholder="Catatan khusus, aturan penggunaan, atau informasi penting lainnya">{{ old('notes', $room->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save mr-1"></i>
                                    Update Ruangan
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
            <!-- Info Ruangan -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-1"></i>
                        Informasi Ruangan
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Kode:</strong></td>
                            <td><span class="badge badge-info">{{ $room->code }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $room->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diupdate:</strong></td>
                            <td>{{ $room->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                        @if($room->bookings_count > 0)
                        <tr>
                            <td><strong>Total Booking:</strong></td>
                            <td><span class="badge badge-success">{{ $room->bookings_count }} kali</span></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Booking Terbaru -->
            @if($room->bookings && $room->bookings->count() > 0)
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check mr-1"></i>
                        Booking Terbaru
                    </h3>
                </div>
                <div class="card-body">
                    @foreach($room->bookings->take(3) as $booking)
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div>
                                <strong>{{ $booking->title }}</strong>
                                <br><small class="text-muted">{{ $booking->booking_date->format('d M Y') }}</small>
                            </div>
                            <span class="badge badge-{{ $booking->status_badge }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                    @endforeach

                    @if($room->bookings->count() > 3)
                        <div class="text-center mt-2">
                            <small class="text-muted">+{{ $room->bookings->count() - 3 }} booking lainnya</small>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-1"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-info btn-block">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat Detail
                    </a>
                    <a href="{{ route('admin.bookings.create', ['room' => $room->id]) }}" class="btn btn-success btn-block">
                        <i class="fas fa-plus mr-1"></i>
                        Buat Booking
                    </a>
                    <button type="button" class="btn btn-danger btn-block" onclick="deleteRoom()">
                        <i class="fas fa-trash mr-1"></i>
                        Hapus Ruangan
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
.form-check {
    margin-bottom: 8px;
}

.form-check-label {
    font-weight: normal;
}

.img-thumbnail {
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    padding: 0.25rem;
}
</style>
@stop

@section('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Custom file input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

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

function deleteRoom() {
    Swal.fire({
        title: 'Hapus Ruangan?',
        text: "Data ruangan {{ $room->name }} akan dihapus permanent!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Create and submit delete form
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.rooms.destroy", $room) }}';

            let csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            let methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@stop
