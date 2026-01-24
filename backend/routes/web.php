<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Route::get('/', function () {
    return view('welcome');
});

// Helper function to recursively delete a directory
function recursiveRemoveDirectory($directory)
{
    foreach (glob("{$directory}/*") as $file) {
        if (is_dir($file)) {
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}

Route::get('/fix-storage-link', function () {
    try {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $results = [];
        $results[] = "<h1>Fixing Storage (Recursive Mode)...</h1>";

        // 1. Fix Directory Structure
        $targetDir = storage_path('app/public/images/layanan');
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
            $results[] = "✅ Created directory: $targetDir";
        }

        // 2. Fix Symlink
        $link = public_path('storage');
        if (file_exists($link)) {
            if (is_link($link)) {
                unlink($link);
                $results[] = "Deleted old symlink.";
            } elseif (is_dir($link)) {
                // Recursive delete for the stubborn directory
                try {
                    recursiveRemoveDirectory($link);
                    $results[] = "⚠️ Deleted obstructing directory 'public/storage' recursively.";
                } catch (\Throwable $e) {
                    $results[] = "❌ Failed to delete directory: " . $e->getMessage();
                }
            } else {
                unlink($link);
                $results[] = "Deleted obstructing file.";
            }
        }

        // 3. Create New Link
        try {
            Artisan::call('storage:link');
            $results[] = "✅ Ran 'php artisan storage:link' success.";
        } catch (\Exception $e) {
            $results[] = "⚠️ Artisan failed: " . $e->getMessage();
            try {
                $target = storage_path('app/public');
                symlink($target, $link);
                $results[] = "✅ Created manual symlink success.";
            } catch (\Exception $ex) {
                $results[] = "❌ Manual symlink failed: " . $ex->getMessage();
            }
        }

        $results[] = "<hr><h3>Status Akhir:</h3>";
        $results[] = "Storage Link Exists: " . (file_exists(public_path('storage')) ? "YES ✅" : "NO ❌");

        return implode("<br>", $results);

    } catch (\Throwable $e) {
        return "CRITICAL ERROR: " . $e->getMessage();
    }
});

// Serve storage files directly (bypass symlink for Railway ephemeral filesystem)
Route::get('/storage/{path}', function ($path) {
    $storagePath = storage_path('app/public/' . $path);
    
    if (!file_exists($storagePath)) {
        abort(404, 'File not found');
    }
    
    $mimeType = mime_content_type($storagePath);
    
    return response()->file($storagePath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');
