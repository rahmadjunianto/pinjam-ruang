/**
 * Calendar Interactive Features
 */
class CalendarManager {
    constructor() {
        this.calendar = null;
        this.currentFilters = {
            room: '',
            bidang: '',
            status: ''
        };
        this.refreshInterval = null;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupAutoRefresh();
    }

    setupEventListeners() {
        // Filter events
        const applyBtn = document.getElementById('apply_filter');
        const resetBtn = document.getElementById('reset_filter');
        const refreshBtn = document.getElementById('refresh_calendar');

        if (applyBtn) {
            applyBtn.addEventListener('click', () => {
                this.applyFilters();
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                this.resetFilters();
            });
        }

        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => {
                this.refreshCalendar();
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'r':
                        e.preventDefault();
                        this.refreshCalendar();
                        break;
                    case 'f':
                        e.preventDefault();
                        const roomFilter = document.getElementById('room_filter');
                        if (roomFilter) roomFilter.focus();
                        break;
                }
            }
        });
    }

    setupAutoRefresh() {
        // Auto refresh every 5 minutes
        this.refreshInterval = setInterval(() => {
            if (this.calendar) {
                this.calendar.refetchEvents();
                this.showNotification('Calendar data refreshed', 'info');
            }
        }, 5 * 60 * 1000);
    }

    applyFilters() {
        this.currentFilters.room = document.getElementById('room_filter').value;
        this.currentFilters.bidang = document.getElementById('bidang_filter').value;
        this.currentFilters.status = document.getElementById('status_filter').value;

        if (this.calendar) {
            this.calendar.refetchEvents();
            this.showNotification('Filters applied', 'success');
        }
    }

    resetFilters() {
        document.getElementById('room_filter').value = '';
        document.getElementById('bidang_filter').value = '';
        document.getElementById('status_filter').value = '';
        this.currentFilters = { room: '', bidang: '', status: '' };

        if (this.calendar) {
            this.calendar.refetchEvents();
            this.showNotification('Filters reset', 'info');
        }
    }

    refreshCalendar() {
        if (this.calendar) {
            this.calendar.refetchEvents();
            this.showNotification('Calendar refreshed', 'success');
        }
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show notification-popup`;
        notification.innerHTML = `
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        `;

        // Add to page
        document.body.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 3000);
    }

    getCurrentFilters() {
        return this.currentFilters;
    }

    setCalendar(calendar) {
        this.calendar = calendar;
    }

    destroy() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
        }
    }
}

// Initialize calendar manager
window.calendarManager = new CalendarManager();

// Export for global access
window.CalendarManager = CalendarManager;
