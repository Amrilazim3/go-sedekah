<?php

namespace App\Http\Controllers\Needy;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\DonationRequest;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request, $user)
    {
        // fetch bank account here $bankAccounts here
        $bankAccounts = [];

        $bankAccountsArr = Bank::select([
            'id',
            'user_id',
            'account_number'
        ])->where('user_id', $user->id)->get();

        foreach ($bankAccountsArr as $bank) {
            $bankAccounts[] = [$bank['id'], $bank['account_number']];
        }

        // donation requests 
        $requestsData = DonationRequest::select([
            'id',
            'title',
            'currently_received',
            'target_amount',
            'status',
            'is_verified',
            'created_at',
            'verification_expiry_at'
        ])->where('user_id', $user->id)->paginate(13, ['*'], 'requests');

        return compact("bankAccounts", "requestsData");
    }
}
