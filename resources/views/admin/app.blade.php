@extends('adminlte::page')

@section('title', $title ?? 'SIAKAD KEMENAG')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('page-title', 'Sistem Informasi Akademik')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                        @yield('breadcrumb')
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    {{-- Dynamic content with fade-in animation --}}
    <div class="fade-in">
        @yield('content')
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
    {{-- Google Fonts untuk konsistensi tampilan --}}
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    @stack('styles')
@stop

@section('js')
    <script>
        // Script untuk animasi dan interaktivitas
        $(document).ready(function() {
            // Tambahkan kelas fade-in untuk animasi
            $('.content-wrapper').addClass('fade-in');

            // Tooltip untuk semua elemen yang memiliki title
            $('[title]').tooltip();

            // Auto-hide alert setelah 5 detik
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Smooth scroll untuk anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });
        });
    </script>
    @stack('scripts')
@stop

@section('footer')
    <div class="float-right d-none d-sm-block">
        <strong>Versi 1.0</strong>
    </div>
    <strong>&copy; {{ date('Y') }} <a href="#">Kementerian Agama Republik Indonesia</a>.</strong>
    Semua hak dilindungi undang-undang.
@stop