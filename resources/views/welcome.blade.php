<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Peminjaman Ruang - Kementerian Agama</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">

        <style>
            .bg-kemenag {
                background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
            }
            .text-gold {
                color: #ffd700;
            }
            .border-gold {
                border-color: #ffd700;
            }
            #calendar {
                height: 500px;
                overflow: hidden;
            }
            .fc-theme-standard .fc-scrollgrid {
                border-color: #ffd700;
            }
            .fc-col-header-cell {
                background-color: rgba(255, 215, 0, 0.3) !important;
                color: #1a5d1a !important;
                font-weight: bold !important;
            }
            .fc-event {
                font-size: 10px;
                border: none !important;
                color: white !important;
                font-weight: 500 !important;
                border-radius: 3px !important;
                margin: 1px !important;
                padding: 1px 3px !important;
            }
            .fc-daygrid-day {
                background-color: rgba(255, 255, 255, 0.95) !important;
            }
            .fc-daygrid-day-number {
                color: #1a5d1a !important;
                font-weight: 600 !important;
            }
            .fc-day-today {
                background-color: rgba(255, 215, 0, 0.2) !important;
            }
            .fc-toolbar {
                padding: 5px 0 !important;
            }
            .fc-toolbar-title {
                color: #1a5d1a !important;
                font-weight: bold !important;
                font-size: 1rem !important;
            }
            .fc-button {
                background-color: #2e7d32 !important;
                border-color: #2e7d32 !important;
                color: white !important;
                font-size: 12px !important;
                padding: 2px 8px !important;
            }
            .fc-button:hover {
                background-color: #1b5e20 !important;
                border-color: #1b5e20 !important;
            }
            .fc-button:disabled {
                background-color: #6c757d !important;
                border-color: #6c757d !important;
            }
            .fc-more-link {
                color: #2e7d32 !important;
                font-weight: bold !important;
            }
            .bidang-tooltip {
                position: absolute;
                background: rgba(46, 125, 50, 0.95);
                color: white;
                padding: 5px 8px;
                border-radius: 4px;
                font-size: 11px;
                z-index: 1000;
                max-width: 150px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.2s ease;
            }
            .bidang-tooltip.show {
                opacity: 1;
            }
            .fc-event-title {
                font-weight: 600 !important;
            }
            .fc-event-room {
                font-size: 9px !important;
                opacity: 0.9 !important;
                font-style: italic !important;
                color: rgba(255, 255, 255, 0.9) !important;
            }
            .fc-event-bidang {
                font-size: 9px !important;
                opacity: 0.9 !important;
                font-style: italic !important;
                color: rgba(255, 255, 255, 0.8) !important;
            }
        </style>
    </head>
    <body class="bg-light overflow-hidden">
        <div class="container-fluid p-0">
            <div class="row min-vh-100 g-0">
                <!-- Sidebar Info -->
                <div class="col-md-6 bg-kemenag d-flex align-items-center">
                    <div class="text-center text-white w-100 p-5">
                        <div class="mb-4">
                            <i class="fas fa-mosque fa-4x text-gold mb-3"></i>
                            <h1 class="h2 mb-3">Sistem Peminjaman Ruang</h1>
                            <h4 class="text-gold">Kementerian Agama RI</h4>
                        </div>

                        <div class="mt-5">
                            <div class="card bg-transparent border-gold">
                                <div class="card-body">
                                    <h5 class="card-title text-gold">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Kalender Peminjaman
                                    </h5>
                                    <div id="calendar" class="mt-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-6 d-flex align-items-center">
                    <div class="w-100 p-5">
                        <div class="text-center mb-5">
                            <i class="fas fa-door-open fa-3x text-success mb-3"></i>
                            <h2 class="mb-3">Selamat Datang</h2>
                            <p class="text-muted">Silakan login untuk mengakses sistem peminjaman ruang</p>
                        </div>

                        @if (Route::has('login'))
                            <div class="text-center">
                                @auth
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Anda sudah login sebagai <strong>{{ Auth::user()->name }}</strong>
                                    </div>
                                    <a href="{{ url('/dashboard') }}" class="btn btn-success btn-lg">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        Masuk ke Dashboard
                                    </a>
                                @else
                                    <div class="d-grid gap-3">
                                        <a href="{{ route('login') }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-sign-in-alt me-2"></i>
                                            Login
                                        </a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="btn btn-outline-success">
                                                <i class="fas fa-user-plus me-2"></i>
                                                Register
                                            </a>
                                        @endif
                                    </div>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- FullCalendar JS -->
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                if (calendarEl) {
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        height: 500,
                        aspectRatio: 1.35,
                        headerToolbar: {
                            left: 'prev,next',
                            center: 'title',
                            right: 'today'
                        },
                        buttonText: {
                            today: 'Hari Ini',
                            month: 'Bulan',
                            week: 'Minggu',
                            day: 'Hari',
                            list: 'List'
                        },
                        locale: 'id',
                        dayMaxEvents: 2,
                        moreLinkClick: 'popover',
                        fixedWeekCount: false,
                        showNonCurrentDates: false,
                        events: function(fetchInfo, successCallback, failureCallback) {
                            // Fetch real data from Laravel API
                            fetch('/api/bookings-calendar')
                                .then(response => response.json())
                                .then(data => {
                                    successCallback(data);
                                })
                                .catch(error => {
                                    console.log('Error fetching calendar data:', error);
                                    // Fallback to sample data
                                    successCallback([
                                        {
                                            title: 'Rapat Koordinasi',
                                            start: '{{ date("Y-m-d") }}',
                                            color: '#28a745',
                                            extendedProps: {
                                                room: 'Ruang Meeting A',
                                                bidang: 'Sekretariat',
                                                pic: 'Dr. Ahmad Sulaiman',
                                                status: 'approved',
                                                time: '09:00-11:00',
                                                participants_count: 15,
                                                description: 'Rapat koordinasi bulanan untuk evaluasi program kerja'
                                            }
                                        },
                                        {
                                            title: 'Workshop Pelatihan',
                                            start: '{{ date("Y-m-d", strtotime("+1 day")) }}',
                                            color: '#ffc107',
                                            extendedProps: {
                                                room: 'Ruang Workshop B',
                                                bidang: 'Bimas Islam',
                                                pic: 'Dra. Siti Fatimah',
                                                status: 'pending',
                                                time: '13:00-16:00',
                                                participants_count: 25,
                                                description: 'Workshop peningkatan kapasitas SDM'
                                            }
                                        },
                                        {
                                            title: 'Seminar Nasional',
                                            start: '{{ date("Y-m-d", strtotime("+3 days")) }}',
                                            end: '{{ date("Y-m-d", strtotime("+4 days")) }}',
                                            color: '#dc3545',
                                            extendedProps: {
                                                room: 'Aula Utama',
                                                bidang: 'Pendidikan Islam',
                                                pic: 'Prof. Dr. Muhammad Yusuf',
                                                status: 'approved',
                                                time: 'Full Day',
                                                participants_count: 200,
                                                description: 'Seminar nasional pendidikan Islam di era digital'
                                            }
                                        }
                                    ]);
                                });
                        },
                        eventDidMount: function(info) {
                            // Add room name to event display
                            if (info.event.extendedProps.room) {
                                const roomEl = document.createElement('div');
                                roomEl.className = 'fc-event-room';
                                roomEl.textContent = info.event.extendedProps.room;
                                if (info.el.querySelector('.fc-event-title-container')) {
                                    info.el.querySelector('.fc-event-title-container').appendChild(roomEl);
                                } else {
                                    info.el.appendChild(roomEl);
                                }
                            }

                            // Add bidang to event display
                            if (info.event.extendedProps.bidang) {
                                const bidangEl = document.createElement('div');
                                bidangEl.className = 'fc-event-bidang';
                                bidangEl.textContent = info.event.extendedProps.bidang;
                                if (info.el.querySelector('.fc-event-title-container')) {
                                    info.el.querySelector('.fc-event-title-container').appendChild(bidangEl);
                                } else {
                                    info.el.appendChild(bidangEl);
                                }
                            }

                            // Add tooltip on hover
                            info.el.addEventListener('mouseenter', function(e) {
                                showTooltip(e, info.event);
                            });

                            info.el.addEventListener('mouseleave', function() {
                                hideTooltip();
                            });
                        },
                        eventClick: function(info) {
                            showEventDetail(info.event);
                        },
                        eventDisplay: 'block',
                        displayEventTime: true,
                        eventTimeFormat: {
                            hour: '2-digit',
                            minute: '2-digit',
                            meridiem: false
                        }
                    });

                    calendar.render();
                }

                // Tooltip functions
                let tooltipEl = null;

                function showTooltip(e, event) {
                    hideTooltip();

                    const props = event.extendedProps;
                    let tooltipContent = '<strong>' + event.title + '</strong><br>';
                    tooltipContent += 'Ruang: ' + (props.room || 'N/A') + '<br>';
                    tooltipContent += 'Bidang: ' + (props.bidang || 'N/A') + '<br>';
                    tooltipContent += 'PIC: ' + (props.pic || 'N/A') + '<br>';
                    tooltipContent += 'Status: ' + (props.status || 'N/A') + '<br>';
                    tooltipContent += 'Waktu: ' + (props.time || 'N/A');

                    tooltipEl = document.createElement('div');
                    tooltipEl.className = 'bidang-tooltip';
                    tooltipEl.innerHTML = tooltipContent;
                    document.body.appendChild(tooltipEl);

                    // Position tooltip
                    const rect = e.target.getBoundingClientRect();
                    tooltipEl.style.left = (rect.left + window.scrollX + 10) + 'px';
                    tooltipEl.style.top = (rect.top + window.scrollY - 10) + 'px';

                    setTimeout(() => tooltipEl.classList.add('show'), 10);
                }

                function hideTooltip() {
                    if (tooltipEl) {
                        tooltipEl.remove();
                        tooltipEl = null;
                    }
                }

                function showEventDetail(event) {
                    const props = event.extendedProps;
                    let alertMessage = '🎯 Kegiatan: ' + event.title + '\n';
                    alertMessage += '🏢 Ruang: ' + (props.room || 'N/A') + '\n';
                    alertMessage += '🏛️ Bidang: ' + (props.bidang || 'N/A') + '\n';
                    alertMessage += '👤 PIC: ' + (props.pic || 'N/A') + '\n';
                    alertMessage += '📊 Status: ' + (props.status || 'N/A') + '\n';
                    alertMessage += '⏰ Waktu: ' + (props.time || 'N/A') + '\n';
                    alertMessage += '👥 Peserta: ' + (props.participants_count || 0) + ' orang\n';
                    if (props.description) {
                        alertMessage += '📝 Deskripsi: ' + props.description;
                    }
                    alert(alertMessage);
                }

                function getStatusColor(status) {
                    switch(status) {
                        case 'approved': return 'success';
                        case 'pending': return 'warning';
                        case 'rejected': return 'danger';
                        case 'cancelled': return 'secondary';
                        default: return 'secondary';
                    }
                }
            });
        </script>
    </body>
</html>
