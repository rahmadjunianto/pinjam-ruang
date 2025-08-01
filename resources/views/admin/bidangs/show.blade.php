@extends('adminlte::page')

@section('title', 'Detail Bidang')

@sect                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $bidang->created_at ? $bidang->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui:</strong></td>
                            <td>{{ $bidang->updated_at ? $bidang->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        </tr>tent_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Detail Bidang: {{ $bidang->nama }}</h1>
        <div class="btn-group">
            <a href="{{ route('admin.bidangs.edit', $bidang) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.bidangs.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Bidang</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Kode Bidang:</strong></td>
                            <td>
                                <span class="badge badge-secondary">{{ $bidang->kode }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Nama Bidang:</strong></td>
                            <td>{{ $bidang->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Deskripsi:</strong></td>
                            <td>{{ $bidang->deskripsi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kepala Bidang:</strong></td>
                            <td>{{ $bidang->kepala_bidang ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Telepon:</strong></td>
                            <td>{{ $bidang->telepon ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>
                                @if($bidang->email)
                                    <a href="mailto:{{ $bidang->email }}">{{ $bidang->email }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($bidang->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $bidang->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui:</strong></td>
                            <td>{{ $bidang->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Statistik</h3>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-calendar-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Booking</span>
                            <span class="info-box-number">{{ $bidang->bookings_count }}</span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Booking Pending</span>
                            <span class="info-box-number">{{ $pendingBookings }}</span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Booking Disetujui</span>
                            <span class="info-box-number">{{ $approvedBookings }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($bidang->bookings->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Booking Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.bookings.index', ['bidang_id' => $bidang->id]) }}" class="btn btn-tool">
                        <i class="fas fa-external-link-alt"></i> Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Kode Booking</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bidang->bookings->take(5) as $booking)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.bookings.show', $booking) }}">
                                        {{ $booking->booking_code }}
                                    </a>
                                </td>
                                <td>{{ $booking->room->name }}</td>
                                <td>{{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@stop

@section('css')
<style>
.info-box {
    margin-bottom: 1rem;
}
</style>
@stop
