<?php

namespace App\Http\Controllers\Needy;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $donationRequestsIds = $user->donationRequests()->pluck('id');

        return [
            'donationReceivedTotalAmount' => $user->donationRequests()
                ->sum('currently_received'),
            'donationRequestsMade' => $user->donationRequests()->count(),
            'totalDonator' => Donation::select('user_id')
                ->whereIn('donation_request_id', $donationRequestsIds)
                ->distinct()
                ->get()
                ->count(),
            'recentDonationRequest' => DonationRequest::where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->first(),
            'recentDonator' => Donation::whereIn('donation_request_id', $donationRequestsIds)
                ->orderByDesc('created_at')->with(['user' => function ($query) {
                    $query->select('id', 'name');
                }])->first()
        ];
    }
}
