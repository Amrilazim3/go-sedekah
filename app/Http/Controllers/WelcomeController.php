<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationRequest;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index()
    {
        $donationRequestsData = DonationRequest::select([
            'id',
            'user_id',
            'title',
            'detail',
            'currently_received',
            'target_amount',
            'created_at'
        ])
            ->with(['user' => function ($query) {
                $query->select([
                    'id',
                    'name'
                ]);
            }])
            ->where('status', 'approved')
            ->whereColumn('currently_received', '!=', 'target_amount')
            ->paginate(6);

        $recentDonationsData = Donation::select(
            'id',
            'user_id',
            'bill_id',
            'amount',
            'is_hidden',
            'created_at',
        )
            ->orderBy('created_at', 'desc')
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->limit(5)
            ->get();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'donationRequestsData' => $donationRequestsData,
            'recentDonationsData' => $recentDonationsData
        ])
            ->with('jetstream.flash.billplzID', session()->get('jetstream.flash.billplzID'))
            ->with('jetstream.flash.successPayment', session()->get('jetstream.flash.successPayment'));
    }
}
