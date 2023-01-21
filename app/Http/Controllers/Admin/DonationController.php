<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationRequest;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    const DONATION_COLUMN = [
        'id',
        'user_id',
        'donation_request_id',
        'amount',
        'created_at'
    ];

    const DONATION_REQUEST_COLUMN = [
        'id',
        'user_id',
        'title',
        'currently_received',
        'target_amount'
    ];

    const USER_COLUMN = ['id', 'name'];

    public function index(Request $request)
    {
        // all user donation histories
        $usersData = Donation::select(self::DONATION_COLUMN)
            ->with(['donationRequest' => function ($query) {
                return $query->select(self::DONATION_REQUEST_COLUMN)
                    ->with(['user' => function ($query) {
                        return $query->select(self::USER_COLUMN);
                    }]);
            }])->with(['user' => function ($query) {
                return $query->select(self::USER_COLUMN);
            }])
            ->paginate(13, ['*'], 'users');

        // all user donation requests
        $requestsData = (new DonationRequestController)->index();

        return compact("usersData", "requestsData");
    }

    public function querySearchFilter(string $search)
    {
        return Donation::select(self::DONATION_COLUMN)
            ->with(['donationRequest' => function ($query) {
                return $query->select(self::DONATION_REQUEST_COLUMN)
                    ->with(['user' => function ($query) {
                        return $query->select(self::USER_COLUMN);
                    }]);
            }])
            ->with(['user' => function ($query) {
                return $query->select(self::USER_COLUMN);
            }])
            ->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhere(function ($query) use ($search) {
                $query->whereHas('donationRequest', function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('donationRequest.user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->limit(10)
            ->get();
    }
}
