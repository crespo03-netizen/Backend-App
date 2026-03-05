<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/run-migrations', function () {
    Artisan::call('migrate --force');

    return 'Migrations completed successfully.';
});

require __DIR__.'/auth.php';
