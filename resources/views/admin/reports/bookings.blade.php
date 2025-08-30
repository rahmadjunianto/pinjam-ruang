@extends('adminlte::page')

@section('title', 'Laporan Peminjaman - SIAKAD KEMENAG')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-chart-bar text-primary mr-2"></i>
                Laporan Peminjaman
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Peminjaman</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <!-- Filter Card -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter mr-2"></i>Filter Laporan
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.bookings') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="period">Periode:</label>
                            <select class="form-control" id="period" name="period">
                                <option value="">Pilih Periode</option>
                                <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_from">Dari Tanggal:</label>
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                   value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_to">Sampai Tanggal:</label>
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                   value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="room_id">Ruangan:</label>
                            <select class="form-control" id="room_id" name="room_id">
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
                        <div class="form-group">
                            <label for="bidang_id">Seksi:</label>
                            <select class="form-control" id="bidang_id" name="bidang_id">
                                <option value="">Semua Seksi</option>
                                @foreach($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}" {{ request('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                        {{ $bidang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.reports.bookings') }}" class="btn btn-secondary">
                            <i class="fas fa-undo mr-1"></i>Reset
                        </a>
                        <button type="button" class="btn btn-success" onclick="exportData()">
                            <i class="fas fa-download mr-1"></i>Export CSV
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-2 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Peminjaman</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['approved'] }}</h3>
                    <p>Disetujui</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['pending'] }}</h3>
                    <p>Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['rejected'] }}</h3>
                    <p>Ditolak</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['cancelled'] }}</h3>
                    <p>Dibatalkan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ban"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{ number_format(($stats['approved'] / max($stats['total'], 1)) * 100, 1) }}%</h3>
                    <p>Tingkat Persetujuan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-percentage"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Room Usage Chart -->
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-home mr-2"></i>Penggunaan Ruangan Terpopuler
                    </h3>
                </div>
                <div class="card-body">
                    @if(config('app.debug'))
                        <div class="alert alert-info" style="font-size: 12px;">
                            <strong>Debug Info:</strong>
                            Room Stats Count: {{ count($roomStats ?? []) }} |
                            Sample Data: {{ json_encode(($roomStats ?? collect())->take(3)) }}
                        </div>
                    @endif
                    <div class="chart-container">
                        <canvas id="roomChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Trend Chart -->
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-2"></i>Trend Peminjaman Bulanan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table mr-2"></i>Data Peminjaman
            </h3>
            <div class="card-tools">
                <span class="badge badge-primary">{{ $bookings->count() }} data</span>
            </div>
        </div>
        <div class="card-body">
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="reportTable">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Judul Kegiatan</th>
                                <th>Ruangan</th>
                                <th>Seksi</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Pemohon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <code>{{ $booking->booking_code }}</code>
                                    </td>
                                    <td>
                                        <strong>{{ $booking->title }}</strong>
                                        @if($booking->description)
                                            <br><small class="text-muted">{{ Str::limit($booking->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="fas fa-home text-success mr-1"></i>
                                        {{ $booking->room->name }}
                                    </td>
                                    <td>
                                        @if($booking->bidang)
                                            <span class="badge badge-info">{{ $booking->bidang->nama }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $booking->start_time }} - {{ $booking->end_time }}
                                    </td>
                                    <td>
                                        <strong>{{ $booking->user->name }}</strong>
                                        <br><small class="text-muted">{{ $booking->contact_email }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'pending' => 'warning',
                                                'approved' => 'success',
                                                'rejected' => 'danger',
                                                'cancelled' => 'secondary'
                                            ][$booking->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $statusClass }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking) }}"
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data peminjaman</h5>
                    <p class="text-muted">Coba ubah filter untuk melihat data yang berbeda.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

<style>
.small-box {
    border-radius: 10px;
}
.small-box .icon {
    top: 10px;
    right: 10px;
}
.bg-purple {
    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%) !important;
    color: white;
}

