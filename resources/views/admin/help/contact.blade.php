@extends('adminlte::page')

@section('title', 'Informasi Kontak')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-phone mr-2"></i>Informasi Kontak</h1>
        <a href="{{ route('admin.help.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>
@endsection

@section('content')
    <!-- Contact Information -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-cog mr-2"></i>Administrator Sistem
                    </h3>
                </div>
                <div class="card-body">
                    @foreach($contacts['admin'] as $admin)
                        <div class="media mb-3">
                            <img src="{{ $admin['avatar'] }}" alt="Avatar" class="img-circle img-size-50 mr-3">
                            <div class="media-body">
                                <h6 class="mt-0 mb-1">{{ $admin['name'] }}</h6>
                                <p class="text-muted mb-1">{{ $admin['position'] }}</p>
                                <p class="mb-1">
                                    <i class="fas fa-phone text-primary mr-2"></i>{{ $admin['phone'] }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-envelope text-info mr-2"></i>{{ $admin['email'] }}
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-building text-success mr-2"></i>{{ $admin['office'] }}
                                </p>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-headset mr-2"></i>Tim Support
                    </h3>
                </div>
                <div class="card-body">
                    @foreach($contacts['support'] as $support)
                        <div class="media mb-3">
                            <img src="{{ $support['avatar'] }}" alt="Avatar" class="img-circle img-size-50 mr-3">
                            <div class="media-body">
                                <h6 class="mt-0 mb-1">{{ $support['name'] }}</h6>
                                <p class="text-muted mb-1">{{ $support['position'] }}</p>
                                <p class="mb-1">
                                    <i class="fas fa-phone text-primary mr-2"></i>{{ $support['phone'] }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-envelope text-info mr-2"></i>{{ $support['email'] }}
                                </p>
                                <p class="mb-0">
                                    <small class="text-muted">{{ $support['availability'] }}</small>
                                </p>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Contact Methods -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-comments mr-2"></i>Cara Menghubungi Kami
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-phone"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Telepon</span>
                            <span class="info-box-number">{{ $quickContact['phone'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fab fa-whatsapp"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">WhatsApp</span>
                            <span class="info-box-number">{{ $quickContact['whatsapp'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-envelope"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Email</span>
                            <span class="info-box-number" style="font-size: 14px;">{{ $quickContact['email'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Darurat</span>
                            <span class="info-box-number">{{ $quickContact['emergency'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Office Location -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt mr-2"></i>Lokasi Kantor
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h6><i class="fas fa-building text-primary mr-2"></i>{{ $officeInfo['name'] }}</h6>
                            <p class="text-muted mb-2">{{ $officeInfo['address'] }}</p>
                            <p class="mb-1">
                                <i class="fas fa-phone text-success mr-2"></i>
                                <strong>Telepon:</strong> {{ $officeInfo['phone'] }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-fax text-info mr-2"></i>
                                <strong>Fax:</strong> {{ $officeInfo['fax'] }}
                            </p>
                            <p class="mb-3">
                                <i class="fas fa-globe text-warning mr-2"></i>
                                <strong>Website:</strong> <a href="{{ $officeInfo['website'] }}" target="_blank">{{ $officeInfo['website'] }}</a>
                            </p>
                            
                            <h6><i class="fas fa-clock text-primary mr-2"></i>Jam Operasional:</h6>
                            <ul class="list-unstyled">
                                @foreach($officeInfo['hours'] as $day => $hours)
                                    <li>
                                        <strong>{{ $day }}:</strong> {{ $hours }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan
                    </h3>
                </div>
                <div class="card-body">
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="senderName">Nama Lengkap:</label>
                            <input type="text" class="form-control" id="senderName" required>
                        </div>
                        <div class="form-group">
                            <label for="senderNip">NIP:</label>
                            <input type="text" class="form-control" id="senderNip" maxlength="18" required>
                        </div>
                        <div class="form-group">
                            <label for="senderPhone">Nomor Telepon:</label>
                            <input type="tel" class="form-control" id="senderPhone" required>
                        </div>
                        <div class="form-group">
                            <label for="messageSubject">Subjek:</label>
                            <select class="form-control" id="messageSubject" required>
                                <option value="">Pilih Subjek</option>
                                <option value="technical">Masalah Teknis</option>
                                <option value="account">Masalah Akun</option>
                                <option value="booking">Masalah Peminjaman</option>
                                <option value="feature">Saran Fitur</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="messageContent">Pesan:</label>
                            <textarea class="form-control" id="messageContent" rows="5" 
                                      placeholder="Deskripsikan masalah atau pertanyaan Anda dengan detail" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="messagePriority">Prioritas:</label>
                            <select class="form-control" id="messagePriority">
                                <option value="low">Rendah</option>
                                <option value="normal" selected>Normal</option>
                                <option value="high">Tinggi</option>
                                <option value="urgent">Mendesak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-paper-plane mr-1"></i>Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Department Contacts -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-sitemap mr-2"></i>Kontak Bidang/Unit
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($departments as $dept)
                    <div class="col-md-4 mb-3">
                        <div class="card card-outline card-secondary">
                            <div class="card-header">
                                <h6 class="card-title mb-0">{{ $dept['name'] }}</h6>
                            </div>
                            <div class="card-body p-3">
                                <p class="mb-1">
                                    <i class="fas fa-user text-primary mr-2"></i>
                                    <strong>{{ $dept['head'] }}</strong>
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-phone text-success mr-2"></i>{{ $dept['phone'] }}
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-map-marker-alt text-danger mr-2"></i>{{ $dept['location'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Response Time Info -->
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-clock mr-2"></i>Waktu Respon
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="text-success">
                        <i class="fas fa-bolt fa-2x mb-2"></i>
                        <h6>Mendesak</h6>
                        <p class="text-muted">< 2 Jam</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="text-warning">
                        <i class="fas fa-rocket fa-2x mb-2"></i>
                        <h6>Tinggi</h6>
                        <p class="text-muted">< 4 Jam</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="text-info">
                        <i class="fas fa-clock fa-2x mb-2"></i>
                        <h6>Normal</h6>
                        <p class="text-muted">< 24 Jam</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="text-secondary">
                        <i class="fas fa-calendar fa-2x mb-2"></i>
                        <h6>Rendah</h6>
                        <p class="text-muted">< 3 Hari</p>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info mt-3">
                <h6><i class="fas fa-info-circle mr-2"></i>Catatan:</h6>
                <ul class="mb-0">
                    <li>Waktu respon dihitung pada jam kerja (Senin-Jumat, 08:00-16:00)</li>
                    <li>Untuk masalah darurat di luar jam kerja, hubungi nomor emergency</li>
                    <li>Pesan yang dikirim pada hari libur akan diproses pada hari kerja berikutnya</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('css')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('js')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Contact form submission
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        const name = $('#senderName').val();
        const nip = $('#senderNip').val();
        const phone = $('#senderPhone').val();
        const subject = $('#messageSubject').val();
        const message = $('#messageContent').val();
        
        if (!name || !nip || !phone || !subject || !message) {
            Swal.fire('Error', 'Semua field wajib diisi!', 'error');
            return;
        }
        
        // Validate NIP
        if (nip.length !== 18 || !/^\d+$/.test(nip)) {
            Swal.fire('Error', 'NIP harus 18 digit angka!', 'error');
            return;
        }
        
        // Show loading
        Swal.fire({
            title: 'Mengirim Pesan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Simulate sending message
        setTimeout(() => {
            Swal.fire({
                title: 'Pesan Terkirim!',
                text: 'Pesan Anda telah dikirim. Tim support akan menghubungi Anda sesuai dengan prioritas yang dipilih.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                $('#contactForm')[0].reset();
            });
        }, 2000);
    });
    
    // Auto-format NIP input
    $('#senderNip').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 18) {
            value = value.slice(0, 18);
        }
        $(this).val(value);
    });
    
    // Auto-format phone input
    $('#senderPhone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        $(this).val(value);
    });
    
    // Quick contact click handlers
    $('.info-box').on('click', function() {
        const type = $(this).find('.info-box-text').text().toLowerCase();
        const number = $(this).find('.info-box-number').text();
        
        if (type.includes('whatsapp')) {
            window.open(`https://wa.me/${number.replace(/\D/g, '')}`, '_blank');
        } else if (type.includes('email')) {
            window.location.href = `mailto:${number}`;
        } else if (type.includes('telepon') || type.includes('darurat')) {
            window.location.href = `tel:${number}`;
        }
    });
});
</script>
@endsection
