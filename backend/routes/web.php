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

        $target = storage_path('app/public');
        $link = public_path('storage');
        $uploadPath = storage_path('app/public/images/layanan');

        $results = [];
        $results[] = "<h1>Debug Storage & Files</h1>";

        // 1. Check Link Status
        $results[] = "<h3>Link Status:</h3>";
        if (is_link($link)) {
            $results[] = "✅ Symlink exists.";
            $realPath = readlink($link);
            $results[] = "   Target: " . $realPath;
            $results[] = "   Valid: " . (is_dir($realPath) ? "YES" : "NO - Broken Link");
        } else {
            $results[] = "❌ Symlink MISSING at $link";
        }

        // 2. Check Upload Directory
        $results[] = "<h3>Upload Directory ($uploadPath):</h3>";
        if (is_dir($uploadPath)) {
            $results[] = "✅ Directory exists.";
            $files = scandir($uploadPath);
            $results[] = "<ul>";
            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    $url = "https://dapur-nyonya-production.up.railway.app/storage/images/layanan/" . $file;
                    $results[] = "<li>$file - <a href='$url' target='_blank'>Try Open</a></li>";
                }
            }
            $results[] = "</ul>";
        } else {
            $results[] = "❌ Directory DOES NOT EXIST.";
        }

        // 3. Re-Link Button (Manual Trigger basically)
        // Only run if specifically asked to avoid loop
        if (request()->has('relink')) {
            try {
                Artisan::call('storage:link');
                $results[] = "<br><b>Ran artisan storage:link</b>";
            } catch (\Exception $e) {
                $results[] = "<br><b>Error running artisan:</b> " . $e->getMessage();
            }
        }

        return implode("<br>", $results);

    } catch (\Throwable $e) {
        return "CRITICAL ERROR: " . $e->getMessage();
    }
});
