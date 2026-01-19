<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fix-storage-link', function () {
    try {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $results = [];
        $results[] = "<h1>Fixing Storage...</h1>";

        // 1. Fix Directory Structure
        $targetDir = storage_path('app/public/images/layanan');
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
            $results[] = "✅ Created directory: $targetDir";
        } else {
            $results[] = "info: Directory already exists.";
        }

        // 2. Fix Symlink
        $link = public_path('storage');
        if (file_exists($link)) {
            if (is_link($link)) {
                unlink($link); // Valid symlink removal
                $results[] = "Deleted old symlink.";
            } elseif (is_dir($link)) {
                // It is a real directory, rename it to back it up
                $backup = public_path('storage_backup_' . time());
                rename($link, $backup);
                $results[] = "⚠️ Renamed obstructing directory 'public/storage' to '" . basename($backup) . "'";
            } else {
                unlink($link); // Regular file
                $results[] = "Deleted obstructing file.";
            }
        }

        try {
            Artisan::call('storage:link');
            $results[] = "✅ Ran 'php artisan storage:link' success.";
        } catch (\Exception $e) {
            $results[] = "⚠️ Artisan failed: " . $e->getMessage();
            // Fallback manual
            $target = storage_path('app/public');
            symlink($target, $link);
            $results[] = "✅ Created manual symlink success.";
        }

        $results[] = "<hr><h3>Status Akhir:</h3>";
        $results[] = "Storage Link Exists: " . (file_exists(public_path('storage')) ? "YES ✅" : "NO ❌");
        $results[] = "Upload Folder Exists: " . (file_exists(storage_path('app/public/images/layanan')) ? "YES ✅" : "NO ❌");

        return implode("<br>", $results);

    } catch (\Throwable $e) {
        return "CRITICAL ERROR: " . $e->getMessage();
    }
});
