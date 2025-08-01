@extends('adminlte::page')

@section('title', 'Kelola Booking')

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-calendar-check text-success mr-2"></i>
                Kelola Booking
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Booking</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-3">
        @if(auth()->user()->role !== 'viewer')
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendingCount }}</h3>
                    <p>
                        @if(auth()->user()->role === 'user')
                            Booking Saya (Pending)
                        @else
                            Pending Approval
                        @endif
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        @endif

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $approvedCount }}</h3>
                    <p>
                        @if(auth()->user()->role === 'user')
                            Booking Saya (Approved)
                        @else
                            Approved
                        @endif
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

                <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $todayCount }}</h3>
                    <p>
                        @if(auth()->user()->role === 'user')
                            Booking Saya Hari Ini
                        @else
                            Booking Hari Ini
                        @endif
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalCount }}</h3>
                    <p>
                        @if(auth()->user()->role === 'user')
                            Total Booking Saya
                        @elseif(auth()->user()->role === 'viewer')
                            Total Booking (Approved)
                        @else
                            Total Booking
                        @endif
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-1"></i>
                Daftar Booking
            </h3>
            <div class="card-tools">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.bookings.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus mr-1"></i>
                        Booking Baru
                    </a>
                @elseif(auth()->user()->role === 'user')
                    <a href="{{ route('admin.bookings.available-rooms') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-search mr-1"></i>
                        Pilih Ruangan
                    </a>
                @endif
            </div>
        </div>

        <!-- Filters -->
        <div class="card-body border-bottom">
            <form method="GET" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label for="search" class="small">Cari Booking:</label>
                            <input type="text"
                                   class="form-control form-control-sm"
                                   id="search"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Kode, judul, atau PIC...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label for="status" class="small">Status:</label>
                            <select class="form-control form-control-sm" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label for="room_id" class="small">Ruangan:</label>
                            <select class="form-control form-control-sm" id="room_id" name="room_id">
                                <option value="">Semua Ruangan</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label for="date_from" class="small">Dari Tanggal:</label>
                            <input type="date"
                                   class="form-control form-control-sm"
                                   id="date_from"
                                   name="date_from"
                                   value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label for="date_to" class="small">Sampai Tanggal:</label>
                            <input type="date"
                                   class="form-control form-control-sm"
                                   id="date_to"
                                   name="date_to"
                                   value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group mb-2">
                            <label class="small">&nbsp;</label>
                            <div class="btn-group d-block">
                                <button type="submit" class="btn btn-primary btn-sm btn-block">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                @if(request()->hasAny(['search', 'status', 'room_id', 'date_from', 'date_to']))
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times mr-1"></i>
                                Clear Filter
                            </a>
                            <small class="text-muted ml-2">
                                Menampilkan {{ $bookings->total() }} hasil dari {{ $bookings->currentPage() }} halaman
                            </small>
                        </div>
                    </div>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="card-body p-0">
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Kode & Acara</th>
                                <th>Ruangan</th>
                                <th>Tanggal & Waktu</th>
                                <th>PIC</th>
                                <th>Peserta</th>
                                <th>Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>
                                    <td>
                                        <div>
                                            <strong>{{ $booking->booking_code }}</strong>
                                            <br><span class="text-primary">{{ $booking->title }}</span>
                                            @if($booking->description)
                                                <br><small class="text-muted">{{ Str::limit($booking->description, 40) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $booking->room->name }}</strong>
                                            <br><span class="badge badge-info">{{ $booking->room->code }}</span>
                                            <br><small class="text-muted">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $booking->room->location }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <i class="fas fa-calendar mr-1"></i>
                                            <strong>{{ $booking->booking_date->format('d M Y') }}</strong>
                                            <br><small class="text-muted">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                                                {{ Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                                ({{ $booking->duration }} jam)
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $booking->contact_person }}</strong>
                                            @if($booking->contact_phone)
                                                <br><small class="text-muted">
                                                    <i class="fas fa-phone mr-1"></i>
                                                    {{ $booking->contact_phone }}
                                                </small>
                                            @endif
                                            @if($booking->contact_email)
                                                <br><small class="text-muted">
                                                    <i class="fas fa-envelope mr-1"></i>
                                                    {{ $booking->contact_email }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-users mr-1"></i>
                                            {{ $booking->participants_count }}
                                        </span>
                                        @if($booking->equipment_needed)
                                            <br><small class="text-muted">
                                                <i class="fas fa-tools mr-1"></i>
                                                Equipment
                                            </small>
                                        @endif
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

                                        @if($booking->total_cost > 0)
                                            <br><small class="text-success">
                                                <i class="fas fa-money-bill-wave mr-1"></i>
                                                Rp {{ number_format($booking->total_cost, 0, ',', '.') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" role="group">
                                            <a href="{{ route('admin.bookings.show', $booking) }}"
                                               class="btn btn-info btn-sm"
                                               title="Detail">
                                                <i class="fas fa-eye mr-1"></i>
                                                Detail
                                            </a>

                                            @if(auth()->user()->role === 'admin' && $booking->status === 'pending')
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button"
                                                            class="btn btn-success btn-sm"
                                                            onclick="approveBooking({{ $booking->id }})"
                                                            title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="rejectBooking({{ $booking->id }})"
                                                            title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <a href="{{ route('admin.bookings.edit', $booking) }}"
                                                       class="btn btn-warning btn-sm"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            @elseif(auth()->user()->role === 'user' && $booking->user_id === auth()->id() && $booking->status === 'pending')
                                                <!-- User can only edit their own pending bookings -->
                                                <a href="{{ route('admin.bookings.edit', $booking) }}"
                                                   class="btn btn-warning btn-sm"
                                                   title="Edit">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Edit
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak Ada Booking</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'status', 'room_id', 'date_from', 'date_to']))
                            Tidak ada booking yang sesuai dengan filter pencarian.
                        @else
                            Belum ada booking yang dibuat.
                        @endif
                    </p>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.bookings.create') }}" class="btn btn-success">
                            <i class="fas fa-plus mr-1"></i>
                            Buat Booking Baru
                        </a>
                    @elseif(auth()->user()->role === 'user')
                        <a href="{{ route('admin.bookings.available-rooms') }}" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i>
                            Pilih Ruangan untuk Booking
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
            <div class="card-footer">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@stop

