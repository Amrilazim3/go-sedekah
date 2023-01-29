<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Needy\BankController;
use App\Http\Controllers\WelcomeController;
use Billplz\Laravel\Billplz;
use GuzzleHttp\Client;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [WelcomeController::class, 'index']);

Route::post('donations/{donationRequest}', [DonationController::class, 'store'])->name('donations.donate.store');
Route::get('donations/response', [DonationController::class, 'response'])->name('donations.response');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/donations', [
        App\Http\Controllers\DonationController::class,
        'index'
    ])->name('donations.index');

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
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

            Route::patch('/donation-request/{donationRequest}/approve', [
                App\Http\Controllers\Admin\DonationRequestController::class, 'approve'
            ])->name('donationRequest.approve');
            Route::patch('/donation-request/{donationRequest}/reject', [
                App\Http\Controllers\Admin\DonationRequestController::class, 'reject'
            ])->name('donationRequest.reject');
        });

    Route::middleware('role:needy')
        ->prefix('needy')
        ->name('needy.')
        ->group(function () {
            Route::get('/banks', [BankController::class, 'index'])->name('banks.index');
            Route::post('/banks', [BankController::class, 'store'])->name('banks.store');
            Route::delete('/banks/{bank}', [BankController::class, 'destroy'])->name('banks.destroy');

            Route::post('/donation-request', [
                App\Http\Controllers\Needy\DonationRequestController::class,
                'store'
            ])->name('donationRequest.store');
            Route::delete('/donation-request/{donationRequest}', [
                App\Http\Controllers\Needy\DonationRequestController::class,
                'destroy'
            ])->name('donationRequest.destroy');
        });
});
