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
        $historiesData = [];
        $requestsData = [];
        $usersData = [];

        $querySearchResult = $this->queryFilter(
            request(['search', 'type', 'status']),
            $request->user()
        );

        if ($user->hasRole('donor')) {
            // user donation histories
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
        }

        if ($user->hasRole('admin')) {
            // all user donation histories
            $usersData = Donation::select([
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
            $requestsData = DonationRequest::select([
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
        }

        return Inertia::render('Donations', [
            'bankAccounts' => $bankAccounts,
            'historiesData' => $historiesData,
            'requestsData' => $requestsData,
            'usersData' => $usersData,
            'querySearchResult' => $querySearchResult,
            'queryParams' => request(['search', 'type', 'status'])
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

    protected function queryFilter($params, $user)
    {
        if (count($params) == 0) {
            return [];
        }

        if (array_key_exists('status', $params)) {
            if ($params['type'] == 'admin-request') {
                return DonationRequest::select([
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
                    ->where('status', $params['status'])
                    ->paginate(13, ['*'], 'requests');
            }

            if ($params['type'] == 'needy-requests') {
                return DonationRequest::select([
                    'id',
                    'title',
                    'currently_received',
                    'target_amount',
                    'status',
                    'is_verified',
                    'created_at',
                    'verification_expiry_at'
                ])
                    ->where('user_id', $user->id)
                    ->where('status', $params['status'])
                    ->paginate(13, ['*'], 'requests');
            }
        }

        if (array_key_exists('search', $params)) {
            $searchParam = $params['search'];

            if ($params['type'] == 'histories') {
                return Donation::select([
                    'id',
                    'user_id',
                    'donation_request_id',
                    'amount',
                    'bill_url',
                    'created_at'
                ])
                    ->with(['donationRequest' => function ($query) {
                        return $query->select([
                            'id',
                            'user_id',
                            'title',
                            'currently_received',
                            'target_amount'
                        ])->with(['user' => function ($query) {
                            return $query->select(['id', 'name']);
                        }]);
                    }])
                    ->where(function ($query) use ($searchParam) {
                        $query->whereHas('donationRequest', function ($query) use ($searchParam) {
                            $query->where('title', 'like', '%' . $searchParam . '%');
                        })
                            ->orWhereHas('donationRequest.user', function ($query) use ($searchParam) {
                                $query->where('name', 'like', '%' . $searchParam . '%');
                            });
                    })
                    ->where('user_id', $user->id)
                    ->limit(10)
                    ->get();
            }

            if ($params['type'] == 'admin-requests') {
                return DonationRequest::select([
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
                    ->where(function ($query) use ($searchParam) {
                        $query->where('title', 'like', '%' . $searchParam . '%')
                            ->orWhereHas('user', function ($query) use ($searchParam) {
                                $query->where('name', 'like', '%' . $searchParam . '%');
                            });
                    })
                    ->limit(10)
                    ->get();
            }

            if ($params['type'] == 'users') {
                return Donation::select([
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
                }])
                    ->with(['user' => function ($query) {
                        return $query->select(['id', 'name']);
                    }])
                    ->whereHas('user', function ($query) use ($searchParam) {
                        $query->where('name', 'like', '%' . $searchParam . '%');
                    })
                    ->orWhere(function ($query) use ($searchParam) {
                        $query->whereHas('donationRequest', function ($query) use ($searchParam) {
                            $query->where('title', 'like', '%' . $searchParam . '%');
                        })
                        ->orWhereHas('donationRequest.user', function ($query) use ($searchParam) {
                            $query->where('name', 'like', '%' . $searchParam . '%');
                        });
                    })
                    ->limit(10)
                    ->get();
            }

            if ($params['type'] == 'needy-requests') {
                return DonationRequest::select([
                    'id',
                    'title',
                    'currently_received',
                    'target_amount',
                    'status',
                    'is_verified',
                    'created_at',
                    'verification_expiry_at'
                ])
                    ->where('title', 'like', '%' . $searchParam . '%')
                    ->limit(10)
                    ->get();
            }
        }
    }
}
