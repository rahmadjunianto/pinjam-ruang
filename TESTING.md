# 🧪 Testing Guide - SIAKAD KEMENAG

Panduan lengkap untuk testing aplikasi Sistem Peminjaman Ruang SIAKAD KEMENAG.

## 📋 Overview

Aplikasi ini menggunakan PHPUnit untuk unit testing dan Laravel Dusk untuk browser testing. Semua test telah dikonfigurasi untuk testing environment yang terpisah.

## ⚙️ Setup Testing Environment

### 1. **Database Testing**
```bash
# Create test database
mysql -u root -p -e "CREATE DATABASE adminlte_laravel_test"

# Copy environment for testing
cp .env .env.testing
```

### 2. **Configure .env.testing**
```env
APP_ENV=testing
APP_DEBUG=true
DB_DATABASE=adminlte_laravel_test
MAIL_MAILER=array
QUEUE_CONNECTION=sync
SESSION_DRIVER=array
CACHE_DRIVER=array
```

### 3. **Run Migrations for Testing**
```bash
php artisan migrate --env=testing
php artisan db:seed --env=testing
```

## 🧪 Running Tests

### All Tests
```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

### Specific Tests
```bash
# Run specific test file
php artisan test tests/Feature/BookingTest.php

# Run specific test method
php artisan test --filter testUserCanCreateBooking

# Run tests with specific group
php artisan test --group=booking
```

### Parallel Testing
```bash
# Run tests in parallel
php artisan test --parallel

# Specify number of processes
php artisan test --parallel --processes=4
```

## 📂 Test Structure

```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   └── RegistrationTest.php
│   ├── Admin/
│   │   ├── DashboardTest.php
│   │   ├── UserManagementTest.php
│   │   ├── RoomManagementTest.php
│   │   └── BookingManagementTest.php
│   ├── Booking/
│   │   ├── BookingCreationTest.php
│   │   ├── BookingApprovalTest.php
│   │   └── BookingCancellationTest.php
│   ├── Room/
│   │   ├── RoomAvailabilityTest.php
│   │   └── RoomSearchTest.php
│   └── Report/
│       └── ReportGenerationTest.php
├── Unit/
│   ├── Models/
│   │   ├── UserTest.php
│   │   ├── RoomTest.php
│   │   ├── BookingTest.php
│   │   └── BidangTest.php
│   ├── Services/
│   │   ├── BookingServiceTest.php
│   │   └── ReportServiceTest.php
│   └── Helpers/
│       └── NipValidatorTest.php
└── Browser/
    ├── LoginTest.php
    ├── BookingWorkflowTest.php
    └── AdminDashboardTest.php
```

## 🔐 Authentication Tests

### Example: Login Test
```php
<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'nip' => '196001011980031001',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/login', [
            'nip' => '196001011980031001',
            'password' => 'password'
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'nip' => '196001011980031001',
            'password' => 'wrong-password'
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
```

## 📅 Booking Tests

### Example: Booking Creation Test
```php
<?php

namespace Tests\Feature\Booking;

use App\Models\User;
use App\Models\Room;
use App\Models\Bidang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_booking()
    {
        $user = User::factory()->create(['role' => 'user']);
        $room = Room::factory()->create(['is_active' => true]);
        $bidang = Bidang::factory()->create();

        $bookingData = [
            'room_id' => $room->id,
            'booking_date' => now()->addDays(1)->format('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '11:00',
            'title' => 'Test Meeting',
            'description' => 'Test meeting description',
            'bidang_id' => $bidang->id,
            'contact_phone' => '08123456789',
            'contact_email' => 'test@example.com',
            'expected_attendees' => 10
        ];

        $response = $this->actingAs($user)
            ->post('/admin/bookings', $bookingData);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'room_id' => $room->id,
            'title' => 'Test Meeting',
            'status' => 'pending'
        ]);
    }

    /** @test */
    public function booking_cannot_overlap_with_existing_approved_booking()
    {
        $user = User::factory()->create(['role' => 'user']);
        $room = Room::factory()->create(['is_active' => true]);

        // Create existing booking
        Booking::factory()->create([
            'room_id' => $room->id,
            'booking_date' => now()->addDays(1)->format('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '11:00',
            'status' => 'approved'
        ]);

        $overlappingBookingData = [
            'room_id' => $room->id,
            'booking_date' => now()->addDays(1)->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time' => '12:00',
            'title' => 'Overlapping Meeting'
        ];

        $response = $this->actingAs($user)
            ->post('/admin/bookings', $overlappingBookingData);

        $response->assertSessionHasErrors(['room_id']);
    }
}
```

## 🏢 Room Management Tests

### Example: Room Availability Test
```php
<?php

