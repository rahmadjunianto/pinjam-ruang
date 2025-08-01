/**
 * Dashboard Interactive Features
 */
class Dashboard {
    constructor() {
        this.init();
    }

    init() {
        this.setupFilterForm();
        this.setupAutoRefresh();
        this.setupTooltips();
        this.animateCounters();
    }

    setupFilterForm() {
        const form = document.querySelector('form[action*="dashboard"]');
        if (form) {
            const monthSelect = form.querySelector('#month');
            const yearSelect = form.querySelector('#year');

            if (monthSelect && yearSelect) {
                monthSelect.addEventListener('change', this.updateExportLink.bind(this));
                yearSelect.addEventListener('change', this.updateExportLink.bind(this));
            }
        }
    }

    updateExportLink() {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        const exportBtn = document.querySelector('a[href*="export-pdf"]');

        if (exportBtn) {
            const baseUrl = exportBtn.href.split('?')[0];
            exportBtn.href = `${baseUrl}?month=${month}&year=${year}`;
        }
    }

    setupAutoRefresh() {
        // Optional: Auto-refresh data every 5 minutes
        // setInterval(() => {
        //     this.refreshData();
        // }, 5 * 60 * 1000);
    }

    setupTooltips() {
        // Initialize Bootstrap tooltips if available
        if (typeof bootstrap !== 'undefined') {
            const tooltips = document.querySelectorAll('[data-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                new bootstrap.Tooltip(tooltip);
            });
        }
    }

    animateCounters() {
        const counters = document.querySelectorAll('.small-box .inner h3');

        counters.forEach(counter => {
            const target = parseInt(counter.textContent);
            let current = 0;
            const increment = target / 20;

            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    counter.textContent = Math.ceil(current);
                    setTimeout(updateCounter, 50);
                } else {
                    counter.textContent = target;
                }
            };

            updateCounter();
        });
    }

    refreshData() {
        const monthEl = document.getElementById('month');
        const yearEl = document.getElementById('year');
        const month = monthEl ? monthEl.value : new Date().getMonth() + 1;
        const year = yearEl ? yearEl.value : new Date().getFullYear();

        fetch('/admin/dashboard/rekap-data?month=' + month + '&year=' + year)
            .then(function(response) { return response.json(); })
            .then(function(data) {
                this.updateStatistics(data.statistics);
                this.updateCharts(data.topRooms, data.topBidangs);
            }.bind(this))
            .catch(function(error) {
                console.error('Error refreshing data:', error);
            });
    }

    updateStatistics(stats) {
        // Update statistics counters
        const statsElements = {
            total: document.querySelector('.stats-card.total .inner h3'),
            approved: document.querySelector('.stats-card.approved .inner h3'),
            pending: document.querySelector('.stats-card.pending .inner h3'),
            rejected: document.querySelector('.stats-card.rejected .inner h3')
        };

        Object.keys(statsElements).forEach(key => {
            if (statsElements[key] && stats[key] !== undefined) {
                statsElements[key].textContent = stats[key];
            }
        });
    }

    updateCharts(topRooms, topBidangs) {
        // Update Chart.js charts if they exist
        if (window.roomChart) {
            window.roomChart.data.labels = topRooms.slice(0, 5).map(function(item) {
                return item.room ? item.room.name : 'N/A';
            });
            window.roomChart.data.datasets[0].data = topRooms.slice(0, 5).map(function(item) {
                return item.booking_count;
            });
            window.roomChart.update();
        }

        if (window.bidangChart) {
            window.bidangChart.data.labels = topBidangs.slice(0, 5).map(function(item) {
                return item.bidang ? item.bidang.nama : 'N/A';
            });
            window.bidangChart.data.datasets[0].data = topBidangs.slice(0, 5).map(function(item) {
                return item.booking_count;
            });
            window.bidangChart.update();
        }
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new Dashboard();
});

// Export for global access
window.Dashboard = Dashboard;
