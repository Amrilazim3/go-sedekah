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
        // fetch bank account
        $bankController = new BankController;
        $bankAccounts = $bankController->getIdAndAccountNumber($user);

        // donation requests
        $donationRequestController = new DonationRequestController;
        $requestsData = $donationRequestController->index($user);

        return compact("bankAccounts", "requestsData");
    }
}
