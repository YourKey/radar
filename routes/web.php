<?php

use App\Actions\Notify\sendTelegramNotify;
use App\Models\User;
use App\Services\GuzzleParser;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function() {
    Route::get('/', [\App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [\App\Http\Controllers\ProjectController::class, 'create'])->name('projects.create');

    Route::middleware('project.owner')->group(function() {
        Route::get('projects/{project}', [\App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show');
        Route::get('projects/{project}/{page}', [\App\Http\Controllers\PageController::class, 'show'])->name('projects.snapshots');
    });
});
