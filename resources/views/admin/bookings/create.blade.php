@extends('adminlte::page')

@section('title', 'Buat Booking Baru')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-calendar-plus text-success mr-2"></i>
                Buat Booking Baru
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Booking</a></li>
                <li class="breadcrumb-item active">Buat Baru</li>
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
                        Formulir Booking Ruangan
                    </h3>
                </div>
                <form action="{{ route('admin.bookings.store') }}" method="POST" id="bookingForm">
                    @csrf
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
                                            {{ old('room_id', $selectedRoom->id ?? '') == $room->id ? 'selected' : '' }}>
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
                                            {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }} ({{ $bidang->kode }})
                                    </option>
                                @endforeach
                            </select>
                            @error('bidang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Pilih bidang/unit kerja yang mengadakan acara</small>
                        </div>

                        <!-- Room Info Display -->
                        <div id="roomInfo" class="alert alert-info" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Kapasitas:</strong> <span id="roomCapacity">-</span> orang
                                </div>
                                <div class="col-md-6">
                                    <strong>Harga per Jam:</strong> <span id="roomPrice">-</span>
                                </div>
                            </div>
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
                                           value="{{ old('title') }}"
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
                                      placeholder="Deskripsi detail acara, agenda, atau informasi tambahan">{{ old('description') }}</textarea>
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
                                           value="{{ old('booking_date') }}"
                                           min="{{ date('Y-m-d') }}"
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
                                           value="{{ old('start_time') }}"
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
                                           value="{{ old('end_time') }}"
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
                                           value="{{ old('contact_person') }}"
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
                                           value="{{ old('contact_phone') }}"
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
                                           value="{{ old('contact_email') }}"
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
                                           value="{{ old('participants_count') }}"
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
                                              placeholder="Contoh: Proyektor, Sound system, Microphone wireless">{{ old('equipment_needed') }}</textarea>
                                    @error('equipment_needed')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Cost Display -->
                        <div id="costCalculation" class="alert alert-warning" style="display: none;">
                            <h6><i class="fas fa-calculator mr-1"></i> Perhitungan Biaya</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Durasi:</strong> <span id="duration">-</span> jam
                                </div>
                                <div class="col-md-4">
                                    <strong>Harga per Jam:</strong> <span id="pricePerHour">-</span>
                                </div>
                                <div class="col-md-4">
                                    <strong>Total Biaya:</strong> <span id="totalCost" class="text-success">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i>
                                    Buat Booking
                                </button>
                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times mr-1"></i>
                                    Batal
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Booking akan berstatus <strong>Pending</strong> menunggu approval
                                </small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Info -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-1"></i>
                        Informasi Booking
                    </h3>
                </div>
                <div class="card-body">
                    <div class="callout callout-info">
                        <h6><i class="fas fa-clock mr-1"></i> Waktu Operasional</h6>
                        <p class="small mb-2">
                            • Senin - Jumat: 08:00 - 17:00<br>
                            • Sabtu: 08:00 - 12:00<br>
                            • Minggu: Tutup
                        </p>
                    </div>

                    <div class="callout callout-warning">
                        <h6><i class="fas fa-exclamation-triangle mr-1"></i> Ketentuan</h6>
                        <ul class="small mb-2">
                            <li>Booking minimal H-1 dari tanggal acara</li>
                            <li>Approval otomatis untuk ruangan gratis</li>
                            <li>Pembayaran dilakukan di muka untuk ruangan berbayar</li>
                        </ul>
                    </div>

                    <div class="callout callout-success">
                        <h6><i class="fas fa-check-circle mr-1"></i> Tips</h6>
                        <ul class="small mb-2">
                            <li>Pastikan kapasitas sesuai jumlah peserta</li>
                            <li>Isi kontak PIC dengan lengkap</li>
                            <li>Booking akan mendapat kode unik</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Room Availability -->
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check mr-1"></i>
                        Cek Ketersediaan
                    </h3>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary btn-block" id="checkAvailability">
                        <i class="fas fa-search mr-1"></i>
                        Cek Ketersediaan Ruangan
                    </button>
                    <div id="availabilityResult" class="mt-3" style="display: none;"></div>
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

    // Room selection change
    $('#room_id').change(function() {
        updateRoomInfo();
        calculateCost();
    });

    // Time change events
    $('#start_time, #end_time').change(function() {
        calculateCost();
    });

    // Participants count validation
    $('#participants_count').on('input', function() {
        validateCapacity();
    });

    function updateRoomInfo() {
        const selectedOption = $('#room_id option:selected');
        const capacity = selectedOption.data('capacity');
        const price = selectedOption.data('price');

        if (capacity) {
            $('#roomCapacity').text(capacity);
            $('#roomPrice').text(price > 0 ? 'Rp ' + number_format(price) + '/jam' : 'Gratis');
            $('#roomInfo').show();
        } else {
            $('#roomInfo').hide();
        }
    }

    function calculateCost() {
        const selectedOption = $('#room_id option:selected');
        const price = selectedOption.data('price') || 0;
        const startTime = $('#start_time').val();
        const endTime = $('#end_time').val();

        if (startTime && endTime && price > 0) {
            const start = new Date('2000-01-01 ' + startTime);
            const end = new Date('2000-01-01 ' + endTime);
            const duration = (end - start) / (1000 * 60 * 60);

            if (duration > 0) {
                const totalCost = duration * price;

                $('#duration').text(duration);
                $('#pricePerHour').text('Rp ' + number_format(price));
                $('#totalCost').text('Rp ' + number_format(totalCost));
                $('#costCalculation').show();
            } else {
                $('#costCalculation').hide();
            }
        } else {
            $('#costCalculation').hide();
        }
    }

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

    function number_format(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Check availability
    $('#checkAvailability').click(function() {
        const roomId = $('#room_id').val();
        const date = $('#booking_date').val();
        const startTime = $('#start_time').val();
        const endTime = $('#end_time').val();

        if (!roomId || !date || !startTime || !endTime) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Lengkap',
                text: 'Mohon lengkapi ruangan, tanggal, dan waktu terlebih dahulu!'
            });
            return;
        }

        // Show loading
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Checking...');

        // Simulate API call (replace with actual AJAX call)
        setTimeout(() => {
            $('#availabilityResult').html(`
                <div class="alert alert-success">
                    <i class="fas fa-check-circle mr-1"></i>
                    <strong>Ruangan Tersedia!</strong><br>
                    Waktu yang dipilih dapat dibooking.
                </div>
            `).show();

            $(this).prop('disabled', false).html('<i class="fas fa-search mr-1"></i> Cek Ketersediaan Ruangan');
        }, 1500);
    });

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

    // Initialize if room is pre-selected
    if ($('#room_id').val()) {
        updateRoomInfo();
    }
});
</script>
@stop
