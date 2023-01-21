<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request, $user)
    {
        $historiesData = Donation::select([
            'id',
            'user_id',
            'donation_request_id',
            'amount',
            'bill_url',
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
        }])->where('user_id', $user->id)->paginate(13, ['*'], 'histories');

        return compact("historiesData");
    }
}
