@extends('adminlte::page')

@section('title', 'Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <!-- Filter Section -->
    <div class="card mb-3 filter-section">
        <div class="card-header bg-transparent border-0">
            <h3 class="card-title mb-0">
                <i class="fas fa-filter mr-2"></i>
                Filter Data Rekap
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="row align-items-end">
                <div class="col-md-3">
                    <label for="month" class="form-label font-weight-bold">
                        <i class="fas fa-calendar-alt mr-1"></i>Bulan:
                    </label>
                    <select name="month" id="month" class="form-control">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="year" class="form-label font-weight-bold">
                        <i class="fas fa-calendar mr-1"></i>Tahun:
                    </label>
                    <select name="year" id="year" class="form-control">
                        @for($i = 2020; $i <= date('Y') + 2; $i++)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-search mr-1"></i>Filter Data
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-undo mr-1"></i>Reset
                    </a>
                    <a href="{{ route('admin.dashboard.export-pdf', ['month' => $month, 'year' => $year]) }}"
                       class="btn btn-success" target="_blank">
                        <i class="fas fa-file-pdf mr-1"></i>Export PDF
                    </a>
                </div>
                <div class="col-md-2 text-right">
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Data periode:<br>
                        <strong>{{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</strong>
                    </small>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info stats-card total">
                <div class="inner">
                    <h3>{{ $statistics['total'] }}</h3>
                    <p>Total Peminjaman</p>
                    <small class="text-light">Periode: {{ DateTime::createFromFormat('!m', $month)->format('M') }} {{ $year }}</small>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-light">Semua Status</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success stats-card approved">
                <div class="inner">
                    <h3>{{ $statistics['approved'] }}</h3>
                    <p>Disetujui</p>
                    <small class="text-light">
                        {{ $statistics['total'] > 0 ? round(($statistics['approved'] / $statistics['total']) * 100, 1) : 0 }}% dari total
                    </small>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-light">Sukses</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning stats-card pending">
                <div class="inner">
                    <h3>{{ $statistics['pending'] }}</h3>
                    <p>Menunggu Persetujuan</p>
                    <small class="text-dark">
                        {{ $statistics['total'] > 0 ? round(($statistics['pending'] / $statistics['total']) * 100, 1) : 0 }}% dari total
                    </small>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-dark">Proses</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger stats-card rejected">
                <div class="inner">
                    <h3>{{ $statistics['rejected'] }}</h3>
                    <p>Ditolak</p>
                    <small class="text-light">
                        {{ $statistics['total'] > 0 ? round(($statistics['rejected'] / $statistics['total']) * 100, 1) : 0 }}% dari total
                    </small>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="small-box-footer">
                    <span class="text-light">Gagal</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Top Booked Rooms -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ruang Yang Sering Dipinjam</h3>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($topRooms->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped ranking-table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Nama Ruang</th>
                                        <th>Jumlah Peminjaman</th>
                                        <th>Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalBookings = $topRooms->sum('booking_count'); @endphp
                                    @foreach($topRooms as $index => $roomData)
                                        @php
                                            $percentage = $totalBookings > 0 ? round(($roomData->booking_count / $totalBookings) * 100, 1) : 0;
                                            $rankClass = match($index) {
                                                0 => 'first',
                                                1 => 'second',
                                                2 => 'third',
                                                default => 'other'
                                            };
                                        @endphp
                                        <tr>
                                            <td>
                                                <span class="ranking-number {{ $rankClass }}">{{ $index + 1 }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $roomData->room->name ?? 'N/A' }}</strong>
                                                @if($index === 0)
                                                    <i class="fas fa-crown text-warning ml-1"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-primary badge-ranking">{{ $roomData->booking_count }}</span>
                                            </td>
                                            <td>
                                                <div class="progress progress-xs mb-1">
                                                    <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span class="badge badge-light">{{ $percentage }}%</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox fa-3x"></i>
                            <h5 class="mt-3 text-muted">Tidak ada data peminjaman ruang</h5>
                            <p class="text-muted">untuk periode {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Seksi -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Seksi Yang Sering Meminjam</h3>
                    <div class="card-tools">
                        <span class="badge badge-success">{{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($topBidangs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped ranking-table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Nama Seksi</th>
                                        <th>Jumlah Peminjaman</th>
                                        <th>Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalBookings = $topBidangs->sum('booking_count'); @endphp
                                    @foreach($topBidangs as $index => $bidangData)
                                        @php
                                            $percentage = $totalBookings > 0 ? round(($bidangData->booking_count / $totalBookings) * 100, 1) : 0;
                                            $rankClass = match($index) {
                                                0 => 'first',
                                                1 => 'second',
                                                2 => 'third',
                                                default => 'other'
                                            };
                                        @endphp
                                        <tr>
                                            <td>
                                                <span class="ranking-number {{ $rankClass }}">{{ $index + 1 }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $bidangData->bidang->nama ?? 'N/A' }}</strong>
                                                @if($index === 0)
                                                    <i class="fas fa-trophy text-warning ml-1"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-success badge-ranking">{{ $bidangData->booking_count }}</span>
                                            </td>
                                            <td>
                                                <div class="progress progress-xs mb-1">
                                                    <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                                                </div>
                                                <span class="badge badge-light">{{ $percentage }}%</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-building fa-3x"></i>
                            <h5 class="mt-3 text-muted">Tidak ada data peminjaman seksi</h5>
                            <p class="text-muted">untuk periode {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Charts Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Grafik Perbandingan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Room Chart -->
                        <div class="col-md-6">
                            <canvas id="roomChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- Seksi Chart -->
                        <div class="col-md-6">
                            <canvas id="bidangChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard-custom.css') }}">
<style>
    .small-box {
        border-radius: 0.375rem;
    }
    .progress-xs {
        height: 0.5rem;
    }
    .card-tools .badge {
        font-size: 0.75rem;
    }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
<script>
$(document).ready(function() {
    // Room Chart
    const roomCtx = document.getElementById('roomChart').getContext('2d');
    const roomData = @json($topRooms->take(5));

    window.roomChart = new Chart(roomCtx, {
        type: 'doughnut',
        data: {
            labels: roomData.map(function(item) { return item.room ? item.room.name : 'N/A'; }),
            datasets: [{
                data: roomData.map(function(item) { return item.booking_count; }),
                backgroundColor: [
                    '#007bff',
                    '#28a745',
                    '#ffc107',
                    '#dc3545',
                    '#6c757d'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Top 5 Ruang Terpopuler'
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Seksi Chart
    const bidangCtx = document.getElementById('bidangChart').getContext('2d');
    const bidangData = @json($topBidangs->take(5));

    window.bidangChart = new Chart(bidangCtx, {
        type: 'doughnut',
        data: {
            labels: bidangData.map(function(item) { return item.bidang ? item.bidang.nama : 'N/A'; }),
            datasets: [{
                data: bidangData.map(function(item) { return item.booking_count; }),
                backgroundColor: [
                    '#28a745',
                    '#007bff',
                    '#ffc107',
                    '#dc3545',
                    '#6c757d'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Top 5 Seksi Teraktif'
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endsection