namespace Tests\Feature\Room;

use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function room_availability_check_returns_correct_data()
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['is_active' => true]);

        // Create existing booking
        Booking::factory()->create([
            'room_id' => $room->id,
            'booking_date' => '2025-08-04',
            'start_time' => '09:00',
            'end_time' => '11:00',
            'status' => 'approved'
        ]);

        $response = $this->actingAs($user)
            ->get("/admin/bookings/room/{$room->id}/availability?date=2025-08-04");

        $response->assertStatus(200)
            ->assertJson([
                'room' => [
                    'id' => $room->id,
                    'name' => $room->name
                ],
                'date' => '2025-08-04',
                'available' => false,
                'bookings' => [
                    [
                        'start_time' => '09:00',
                        'end_time' => '11:00',
                        'status' => 'approved'
                    ]
                ]
            ]);
    }
}
```

## 👥 Admin Tests

### Example: User Management Test
```php
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_user_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $users = User::factory()->count(5)->create();

        $response = $this->actingAs($admin)
            ->get('/admin/users');

        $response->assertStatus(200)
            ->assertViewIs('admin.users.index')
            ->assertViewHas('users');
    }

    /** @test */
    public function admin_can_create_new_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $userData = [
            'name' => 'Test User',
            'nip' => '196001011980031002',
            'email' => 'testuser@kemenag.go.id',
            'role' => 'user',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->actingAs($admin)
            ->post('/admin/users', $userData);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'nip' => '196001011980031002',
            'email' => 'testuser@kemenag.go.id'
        ]);
    }

    /** @test */
    public function non_admin_cannot_access_user_management()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)
            ->get('/admin/users');

        $response->assertStatus(403);
    }
}
```

## 📊 Report Tests

### Example: Report Generation Test
```php
<?php

namespace Tests\Feature\Report;

use App\Models\User;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportGenerationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_generate_booking_reports()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create();

        // Create test bookings
        Booking::factory()->count(5)->create([
            'room_id' => $room->id,
            'status' => 'approved',
            'booking_date' => now()->format('Y-m-d')
        ]);

        $response = $this->actingAs($admin)
            ->get('/admin/reports/bookings');

        $response->assertStatus(200)
            ->assertViewIs('admin.reports.bookings')
            ->assertViewHas(['bookings', 'stats', 'roomStats', 'monthlyStats']);
    }

    /** @test */
    public function admin_can_export_reports_to_csv()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Booking::factory()->count(3)->create([
            'status' => 'approved'
        ]);

        $response = $this->actingAs($admin)
            ->get('/admin/reports/bookings/export');

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->assertHeader('Content-Disposition', 'attachment; filename="laporan_peminjaman_' . now()->format('Y_m_d') . '.csv"');
    }
}
```

## 🌐 Browser Tests (Laravel Dusk)

### Setup Dusk
```bash
# Install Dusk
composer require --dev laravel/dusk

# Install Dusk
php artisan dusk:install

