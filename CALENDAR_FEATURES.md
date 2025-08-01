# Kalender Peminjaman Ruang - Admin Dashboard

## 📅 Overview
Halaman kalender admin menyediakan tampilan visual yang komprehensif untuk semua peminjaman ruang dengan interface yang modern dan interaktif, menggunakan FullCalendar.js yang sama seperti di landing page.

## ✨ Fitur Utama

### 1. **Tampilan Kalender Modern**
- **Multiple Views**: Bulan, Minggu, Hari, dan List view
- **Responsive Design**: Optimal di desktop dan mobile
- **Color Coding**: Status peminjaman dengan warna yang berbeda
  - 🟢 **Hijau**: Approved (Disetujui)
  - 🟡 **Kuning**: Pending (Menunggu)
  - 🔴 **Merah**: Rejected (Ditolak)
  - ⚫ **Abu-abu**: Cancelled (Dibatalkan)

### 2. **Filter Advanced**
- **Filter Ruang**: Tampilkan peminjaman untuk ruang tertentu
- **Filter Bidang**: Tampilkan peminjaman dari bidang tertentu
- **Filter Status**: Tampilkan berdasarkan status peminjaman
- **Kombinasi Filter**: Gunakan multiple filter secara bersamaan
- **Reset Filter**: Kembali ke tampilan semua data

### 3. **Interaksi Event**
- **Click Event**: Klik untuk melihat detail lengkap
- **Hover Tooltip**: Informasi ringkas saat hover
- **Modal Detail**: Pop-up dengan informasi lengkap
- **Edit Direct**: Tombol edit langsung ke form

### 4. **Navigation & Control**
- **Date Navigation**: Previous/Next untuk navigasi bulan
- **Today Button**: Kembali ke hari ini
- **View Switcher**: Ganti tampilan (Month/Week/Day/List)
- **Refresh Button**: Update data manual
- **Auto Refresh**: Otomatis setiap 5 menit

### 5. **Keyboard Shortcuts**
- **Ctrl+R**: Refresh kalender
- **Ctrl+F**: Focus ke filter ruang

## 🎨 UI/UX Features

### **Modern Design**
- Gradient header dengan warna corporate
- Card-based layout dengan shadow effects
- Smooth animations dan transitions
- Professional color scheme

### **Event Display**
- Event title dengan font weight bold
- Nama ruang ditampilkan di bawah title
- Nama bidang dengan styling italic
- Progress bar untuk multiple events
- "More" link untuk event overflow

### **Responsive Layout**
- Mobile-first design
- Adaptive toolbar untuk mobile
- Touch-friendly controls
- Optimized untuk tablet

## 📊 Data & API

### **Real-time Data**
- Menggunakan API endpoint `/api/bookings-calendar`
- Support parameter filter (room_id, bidang_id, status)
- Date range filtering otomatis
- Error handling untuk connection issues

### **Data Structure**
```json
{
  "title": "Nama Kegiatan",
  "start": "2025-07-31T09:00:00",
  "end": "2025-07-31T11:00:00",
  "color": "#28a745",
  "extendedProps": {
    "booking_id": 1,
    "booking_code": "BK-20250731-0001",
    "room": "Ruang Meeting A",
    "bidang": "Bidang Pendidikan",
    "pic": "John Doe",
    "status": "approved",
    "participants_count": 25
  }
}
```

## 🔧 Technical Implementation

### **Frontend Stack**
- **FullCalendar v6.1.9**: Library kalender utama
- **Custom CSS**: Styling khusus untuk branding
- **Vanilla JavaScript**: Interaksi tanpa framework
- **Bootstrap 4**: UI components

### **Backend Integration**
- **Laravel API**: Endpoint untuk data kalender
- **Eloquent ORM**: Query optimization
- **Carbon**: Date/time manipulation
- **Response Caching**: Performance optimization

## 📋 File Structure

```
resources/views/admin/bookings/
├── calendar.blade.php          # Main calendar view

public/css/
├── calendar-custom.css         # Custom styling

public/js/
├── calendar-manager.js         # Interactive features

routes/
├── api.php                     # Calendar API endpoint
├── web.php                     # Calendar route

app/Http/Controllers/Admin/
├── BookingController.php       # Calendar method
```

## 🚀 Usage Guide

### **Akses Kalender**
```
URL: /admin/bookings/calendar
Method: GET
Auth: Required (Admin)
```

### **Filter Data**
1. Pilih filter yang diinginkan
2. Klik tombol "Filter"
3. Data akan di-refresh otomatis
4. Gunakan "Reset" untuk menghapus filter

### **View Event Detail**
1. Klik pada event di kalender
2. Modal akan muncul dengan detail lengkap
3. Klik "Edit" untuk modify booking
4. Tutup modal dengan tombol close

### **Navigation**
- **Prev/Next**: Navigasi bulan
- **Today**: Kembali ke hari ini
- **View Switch**: Ganti tampilan kalender
- **Refresh**: Update data manual

## ⚡ Performance Features

### **Optimization**
- Lazy loading untuk events
- API caching untuk response cepat
- Minimal DOM manipulation
- Efficient event rendering

### **Auto Refresh**
- Background refresh setiap 5 menit
- Notification untuk user feedback
- Error handling untuk network issues
- Graceful degradation

## 🎯 Benefits

### **For Admin**
- **Overview Complete**: Lihat semua booking dalam satu view
- **Filter Powerful**: Analisis data dengan filter advanced
- **Edit Quick**: Akses langsung ke form edit
- **Mobile Ready**: Akses dari smartphone/tablet

### **For User Experience**
- **Loading Fast**: Optimized untuk performa
- **Interaction Smooth**: Animations yang natural
- **Information Rich**: Detail lengkap dalam tooltip
- **Navigation Easy**: Intuitive controls

## 🔄 Integration

Kalender admin terintegrasi dengan:
- **Booking Management**: CRUD operations
- **User Authentication**: Access control
- **Room Management**: Filter ruang available
- **Bidang Management**: Filter berdasarkan bidang
- **Dashboard**: Link dari menu navigation

## 📱 Mobile Experience

- **Touch Gestures**: Swipe untuk navigasi
- **Responsive Table**: Mobile-optimized view
- **Compact Layout**: Hemat space di mobile
- **Touch Targets**: Button size optimal
- **Fast Loading**: Optimized untuk mobile network

Kalender admin ini memberikan experience yang sama dengan landing page namun dengan kontrol admin yang lengkap dan fitur management yang powerful! 🎉
