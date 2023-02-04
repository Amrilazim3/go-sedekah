<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return [
            'totalDonationAmount' => Donation::where('user_id', $request->user()->id)->sum('amount'),
            'recentDonation' => Donation::with(['donationRequest' => function ($query) {
                $query->with(['user' => function ($query) {
                    $query->select(['id', 'name']);
                }]);
            }])
                ->where('user_id', $request->user()->id)
                ->orderByDesc('created_at')
                ->first()
        ];
    }
}
