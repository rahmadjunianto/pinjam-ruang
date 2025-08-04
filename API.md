# 🔌 API Documentation - SIAKAD KEMENAG

Dokumentasi lengkap API endpoints untuk Sistem Peminjaman Ruang SIAKAD KEMENAG.

## 📋 Base Information

- **Base URL**: `http://localhost:8000/api`
- **Content-Type**: `application/json`
- **Authentication**: Laravel Sanctum (Bearer Token)
- **Rate Limiting**: 60 requests per minute

## 🔐 Authentication

### Login
```http
POST /login
Content-Type: application/json

{
    "nip": "196001011980031001",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "token": "1|abc123...",
        "user": {
            "id": 1,
            "name": "Administrator",
            "nip": "196001011980031001",
            "role": "admin",
            "email": "admin@kemenag.go.id"
        }
    }
}
```

### Logout
```http
POST /logout
Authorization: Bearer {token}
```

## 🏢 Rooms API

### Get All Rooms
```http
GET /rooms
Authorization: Bearer {token}
```

**Query Parameters:**
- `active` (boolean): Filter by active status
- `category_id` (integer): Filter by category
- `search` (string): Search by name

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Aula Utama",
            "capacity": 100,
            "description": "Ruang serbaguna untuk acara besar",
            "is_active": true,
            "room_category": {
                "id": 1,
                "name": "Aula",
                "description": "Ruang aula besar"
            },
            "photos": [
                {
                    "id": 1,
                    "file_path": "/storage/rooms/aula-1.jpg",
                    "file_name": "aula-1.jpg"
                }
            ]
        }
    ],
    "meta": {
        "total": 10,
        "per_page": 15,
        "current_page": 1
    }
}
```

### Get Room Details
```http
GET /rooms/{id}
Authorization: Bearer {token}
```

### Check Room Availability
```http
GET /rooms/{id}/availability
Authorization: Bearer {token}
```

**Query Parameters:**
- `date` (required): Date in Y-m-d format
- `start_time` (optional): Start time in H:i format
- `end_time` (optional): End time in H:i format

**Response:**
```json
{
    "success": true,
    "data": {
        "room_id": 1,
        "date": "2025-08-04",
        "available": true,
        "existing_bookings": [
            {
                "start_time": "09:00",
                "end_time": "11:00",
                "title": "Rapat Koordinasi",
                "status": "approved"
            }
        ]
    }
}
```

## 📅 Bookings API

### Get User Bookings
```http
GET /bookings
Authorization: Bearer {token}
```

**Query Parameters:**
- `status` (string): pending|approved|rejected|cancelled
- `date_from` (date): Filter from date
- `date_to` (date): Filter to date
- `room_id` (integer): Filter by room

### Create Booking
```http
POST /bookings
Authorization: Bearer {token}
Content-Type: application/json

{
    "room_id": 1,
    "booking_date": "2025-08-04",
    "start_time": "09:00",
    "end_time": "11:00",
    "title": "Rapat Koordinasi",
    "description": "Rapat koordinasi tim bulanan",
    "bidang_id": 1,
    "contact_phone": "08123456789",
    "contact_email": "user@kemenag.go.id",
    "expected_attendees": 15
}
```

**Response:**
```json
{
    "success": true,
    "message": "Booking berhasil dibuat",
    "data": {
        "id": 123,
        "booking_code": "BK-20250804-001",
        "room_id": 1,
        "booking_date": "2025-08-04",
        "start_time": "09:00",
        "end_time": "11:00",
        "title": "Rapat Koordinasi",
        "status": "pending",
        "room": {
            "id": 1,
            "name": "Aula Utama"
        }
    }
}
```

### Get Booking Details
```http
GET /bookings/{id}
Authorization: Bearer {token}
```

### Cancel Booking
```http
PATCH /bookings/{id}/cancel
Authorization: Bearer {token}
Content-Type: application/json

{
    "cancel_reason": "Acara dibatalkan karena kondisi cuaca"
}
```

### Get Calendar Data
```http
GET /bookings/calendar
Authorization: Bearer {token}
```

**Query Parameters:**
- `start` (required): Start date in Y-m-d format
- `end` (required): End date in Y-m-d format
- `room_id` (optional): Filter by room

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 123,
            "title": "Rapat Koordinasi",
            "start": "2025-08-04T09:00:00",
            "end": "2025-08-04T11:00:00",
            "backgroundColor": "#28a745",
            "textColor": "#ffffff",
            "extendedProps": {
                "booking_code": "BK-20250804-001",
                "room_name": "Aula Utama",
                "status": "approved",
                "description": "Rapat koordinasi tim"
            }
        }
    ]
}
```

## 👥 Admin API

### Approve Booking
```http
PATCH /admin/bookings/{id}/approve
Authorization: Bearer {token}
Content-Type: application/json

{
    "notes": "Booking disetujui untuk kegiatan koordinasi"
}
```