/* Chart container height fix */
.chart-container {
    height: 400px !important;
    max-height: 400px !important;
    overflow: hidden;
}
.chart-container canvas {
    max-height: 380px !important;
}
</style>
@stop

@section('js')
<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<!-- SweetAlert2 JS -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('Reports page loaded');

    // Auto submit on filter change
    $('#period, #status, #room_id, #bidang_id').change(function() {
        $('#filterForm').submit();
    });

    // Clear custom dates when period is selected
    $('#period').change(function() {
        if ($(this).val()) {
            $('#date_from, #date_to').val('');
        }
    });

    // Clear period when custom dates are selected
    $('#date_from, #date_to').change(function() {
        if ($(this).val()) {
            $('#period').val('');
        }
    });

    // Initialize DataTable after a short delay
    setTimeout(initializeDataTable, 200);

    // Initialize charts after a short delay
    setTimeout(function() {
        console.log('Starting chart initialization...');
        initializeChartsWhenReady();
    }, 300);
});

// Initialize DataTable when ready
function initializeDataTable() {
    const reportTable = $('#reportTable');
    if (reportTable.length > 0 && typeof $.fn.DataTable !== 'undefined') {
        console.log('Initializing DataTable...');
        reportTable.DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 25,
            order: [[4, 'desc']], // Sort by date column
            columnDefs: [
                { orderable: false, targets: [8] } // Disable sorting for action column
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            processing: true
        });
        console.log('DataTable initialized successfully');
    } else if (reportTable.length > 0) {
        console.log('DataTable library not ready, retrying...');
        setTimeout(initializeDataTable, 100);
    } else {
        console.log('Report table not found on this page');
    }
}

// Chart initialization with retry mechanism
function initializeChartsWhenReady() {
    if (typeof Chart !== 'undefined') {
        console.log('Chart.js is available, initializing charts...');
        initializeCharts();
    } else {
        console.log('Chart.js not ready yet, retrying in 100ms...');
        setTimeout(initializeChartsWhenReady, 100);
    }
}

function showChartError() {
    const roomCanvas = document.getElementById('roomChart');
    const monthlyCanvas = document.getElementById('monthlyChart');

    const errorHTML = `
        <div class="text-center py-4">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-2"></i>
            <br><span class="text-muted">Chart library tidak dapat dimuat</span>
            <br><small class="text-muted">Periksa koneksi internet Anda</small>
            <br><button class="btn btn-sm btn-primary mt-2" onclick="location.reload()">
                <i class="fas fa-refresh mr-1"></i>Muat Ulang
            </button>
        </div>
    `;

    if (roomCanvas) roomCanvas.parentNode.innerHTML = errorHTML;
    if (monthlyCanvas) monthlyCanvas.parentNode.innerHTML = errorHTML;
}

function initializeCharts() {
    console.log('=== CHARTS INITIALIZATION STARTED ===');
    console.log('Chart.js version:', Chart.version || 'unknown');
    console.log('Chart.js available:', typeof Chart !== 'undefined');

    // Test if Chart.js is working with a simple test
    try {
        const testCanvas = document.createElement('canvas');
        const testChart = new Chart(testCanvas, {
            type: 'line',
            data: {
                labels: ['Test'],
                datasets: [{
                    data: [1]
                }]
            }
        });
        testChart.destroy();
        console.log('Chart.js basic test: PASSED');
    } catch (error) {
        console.error('Chart.js basic test: FAILED', error);
        showChartError();
        return;
    }

    // Room Usage Chart
    try {
        console.log('Initializing Room Chart...');
        initializeRoomChart();
    } catch (error) {
        console.error('Failed to initialize room chart:', error);
        showRoomChartError(error.message);
    }

    // Monthly Trend Chart
    try {
        console.log('Initializing Monthly Chart...');
        initializeMonthlyChart();
    } catch (error) {
        console.error('Failed to initialize monthly chart:', error);
        showMonthlyChartError(error.message);
    }

    console.log('=== CHARTS INITIALIZATION COMPLETED ===');
}

