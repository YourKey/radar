<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->middleware(['auth:sanctum'])->group(function() {
    Route::post('projects', [\App\Http\Controllers\Api\ProjectController::class, 'store'])->name('api.v1.projects.store');
    Route::post('snapshots', [\App\Http\Controllers\Api\SnapshotController::class, 'store'])->name('api.v1.snapshots.store');
});
