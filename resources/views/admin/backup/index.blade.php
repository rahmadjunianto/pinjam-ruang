@extends('adminlte::page')

@section('title', 'Backup Data')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-download mr-2"></i>Backup Data</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createBackupModal">
            <i class="fas fa-plus mr-1"></i>Buat Backup Baru
        </button>
    </div>
@endsection

@section('content')
    <!-- Quick Stats -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ count($backups) }}</h3>
                    <p>Total Backup</p>
                </div>
                <div class="icon">
                    <i class="fas fa-archive"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ count(array_filter($backups, fn($b) => strpos($b['type'], 'Database') !== false)) }}</h3>
                    <p>Database Backup</p>
                </div>
                <div class="icon">
                    <i class="fas fa-database"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ count(array_filter($backups, fn($b) => strpos($b['type'], 'Full') !== false)) }}</h3>
                    <p>Full Backup</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-archive"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $lastBackup ? \Carbon\Carbon::parse($lastBackup)->diffForHumans() : 'N/A' }}</h3>
                    <p>Backup Terakhir</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup List -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-2"></i>Daftar Backup
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @if(count($backups) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="backupTable">
                        <thead>
                            <tr>
                                <th>Nama File</th>
                                <th>Tipe</th>
                                <th>Ukuran</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($backups as $backup)
                                <tr>
                                    <td>
                                        <i class="fas {{ strpos($backup['type'], 'Database') !== false ? 'fa-database' : 'fa-file-archive' }} mr-2"></i>
                                        {{ $backup['name'] }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ strpos($backup['type'], 'Database') !== false ? 'success' : 'warning' }}">
                                            {{ $backup['type'] }}
                                        </span>
                                    </td>
                                    <td>{{ $backup['size'] }}</td>
                                    <td>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ \Carbon\Carbon::createFromTimestamp($backup['date'])->format('d/m/Y H:i:s') }}
                                        <br>
                                        <small class="text-muted">
                                            ({{ \Carbon\Carbon::createFromTimestamp($backup['date'])->diffForHumans() }})
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.backup.download', $backup['name']) }}" 
                                               class="btn btn-sm btn-success" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="deleteBackup('{{ $backup['name'] }}')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-archive fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada backup yang dibuat</h5>
                    <p class="text-muted">Klik tombol "Buat Backup Baru" untuk membuat backup pertama Anda.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Backup Guidelines -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-info-circle mr-2"></i>Panduan Backup
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-database text-success mr-2"></i>Database Backup:</h6>
                    <ul>
                        <li>Menyimpan semua data tabel (users, bookings, rooms, dll)</li>
                        <li>File berformat .sql</li>
                        <li>Ukuran file relatif kecil</li>
                        <li>Cocok untuk backup data rutin</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-file-archive text-warning mr-2"></i>Full Application Backup:</h6>
                    <ul>
                        <li>Menyertakan database + file aplikasi</li>
                        <li>File berformat .zip</li>
                        <li>Ukuran file lebih besar</li>
                        <li>Cocok untuk backup lengkap sistem</li>
                    </ul>
                </div>
            </div>
            
            <div class="alert alert-warning mt-3">
                <h6><i class="fas fa-exclamation-triangle mr-2"></i>Perhatian:</h6>
                <ul class="mb-0">
                    <li>Backup secara rutin untuk mencegah kehilangan data</li>
                    <li>Simpan backup di lokasi yang aman dan terpisah</li>
                    <li>Test restore backup secara berkala</li>
                    <li>Hapus backup lama yang tidak diperlukan untuk menghemat ruang</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

<!-- Create Backup Modal -->
<div class="modal fade" id="createBackupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fas fa-plus mr-2"></i>Buat Backup Baru
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="backupForm">
                    <div class="form-group">
                        <label for="backupType">Tipe Backup:</label>
                        <select class="form-control" id="backupType" name="type" required>
                            <option value="">Pilih Tipe Backup</option>
                            <option value="database">Database Only</option>
                            <option value="full">Full Application</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="backupDescription">Deskripsi (Opsional):</label>
                        <textarea class="form-control" id="backupDescription" name="description" 
                                  rows="3" placeholder="Contoh: Backup sebelum update sistem"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="createBackup()">
                    <i class="fas fa-download mr-1"></i>Buat Backup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBackupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fas fa-trash mr-2"></i>Konfirmasi Hapus
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus backup ini?</p>
                <p class="text-danger"><strong>Perhatian:</strong> File backup yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash mr-1"></i>Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
function createBackup() {
    const type = document.getElementById('backupType').value;
    if (!type) {
        Swal.fire('Error', 'Pilih tipe backup terlebih dahulu!', 'error');
        return;
    }

    // Show loading
    Swal.fire({
        title: 'Membuat Backup...',
        text: 'Mohon tunggu, proses backup sedang berlangsung.',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    // Create backup
    fetch(`{{ route('admin.backup.create') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            type: type,
            description: document.getElementById('backupDescription').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                location.reload();
            });
            $('#createBackupModal').modal('hide');
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error!', 'Terjadi kesalahan saat membuat backup.', 'error');
    });
}

function deleteBackup(fileName) {
    $('#deleteBackupModal').modal('show');
    document.getElementById('confirmDeleteBtn').onclick = function() {
        fetch(`{{ route('admin.backup.delete', '') }}/${fileName}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Berhasil!', data.message, 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error!', data.message, 'error');
            }
            $('#deleteBackupModal').modal('hide');
        })
        .catch(error => {
            Swal.fire('Error!', 'Terjadi kesalahan saat menghapus backup.', 'error');
            $('#deleteBackupModal').modal('hide');
        });
    };
}

// Initialize DataTable
$(document).ready(function() {
    $('#backupTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
        },
        order: [[3, 'desc']], // Sort by date descending
        columnDefs: [
            { orderable: false, targets: [4] } // Disable sorting on action column
        ]
    });
});
</script>
@endsection