@section('css')
<style>
.small-box .inner {
    padding: 15px;
}

.table th {
    font-size: 12px;
    font-weight: 600;
}

.table td {
    font-size: 13px;
    vertical-align: middle;
}

.btn-group-vertical .btn {
    margin-bottom: 2px;
}

.badge {
    font-size: 10px;
}
</style>
@stop

@section('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Auto submit filter on change
    $('#status, #room_id, #date_from, #date_to').change(function() {
        $('#filterForm').submit();
    });

    // Search with delay
    let searchTimeout;
    $('#search').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            $('#filterForm').submit();
        }, 500);
    });
});

function approveBooking(bookingId) {
    Swal.fire({
        title: 'Approve Booking?',
        text: "Booking akan disetujui dan user akan mendapat notifikasi.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Approve!',
        cancelButtonText: 'Batal',
        input: 'textarea',
        inputPlaceholder: 'Catatan approval (opsional)...',
        inputAttributes: {
            'aria-label': 'Catatan approval'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/bookings/${bookingId}/approve`;

            let csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            let methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';

            let notesField = document.createElement('input');
            notesField.type = 'hidden';
            notesField.name = 'approval_notes';
            notesField.value = result.value || '';

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            form.appendChild(notesField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function rejectBooking(bookingId) {
    Swal.fire({
        title: 'Reject Booking?',
        text: "Booking akan ditolak dan user akan mendapat notifikasi.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Reject!',
        cancelButtonText: 'Batal',
        input: 'textarea',
        inputPlaceholder: 'Alasan penolakan (wajib)...',
        inputAttributes: {
            'aria-label': 'Alasan penolakan'
        },
        inputValidator: (value) => {
            if (!value) {
                return 'Alasan penolakan harus diisi!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/bookings/${bookingId}/reject`;

            let csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            let methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';

            let reasonField = document.createElement('input');
            reasonField.type = 'hidden';
            reasonField.name = 'rejection_reason';
            reasonField.value = result.value;

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            form.appendChild(reasonField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@stop
