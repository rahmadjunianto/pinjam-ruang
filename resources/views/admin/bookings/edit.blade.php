@extends('adminlte::page')

@section('title', 'Edit Booking')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-edit text-warning mr-2"></i>
                Edit Booking
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Booking</a></li>
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
                        Edit Booking: {{ $booking->booking_code }}
                    </h3>
                </div>
                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" id="bookingForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Room Selection -->
                        <div class="form-group">
                            <label for="room_id">
                                <i class="fas fa-door-open mr-1"></i>
                                Pilih Ruangan <span class="text-danger">*</span>
                            </label>
                            <select class="form-control select2 @error('room_id') is-invalid @enderror"
                                    id="room_id"
                                    name="room_id"
                                    required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}"
                                            data-capacity="{{ $room->capacity }}"
                                            data-price="{{ $room->price_per_hour ?? 0 }}"
                                            {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }} ({{ $room->code }}) - Kapasitas: {{ $room->capacity }} orang
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih ruangan yang akan dibooking</small>
                        </div>

                        <!-- Bidang Selection -->
                        <div class="form-group">
                            <label for="bidang_id">
                                <i class="fas fa-building mr-1"></i>
                                Bidang/Unit Kerja <span class="text-danger">*</span>
                            </label>
                            <select class="form-control select2 @error('bidang_id') is-invalid @enderror"
                                    id="bidang_id"
                                    name="bidang_id"
                                    required>
                                <option value="">-- Pilih Bidang --</option>
                                @foreach($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}"
                                            {{ old('bidang_id', $booking->bidang_id) == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }} ({{ $bidang->kode }})
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih bidang/unit kerja yang mengadakan acara</small>
                        </div>

                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Judul Acara/Kegiatan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title', $booking->title) }}"
                                           placeholder="Contoh: Rapat Koordinasi Bulanan"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">
                                <i class="fas fa-align-left mr-1"></i>
                                Deskripsi Acara
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3"
                                      placeholder="Deskripsi detail acara, agenda, atau informasi tambahan">{{ old('description', $booking->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Date -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="booking_date">
                                        <i class="fas fa-calendar mr-1"></i>
                                        Tanggal Booking <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                           class="form-control @error('booking_date') is-invalid @enderror"
                                           id="booking_date"
                                           name="booking_date"
                                           value="{{ old('booking_date', $booking->booking_date) }}"
                                           required>
                                    @error('booking_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Start Time -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_time">
                                        <i class="fas fa-clock mr-1"></i>
                                        Jam Mulai <span class="text-danger">*</span>
                                    </label>
                                    <input type="time"
                                           class="form-control @error('start_time') is-invalid @enderror"
                                           id="start_time"
                                           name="start_time"
                                           value="{{ old('start_time', $booking->start_time) }}"
                                           required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- End Time -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_time">
                                        <i class="fas fa-clock mr-1"></i>
                                        Jam Selesai <span class="text-danger">*</span>
                                    </label>
                                    <input type="time"
                                           class="form-control @error('end_time') is-invalid @enderror"
                                           id="end_time"
                                           name="end_time"
                                           value="{{ old('end_time', $booking->end_time) }}"
                                           required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <h5><i class="fas fa-user-circle text-primary mr-2"></i>Informasi Kontak PIC</h5>
                        <div class="row">
                            <!-- Contact Person -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_person">
                                        <i class="fas fa-user mr-1"></i>
                                        Nama PIC <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('contact_person') is-invalid @enderror"
                                           id="contact_person"
                                           name="contact_person"
                                           value="{{ old('contact_person', $booking->contact_person) }}"
                                           placeholder="Nama Penanggung Jawab"
                                           required>
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact Phone -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_phone">
                                        <i class="fas fa-phone mr-1"></i>
                                        No. Telepon <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel"
                                           class="form-control @error('contact_phone') is-invalid @enderror"
                                           id="contact_phone"
                                           name="contact_phone"
                                           value="{{ old('contact_phone', $booking->contact_phone) }}"
                                           placeholder="08123456789"
                                           required>
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact Email -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact_email">
                                        <i class="fas fa-envelope mr-1"></i>
                                        Email
                                    </label>
                                    <input type="email"
                                           class="form-control @error('contact_email') is-invalid @enderror"
                                           id="contact_email"
                                           name="contact_email"
                                           value="{{ old('contact_email', $booking->contact_email) }}"
                                           placeholder="email@example.com">
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Participants Count -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="participants_count">
                                        <i class="fas fa-users mr-1"></i>
                                        Jumlah Peserta <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                           class="form-control @error('participants_count') is-invalid @enderror"
                                           id="participants_count"
                                           name="participants_count"
                                           value="{{ old('participants_count', $booking->participants_count) }}"
                                           min="1"
                                           placeholder="25"
                                           required>
                                    @error('participants_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Jumlah peserta yang akan hadir</small>
                                </div>
                            </div>

                            <!-- Equipment Needed -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="equipment_needed">
                                        <i class="fas fa-tools mr-1"></i>
                                        Peralatan yang Dibutuhkan
                                    </label>
                                    <textarea class="form-control @error('equipment_needed') is-invalid @enderror"
                                              id="equipment_needed"
                                              name="equipment_needed"
                                              rows="3"
                                              placeholder="Contoh: Proyektor, Sound system, Microphone wireless">{{ old('equipment_needed', $booking->equipment_needed) }}</textarea>
                                    @error('equipment_needed')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save mr-1"></i>
                                    Update Booking
                                </button>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-info ml-2">
                                    <i class="fas fa-eye mr-1"></i>
                                    Lihat Detail
                                </a>
                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Kembali
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Status: <strong>{{ ucfirst($booking->status) }}</strong>
                                </small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Booking Info -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-1"></i>
                        Info Booking
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><strong>Kode:</strong></td>
                            <td>{{ $booking->booking_code }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @switch($booking->status)
                                    @case('pending')
                                        <span class="badge badge-warning">Pending</span>
                                        @break
                                    @case('approved')
                                        <span class="badge badge-success">Disetujui</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge badge-danger">Ditolak</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge badge-secondary">Dibatalkan</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui:</strong></td>
                            <td>{{ $booking->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Perhatian
                    </h3>
                </div>
                <div class="card-body">
                    <div class="callout callout-warning">
                        <ul class="small mb-2">
                            <li>Edit hanya bisa dilakukan pada booking dengan status <strong>Pending</strong></li>
                            <li>Perubahan jadwal akan di-validasi ulang</li>
                            <li>Pastikan tidak ada konflik waktu dengan booking lain</li>
                        </ul>
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

.callout-warning {
    border-left-color: #ffc107;
    background-color: #fff3cd;
}

.select2-container--default .select2-selection--single {
    height: 38px;
    line-height: 38px;
}
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    // Participants count validation
    $('#participants_count').on('input', function() {
        validateCapacity();
    });

    function validateCapacity() {
        const selectedOption = $('#room_id option:selected');
        const capacity = selectedOption.data('capacity');
        const participants = parseInt($('#participants_count').val());

        if (capacity && participants > capacity) {
            $('#participants_count').addClass('is-invalid');
            $('#participants_count').next('.invalid-feedback').remove();
            $('#participants_count').after('<div class="invalid-feedback">Jumlah peserta melebihi kapasitas ruangan (' + capacity + ' orang)</div>');
        } else {
            $('#participants_count').removeClass('is-invalid');
            $('#participants_count').next('.invalid-feedback').remove();
        }
    }

    // Form validation
    $('#bookingForm').on('submit', function(e) {
        let isValid = true;

        // Validate required fields
        $('input[required], select[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Validate time
        const startTime = $('#start_time').val();
        const endTime = $('#end_time').val();

        if (startTime && endTime && startTime >= endTime) {
            $('#end_time').addClass('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Form Tidak Valid',
                text: 'Mohon periksa kembali data yang diisi!'
            });
        }
    });

    // Initialize capacity validation if data exists
    if ($('#room_id').val() && $('#participants_count').val()) {
        validateCapacity();
    }
});
</script>
@stop
