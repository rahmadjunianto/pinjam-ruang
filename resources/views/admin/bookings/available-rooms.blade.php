@extends('adminlte::page')

@section('title', 'Pilih Ruangan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-home mr-2"></i>Pilih Ruangan untuk Dipinjam</h1>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        @forelse($rooms as $room)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $room->name }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-home fa-3x text-muted"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $room->name }}</h5>

                        <div class="mb-2">
                            <span class="badge badge-{{ $room->roomCategory->name === 'Ruang Rapat' ? 'primary' : ($room->roomCategory->name === 'Aula' ? 'success' : 'info') }}">
                                {{ $room->roomCategory->name }}
                            </span>
                        </div>

                        <p class="card-text flex-grow-1">{{ $room->description ?: 'Tidak ada deskripsi' }}</p>

                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-users mr-1"></i>Kapasitas: {{ $room->capacity }} orang
                            </small>
                        </div>

                        @if($room->facilities)
                            <div class="mb-3">
                                <h6>Fasilitas:</h6>
                                <div class="d-flex flex-wrap">
                                    @foreach(explode(',', $room->facilities) as $facility)
                                        <span class="badge badge-light mr-1 mb-1">{{ trim($facility) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-auto">
                            <a href="{{ route('admin.bookings.create', ['room' => $room->id]) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-calendar-plus mr-1"></i>Pilih Ruangan Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5>Tidak Ada Ruangan Tersedia</h5>
                    <p>Saat ini tidak ada ruangan yang tersedia untuk dipinjam.</p>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@section('css')
<style>
.card {
    transition: transform 0.2s;
    border: 1px solid #dee2e6;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.badge {
    font-size: 0.8em;
}

.card-img-top {
    border-radius: 0.25rem 0.25rem 0 0;
}
</style>
@endsection
