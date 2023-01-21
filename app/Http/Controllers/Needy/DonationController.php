<?php

namespace App\Http\Controllers\Needy;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\DonationRequest;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $bankAccounts = (new BankController)->getIdAndAccountNumber();

        $requestsData = (new DonationRequestController)->index();

        return compact("bankAccounts", "requestsData");
    }
}
