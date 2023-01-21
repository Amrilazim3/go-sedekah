<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationRequest;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request, $user)
    {
        // all user donation histories
        $usersData = Donation::select([
            'id',
            'user_id',
            'donation_request_id',
            'amount',
            'created_at'
        ])->with(['donationRequest' => function ($query) {
            return $query->select([
                'id',
                'user_id',
                'currently_received',
                'target_amount',
                'title'
            ])->with(['user' => function ($query) {
                return $query->select(['id', 'name']);
            }]);
        }])->with(['user' => function ($query) {
            return $query->select(['id', 'name']);
        }])
            ->paginate(13, ['*'], 'users');

        // all user donation requests
        $requestsData = DonationRequest::select([
            'id',
            'user_id',
            'title',
            'detail',
            'currently_received',
            'target_amount',
            'status',
            'is_verified',
            'created_at',
            'verification_expiry_at'
        ])->with(['user' => function ($query) {
            return $query->select(['id', 'name']);
        }])
            ->paginate(13, ['*'], 'requests');

        return compact("usersData", "requestsData");
    }
}
