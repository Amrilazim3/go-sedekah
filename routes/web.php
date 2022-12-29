<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Donor\DashboardController as DonorDashboardController;
use App\Http\Controllers\Needy\DashboardController as NeedyDashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [WelcomeController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        return redirect()->route($request->user()->getRoleNames()[0] . '.dashboard');
    })->name('dashboard');

    // admin routes
    Route::prefix('admin')
        ->middleware('role:admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        });

    // donor routes
    Route::prefix('donor')
        ->middleware('role:donor')
        ->name('donor.')
        ->group(function () {
            Route::get('/dashboard', [DonorDashboardController::class, 'index'])->name('dashboard');
        });

    // needy routes
    Route::prefix('needy')
        ->middleware('role:needy')
        ->name('needy.')
        ->group(function () {
            Route::get('/dashboard', [NeedyDashboardController::class, 'index'])->name('dashboard');
        });
});
