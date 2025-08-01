@extends('adminlte::page')

@section('title', 'Test Charts')

@section('content_header')
    <h1>Test Charts</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Usage Chart</h3>
                </div>
                <div class="card-body">
                    <canvas id="roomChart" style="height: 300px;"></canvas>
                    <div id="roomDebug"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Monthly Trend Chart</h3>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" style="height: 300px;"></canvas>
                    <div id="monthlyDebug"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>

<script>
$(document).ready(function() {
    console.log('Document ready');
    console.log('Chart.js available:', typeof Chart !== 'undefined');

    if (typeof Chart !== 'undefined') {
        console.log('Chart.js version:', Chart.version);

        // Room Stats from controller
        const roomStatsData = @json($roomStats ?? collect());
        console.log('Room stats from controller:', roomStatsData);
        document.getElementById('roomDebug').innerHTML = '<pre>' + JSON.stringify(roomStatsData, null, 2) + '</pre>';

        // Monthly Stats from controller
        const monthlyStatsData = @json($monthlyStats ?? collect());
        console.log('Monthly stats from controller:', monthlyStatsData);
        document.getElementById('monthlyDebug').innerHTML = '<pre>' + JSON.stringify(monthlyStatsData, null, 2) + '</pre>';

        // Create Room Chart
        const roomCtx = document.getElementById('roomChart').getContext('2d');
        const roomLabels = Object.keys(roomStatsData);
        const roomValues = Object.values(roomStatsData);

        if (roomLabels.length > 0) {
            const roomChart = new Chart(roomCtx, {
                type: 'doughnut',
                data: {
                    labels: roomLabels,
                    datasets: [{
                        data: roomValues,
                        backgroundColor: [
                            '#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1',
                            '#fd7e14', '#20c997', '#6c757d', '#e83e8c', '#17a2b8'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
            console.log('Room chart created');
        } else {
            document.getElementById('roomChart').parentNode.innerHTML = '<p>No room data available</p>';
        }

        // Create Monthly Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyLabels = [];
        const monthlyValues = [];

        Object.keys(monthlyStatsData).forEach(function(month) {
            const date = new Date(month + '-01');
            const monthName = date.toLocaleDateString('id-ID', { year: 'numeric', month: 'short' });
            monthlyLabels.push(monthName);
            monthlyValues.push(monthlyStatsData[month]);
        });

        if (monthlyLabels.length > 0) {
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
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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
            console.log('Monthly chart created');
        } else {
            document.getElementById('monthlyChart').parentNode.innerHTML = '<p>No monthly data available</p>';
        }

    } else {
        console.error('Chart.js not loaded');
        document.getElementById('roomDebug').innerHTML = '<p style="color: red;">Chart.js not loaded</p>';
        document.getElementById('monthlyDebug').innerHTML = '<p style="color: red;">Chart.js not loaded</p>';
    }
});
</script>
@stop
