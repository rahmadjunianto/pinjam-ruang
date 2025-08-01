# 🏢 Aplikasi Peminjaman Ruang - Kementerian Agama

Aplikasi peminjaman ruang terintegrasi dengan template Kementerian Agama untuk mengelola peminjaman ruangan secara digital dan efisien.

## 📋 **Fitur Utama Aplikasi Peminjaman Ruang**

### 🏠 **Manajemen Ruangan**
- **CRUD Ruangan**: Tambah, edit, hapus, dan lihat detail ruangan
- **Kategori Ruangan**: Klasifikasi ruangan (Rapat, Aula, Kelas, Lab, Musholla)
- **Status Ruangan**: Available, Maintenance, Unavailable
- **Kapasitas & Fasilitas**: Detail kapasitas dan fasilitas tiap ruangan
- **Upload Foto**: Gambar ruangan untuk referensi visual
- **Harga per Jam**: Opsional untuk ruangan berbayar

### 📅 **Sistem Peminjaman**
- **Booking Online**: Peminjaman ruangan secara digital
- **Approval Workflow**: Sistem persetujuan bertingkat
- **Kalender Peminjaman**: Visualisasi jadwal peminjaman
- **Cek Ketersediaan**: Real-time availability check
- **Kode Booking Otomatis**: Sistem kode unik untuk setiap booking
- **Email Notification**: Notifikasi otomatis (opsional)

### 👥 **Manajemen User & Approval**
- **Multi-level Approval**: Admin dapat approve/reject booking
- **User Booking History**: Riwayat peminjaman user
- **Contact Person**: Data PIC untuk setiap booking
- **Status Tracking**: Pending, Approved, Rejected, Completed, Cancelled

### 📊 **Pelaporan & Monitoring**
- **Dashboard Statistics**: Statistik real-time penggunaan ruangan
- **Laporan Peminjaman**: Report harian, bulanan, tahunan
- **Usage Analytics**: Analisis tingkat okupansi ruangan
- **Export Data**: Excel/PDF export untuk laporan

## 🗃️ **Database Schema**

### **Tabel: room_categories**
```sql
- id (Primary Key)
- name (varchar) - Nama kategori
- description (text) - Deskripsi kategori
- color (varchar) - Warna hex untuk display
- icon (varchar) - FontAwesome icon class
- is_active (boolean) - Status aktif
- created_at, updated_at
```

### **Tabel: rooms**
```sql
- id (Primary Key)
- name (varchar) - Nama ruangan
- code (varchar, unique) - Kode ruangan
- description (text) - Deskripsi ruangan
- room_category_id (Foreign Key) - Kategori ruangan
- capacity (integer) - Kapasitas maksimal
- location (varchar) - Lokasi fisik
- floor (varchar) - Lantai
- facilities (json) - Array fasilitas
- image (varchar) - Path foto ruangan
- status (enum) - available, maintenance, unavailable
- price_per_hour (decimal) - Harga per jam
- notes (text) - Catatan tambahan
- is_active (boolean) - Status aktif
- created_at, updated_at
```

### **Tabel: bookings**
```sql
- id (Primary Key)
- booking_code (varchar, unique) - Kode booking otomatis
- room_id (Foreign Key) - ID ruangan
- user_id (Foreign Key) - ID user peminjam
- title (varchar) - Judul acara/kegiatan
- description (text) - Deskripsi acara
- contact_person (varchar) - Nama PIC
- contact_phone (varchar) - No. telepon PIC
- contact_email (varchar) - Email PIC
- booking_date (date) - Tanggal peminjaman
- start_time (time) - Jam mulai
- end_time (time) - Jam selesai
- participants_count (integer) - Jumlah peserta
- equipment_needed (text) - Peralatan yang dibutuhkan
- status (enum) - pending, approved, rejected, completed, cancelled
- total_cost (decimal) - Total biaya
- approval_notes (text) - Catatan persetujuan
- approved_at (timestamp) - Waktu approve
- approved_by (Foreign Key) - User yang approve
- rejection_reason (text) - Alasan penolakan
- created_at, updated_at
```

## 🎨 **Model & Relationships**

### **RoomCategory Model**
```php
- hasMany(Room::class)
- scopeActive()
```

### **Room Model**
```php
- belongsTo(RoomCategory::class)
- hasMany(Booking::class)
- scopeActive()
- scopeAvailable()
- isAvailableAt($date, $startTime, $endTime)
- getFacilitiesStringAttribute()
- getStatusBadgeAttribute()
```

### **Booking Model**
```php
- belongsTo(Room::class)
- belongsTo(User::class) - Peminjam
- belongsTo(User::class, 'approved_by') - Approver
- scopePending()
- scopeApproved()
- scopeToday()
- scopeUpcoming()
- generateBookingCode()
- getDurationAttribute()
- canBeCancelled()
- canBeEdited()
```

## 🛠️ **Controllers Structure**

### **RoomController**
```php
- index() - List ruangan dengan filter
- create() - Form tambah ruangan
- store() - Simpan ruangan baru
- show() - Detail ruangan + booking history
- edit() - Form edit ruangan
- update() - Update ruangan
- destroy() - Hapus ruangan
- checkAvailability() - Cek ketersediaan ruangan
```