function initializeRoomChart() {
    console.log('=== ROOM CHART INITIALIZATION ===');

    const roomCanvas = document.getElementById('roomChart');
    if (!roomCanvas) {
        console.error('Room chart canvas not found');
        return;
    }

    console.log('Room canvas found:', roomCanvas);

    const roomCtx = roomCanvas.getContext('2d');
    const roomStatsData = @json($roomStats ?? collect());

    console.log('Raw room stats data:', roomStatsData);
    console.log('Type of roomStatsData:', typeof roomStatsData);
    console.log('Is array?', Array.isArray(roomStatsData));

    // Handle both array and object formats
    let roomLabels, roomValues;

    if (Array.isArray(roomStatsData)) {
        console.log('Data is array format');
        roomLabels = roomStatsData.map(item => item.name || 'Unknown');
        roomValues = roomStatsData.map(item => item.count || 0);
    } else if (typeof roomStatsData === 'object' && roomStatsData !== null) {
        console.log('Data is object format');
        roomLabels = Object.keys(roomStatsData);
        roomValues = Object.values(roomStatsData);
    } else {
        console.log('Data is empty or invalid format');
        roomLabels = [];
        roomValues = [];
    }

    console.log('Processed labels:', roomLabels);
    console.log('Processed values:', roomValues);

    if (roomLabels.length === 0 || roomValues.length === 0) {
        console.log('No data available, showing empty state');
        showRoomChartEmpty();
        return;
    }

    console.log('Creating room chart with', roomLabels.length, 'items');

    try {
        const chartInstance = new Chart(roomCtx, {
            type: 'doughnut',
            data: {
                labels: roomLabels,
                datasets: [{
                    data: roomValues,
                    backgroundColor: [
                        '#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1',
                        '#fd7e14', '#20c997', '#6c757d', '#e83e8c', '#17a2b8'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 1,
                interaction: {
                    intersect: false
                },
                layout: {
                    padding: 10
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Penggunaan Ruangan Terpopuler',
                        font: { size: 14 }
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            usePointStyle: true,
                            font: { size: 11 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        console.log('Room chart created successfully:', chartInstance);
        console.log('Chart ID:', chartInstance.id);

    } catch (error) {
        console.error('Error creating room chart:', error);
        showRoomChartError(error.message);
    }
}

function showRoomChartEmpty() {
    const roomCanvas = document.getElementById('roomChart');
    if (roomCanvas) {
        roomCanvas.parentNode.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-chart-pie fa-3x text-muted mb-2"></i>
                <br><span class="text-muted">Tidak ada data untuk ditampilkan</span>
                <br><small class="text-muted">Silakan ubah filter atau periode</small>
            </div>
        `;
    }
}

function showRoomChartError(message) {
    const roomCanvas = document.getElementById('roomChart');
    if (roomCanvas) {
        roomCanvas.parentNode.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-2"></i>
                <br><span class="text-muted">Error: ${message}</span>
                <br><button class="btn btn-sm btn-secondary mt-2" onclick="location.reload()">
                    <i class="fas fa-refresh mr-1"></i>Coba Lagi
                </button>
            </div>
        `;
    }
}

function initializeMonthlyChart() {
    const monthlyCanvas = document.getElementById('monthlyChart');
    if (!monthlyCanvas) {
        console.log('Monthly chart canvas not found');
        return;
    }

    const monthlyCtx = monthlyCanvas.getContext('2d');
    const monthlyStatsData = @json($monthlyStats ?? collect());
    console.log('Monthly stats data:', monthlyStatsData);

    const monthlyLabels = [];
    const monthlyValues = [];

    Object.keys(monthlyStatsData).forEach(function(month) {
        try {
            const date = new Date(month + '-01');
            const monthName = date.toLocaleDateString('id-ID', { year: 'numeric', month: 'short' });
            monthlyLabels.push(monthName);
            monthlyValues.push(monthlyStatsData[month]);
        } catch (e) {
            console.error('Error parsing month:', month, e);
        }
    });

    if (monthlyLabels.length === 0 || monthlyValues.length === 0) {
        showMonthlyChartEmpty();
        return;
    }

    console.log('Creating monthly chart with', monthlyLabels.length, 'data points');

    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: monthlyValues,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#007bff',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 1.5,
            interaction: {
                intersect: false
            },
            layout: {
                padding: 10
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Trend Peminjaman Bulanan',
                    font: { size: 14 }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    console.log('Monthly chart created successfully');
}

function showMonthlyChartEmpty() {
    const monthlyCanvas = document.getElementById('monthlyChart');
    if (monthlyCanvas) {
        monthlyCanvas.parentNode.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-chart-line fa-3x text-muted mb-2"></i>
                <br><span class="text-muted">Tidak ada data trend bulanan</span>
                <br><small class="text-muted">Silakan ubah filter atau periode</small>
            </div>
        `;
    }
}

function showMonthlyChartError(message) {
    const monthlyCanvas = document.getElementById('monthlyChart');
    if (monthlyCanvas) {
        monthlyCanvas.parentNode.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-2"></i>
                <br><span class="text-muted">Error: ${message}</span>
                <br><button class="btn btn-sm btn-secondary mt-2" onclick="location.reload()">
                    <i class="fas fa-refresh mr-1"></i>Coba Lagi
                </button>
            </div>
        `;
    }
}

function initializeMonthlyChart() {
    const monthlyCanvas = document.getElementById('monthlyChart');
    if (!monthlyCanvas) {
        console.error('Monthly chart canvas not found');
        return;
    }

    const monthlyCtx = monthlyCanvas.getContext('2d');
    const monthlyStatsData = @json($monthlyStats ?? collect());
    console.log('Monthly stats data:', monthlyStatsData);
    const monthlyLabels = [];
    const monthlyValues = [];

    // Process monthly data
    Object.keys(monthlyStatsData).forEach(function(month) {
        try {
            const date = new Date(month + '-01');
            const monthName = date.toLocaleDateString('id-ID', { year: 'numeric', month: 'short' });
            monthlyLabels.push(monthName);
            monthlyValues.push(monthlyStatsData[month]);
        } catch (e) {
            console.log('Error parsing month:', month);
        }
    });

    if (monthlyLabels.length > 0) {
        console.log('Creating monthly chart with labels:', monthlyLabels, 'values:', monthlyValues);
        try {
            const monthlyChart = new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: monthlyValues,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#007bff',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Trend Peminjaman Bulanan',
                            font: { size: 14 }
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
            console.log('Monthly chart created successfully');
        } catch (error) {
            console.error('Error creating monthly chart:', error);
            showMonthlyChartError(error.message);
        }
    } else {
        console.log('No monthly data available');
        showMonthlyChartEmpty();
    }
}

function showMonthlyChartEmpty() {
    const monthlyCanvas = document.getElementById('monthlyChart');
    if (monthlyCanvas) {
        monthlyCanvas.parentNode.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-chart-line fa-3x text-muted mb-2"></i>
                <br><span class="text-muted">Tidak ada data trend bulanan</span>
                <br><small class="text-muted">Silakan ubah filter atau periode</small>
            </div>
        `;
    }
}

function showMonthlyChartError(message) {
    const monthlyCanvas = document.getElementById('monthlyChart');
    if (monthlyCanvas) {
        monthlyCanvas.parentNode.innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-2"></i>
                <br><span class="text-muted">Error: ${message}</span>
                <br><button class="btn btn-sm btn-secondary mt-2" onclick="location.reload()">
                    <i class="fas fa-refresh mr-1"></i>Coba Lagi
                </button>
            </div>
        `;
    }
}

function exportData() {
    // Get current filter parameters
    const params = new URLSearchParams();
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);

    for (let [key, value] of formData.entries()) {
        if (value) {
            params.append(key, value);
        }
    }

    // Navigate to export URL
    window.location.href = `{{ route('admin.reports.bookings.export') }}?${params.toString()}`;
}
</script>
@stop
