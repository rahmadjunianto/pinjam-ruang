@extends('adminlte::page')

@section('title', 'Informasi Sistem')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-server mr-2"></i>Informasi Sistem</h1>
        <a href="{{ route('admin.help.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>
@endsection

@section('content')
    <!-- System Overview -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Aplikasi
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nama Aplikasi:</strong></td>
                            <td>{{ $systemInfo['app_name'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Versi:</strong></td>
                            <td>{{ $systemInfo['version'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Environment:</strong></td>
                            <td>
                                <span class="badge badge-{{ $systemInfo['environment'] === 'production' ? 'success' : 'warning' }}">
                                    {{ ucfirst($systemInfo['environment']) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Framework:</strong></td>
                            <td>{{ $systemInfo['framework'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Database:</strong></td>
                            <td>{{ $systemInfo['database'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Timezone:</strong></td>
                            <td>{{ $systemInfo['timezone'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Locale:</strong></td>
                            <td>{{ $systemInfo['locale'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs mr-2"></i>Konfigurasi Server
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>PHP Version:</strong></td>
                            <td>{{ $serverInfo['php_version'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Server Software:</strong></td>
                            <td>{{ $serverInfo['server_software'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Operating System:</strong></td>
                            <td>{{ $serverInfo['operating_system'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Memory Limit:</strong></td>
                            <td>{{ $serverInfo['memory_limit'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Max Upload Size:</strong></td>
                            <td>{{ $serverInfo['max_upload_size'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Max Execution Time:</strong></td>
                            <td>{{ $serverInfo['max_execution_time'] }}s</td>
                        </tr>
                        <tr>
                            <td><strong>Disk Free Space:</strong></td>
                            <td>{{ $serverInfo['disk_free_space'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $statistics['total_users'] }}</h3>
                    <p>Total Pengguna</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $statistics['total_rooms'] }}</h3>
                    <p>Total Ruangan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $statistics['total_bookings'] }}</h3>
                    <p>Total Peminjaman</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $statistics['active_sessions'] }}</h3>
                    <p>Sesi Aktif</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Features & Modules -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-puzzle-piece mr-2"></i>Fitur & Modul Sistem
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($features as $category => $categoryFeatures)
                    <div class="col-md-6">
                        <h6 class="text-primary">
                            <i class="fas {{ $categoryFeatures['icon'] }} mr-2"></i>{{ $categoryFeatures['name'] }}
                        </h6>
                        <ul class="list-unstyled ml-3">
                            @foreach($categoryFeatures['items'] as $feature)
                                <li class="mb-1">
                                    <i class="fas fa-check text-success mr-2"></i>{{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- System Requirements -->
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-exclamation-triangle mr-2"></i>Persyaratan Sistem
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-desktop text-primary mr-2"></i>Browser yang Didukung:</h6>
                    <ul>
                        @foreach($requirements['browsers'] as $browser)
                            <li>{{ $browser }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-mobile-alt text-success mr-2"></i>Perangkat:</h6>
                    <ul>
                        @foreach($requirements['devices'] as $device)
                            <li>{{ $device }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-wifi text-info mr-2"></i>Koneksi Internet:</h6>
                    <ul>
                        @foreach($requirements['internet'] as $req)
                            <li>{{ $req }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-shield-alt text-warning mr-2"></i>Keamanan:</h6>
                    <ul>
                        @foreach($requirements['security'] as $sec)
                            <li>{{ $sec }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Log -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-history mr-2"></i>Riwayat Perubahan
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="timeline">
                @foreach($changelog as $log)
                    <div class="time-label">
                        <span class="bg-{{ $log['type'] === 'major' ? 'danger' : ($log['type'] === 'minor' ? 'warning' : 'success') }}">
                            {{ $log['date'] }}
                        </span>
                    </div>
                    <div>
                        <i class="fas {{ $log['icon'] }} bg-{{ $log['color'] }}"></i>
                        <div class="timeline-item">
                            <span class="time">
                                <i class="fas fa-clock"></i> {{ $log['time'] }}
                            </span>
                            <h3 class="timeline-header">
                                <strong>v{{ $log['version'] }}</strong> - {{ $log['title'] }}
                            </h3>
                            <div class="timeline-body">
                                {!! $log['description'] !!}
                                @if(isset($log['changes']))
                                    <ul class="mt-2">
                                        @foreach($log['changes'] as $change)
                                            <li>{{ $change }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- System Health Check -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-heartbeat mr-2"></i>Status Kesehatan Sistem
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-info" onclick="refreshHealthCheck()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row" id="healthCheckContainer">
                @foreach($healthCheck as $check)
                    <div class="col-md-3 mb-3">
                        <div class="info-box bg-{{ $check['status'] === 'ok' ? 'success' : ($check['status'] === 'warning' ? 'warning' : 'danger') }}">
                            <span class="info-box-icon">
                                <i class="fas {{ $check['icon'] }}"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ $check['name'] }}</span>
                                <span class="info-box-number">
                                    {{ $check['status'] === 'ok' ? 'OK' : ($check['status'] === 'warning' ? 'Warning' : 'Error') }}
                                </span>
                                @if(isset($check['details']))
                                    <span class="progress-description">{{ $check['details'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- License & Credits -->
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-certificate mr-2"></i>Lisensi & Credits
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-scroll text-primary mr-2"></i>Lisensi:</h6>
                    <p>{{ $license['type'] }} - {{ $license['description'] }}</p>
                    <p class="text-muted">© {{ $license['year'] }} {{ $license['holder'] }}</p>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-code text-success mr-2"></i>Teknologi yang Digunakan:</h6>
                    <div class="row">
                        @foreach($technologies as $tech)
                            <div class="col-6">
                                <small class="text-muted">{{ $tech['name'] }}</small><br>
                                <span class="badge badge-secondary">v{{ $tech['version'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <hr>

            <div class="text-center">
                <p class="text-muted mb-0">
                    Dikembangkan dengan ❤️ untuk Kementerian Agama Republik Indonesia
                </p>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
function refreshHealthCheck() {
    const container = $('#healthCheckContainer');

    // Show loading
    container.html(`
        <div class="col-12 text-center">
            <i class="fas fa-spinner fa-spin fa-2x text-info"></i>
            <p class="mt-2">Memeriksa status sistem...</p>
        </div>
    `);

    // Simulate health check
    setTimeout(() => {
        location.reload();
    }, 3000);
}

$(document).ready(function() {
    // Auto refresh every 5 minutes
    setInterval(function() {
        const lastRefresh = new Date();
        const refreshTime = lastRefresh.toLocaleTimeString();
        console.log('Auto-refreshing system info at', refreshTime);
    }, 300000); // 5 minutes
});
</script>
@endsection