### **BookingController**
```php
- index() - List booking dengan filter
- create() - Form booking baru
- store() - Simpan booking baru
- show() - Detail booking
- edit() - Form edit booking
- update() - Update booking
- destroy() - Hapus booking
- approve() - Approve booking
- reject() - Reject booking
- cancel() - Cancel booking
- calendar() - Kalender view
```

### **RoomCategoryController**
```php
- index() - List kategori ruangan
- create() - Form tambah kategori
- store() - Simpan kategori baru
- show() - Detail kategori
- edit() - Form edit kategori
- update() - Update kategori
- destroy() - Hapus kategori
```

## 🌐 **Routes Structure**

### **Admin Routes (Prefix: admin/)**
```php
// Resource Routes
Route::resource('rooms', RoomController::class);
Route::resource('bookings', BookingController::class);
Route::resource('room-categories', RoomCategoryController::class);

// Additional Booking Routes
Route::patch('bookings/{booking}/approve', 'approve');
Route::patch('bookings/{booking}/reject', 'reject');
Route::patch('bookings/{booking}/cancel', 'cancel');
Route::get('bookings/calendar', 'calendar');

// Room Availability
Route::get('rooms/{room}/availability', 'checkAvailability');
```

## 📱 **Views Structure**

### **Rooms Views**
- `admin/rooms/index.blade.php` - List ruangan dengan filter & search
- `admin/rooms/create.blade.php` - Form tambah ruangan
- `admin/rooms/edit.blade.php` - Form edit ruangan
- `admin/rooms/show.blade.php` - Detail ruangan + booking history

### **Bookings Views**
- `admin/bookings/index.blade.php` - List booking dengan filter
- `admin/bookings/create.blade.php` - Form booking baru
- `admin/bookings/edit.blade.php` - Form edit booking
- `admin/bookings/show.blade.php` - Detail booking
- `admin/bookings/calendar.blade.php` - Kalender peminjaman

### **Room Categories Views**
- `admin/room-categories/index.blade.php` - List kategori
- `admin/room-categories/create.blade.php` - Form tambah kategori
- `admin/room-categories/edit.blade.php` - Form edit kategori

## 🔧 **Features yang Sudah Dibuat**

✅ **Database Schema & Migration**
- Migration untuk room_categories, rooms, bookings
- Foreign key relationships
- Indexes untuk performa

✅ **Models dengan Relationships**
- Room, RoomCategory, Booking models
- Eloquent relationships
- Accessors & Scopes
- Business logic methods

✅ **Seeder Data Sample**
- 5 kategori ruangan default
- 7 ruangan sample dengan fasilitas
- 2 booking sample

✅ **Controllers**
- RoomController dengan full CRUD
- Validation rules
- File upload handling
- Error handling

✅ **Routes Configuration**
- Resource routes
- Additional booking routes
- Middleware protection

✅ **Menu Integration**
- Menu peminjaman ruang di sidebar
- Sub-menu untuk rooms, categories, bookings
- Kalender dan laporan

✅ **Views - Room Index**
- Responsive table dengan filter
- Search functionality
- Status badges dengan warna
- Statistics cards
- CRUD actions dengan confirmasi

## 🚀 **Langkah Selanjutnya**

### **Yang Perlu Dikembangkan:**

1. **Booking Views**
   - Form booking dengan date/time picker
   - Approval interface untuk admin
   - Calendar view dengan FullCalendar.js
   - Email notifications

2. **Advanced Features**
   - Recurring bookings
   - Equipment management
   - QR code untuk check-in
   - Integration dengan Google Calendar

3. **Reports & Analytics**
   - Usage statistics
   - Export to PDF/Excel
   - Occupancy rate analytics
   - Cost analysis

4. **User Experience**
   - Real-time availability check
   - Mobile-responsive design
   - Push notifications
   - Booking reminders

## 📧 **Sample Data yang Sudah Ada**

### **Kategori Ruangan:**
1. Ruang Rapat (🟢 hijau)
2. Aula (🔵 biru)
3. Ruang Kelas (🟡 kuning)
4. Laboratorium (🔴 merah)
5. Musholla (🟣 ungu)

### **Ruangan Sample:**
1. Ruang Rapat Utama (50 orang)
2. Ruang Rapat Kecil (15 orang)
3. Aula Serbaguna (300 orang)
4. Ruang Kelas A & B (40 & 25 orang)
5. Lab Komputer (30 orang)
6. Musholla At-Taqwa (100 orang)

## 💡 **Best Practices**

- **Security**: Form validation, CSRF protection, authorization
- **Performance**: Eager loading, pagination, indexing
- **UX**: Responsive design, loading states, confirmations
- **Code Quality**: PSR standards, comments, clean architecture
- **Testing**: Unit tests untuk models & controllers

---

**Aplikasi ini siap untuk dikembangkan lebih lanjut sesuai kebutuhan spesifik Kementerian Agama RI.**
