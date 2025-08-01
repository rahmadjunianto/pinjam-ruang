@extends('adminlte::page')

@section('title', 'Detail Ruangan')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-eye text-info mr-2"></i>
                Detail Ruangan
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.rooms.index') }}">Ruangan</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- Info Ruangan -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-door-open mr-1"></i>
                        {{ $room->name }}
                        <span class="badge badge-secondary ml-2">{{ $room->code }}</span>
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit mr-1"></i>
                            Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($room->image)
                        <div class="text-center mb-4">
                            <img src="{{ Storage::url($room->image) }}"
                                 alt="{{ $room->name }}"
                                 class="img-fluid rounded shadow"
                                 style="max-height: 300px;">
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-info-circle text-info mr-2"></i>Informasi Dasar</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="120"><strong>Kode:</strong></td>
                                    <td><span class="badge badge-info">{{ $room->code }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td>{{ $room->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kapasitas:</strong></td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-users mr-1"></i>
                                            {{ $room->capacity }} orang
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi:</strong></td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                                        {{ $room->location }}
                                        @if($room->floor)
                                            <br><small class="text-muted">{{ $room->floor }}</small>
                                        @endif
                                    </td>
                                </tr>
                                @if($room->price_per_hour)
                                <tr>
                                    <td><strong>Harga:</strong></td>
                                    <td>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-money-bill-wave mr-1"></i>
                                            Rp {{ number_format($room->price_per_hour, 0, ',', '.') }}/jam
                                        </span>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <td><strong>Harga:</strong></td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-gift mr-1"></i>
                                            Gratis
                                        </span>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5><i class="fas fa-tools text-primary mr-2"></i>Fasilitas</h5>
                            @php
                                $facilities = $room->facilities;
                                if (is_string($facilities)) {
                                    $facilities = json_decode($facilities, true) ?: [];
                                }
                                $facilities = $facilities ?: [];
                            @endphp
                            @if(!empty($facilities))
                                <div class="row">
                                    @php
                                        $facilityIcons = [
                                            'Proyektor' => 'fas fa-video text-primary',
                                            'AC' => 'fas fa-snowflake text-info',
                                            'WiFi' => 'fas fa-wifi text-success',
                                            'Sound System' => 'fas fa-volume-up text-warning',
                                            'Microphone' => 'fas fa-microphone text-purple',
                                            'Whiteboard' => 'fas fa-chalkboard text-dark',
                                            'Meja & Kursi' => 'fas fa-chair text-brown',
                                            'Toilet' => 'fas fa-restroom text-secondary',
                                            'Parkir' => 'fas fa-parking text-info'
                                        ];
                                    @endphp
                                    @foreach($facilities as $facility)
                                        <div class="col-6 mb-2">
                                            <span class="badge badge-light border p-2 w-100">
                                                <i class="{{ $facilityIcons[$facility] ?? 'fas fa-check text-success' }} mr-1"></i>
                                                {{ $facility }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">Tidak ada fasilitas yang tercatat</p>
                            @endif
                        </div>
                    </div>

                    @if($room->description)
                        <div class="mt-4">
                            <h5><i class="fas fa-align-left text-secondary mr-2"></i>Deskripsi</h5>
                            <div class="bg-light p-3 rounded">
                                {{ $room->description }}
                            </div>
                        </div>
                    @endif

                    @if($room->notes)
                        <div class="mt-4">
                            <h5><i class="fas fa-sticky-note text-warning mr-2"></i>Catatan</h5>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                {{ $room->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Booking -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1"></i>
                        Riwayat Booking ({{ $bookings->total() }})
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.bookings.create', ['room' => $room->id]) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus mr-1"></i>
                            Buat Booking
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Kode Booking</th>
                                        <th>Acara</th>
                                        <th>Tanggal & Waktu</th>
                                        <th>PIC</th>
                                        <th>Peserta</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>
                                                <strong>{{ $booking->booking_code }}</strong>
                                                <br><small class="text-muted">{{ $booking->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $booking->title }}</strong>
                                                @if($booking->description)
                                                    <br><small class="text-muted">{{ Str::limit($booking->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ $booking->booking_date->format('d M Y') }}
                                                <br><small class="text-muted">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                                                    {{ Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                {{ $booking->contact_person }}
                                                @if($booking->contact_phone)
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-phone mr-1"></i>
                                                        {{ $booking->contact_phone }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">
                                                    <i class="fas fa-users mr-1"></i>
                                                    {{ $booking->participants_count }} orang
                                                </span>
                                            </td>
                                            <td>
                                                @switch($booking->status)
                                                    @case('pending')
                                                        <span class="badge badge-warning">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            Pending
                                                        </span>
                                                        @break
                                                    @case('approved')
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                            Approved
                                                        </span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-times-circle mr-1"></i>
                                                            Rejected
                                                        </span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge badge-primary">
                                                            <i class="fas fa-flag-checkered mr-1"></i>
                                                            Completed
                                                        </span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge badge-secondary">
                                                            <i class="fas fa-ban mr-1"></i>
                                                            Cancelled
                                                        </span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                                       class="btn btn-info btn-sm"
                                                       title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($booking->status === 'pending')
                                                        <a href="{{ route('admin.bookings.edit', $booking) }}"
                                                           class="btn btn-warning btn-sm"
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($bookings->hasPages())
                            <div class="card-footer">
                                {{ $bookings->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Booking</h5>
                            <p class="text-muted">Ruangan ini belum pernah dibooking.</p>
                            <a href="{{ route('admin.bookings.create', ['room' => $room->id]) }}" class="btn btn-success">
                                <i class="fas fa-plus mr-1"></i>
                                Buat Booking Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-1"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.bookings.create', ['room' => $room->id]) }}" class="btn btn-success btn-block">
                        <i class="fas fa-plus mr-1"></i>
                        Buat Booking
                    </a>
                    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-warning btn-block">
                        <i class="fas fa-edit mr-1"></i>
                        Edit Ruangan
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="button" class="btn btn-danger btn-block" onclick="deleteRoom()">
                        <i class="fas fa-trash mr-1"></i>
                        Hapus Ruangan
                    </button>
                </div>
            </div>

            <!-- Statistik Ruangan -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Statistik Ruangan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-calendar-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Booking</span>
                                    <span class="info-box-number">{{ $totalBookings }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending</span>
                                    <span class="info-box-number">{{ $pendingBookings }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="info-box bg-primary">
                                <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Approved</span>
                                    <span class="info-box-number">{{ $approvedBookings }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Peserta</span>
                                    <span class="info-box-number">{{ $totalParticipants }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Sistem -->
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info mr-1"></i>
                        Informasi Sistem
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $room->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diupdate:</strong></td>
                            <td>{{ $room->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($room->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
.info-box {
    margin-bottom: 10px;
}

.info-box-content {
    padding: 5px 10px;
}

.info-box-text {
    font-size: 11px;
}

.info-box-number {
    font-size: 16px;
    font-weight: bold;
}

.badge-light {
    background-color: #f8f9fa !important;
    color: #495057 !important;
}
</style>
@stop

@section('js')
<script>
function deleteRoom() {
    Swal.fire({
        title: 'Hapus Ruangan?',
        text: "Data ruangan {{ $room->name }} akan dihapus permanent! Semua booking terkait juga akan dihapus.",
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
