<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Dashboard - {{ $monthName }} {{ $year }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }

        .header .subtitle {
            color: #6c757d;
            font-size: 14px;
            margin: 5px 0;
        }

        .stats-section {
            margin-bottom: 30px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stats-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }

        .stats-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            display: block;
        }

        .stats-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        .section-title {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            margin: 20px 0 10px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .data-table th {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }

        .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .ranking-badge {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            color: white;
            text-align: center;
            line-height: 20px;
            font-weight: bold;
            font-size: 10px;
        }

        .rank-1 { background-color: #FFD700; }
        .rank-2 { background-color: #C0C0C0; }
        .rank-3 { background-color: #CD7F32; }
        .rank-other { background-color: #6c757d; }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }

        .two-column {
            display: table;
            width: 100%;
        }

        .column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 10px;
        }

        .column:first-child {
            padding-left: 0;
        }

        .column:last-child {
            padding-right: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAP DASHBOARD PEMINJAMAN RUANG</h1>
        <div class="subtitle">Periode: {{ $monthName }} {{ $year }}</div>
        <div class="subtitle">Generated: {{ $generated_at }}</div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-section">
        <div class="section-title">📊 RINGKASAN STATISTIK</div>
        <div class="stats-grid">
            <div class="stats-item">
                <span class="stats-number">{{ $statistics['total'] }}</span>
                <div class="stats-label">Total Peminjaman</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $statistics['approved'] }}</span>
                <div class="stats-label">Disetujui</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $statistics['pending'] }}</span>
                <div class="stats-label">Menunggu</div>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $statistics['rejected'] }}</span>
                <div class="stats-label">Ditolak</div>
            </div>
        </div>
    </div>

    <div class="two-column">
        <!-- Top Rooms Section -->
        <div class="column">
            <div class="section-title">🏢 RUANG TERPOPULER</div>
            @if($topRooms->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">Rank</th>
                            <th>Nama Ruang</th>
                            <th style="width: 60px;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topRooms as $index => $roomData)
                            @php
                                $rankClass = match($index) {
                                    0 => 'rank-1',
                                    1 => 'rank-2',
                                    2 => 'rank-3',
                                    default => 'rank-other'
                                };
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    <span class="ranking-badge {{ $rankClass }}">{{ $index + 1 }}</span>
                                </td>
                                <td>{{ $roomData->room->name ?? 'N/A' }}</td>
                                <td style="text-align: center; font-weight: bold;">{{ $roomData->booking_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">
                    Tidak ada data peminjaman ruang untuk periode ini
                </div>
            @endif
        </div>

        <!-- Top Bidangs Section -->
        <div class="column">
            <div class="section-title">🏛️ BIDANG TERAKTIF</div>
            @if($topBidangs->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;">Rank</th>
                            <th>Nama Bidang</th>
                            <th style="width: 60px;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topBidangs as $index => $bidangData)
                            @php
                                $rankClass = match($index) {
                                    0 => 'rank-1',
                                    1 => 'rank-2',
                                    2 => 'rank-3',
                                    default => 'rank-other'
                                };
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    <span class="ranking-badge {{ $rankClass }}">{{ $index + 1 }}</span>
                                </td>
                                <td>{{ $bidangData->bidang->nama ?? 'N/A' }}</td>
                                <td style="text-align: center; font-weight: bold;">{{ $bidangData->booking_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">
                    Tidak ada data peminjaman bidang untuk periode ini
                </div>
            @endif
        </div>
    </div>

    <div class="footer">
        Aplikasi Peminjaman Ruang - Generated on {{ $generated_at }}
    </div>
</body>
</html>
