<?php

/**
 * Vercel Serverless PHP Entry Point
 * 
 * This file handles all API requests for the Laravel application
 * when deployed to Vercel using vercel-php runtime.
 */

// Set working directory to Laravel root
chdir(__DIR__ . '/..');

// Load Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Create the request from globals
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

// Handle the request
$response = $kernel->handle($request);

// Send the response
$response->send();

// Terminate the application
$kernel->terminate($request, $response);
