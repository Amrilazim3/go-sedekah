<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $donationRequestsIds = $user->donationRequests()->pluck('id');
        
        return [
            'accumulatedDonation' => Donation::sum('amount'),
            'thisMonthAccumulatedDonation' => Donation::whereBetween('created_at', [$start, $end])->sum('amount'),
            'thisMonthDonors' => Donation::select('user_id')
                ->whereIn('donation_request_id', $donationRequestsIds)
                ->whereBetween('created_at', [$start, $end])
                ->distinct()
                ->get()
                ->count(),
            'recentApprovedDonationRequest' => DonationRequest::where('status', 'approved')
                ->with(['user' => function ($query) {
                    $query->select(['id', 'name']);
                }])
                ->orderByDesc('created_at')
                ->get(),
            'totalUsers' => [
                'admin' => User::role('admin')->get()->count(),
                'donor' => User::role('donor')->get()->count(),
                'needy' => User::role('needy')->get()->count()
            ]
        ];
    }
}
