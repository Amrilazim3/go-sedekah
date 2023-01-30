<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    const DONATION_COLUMN = [
        'id',
        'user_id',
        'bill_id',
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
        $historiesData = Donation::select(self::DONATION_COLUMN)
            ->with(['donationRequest' => function ($query) {
                return $query->select(self::DONATION_REQUEST_COLUMN)
                    ->with(['user' => function ($query) {
                        return $query->select(self::USER_COLUMN);
                    }]);
            }])->where('user_id', auth()->user()->id)->paginate(13, ['*'], 'histories');

        return compact("historiesData");
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
            ->where(function ($query) use ($search) {
                $query->whereHas('donationRequest', function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('donationRequest.user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->where('user_id', auth()->user()->id)
            ->limit(10)
            ->get();
    }
}
