<?php

use Illuminate\Support\Facades\Route;

// React SPA - Catch all routes except API
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');