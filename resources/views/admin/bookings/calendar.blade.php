@extends('adminlte::page')

@section('title', 'Kalender Peminjaman')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-calendar mr-2"></i>Kalender Peminjaman Ruang</h1>
        <div class="btn-group">
            <button type="button" id="refresh_calendar" class="btn btn-outline-primary" title="Refresh (Ctrl+R)">
                <i class="fas fa-sync-alt mr-1"></i>Refresh
            </button>
            <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i>Tambah Peminjaman
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Filter Section -->
    <div class="card mb-3 filter-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter mr-2"></i>Filter Kalender
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="room_filter"><i class="fas fa-home mr-1"></i>Filter Ruang:</label>
                    <select id="room_filter" class="form-control">
                        <option value="">Semua Ruang</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="bidang_filter"><i class="fas fa-building mr-1"></i>Filter Seksi:</label>
                    <select id="bidang_filter" class="form-control">
                        <option value="">Semua Seksi</option>
                        @foreach($bidangs as $bidang)
                            <option value="{{ $bidang->id }}">{{ $bidang->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status_filter"><i class="fas fa-info-circle mr-1"></i>Filter Status:</label>
                    <select id="status_filter" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" id="apply_filter" class="btn btn-primary mr-2">
                        <i class="fas fa-search mr-1"></i>Filter
                    </button>
                    <button type="button" id="reset_filter" class="btn btn-secondary">
                        <i class="fas fa-undo mr-1"></i>Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Section -->
    <div class="card calendar-container">
        <div class="card-body p-0">
            <div id="calendar" style="min-height: 600px;"></div>
        </div>
    </div>

    <!-- Legend -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-info-circle mr-2"></i>Keterangan Status
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="legend-box bg-success mr-2"></div>
                        <span>Disetujui</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="legend-box bg-warning mr-2"></div>
                        <span>Pending</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="legend-box bg-danger mr-2"></div>
                        <span>Ditolak</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="legend-box bg-secondary mr-2"></div>
                        <span>Dibatalkan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Detail Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="eventModalBody">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="editEventBtn">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/calendar-custom.css') }}">
@endsection

@section('js')
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script src="{{ asset('js/calendar-manager.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    aspectRatio: 1.8,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    buttonText: {
                        today: 'Hari Ini',
                        month: 'Bulan',
                        week: 'Minggu',
                        day: 'Hari',
                        list: 'List'
                    },
                    locale: 'id',
                    dayMaxEvents: 3,
                    moreLinkClick: 'popover',
                    fixedWeekCount: false,
                    showNonCurrentDates: false,
                    events: function(fetchInfo, successCallback, failureCallback) {
                        // Build query parameters
                        let params = new URLSearchParams();
                        params.append('start', fetchInfo.startStr);
                        params.append('end', fetchInfo.endStr);

                        const filters = window.calendarManager.getCurrentFilters();
                        if (filters.room) params.append('room_id', filters.room);
                        if (filters.bidang) params.append('bidang_id', filters.bidang);
                        if (filters.status) params.append('status', filters.status);

                        fetch('/api/bookings-calendar?' + params.toString())
                            .then(response => response.json())
                            .then(data => {
                                successCallback(data);
                            })
                            .catch(error => {
                                console.error('Error fetching calendar data:', error);
                                failureCallback(error);
                            });
                    },
                    eventDidMount: function(info) {
                        // Add room name to event display
                        if (info.event.extendedProps.room) {
                            const roomEl = document.createElement('div');
                            roomEl.className = 'fc-event-room';
                            roomEl.textContent = info.event.extendedProps.room;
                            info.el.querySelector('.fc-event-title-container').appendChild(roomEl);
                        }

                        // Add seksi to event display
                        if (info.event.extendedProps.bidang) {
                            const bidangEl = document.createElement('div');
                            bidangEl.className = 'fc-event-bidang';
                            bidangEl.textContent = info.event.extendedProps.bidang;
                            info.el.querySelector('.fc-event-title-container').appendChild(bidangEl);
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
                        showEventModal(info.event);
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

                // Set calendar reference for manager
                window.calendarManager.setCalendar(calendar);

                // Remove old filter functionality since it's now handled by manager
                // Filter functionality now handled by CalendarManager class
            }

            // Tooltip functions
            let tooltipEl = null;

            function showTooltip(e, event) {
                hideTooltip();

                const props = event.extendedProps;
                let tooltipContent = '<strong>' + event.title + '</strong><br>';
                tooltipContent += 'Ruang: ' + (props.room || 'N/A') + '<br>';
                tooltipContent += 'Seksi: ' + (props.bidang || 'N/A') + '<br>';
                tooltipContent += 'PIC: ' + (props.pic || 'N/A') + '<br>';
                tooltipContent += 'Status: ' + (props.status || 'N/A') + '<br>';
                tooltipContent += 'Waktu: ' + (props.time || 'N/A');

                tooltipEl = document.createElement('div');
                tooltipEl.className = 'tooltip-custom';
                tooltipEl.innerHTML = tooltipContent;
                document.body.appendChild(tooltipEl);

                // Position tooltip
                const rect = e.target.getBoundingClientRect();
                tooltipEl.style.left = (rect.left + window.scrollX + 10) + 'px';
                tooltipEl.style.top = (rect.top + window.scrollY - 10) + 'px';
            }

            function hideTooltip() {
                if (tooltipEl) {
                    document.body.removeChild(tooltipEl);
                    tooltipEl = null;
                }
            }

            function showEventModal(event) {
                const props = event.extendedProps;
                let modalContent = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-calendar-alt mr-2"></i>Informasi Peminjaman</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Kode Booking:</strong></td><td>${props.booking_code || 'N/A'}</td></tr>
                                <tr><td><strong>Judul Kegiatan:</strong></td><td>${event.title}</td></tr>
                                <tr><td><strong>Tanggal:</strong></td><td>${event.start ? event.start.toLocaleDateString('id-ID') : 'N/A'}</td></tr>
                                <tr><td><strong>Waktu:</strong></td><td>${props.time || 'N/A'}</td></tr>
                                <tr><td><strong>Status:</strong></td><td>
                                    <span class="badge badge-${getStatusColor(props.status)}">${props.status || 'N/A'}</span>
                                </td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-info-circle mr-2"></i>Detail Lainnya</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Ruang:</strong></td><td>${props.room || 'N/A'}</td></tr>
                                <tr><td><strong>Bidang:</strong></td><td>${props.bidang || 'N/A'}</td></tr>
                                <tr><td><strong>PIC:</strong></td><td>${props.pic || 'N/A'}</td></tr>
                                <tr><td><strong>Contact:</strong></td><td>${props.contact || 'N/A'}</td></tr>
                                <tr><td><strong>Peserta:</strong></td><td>${props.participants_count || 0} orang</td></tr>
                            </table>
                        </div>
                    </div>
                    ${props.description ? `
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6><i class="fas fa-align-left mr-2"></i>Deskripsi</h6>
                            <p>${props.description}</p>
                        </div>
                    </div>
                    ` : ''}
                `;

                document.getElementById('eventModalBody').innerHTML = modalContent;

                // Set edit button action
                document.getElementById('editEventBtn').onclick = function() {
                    if (props.booking_id) {
                        window.location.href = '/admin/bookings/' + props.booking_id + '/edit';
                    }
                };

                $('#eventModal').modal('show');
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
@endsection
