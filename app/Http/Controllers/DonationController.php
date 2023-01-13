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

        // for needy form
        $bankAccounts = [];
        $histories = [];
        $requests = [];
        $users = [];

        if ($user->hasRole('admin')) {
            // user donation histories
            $histories = Donation::select([
                'id',
                'user_id',
                'donation_request_id',
                'amount',
                'created_at'
            ])->with(['donationRequest' => function ($query) {
                return $query->select([
                    'id',
                    'user_id',
                    'title'
                ])->with(['user' => function ($query) {
                    return $query->select(['id', 'name']);
                }]);
            }])->where('user_id', $user->id)->paginate(13);

            // all user donation histories
            $users = Donation::select([
                'id',
                'user_id',
                'donation_request_id',
                'amount'
            ])->with(['donationRequest' => function ($query) {
                return $query->select([
                    'id',
                    'user_id',
                    'title'
                ])->with(['user' => function ($query) {
                    return $query->select(['id', 'name']);
                }]);
            }])->paginate(13);

            // all user donation requests
            $requests = DonationRequest::select([
                'id',
                'user_id',
                'title',
                'details',
                'currently_received',
                'target_amount',
                'status',
                'created_at'
            ])->with(['user' => function ($query) {
                return $query->select(['id', 'name']);
            }])->paginate(13);
        }

        if ($user->hasRole('donor')) {
            // user donation histories
            $histories = Donation::select([
                'id',
                'user_id',
                'donation_request_id',
                'amount',
                'created_at'
            ])->with(['donationRequest' => function ($query) {
                return $query->select([
                    'id',
                    'user_id',
                    'title'
                ])->with(['user' => function ($query) {
                    return $query->select(['id', 'name']);
                }]);
            }])->where('user_id', $user->id)->paginate(13);
        }

        if ($user->hasRole('needy')) {
            // fetch bank account here $bankAccounts here
            $bankAccounts = Bank::select([
                'id',
                'user_id',
                'account_number'
            ])->where('user_id', $user->id)->get();

            // user donation histories
            $histories = Donation::select([
                'id',
                'user_id',
                'donation_request_id',
                'amount',
                'created_at'
            ])->with(['donationRequest' => function ($query) {
                return $query->select([
                    'id',
                    'user_id',
                    'title'
                ])->with(['user' => function ($query) {
                    return $query->select(['id', 'name']);
                }]);
            }])->where('user_id', $user->id)->paginate(13);

            // donation requests 
            $requests = DonationRequest::select([
                'id',
                'title',
                'currently_received',
                'target_amount',
                'status',
                'created_at'
            ])->where('user_id', $user->id)->paginate(13);
        }

        return Inertia::render('Donations', [
            'bankAccounts' => $bankAccounts,
            'histories' => $histories,
            'requests' => $requests,
            'users' => $users,
        ]);
    }
}
