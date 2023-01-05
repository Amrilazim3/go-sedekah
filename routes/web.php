<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users');

            Route::post(
                '/users/{user}/assign-role/admin',
                [UserController::class, 'assignAdminRole']
            )->name('users.assignAdminRole');

            Route::post(
                '/users/{user}/assign-role/needy',
                [UserController::class, 'assignNeedyRole']
            )->name('users.assignNeedyRole');

            Route::delete(
                '/users/{user}/remove-role/admin',
                [UserController::class, 'removeAdminRole']
            )->name('users.assignNeedyRole');

            Route::delete(
                '/users/{user}/remove-role/needy',
                [UserController::class, 'removeNeedyRole']
            )->name('users.assignNeedyRole');
        });
});
