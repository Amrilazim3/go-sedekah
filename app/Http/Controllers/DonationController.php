<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Donation;
use App\Models\DonationRequest;
use App\Models\User;
use Billplz\Laravel\Billplz;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $roles = $user->roles->transform(function ($item) {
            return $item->name;
        })->toArray();
        $dataRoles = [];

        foreach ($roles as $role) {
            $controller = "App\\Http\\Controllers\\" . ucfirst($role) . "\\DonationController";

            $dataRoles[$role] = (new $controller)->index($request);
        }

        $queryResult = [];

        if (count(request(['role', 'model'])) > 0) {
            $queryController = "App\\Http\\Controllers\\"
                . ucfirst(request('role')) .
                "\\"
                . request('model')
                . "Controller";
            $urlParts = parse_url($request->getRequestUri());
            parse_str($urlParts['query'], $queryParamResults);
            $firstQueryParamKey = array_keys($queryParamResults)[0]; // either 'search' or 'status'

            $queryMethod = "query" . ucfirst($firstQueryParamKey) . "Filter";
            $queryResult = (new $queryController)->{$queryMethod}(request($firstQueryParamKey));
        }

        return Inertia::render('Donations', [
            'dataRoles' => $dataRoles,
            'queryResult' => $queryResult,
            'queryParams' => request(['search', 'status', 'role', 'model'])
        ])
            ->with('jetstream.flash.banner', session()->get('jetstream.flash.banner'))
            ->with('jetstream.flash.bannerStyle', session()->get('jetstream.flash.bannerStyle'));
    }

    public function store(DonationRequest $donationRequest, Request $request)
    {
        $maxDonationAmount = $donationRequest->target_amount - $donationRequest->currently_received;

        $request->validate([
            'name' => ['required', 'max:20'],
            'email' => ['required', 'email'],
            'amount' => ['required', 'min:2', 'max:' . $maxDonationAmount],
            'message' => ['required', 'max:200']
        ]);

        $user = auth()->user();

        if ($user == null) {
            $user = User::firstOrCreate([
                'name' => $request->name,
                'email' => $request->email,
                'password' => null,
            ]);
        }

        try {
            $bill = Billplz::bill()->create(
                config('services.billplz.collection_id'),
                $user->email,
                null,
                $user->name,
                intval($request->amount . 000),
                'http://localhost',
                $request->message,
                [
                    'redirect_url' => 'http://localhost/donations/response'
                ]
            );

            Donation::create([
                'user_id' => $user->id,
                'donation_request_id' => $donationRequest->id,
                'bill_id' => $bill->toArray()['id'],
                'amount' => $request->amount,
                'message' => $request->message,
                'is_hidden' => $request->isHidden,
                'status' => 'pending'
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Something when wrong, please try again.');
        }

        $request->session()->flash('jetstream.flash.billplzID', $bill->toArray()['url']);
        return redirect()->back();
    }

    public function response(Request $request)
    {
        $donation = Donation::where('bill_id', $request->billplz['id'])->first();
        $donationRequest = DonationRequest::where('id', $donation->donation_request_id)->first();

        if ($request->billplz['paid'] == 'true') {
            $newCurrentlyReceived = $donationRequest->currently_received + $donation->amount;
            
            $donationRequest->update([
                'currently_received' => $newCurrentlyReceived
            ]);

            $donation->update([
                'status' => 'paid'
            ]);

            // send notification to donation request's owner.
        }

        $request->session()->flash('jetstream.flash.successPayment', true);
        return redirect('/');
    }
}
