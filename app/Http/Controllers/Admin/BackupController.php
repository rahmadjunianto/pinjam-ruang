<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

class BackupController extends Controller
{
    /**
     * Display backup management page
     */
    public function index()
    {
        $backups = $this->getBackupFiles();
        $lastBackup = $this->getLastBackupDate();
        
        return view('admin.backup.index', compact('backups', 'lastBackup'));
    }

    /**
     * Create backup based on type
     */
    public function create(Request $request)
    {
        // Debug: Log the request details
        Log::info('Backup create request received', [
            'user' => Auth::check() ? Auth::user()->email : 'Not authenticated',
            'role' => Auth::check() ? Auth::user()->role : 'No role',
            'type' => $request->input('type'),
            'expects_json' => $request->expectsJson()
        ]);

        $type = $request->input('type', 'database');
        
        try {
            if ($type === 'full') {
                return $this->createFullBackup();
            } else {
                return $this->createDatabaseBackup();
            }
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
            
            return redirect()->back()
                           ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Create database backup
     */
    public function createDatabaseBackup()
    {
        try {
            $filename = 'backup_db_' . date('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);
            
            // Create backup directory if not exists
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            // Get database configuration
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');

            // Create mysqldump command
            $command = "mysqldump -h {$host} -u {$username} -p{$password} {$database} > {$path}";
            
            // Execute command
            exec($command, $output, $returnCode);

            if ($returnCode === 0) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Backup database berhasil dibuat!'
                    ]);
                }
                
                return redirect()->back()
                               ->with('success', 'Backup database berhasil dibuat!');
            } else {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal membuat backup database!'
                    ]);
                }
                
                return redirect()->back()
                               ->with('error', 'Gagal membuat backup database!');
            }
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
            
            return redirect()->back()
                           ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Create full application backup
     */
    public function createFullBackup()
    {
        try {
            $filename = 'backup_full_' . date('Y-m-d_H-i-s') . '.zip';
            $zipPath = storage_path('app/backups/' . $filename);
            
            // Create backup directory if not exists
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                
                // Add important directories
                $this->addDirectoryToZip($zip, app_path(), 'app/');
                $this->addDirectoryToZip($zip, config_path(), 'config/');
                $this->addDirectoryToZip($zip, database_path(), 'database/');
                $this->addDirectoryToZip($zip, resource_path(), 'resources/');
                $this->addDirectoryToZip($zip, public_path(), 'public/');
                
                // Add important files
                $zip->addFile(base_path('.env'), '.env');
                $zip->addFile(base_path('composer.json'), 'composer.json');
                $zip->addFile(base_path('package.json'), 'package.json');

                $zip->close();

                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Backup lengkap berhasil dibuat!'
                    ]);
                }
                
                return redirect()->back()
                               ->with('success', 'Backup lengkap berhasil dibuat!');
            } else {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal membuat file backup!'
                    ]);
                }
                
                return redirect()->back()
                               ->with('error', 'Gagal membuat file backup!');
            }
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
            
            return redirect()->back()
                           ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Download backup file
     */
    public function download($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        
        if (!file_exists($path)) {
            return redirect()->back()
                           ->with('error', 'File backup tidak ditemukan!');
        }

        return response()->download($path);
    }

    /**
     * Delete backup file
     */
    public function delete($filename)
    {
        try {
            $path = storage_path('app/backups/' . $filename);
            
            if (file_exists($path)) {
                unlink($path);
                
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'File backup berhasil dihapus!'
                    ]);
                }
                
                return redirect()->back()
                               ->with('success', 'File backup berhasil dihapus!');
            } else {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'File backup tidak ditemukan!'
                    ]);
                }
                
                return redirect()->back()
                               ->with('error', 'File backup tidak ditemukan!');
            }
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            }
            
            return redirect()->back()
                           ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Get list of backup files
     */
    private function getBackupFiles()
    {
        $backupPath = storage_path('app/backups');
        $backups = [];

        if (is_dir($backupPath)) {
            $files = scandir($backupPath);
            
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $filePath = $backupPath . '/' . $file;
                    $fileTime = filemtime($filePath);
                    $backups[] = [
                        'name' => $file,
                        'size' => $this->formatBytes(filesize($filePath)),
                        'date' => date('d/m/Y H:i:s', $fileTime),
                        'timestamp' => $fileTime, // Add timestamp for sorting
                        'type' => strpos($file, 'backup_db_') === 0 ? 'Database' : 'Full Backup'
                    ];
                }
            }
            
            // Sort by timestamp descending (newest first)
            usort($backups, function($a, $b) {
                return $b['timestamp'] - $a['timestamp'];
            });
        }

        return $backups;
    }

    /**
     * Add directory to zip recursively
     */
    private function addDirectoryToZip($zip, $dir, $zipdir = '')
    {
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != '.' && $file != '..') {
                        $fullpath = $dir . '/' . $file;
                        $zippath = $zipdir . $file;
                        
                        if (is_file($fullpath)) {
                            $zip->addFile($fullpath, $zippath);
                        } elseif (is_dir($fullpath)) {
                            $this->addDirectoryToZip($zip, $fullpath, $zippath . '/');
                        }
                    }
                }
                closedir($dh);
            }
        }
    }

    /**
     * Get last backup date
     */
    private function getLastBackupDate()
    {
        $backups = $this->getBackupFiles();
        
        if (empty($backups)) {
            return null;
        }
        
        $lastBackupTimestamp = max(array_column($backups, 'timestamp'));
        return date('Y-m-d H:i:s', $lastBackupTimestamp);
    }

    /**
     * Format file size
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
