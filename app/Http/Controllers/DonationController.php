<?php

namespace App\Http\Controllers;

use App\Events\RecentDonation;
use App\Jobs\VerifyDonationExpiration;
use App\Models\Bank;
use App\Models\Donation;
use App\Models\DonationRequest;
use App\Models\User;
use App\Notifications\Donor\SuccessfulDonation;
use App\Notifications\Needy\Donation\VerificationExpiration;
use Billplz\Laravel\Billplz;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
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
        $maxDonationAmount = $this->getMaxDonationAmount($donationRequest);

        $request->validate([
            'name' => ['required', 'max:20'],
            'email' => ['required', 'email'],
            'amount' => ['required', 'integer', 'min:2', 'max:' . $maxDonationAmount],
            'message' => ['required', 'max:200']
        ]);

        $user = $request->user();

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
                intval($request->amount . "00"),
                config('app.url'),
                $request->message,
                [
                    'redirect_url' => config('app.url') . '/donations/response'
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
            return redirect()->back()->withErrors('Something when wrong, please try again.', 'billplzError');
        }

        $request->session()->flash('jetstream.flash.billplzID', $bill->toArray()['url']);
        return redirect()->back();
    }

    public function response(Request $request)
    {
        $donation = Donation::where('bill_id', $request->billplz['id'])->first();
        $donationRequest = DonationRequest::where('id', $donation->donation_request_id)->first();

        if ($request->billplz['paid'] == 'false') {
            $donation->delete();

            $request->session()->flash('jetstream.flash.successPayment', false);
            return redirect('/');
        }

        $donationRequest->update([
            'currently_received' => $donationRequest->currently_received + $donation->amount
        ]);

        if ($donationRequest->target_amount == $donationRequest->currently_received) {
            $donationRequest->setVerificationExpiryDate();

            Notification::send(
                User::find($donationRequest->user_id),
                new VerificationExpiration($donationRequest)
            );

            VerifyDonationExpiration::dispatch($donationRequest)->delay(now()->addDays(7));
        }

        $donation->update([
            'status' => 'paid'
        ]);

        Notification::send(
            User::find($donationRequest->user_id),
            new SuccessfulDonation($donation)
        );

        RecentDonation::dispatch(
            Donation::select(
                'id',
                'user_id',
                'bill_id',
                'amount',
                'is_hidden',
                'created_at',
            )
                ->with(['user' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->find($donation->id)
                ->toArray()
        );

        $request->session()->flash('jetstream.flash.successPayment', true);
        return redirect('/');
    }

    protected function getMaxDonationAmount(DonationRequest $donationRequest)
    {
        $pendingAmount = 0;
        Donation::where('status', 'pending')->chunk(10, function ($donations) use ($pendingAmount) {
            foreach ($donations as $donation) {
                $pendingAmount += $donation->amount;
            }
        });

        return $donationRequest->target_amount - ($donationRequest->currently_received + $pendingAmount);
    }
}
