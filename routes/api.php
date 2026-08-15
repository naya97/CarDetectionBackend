<?php

use App\Http\Controllers\Admin\BlacklistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DetectionController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Internal\AiResultController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // Dashboard
    Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
        Route::get('stats', 'stats');
        Route::get('charts', 'charts');
    });

    // Vehicles
    Route::prefix('vehicles')->controller(VehicleController::class)->group(function () {
        Route::get('stats', 'stats');
        Route::get('filter-options', 'filterOptions');
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('{vehicle}', 'show');
        Route::put('{vehicle}', 'update');
        Route::delete('{vehicle}', 'destroy');
    });

    // Blacklist
    Route::prefix('blacklist')->controller(BlacklistController::class)->group(function () {
        Route::get('stats', 'stats');
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('{blacklist}', 'update');
        Route::delete('{blacklist}', 'destroy');
    });

    // Videos 
    Route::prefix('videos')->controller(VideoController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('{video}', 'show');
        Route::get('processed/{video}', 'processedVideo');
    });

    // Detections 
    Route::prefix('videos/{video}')->controller(DetectionController::class)->group(function () {
        Route::get('detections', 'index');
    });

    Route::get('detections/{detection}', [DetectionController::class, 'show']);
});

/*
|--------------------------------------------------------------------------
| Internal AI Callback Routes
|--------------------------------------------------------------------------
*/

Route::prefix('internal')->group(function () {
    Route::post('ai/video-result', [AiResultController::class, 'store']);
});
