<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fix-storage-link', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');

    // Force delete existing link if it exists
    if (file_exists($link)) {
        unlink($link);
    }

    $results = [];
    $results[] = "Target Directory: " . $target;
    $results[] = "Target Exists: " . (is_dir($target) ? 'YES' : 'NO');

    // Create target directory if it doesn't exist
    if (!is_dir($target)) {
        mkdir($target, 0755, true);
        $results[] = "Created target directory.";
    }

    try {
        Artisan::call('storage:link');
        $results[] = "SUCCESS: Storage link recreated via Artisan.";
    } catch (\Exception $e) {
        try {
            symlink($target, $link);
            $results[] = "SUCCESS: Storage link recreated via symlink().";
        } catch (\Exception $e2) {
            $results[] = "ERROR: Failed to create link -> " . $e2->getMessage();
        }
    }

    return implode("<br>", $results);
});
