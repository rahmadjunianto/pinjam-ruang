@extends('adminlte::page')

@section('title', 'FAQ - Pertanyaan Umum')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-question-circle mr-2"></i>FAQ - Pertanyaan Umum</h1>
        <a href="{{ route('admin.help.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>
@endsection

@section('content')
    <!-- Search Box -->
    <div class="card">
        <div class="card-body">
            <div class="input-group">
                <input type="text" class="form-control" id="faqSearch" placeholder="Cari pertanyaan atau kata kunci...">
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Categories -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-outline-primary active">
                    <input type="radio" name="category" value="all" checked> Semua
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="category" value="login"> Login & Akses
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="category" value="booking"> Peminjaman
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="category" value="calendar"> Kalender
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="category" value="profile"> Profil
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="category" value="admin"> Administrator
                </label>
                <label class="btn btn-outline-primary">
                    <input type="radio" name="category" value="technical"> Teknis
                </label>
            </div>
        </div>
    </div>

    <!-- FAQ Content -->
    <div class="accordion" id="faqAccordion">
        @foreach($faqs as $index => $faq)
            <div class="card faq-item" data-category="{{ $faq['category'] }}">
                <div class="card-header" id="heading{{ $index }}">
                    <h6 class="mb-0">
                        <button class="btn btn-link text-left w-100" type="button" data-toggle="collapse" 
                                data-target="#collapse{{ $index }}" aria-expanded="false">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas {{ $faq['icon'] }} mr-2 text-{{ $faq['color'] }}"></i>
                                    {{ $faq['question'] }}
                                </span>
                                <span class="badge badge-{{ $faq['color'] }}">{{ $faq['category_name'] }}</span>
                            </div>
                        </button>
                    </h6>
                </div>
                <div id="collapse{{ $index }}" class="collapse" data-parent="#faqAccordion">
                    <div class="card-body">
                        {!! $faq['answer'] !!}
                        @if(isset($faq['related_links']))
                            <div class="mt-3">
                                <h6><i class="fas fa-link mr-2"></i>Link Terkait:</h6>
                                <ul>
                                    @foreach($faq['related_links'] as $link)
                                        <li><a href="{{ $link['url'] }}">{{ $link['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(isset($faq['helpful']))
                            <div class="mt-3 pt-3 border-top">
                                <small class="text-muted">Apakah jawaban ini membantu?</small>
                                <div class="btn-group btn-group-sm ml-2">
                                    <button class="btn btn-success btn-sm" onclick="markHelpful({{ $index }}, true)">
                                        <i class="fas fa-thumbs-up"></i> Ya
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="markHelpful({{ $index }}, false)">
                                        <i class="fas fa-thumbs-down"></i> Tidak
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- No Results Message -->
    <div class="card d-none" id="noResults">
        <div class="card-body text-center">
            <i class="fas fa-search fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">Tidak ada hasil yang ditemukan</h5>
            <p class="text-muted">Coba gunakan kata kunci yang berbeda atau hubungi administrator untuk bantuan lebih lanjut.</p>
            <a href="{{ route('admin.help.contact') }}" class="btn btn-primary">
                <i class="fas fa-phone mr-1"></i>Hubungi Admin
            </a>
        </div>
    </div>

    <!-- Still Need Help -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-hands-helping mr-2"></i>Masih Butuh Bantuan?
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-book fa-3x text-primary mb-3"></i>
                        <h6>Panduan Lengkap</h6>
                        <p class="text-muted">Baca panduan lengkap penggunaan sistem</p>
                        <a href="{{ route('admin.help.user-guide') }}" class="btn btn-primary">Buka Panduan</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-phone fa-3x text-success mb-3"></i>
                        <h6>Hubungi Admin</h6>
                        <p class="text-muted">Dapatkan bantuan langsung dari administrator</p>
                        <a href="{{ route('admin.help.contact') }}" class="btn btn-success">Kontak Admin</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-video fa-3x text-info mb-3"></i>
                        <h6>Video Tutorial</h6>
                        <p class="text-muted">Tonton video tutorial step-by-step</p>
                        <button class="btn btn-info" disabled>Segera Hadir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Suggest FAQ -->
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-lightbulb mr-2"></i>Saran Pertanyaan FAQ
            </h3>
        </div>
        <div class="card-body">
            <p>Punya pertanyaan yang tidak ada di FAQ? Kirimkan saran Anda!</p>
            <form id="suggestFaqForm">
                <div class="form-group">
                    <label for="suggestedQuestion">Pertanyaan yang Disarankan:</label>
                    <textarea class="form-control" id="suggestedQuestion" rows="3" 
                              placeholder="Tulis pertanyaan yang menurut Anda perlu ditambahkan ke FAQ"></textarea>
                </div>
                <div class="form-group">
                    <label for="questionCategory">Kategori:</label>
                    <select class="form-control" id="questionCategory">
                        <option value="">Pilih Kategori</option>
                        <option value="login">Login & Akses</option>
                        <option value="booking">Peminjaman</option>
                        <option value="calendar">Kalender</option>
                        <option value="profile">Profil</option>
                        <option value="admin">Administrator</option>
                        <option value="technical">Teknis</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-paper-plane mr-1"></i>Kirim Saran
                </button>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Search functionality
    $('#faqSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        let hasResults = false;
        
        $('.faq-item').each(function() {
            const question = $(this).find('button').text().toLowerCase();
            const answer = $(this).find('.card-body').text().toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                $(this).show();
                hasResults = true;
            } else {
                $(this).hide();
            }
        });
        
        // Show/hide no results message
        if (hasResults || searchTerm === '') {
            $('#noResults').addClass('d-none');
        } else {
            $('#noResults').removeClass('d-none');
        }
    });
    
    // Category filter
    $('input[name="category"]').on('change', function() {
        const selectedCategory = $(this).val();
        
        if (selectedCategory === 'all') {
            $('.faq-item').show();
        } else {
            $('.faq-item').each(function() {
                if ($(this).data('category') === selectedCategory) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        
        // Clear search when changing category
        $('#faqSearch').val('');
        $('#noResults').addClass('d-none');
    });
    
    // Suggest FAQ form
    $('#suggestFaqForm').on('submit', function(e) {
        e.preventDefault();
        
        const question = $('#suggestedQuestion').val();
        const category = $('#questionCategory').val();
        
        if (!question.trim()) {
            Swal.fire('Error', 'Silakan tulis pertanyaan terlebih dahulu!', 'error');
            return;
        }
        
        // Simulate sending suggestion
        Swal.fire({
            title: 'Terima Kasih!',
            text: 'Saran pertanyaan Anda telah dikirim dan akan direview oleh administrator.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            $('#suggestFaqForm')[0].reset();
        });
    });
});

// Mark helpful function
function markHelpful(index, isHelpful) {
    const message = isHelpful ? 
        'Terima kasih! Feedback Anda membantu kami meningkatkan FAQ.' : 
        'Terima kasih atas feedback Anda. Kami akan berusaha meningkatkan jawaban ini.';
    
    Swal.fire({
        title: 'Feedback Diterima',
        text: message,
        icon: 'success',
        timer: 3000,
        showConfirmButton: false
    });
}
</script>
@endsection