# Download Chrome driver
php artisan dusk:chrome-driver
```

### Example: Booking Workflow Test
```php
<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Room;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BookingWorkflowTest extends DuskTestCase
{
    /** @test */
    public function user_can_complete_booking_workflow()
    {
        $user = User::factory()->create(['role' => 'user']);
        $room = Room::factory()->create(['is_active' => true]);

        $this->browse(function (Browser $browser) use ($user, $room) {
            $browser->loginAs($user)
                ->visit('/admin/bookings/create')
                ->select('room_id', $room->id)
                ->type('booking_date', now()->addDays(1)->format('Y-m-d'))
                ->type('start_time', '09:00')
                ->type('end_time', '11:00')
                ->type('title', 'Browser Test Meeting')
                ->type('description', 'Test description')
                ->type('contact_phone', '08123456789')
                ->type('contact_email', 'test@example.com')
                ->type('expected_attendees', '10')
                ->press('Simpan')
                ->assertPathIs('/admin/bookings')
                ->assertSee('Booking berhasil dibuat');
        });
    }
}
```

## 🔧 Test Utilities

### Custom Assertions
```php
<?php

namespace Tests;

use PHPUnit\Framework\Assert as PHPUnit;

class CustomAssertions
{
    public static function assertBookingExists($bookingCode)
    {
        PHPUnit::assertTrue(
            \App\Models\Booking::where('booking_code', $bookingCode)->exists(),
            "Booking with code {$bookingCode} does not exist"
        );
    }

    public static function assertRoomAvailable($roomId, $date, $startTime, $endTime)
    {
        $conflicting = \App\Models\Booking::where('room_id', $roomId)
            ->where('booking_date', $date)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                          ->where('end_time', '>=', $endTime);
                    });
            })
            ->whereIn('status', ['approved', 'pending'])
            ->exists();

        PHPUnit::assertFalse($conflicting, "Room is not available for the specified time");
    }
}
```

### Test Factories
```php
<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'room_id' => \App\Models\Room::factory(),
            'bidang_id' => \App\Models\Bidang::factory(),
            'booking_code' => 'BK-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
            'booking_date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '11:00',
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'contact_phone' => $this->faker->phoneNumber(),
            'contact_email' => $this->faker->email(),
            'expected_attendees' => $this->faker->numberBetween(5, 50),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }

    public function approved()
    {
        return $this->state(['status' => 'approved']);
    }

    public function pending()
    {
        return $this->state(['status' => 'pending']);
    }
}
```

## 📊 Test Coverage

### Generate Coverage Report
```bash
# HTML coverage report
php artisan test --coverage-html coverage-report

# Text coverage report
php artisan test --coverage-text

# Clover XML (for CI)
php artisan test --coverage-clover coverage.xml
```

### Coverage Configuration
Add to `phpunit.xml`:
```xml
<coverage>
    <include>
        <directory suffix=".php">./app</directory>
    </include>
    <exclude>
        <file>./app/Console/Kernel.php</file>
        <file>./app/Exceptions/Handler.php</file>
        <file>./app/Http/Kernel.php</file>
    </exclude>
    <report>
        <html outputDirectory="./coverage-report"/>
        <text outputFile="./coverage.txt"/>
    </report>
</coverage>
```

## 🚀 CI/CD Testing

### GitHub Actions Example
```yaml
name: Laravel Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main ]

jobs:
  laravel-tests:
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ALLOW_EMPTY_PASSWORD: false
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: test_db
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3

    steps:
    - uses: actions/checkout@v3

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'

    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

    - name: Generate Application Key
      run: php artisan key:generate

    - name: Execute tests
      env:
        DB_CONNECTION: mysql
        DB_HOST: 127.0.0.1
        DB_PORT: 3306
        DB_DATABASE: test_db
        DB_USERNAME: root
        DB_PASSWORD: password
      run: php artisan test
```

## 🎯 Best Practices

### 1. **Test Organization**
- Group related tests in the same file
- Use descriptive test method names
- Follow AAA pattern (Arrange, Act, Assert)

### 2. **Database Testing**
- Use `RefreshDatabase` trait
- Create minimal test data
- Use factories for consistent data

### 3. **Mocking**
- Mock external services
- Use fake drivers for mail/storage
- Mock time-dependent operations

### 4. **Performance**
- Use database transactions when possible
- Run tests in parallel
- Use SQLite for faster testing

### 5. **Maintenance**
- Keep tests up to date with code changes
- Remove obsolete tests
- Refactor common test logic

---

**© 2025 Kementerian Agama RI - Testing Guide**
