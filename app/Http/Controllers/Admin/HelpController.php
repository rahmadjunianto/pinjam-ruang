<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display help page
     */
    public function index()
    {
        return view('admin.help.index');
    }

    /**
     * Show user guide
     */
    public function userGuide()
    {
        return view('admin.help.user-guide');
    }

    /**
     * Show admin guide
     */
    public function adminGuide()
    {
        return view('admin.help.admin-guide');
    }

    /**
     * Show FAQ
     */
    public function faq()
    {
        $faqs = [
            [
                'category' => 'login',
                'category_name' => 'Login & Akses',
                'icon' => 'fa-sign-in-alt',
                'color' => 'primary',
                'question' => 'Bagaimana cara login ke sistem?',
                'answer' => '<p>Untuk login ke sistem:</p>
                           <ol>
                               <li>Masukkan NIP (18 digit)</li>
                               <li>Masukkan password</li>
                               <li>Klik tombol "Masuk"</li>
                           </ol>
                           <p><strong>Catatan:</strong> Jika lupa password, hubungi administrator untuk reset.</p>',
                'helpful' => true
            ],
            [
                'category' => 'booking',
                'category_name' => 'Peminjaman',
                'icon' => 'fa-calendar-plus',
                'color' => 'success',
                'question' => 'Bagaimana cara melakukan peminjaman ruangan?',
                'answer' => '<p>Untuk melakukan peminjaman ruangan:</p>
                           <ol>
                               <li>Masuk ke menu "Peminjaman Ruang" → "Data Peminjaman"</li>
                               <li>Klik tombol "Tambah Peminjaman"</li>
                               <li>Pilih ruangan yang diinginkan</li>
                               <li>Tentukan tanggal dan waktu</li>
                               <li>Isi tujuan peminjaman</li>
                               <li>Klik "Ajukan Peminjaman"</li>
                           </ol>',
                'helpful' => true,
                'related_links' => [
                    ['title' => 'Panduan Lengkap Peminjaman', 'url' => '#booking']
                ]
            ],
            [
                'category' => 'booking',
                'category_name' => 'Peminjaman',
                'icon' => 'fa-clock',
                'color' => 'warning',
                'question' => 'Berapa lama waktu yang dibutuhkan untuk persetujuan?',
                'answer' => '<p>Waktu persetujuan peminjaman:</p>
                           <ul>
                               <li><strong>Normal:</strong> 1-2 hari kerja</li>
                               <li><strong>Mendesak:</strong> Sama hari (hubungi admin)</li>
                               <li><strong>Hari libur:</strong> Diproses hari kerja berikutnya</li>
                           </ul>
                           <p>Anda akan mendapat notifikasi ketika status berubah.</p>',
                'helpful' => true
            ],
            [
                'category' => 'booking',
                'category_name' => 'Peminjaman',
                'icon' => 'fa-times-circle',
                'color' => 'danger',
                'question' => 'Apakah bisa membatalkan peminjaman yang sudah disetujui?',
                'answer' => '<p>Ya, peminjaman dapat dibatalkan dengan cara:</p>
                           <ol>
                               <li>Masuk ke menu "Data Peminjaman"</li>
                               <li>Cari peminjaman yang ingin dibatalkan</li>
                               <li>Klik tombol "Batal" pada peminjaman tersebut</li>
                               <li>Atau hubungi administrator langsung</li>
                           </ol>
                           <p><strong>Catatan:</strong> Pembatalan sebaiknya dilakukan minimal 2 jam sebelum acara.</p>',
                'helpful' => true
            ],
            [
                'category' => 'calendar',
                'category_name' => 'Kalender',
                'icon' => 'fa-calendar',
                'color' => 'info',
                'question' => 'Bagaimana cara melihat jadwal ruangan?',
                'answer' => '<p>Untuk melihat jadwal ruangan:</p>
                           <ol>
                               <li>Klik menu "Kalender Peminjaman"</li>
                               <li>Pilih bulan dan tahun yang diinginkan</li>
                               <li>Klik pada tanggal untuk melihat detail</li>
                               <li>Gunakan filter ruangan jika diperlukan</li>
                           </ol>',
                'helpful' => true
            ],
            [
                'category' => 'admin',
                'category_name' => 'Administrator',
                'icon' => 'fa-user-shield',
                'color' => 'danger',
                'question' => 'Siapa yang dapat menyetujui peminjaman ruangan?',
                'answer' => '<p>Peminjaman ruangan hanya dapat disetujui oleh:</p>
                           <ul>
                               <li>Pengguna dengan role <strong>Administrator</strong></li>
                               <li>Melalui dashboard admin menu "Data Peminjaman"</li>
                               <li>Status akan berubah otomatis setelah disetujui</li>
                           </ul>',
                'helpful' => true
            ],
            [
                'category' => 'profile',
                'category_name' => 'Profil',
                'icon' => 'fa-user-circle',
                'color' => 'secondary',
                'question' => 'Bagaimana cara mengubah password?',
                'answer' => '<p>Untuk mengubah password:</p>
                           <ol>
                               <li>Klik nama Anda di pojok kanan atas</li>
                               <li>Pilih "Profil"</li>
                               <li>Masukkan password lama</li>
                               <li>Masukkan password baru (min. 8 karakter)</li>
                               <li>Konfirmasi password baru</li>
                               <li>Klik "Simpan Perubahan"</li>
                           </ol>',
                'helpful' => true
            ],
            [
                'category' => 'login',
                'category_name' => 'Login & Akses',
                'icon' => 'fa-key',
                'color' => 'warning',
                'question' => 'Apa yang harus dilakukan jika lupa password?',
                'answer' => '<p>Jika lupa password:</p>
                           <ol>
                               <li>Hubungi administrator sistem</li>
                               <li>Berikan NIP untuk verifikasi identitas</li>
                               <li>Password akan direset ke default (NIP)</li>
                               <li>Login dengan password baru dan ubah segera</li>
                           </ol>',
                'helpful' => true
            ],
            [
                'category' => 'technical',
                'category_name' => 'Teknis',
                'icon' => 'fa-headset',
                'color' => 'success',
                'question' => 'Bagaimana cara menghubungi support?',
                'answer' => '<p>Cara menghubungi support:</p>
                           <ul>
                               <li><strong>Email:</strong> support@kemenag.go.id</li>
                               <li><strong>Telepon:</strong> (021) 3853-1001</li>
                               <li><strong>WhatsApp:</strong> 0812-3456-7890</li>
                               <li><strong>Langsung:</strong> Ruang IT Lantai 3</li>
                           </ul>',
                'helpful' => true
            ]
        ];

        return view('admin.help.faq', compact('faqs'));
    }

    /**
     * Show contact information
     */
    public function contact()
    {
        $contacts = [
            'admin' => [
                [
                    'name' => 'Ahmad Suryadi, S.Kom',
                    'position' => 'Administrator Sistem',
                    'phone' => '0812-3456-7890',
                    'email' => 'admin.sistem@kemenag.go.id',
                    'office' => 'Lantai 3, Ruang IT',
                    'avatar' => 'https://via.placeholder.com/50x50.png?text=AS'
                ],
                [
                    'name' => 'Siti Nurhaliza, S.T',
                    'position' => 'Technical Support',
                    'phone' => '0813-4567-8901',
                    'email' => 'support@kemenag.go.id',
                    'office' => 'Lantai 3, Ruang IT',
                    'avatar' => 'https://via.placeholder.com/50x50.png?text=SN'
                ]
            ],
            'support' => [
                [
                    'name' => 'Helpdesk Kemenag',
                    'position' => 'Tim Dukungan 24/7',
                    'phone' => '021-3456-7890',
                    'email' => 'helpdesk@kemenag.go.id',
                    'availability' => 'Senin-Jumat: 08:00-16:00',
                    'avatar' => 'https://via.placeholder.com/50x50.png?text=HD'
                ]
            ]
        ];

        $quickContact = [
            'phone' => '021-3456-7890',
            'whatsapp' => '6281234567890',
            'email' => 'admin@kemenag.go.id',
            'emergency' => '0800-1-EMERGENCY'
        ];

        $officeInfo = [
            'name' => 'Kementerian Agama Republik Indonesia',
            'address' => 'Jl. Lapangan Banteng Barat No. 3-4, Jakarta Pusat 10110',
            'phone' => '021-3456-7890',
            'fax' => '021-3456-7891',
            'website' => 'https://kemenag.go.id',
            'hours' => [
                'Senin - Kamis' => '08:00 - 16:00',
                'Jumat' => '08:00 - 11:30, 13:00 - 16:00',
                'Sabtu - Minggu' => 'Tutup'
            ]
        ];

        $departments = [
            [
                'name' => 'Bidang Teknologi Informasi',
                'head' => 'Dr. Ahmad Fauzi, M.T',
                'phone' => '021-3456-7801',
                'location' => 'Lantai 3'
            ],
            [
                'name' => 'Bidang Administrasi',
                'head' => 'Hj. Siti Aminah, S.E',
                'phone' => '021-3456-7802',
                'location' => 'Lantai 2'
            ],
            [
                'name' => 'Bidang Keuangan',
                'head' => 'Drs. Muhammad Yusuf',
                'phone' => '021-3456-7803',
                'location' => 'Lantai 2'
            ]
        ];

        return view('admin.help.contact', compact('contacts', 'quickContact', 'officeInfo', 'departments'));
    }

    /**
     * Show system information
     */
    public function system()
    {
        $systemInfo = [
            'app_name' => 'Sistem Peminjaman Ruangan Kemenag',
            'version' => '1.0.0',
            'environment' => config('app.env'),
            'framework' => 'Laravel ' . app()->version(),
            'database' => 'MySQL 8.0',
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale')
        ];

        $serverInfo = [
            'php_version' => PHP_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'operating_system' => PHP_OS,
            'memory_limit' => ini_get('memory_limit'),
            'max_upload_size' => ini_get('upload_max_filesize'),
            'max_execution_time' => ini_get('max_execution_time'),
            'disk_free_space' => $this->formatBytes(disk_free_space('.'))
        ];

        $statistics = [
            'total_users' => \App\Models\User::count(),
            'total_rooms' => \App\Models\Room::count(),
            'total_bookings' => \App\Models\Booking::count(),
            'active_sessions' => 12 // Placeholder
        ];

        $features = [
            'core' => [
                'name' => 'Fitur Utama',
                'icon' => 'fa-star',
                'items' => [
                    'Manajemen Ruangan',
                    'Sistem Peminjaman',
                    'Kalender Interaktif',
                    'Dashboard Analytics',
                    'Sistem Persetujuan'
                ]
            ],
            'admin' => [
                'name' => 'Administrasi',
                'icon' => 'fa-cogs',
                'items' => [
                    'Manajemen User',
                    'Kontrol Hak Akses',
                    'Backup & Restore',
                    'Monitoring Sistem',
                    'Laporan Lengkap'
                ]
            ]
        ];

        $requirements = [
            'browsers' => [
                'Google Chrome 90+',
                'Mozilla Firefox 88+',
                'Safari 14+',
                'Microsoft Edge 90+'
            ],
            'devices' => [
                'Desktop Computer',
                'Laptop',
                'Tablet (iPad, Android)',
                'Smartphone (iOS, Android)'
            ],
            'internet' => [
                'Koneksi internet minimum 1 Mbps',
                'Koneksi stabil untuk realtime update',
                'HTTPS support'
            ],
            'security' => [
                'JavaScript enabled',
                'Cookies enabled',
                'Pop-up blocker disabled'
            ]
        ];

        $changelog = [
            [
                'version' => '1.0.0',
                'type' => 'major',
                'date' => '1 Agustus 2025',
                'time' => '10:00',
                'title' => 'Initial Release',
                'icon' => 'fa-rocket',
                'color' => 'success',
                'description' => 'Peluncuran awal sistem peminjaman ruangan dengan fitur lengkap.',
                'changes' => [
                    'Sistem peminjaman ruangan',
                    'Dashboard analytics',
                    'Manajemen user dan hak akses',
                    'Sistem backup data',
                    'Pusat bantuan lengkap'
                ]
            ]
        ];

        $healthCheck = [
            [
                'name' => 'Database',
                'status' => 'ok',
                'icon' => 'fa-database',
                'details' => 'Koneksi normal'
            ],
            [
                'name' => 'Storage',
                'status' => 'ok',
                'icon' => 'fa-hdd',
                'details' => '85% available'
            ],
            [
                'name' => 'Cache',
                'status' => 'ok',
                'icon' => 'fa-tachometer-alt',
                'details' => 'Redis aktif'
            ],
            [
                'name' => 'Queue',
                'status' => 'warning',
                'icon' => 'fa-clock',
                'details' => '3 jobs pending'
            ]
        ];

        $license = [
            'type' => 'Proprietary',
            'description' => 'Sistem internal Kementerian Agama RI',
            'year' => '2025',
            'holder' => 'Kementerian Agama Republik Indonesia'
        ];

        $technologies = [
            ['name' => 'Laravel', 'version' => '11.x'],
            ['name' => 'PHP', 'version' => '8.2'],
            ['name' => 'MySQL', 'version' => '8.0'],
            ['name' => 'AdminLTE', 'version' => '3.2'],
            ['name' => 'Bootstrap', 'version' => '5.1'],
            ['name' => 'jQuery', 'version' => '3.6']
        ];

        return view('admin.help.system', compact(
            'systemInfo', 'serverInfo', 'statistics', 'features', 
            'requirements', 'changelog', 'healthCheck', 'license', 'technologies'
        ));
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($size, $precision = 2)
    {
        if ($size == 0) return '0 B';
        
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
