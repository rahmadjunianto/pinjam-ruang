@extends('adminlte::page')

@section('title', 'Detail Booking')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-eye text-info mr-2"></i>
                Detail Booking
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Booking</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        {{ $booking->title }}
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-{{ $booking->status === 'approved' ? 'success' : ($booking->status === 'pending' ? 'warning' : ($booking->status === 'rejected' ? 'danger' : 'info')) }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong><i class="fas fa-barcode mr-1"></i> Kode Booking</strong>
                            <p class="text-muted">{{ $booking->booking_code }}</p>

                            <strong><i class="fas fa-calendar mr-1"></i> Tanggal</strong>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</p>

                            <strong><i class="fas fa-clock mr-1"></i> Waktu</strong>
                            <p class="text-muted">{{ $booking->start_time }} - {{ $booking->end_time }}</p>

                            <strong><i class="fas fa-users mr-1"></i> Jumlah Peserta</strong>
                            <p class="text-muted">{{ $booking->participants_count }} orang</p>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-user mr-1"></i> Peminjam</strong>
                            <p class="text-muted">{{ $booking->user->name }}</p>

                            <strong><i class="fas fa-building mr-1"></i> Bidang</strong>
                            <p class="text-muted">{{ $booking->bidang->nama ?? '-' }}</p>

                            <strong><i class="fas fa-door-open mr-1"></i> Ruangan</strong>
                            <p class="text-muted">{{ $booking->room->name }}</p>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</strong>
                            <p class="text-muted">{{ $booking->room->location }}</p>
                        </div>
                    </div>

                    @if($booking->description)
                        <strong><i class="fas fa-align-left mr-1"></i> Deskripsi</strong>
                        <p class="text-muted">{{ $booking->description }}</p>
                    @endif

                    @if($booking->equipment_needed)
                        <strong><i class="fas fa-tools mr-1"></i> Peralatan Dibutuhkan</strong>
                        <p class="text-muted">{{ $booking->equipment_needed }}</p>
                    @endif
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-address-book mr-2"></i>
                        Informasi Kontak
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong><i class="fas fa-user-tie mr-1"></i> PIC</strong>
                            <p class="text-muted">{{ $booking->contact_person }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-phone mr-1"></i> Telepon</strong>
                            <p class="text-muted">{{ $booking->contact_phone }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                            <p class="text-muted">{{ $booking->contact_email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Approval Information --}}
            @if($booking->status !== 'pending')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-check-circle mr-2"></i>
                            Informasi Persetujuan
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($booking->approved_by)
                            <strong><i class="fas fa-user-check mr-1"></i> Disetujui oleh</strong>
                            <p class="text-muted">{{ $booking->approvedBy->name ?? 'N/A' }}</p>

                            <strong><i class="fas fa-calendar-check mr-1"></i> Tanggal Persetujuan</strong>
                            <p class="text-muted">{{ $booking->approved_at ? \Carbon\Carbon::parse($booking->approved_at)->format('d F Y H:i') : '-' }}</p>
                        @endif

                        @if($booking->approval_notes)
                            <strong><i class="fas fa-sticky-note mr-1"></i> Catatan Persetujuan</strong>
                            <p class="text-muted">{{ $booking->approval_notes }}</p>
                        @endif

                        @if($booking->rejection_reason)
                            <strong><i class="fas fa-times-circle mr-1"></i> Alasan Penolakan</strong>
                            <p class="text-muted text-danger">{{ $booking->rejection_reason }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar Actions --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs mr-2"></i>
                        Aksi
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning btn-block">
                            <i class="fas fa-edit mr-1"></i> Edit Booking
                        </a>

                        @if($booking->status === 'pending')
                            <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Setujui booking ini?')">
                                    <i class="fas fa-check mr-1"></i> Setujui
                                </button>
                            </form>

                            <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Tolak booking ini?')">
                                    <i class="fas fa-times mr-1"></i> Tolak
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-default btn-block">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Room Information --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-door-open mr-2"></i>
                        Informasi Ruangan
                    </h3>
                </div>
                <div class="card-body">
                    <strong>{{ $booking->room->name }}</strong>
                    <p class="text-muted">{{ $booking->room->description }}</p>

                    <small class="text-muted">
                        <i class="fas fa-users mr-1"></i> Kapasitas: {{ $booking->room->capacity }} orang<br>
                        <i class="fas fa-map-marker-alt mr-1"></i> Lokasi: {{ $booking->room->location }}
                    </small>

                    @php
                        $facilities = $booking->room->facilities;
                        if (is_string($facilities)) {
                            $facilities = json_decode($facilities, true) ?: [];
                        }
                        $facilities = $facilities ?: [];
                    @endphp
                    @if(!empty($facilities))
                        <hr>
                        <strong>Fasilitas:</strong>
                        <ul class="list-unstyled">
                            @foreach($facilities as $facility)
                                <li><i class="fas fa-check text-success mr-1"></i> {{ $facility }}</li>
                            @endforeach
                        </ul>
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
