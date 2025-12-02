<?php

// Path to your Laravel project root (public_html is the root in your case)
$basePath = __DIR__;

// Load Composer's autoloader
require $basePath . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once $basePath . '/bootstrap/app.php';

// Resolve the console kernel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run your command
$status = $kernel->call('trades:close-pending');

// Optional: print output (good for debugging)
echo $kernel->output();