### Reject Booking
```http
PATCH /admin/bookings/{id}/reject
Authorization: Bearer {token}
Content-Type: application/json

{
    "rejection_reason": "Ruangan sudah dibooking pada waktu tersebut"
}
```

### Get All Bookings (Admin)
```http
GET /admin/bookings
Authorization: Bearer {token}
```

**Query Parameters:**
- `status` (string): Filter by status
- `room_id` (integer): Filter by room
- `user_id` (integer): Filter by user
- `date_from` (date): Filter from date
- `date_to` (date): Filter to date

### Get Reports Data
```http
GET /admin/reports/bookings
Authorization: Bearer {token}
```

**Query Parameters:**
- `period` (string): today|week|month|year
- `status` (string): Filter by status
- `room_id` (integer): Filter by room
- `bidang_id` (integer): Filter by bidang
- `date_from` (date): Custom date range start
- `date_to` (date): Custom date range end

**Response:**
```json
{
    "success": true,
    "data": {
        "statistics": {
            "total": 150,
            "approved": 120,
            "pending": 20,
            "rejected": 8,
            "cancelled": 2
        },
        "room_stats": {
            "Aula Utama": 45,
            "Ruang Rapat A": 30,
            "Ruang Seminar": 25
        },
        "monthly_stats": {
            "2025-07": 40,
            "2025-08": 35,
            "2025-09": 45
        },
        "bookings": [
            {
                "id": 123,
                "booking_code": "BK-20250804-001",
                "title": "Rapat Koordinasi",
                "room": {
                    "name": "Aula Utama"
                },
                "user": {
                    "name": "John Doe"
                },
                "booking_date": "2025-08-04",
                "start_time": "09:00",
                "end_time": "11:00",
                "status": "approved"
            }
        ]
    }
}
```

### Export Reports
```http
GET /admin/reports/bookings/export
Authorization: Bearer {token}
```

**Query Parameters:** Same as reports endpoint

**Response:** CSV file download

## 🏢 Room Categories API

### Get All Categories
```http
GET /room-categories
Authorization: Bearer {token}
```

### Create Category (Admin)
```http
POST /admin/room-categories
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Ruang Meeting",
    "description": "Ruang meeting kecil untuk diskusi tim"
}
```

## 🏛️ Bidang API

### Get All Bidang
```http
GET /bidangs
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nama": "Bidang Pendidikan Islam",
            "kode": "PENDIS",
            "deskripsi": "Bidang yang menangani pendidikan Islam",
            "is_active": true
        }
    ]
}
```

## 👤 User Management API

### Get User Profile
```http
GET /profile
Authorization: Bearer {token}
```

### Update Profile
```http
PUT /profile
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "name": "John Doe Updated",
    "email": "john.updated@kemenag.go.id",
    "phone": "08123456789",
    "photo": [file upload]
}
```

### Change Password
```http
POST /profile/change-password
Authorization: Bearer {token}
Content-Type: application/json

{
    "current_password": "oldpassword",
    "password": "newpassword",
    "password_confirmation": "newpassword"
}
```

## 📊 Dashboard API

### Get Dashboard Data
```http
GET /dashboard
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "stats": {
            "total_rooms": 25,
            "total_bookings": 150,
            "pending_bookings": 12,
            "approved_today": 5
        },
        "recent_bookings": [
            {
                "id": 123,
                "title": "Rapat Koordinasi",
                "room_name": "Aula Utama",
                "booking_date": "2025-08-04",
                "status": "pending"
            }
        ],
        "room_usage": {
            "labels": ["Aula Utama", "Ruang Rapat A"],
            "data": [45, 30]
        }
    }
}
```

## ❌ Error Responses

### Validation Error
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "room_id": ["The room id field is required."],
        "booking_date": ["The booking date must be a valid date."]
    }
}
```

### Authorization Error
```json
{
    "success": false,
    "message": "Unauthorized",
    "error": "Invalid or expired token"
}
```

### Not Found Error
```json
{
    "success": false,
    "message": "Resource not found",
    "error": "Booking with ID 999 not found"
}
```

### Server Error
```json
{
    "success": false,
    "message": "Internal server error",
    "error": "Something went wrong on our server"
}
```

## 📋 Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `429` - Too Many Requests
- `500` - Internal Server Error

## 🔄 Pagination

All list endpoints support pagination:

```json
{
    "data": [...],
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "per_page": 15,
        "to": 15,
        "total": 75
    },
    "links": {
        "first": "http://localhost:8000/api/bookings?page=1",
        "last": "http://localhost:8000/api/bookings?page=5",
        "prev": null,
        "next": "http://localhost:8000/api/bookings?page=2"
    }
}
```

## 🧪 Testing API

### Using cURL
```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"nip":"196001011980031001","password":"password"}'

# Get bookings with token
curl -X GET http://localhost:8000/api/bookings \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Using Postman
1. Import API collection
2. Set environment variables
3. Use Bearer token authentication

---

**© 2025 Kementerian Agama RI - API Documentation**
