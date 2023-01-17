<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Donation;
use App\Models\DonationRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $bankAccounts = [];
        $histories = [];
        $requests = [];
        $users = [];

        if ($user->hasRole('donor')) {
            // user donation histories
            $histories = Donation::select([
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
        }

        if ($user->hasRole('admin')) {
            // all user donation histories
            $users = Donation::select([
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
            $requests = DonationRequest::select([
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
        }

        if ($user->hasRole('needy')) {
            // fetch bank account here $bankAccounts here
            $bankAccountsArr = Bank::select([
                'id',
                'user_id',
                'account_number'
            ])->where('user_id', $user->id)->get();

            foreach ($bankAccountsArr as $bank) {
                $bankAccounts[] = [$bank['id'], $bank['account_number']];
            }

            // donation requests 
            $requests = DonationRequest::select([
                'id',
                'title',
                'currently_received',
                'target_amount',
                'status',
                'is_verified',
                'created_at',
                'verification_expiry_at'
            ])->where('user_id', $user->id)->paginate(13, ['*'], 'requests');
        }

        return Inertia::render('Donations', [
            'bankAccounts' => $bankAccounts,
            'histories' => $histories,
            'requests' => $requests,
            'users' => $users,
        ])
            ->with('jetstream.flash.banner', session()->get('jetstream.flash.banner'))
            ->with('jetstream.flash.bannerStyle', session()->get('jetstream.flash.bannerStyle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:50'],
            'detail' => ['required', 'max:200'],
            'targetAmount' => ['required', 'numeric', 'min:10'],
        ]);

        $bank = Bank::where('id', $request->bankAccountId)->first();

        DonationRequest::create([
            'user_id' => $request->user()->id,
            'bank_id' => $bank->id,
            'title' => $request->title,
            'detail' => $request->detail,
            'currently_received' => 0,
            'target_amount' => $request->targetAmount,
        ]);

        // send email to an admin (future)

        $request->session()->flash('jetstream.flash.banner', 'Donation request successfully made.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('donations.index');
    }

    public function destroy(DonationRequest $donationRequest, Request $request)
    {
        $donationRequest->delete();

        // send email to an admin to inform that the request has been deleted.

        $request->session()->flash('jetstream.flash.banner', 'Donation request successfully deleted.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('donations.index');
    }

    public function approveRequest(DonationRequest $donationRequest, Request $request)
    {
        // send email to needy
        $donationRequest->update([
            'status' => 'approved'
        ]);

        $request->session()->flash('jetstream.flash.banner', 'Donation request successfully approved.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('donations.index');
    }

    public function rejectRequest(DonationRequest $donationRequest, Request $request)
    {
        $donationRequest->update([
            'status' => 'rejected'
        ]);

        // send email to needy

        $request->session()->flash('jetstream.flash.banner', 'Donation request successfully rejected.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('donations.index');
    }
}
