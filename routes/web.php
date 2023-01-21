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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/donations', [
        App\Http\Controllers\DonationController::class,
        'index'
    ])->name('donations.index');

    Route::post('/donation-request', [
        App\Http\Controllers\Needy\DonationRequestController::class,
        'store'
    ])->name('donationRequest.store');
    Route::delete('/donation-request/{donationRequest}', [
        App\Http\Controllers\Needy\DonationRequestController::class,
        'destroy'
    ])->name('donationRequest.destroy');
    Route::patch('/donation-request/{donationRequest}/approve', [
        App\Http\Controllers\Admin\DonationRequestController::class, 'approve'
    ])->name('donationRequest.approve');
    Route::patch('/donation-request/{donationRequest}/reject', [
        App\Http\Controllers\Admin\DonationRequestController::class, 'reject'
    ])->name('donationRequest.reject');

    Route::post('/billplz', function (Request $request) {
        // $bill = Billplz::bill()->create('bgs0cicq', 'amril@gmail.com', '0172374050', 'amril azim', 23000, 'http://localhost', 'donation for fulan bin fulan', ['redirect_url' => 'http://localhost']);

        // to create open collection
        // Billplz::openCollection()->create();

        // to create bank account
        // $newBankAcc = Billplz::bank()->create('ESMAN HANIF BIN KHAIRUL ANWAR', '030307090212', '151587221231', 'MBBEMYKL', false);
        // $newBankAcc = Billplz::bank()->get('151587221231');
        // dd($newBankAcc);

        // $client = new Client();
        // $client->request('GET', 'https://www.billplz-sandbox.com/api/v3/bank_verification_services/151587221231');

        // get bank account
        // dd(Http::withBasicAuth('fe3b1a4d-889f-404e-9fcf-59f2314e83a1:', '')->get('https://www.billplz-sandbox.com/api/v3/bank_verification_services/151587221231')->json());

        // get open collection 
        // dd(Http::withBasicAuth('fe3b1a4d-889f-404e-9fcf-59f2314e83a1:', '')->get('https://www.billplz-sandbox.com/api/v3/open_collections/b_xg5irk')->json());

        // get bill
        // dd(Http::withBasicAuth('fe3b1a4d-889f-404e-9fcf-59f2314e83a1:', '')->get('https://www.billplz-sandbox.com/api/v3/bills/o3ieijra')->json());
    });

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
        });

    Route::middleware('role:needy')
        ->prefix('needy')
        ->name('needy.')
        ->group(function () {
            Route::get('/banks', [BankController::class, 'index'])->name('banks.index');
            Route::post('/banks', [BankController::class, 'store'])->name('banks.store');
            Route::delete('/banks/{bank}', [BankController::class, 'destroy'])->name('banks.destroy');
        });
});
