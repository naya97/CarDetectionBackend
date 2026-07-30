<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('admin/dashboard')->controller(\App\Http\Controllers\Admin\DashboardController::class)->group(function () {
    Route::get('stats', 'stats');
    Route::get('charts', 'charts');
    Route::get('alerts/latest', 'latestAlerts');
});

Route::prefix('admin/vehicles')->controller(\App\Http\Controllers\Admin\VehicleController::class)->group(function () {
    Route::get('stats', 'stats');
    Route::get('filter-options', 'filterOptions');
    Route::get('/', 'index');
});
