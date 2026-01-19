<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fix-storage-link', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');
    
    // Check if link already exists
    if (file_exists($link)) {
        return 'Storage link already exists.';
    }

    // Try artisan command first
    try {
        Artisan::call('storage:link');
        return 'Storage link created successfully via Artisan.';
    } catch (\Exception $e) {
        // Fallback: Try manual symlink (sometimes required on shared hosts/some envs)
        try {
            symlink($target, $link);
            return 'Storage link created successfully via symlink().';
        } catch (\Exception $e2) {
             return 'Failed to create storage link: ' . $e->getMessage();
        }
    }
});
