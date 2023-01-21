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
        $roles = $user->roles->transform(function ($item) {
            return $item->name;
        })->toArray();
        $bankAccounts = [];
        $historiesData = [];
        $requestsData = [];
        $usersData = [];
        $querySearchResult = $this->queryFilter(
            request(['search', 'type', 'status']),
            $request->user()
        );

        foreach ($roles as $role) {
            $ucRole = ucfirst($role);
            $controller = "App\\Http\\Controllers\\$ucRole\\DonationController";
            $controller = new $controller;

            $donationData = $controller->index($request, $user);
            foreach ($donationData as $dataKey => $data) {
                ${$dataKey} = $data;
            }
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

    protected function queryFilter($params, $user)
    {
        if (count($params) == 0) {
            return [];
        }

        if (array_key_exists('status', $params)) {
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
