<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fix-storage-link', function () {
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $target = storage_path('app/public');
    $link = public_path('storage');
    $results = [];

    $results[] = "<b>Debug Info:</b>";
    $results[] = "Target: $target";
    $results[] = "Link: $link";

    // 1. Handle existing link/file/directory
    if (file_exists($link)) {
        if (is_link($link)) {
            unlink($link);
            $results[] = "Deleted existing symlink.";
        } elseif (is_dir($link)) {
            // Rename invalid directory instead of crashing
            $backupName = $link . '_backup_' . time();
            rename($link, $backupName);
            $results[] = "Renamed existing directory to: " . basename($backupName);
        } else {
            unlink($link);
            $results[] = "Deleted existing file.";
        }
    }

    // 2. Ensure target exists
    if (!is_dir($target)) {
        mkdir($target, 0755, true);
        $results[] = "Created missing target directory.";
    }

    // 3. Create Link
    try {
        symlink($target, $link);
        $results[] = "<h3 style='color:green'>SUCCESS: Link created via symlink() function.</h3>";
    } catch (\Throwable $e) {
        $results[] = "symlink() failed: " . $e->getMessage();

        // Retry with Artisan
        try {
            Artisan::call('storage:link');
            $results[] = "<h3 style='color:green'>SUCCESS: Link created via Artisan command.</h3>";
        } catch (\Throwable $e2) {
            $results[] = "<h3 style='color:red'>FAILED: " . $e2->getMessage() . "</h3>";
        }
    }

    return implode("<br>", $results);
});
