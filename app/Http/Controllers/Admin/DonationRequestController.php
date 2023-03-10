<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationRequest;
use App\Models\User;
use App\Notifications\Admin\Donation\RequestApproved;
use App\Notifications\Admin\Donation\RequestRejected;
use App\Notifications\Admin\Donation\RequestVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class DonationRequestController extends Controller
{
    const DONATION_REQUEST_COLUMN = [
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
    ];

    const USER_COLUMN = ['id', 'name'];

    public function index()
    {
        return DonationRequest::select(self::DONATION_REQUEST_COLUMN)
            ->with(['user' => function ($query) {
                return $query->select(self::USER_COLUMN);
            }])
            ->paginate(5, ['*'], 'requests');
    }

    public function approve(DonationRequest $donationRequest, Request $request)
    {
        $donationRequest->update([
            'status' => 'approved'
        ]);

        Notification::send(
            User::find($donationRequest->user_id),
            new RequestApproved($donationRequest)
        );

        $request->session()->flash('jetstream.flash.banner', 'Donation request successfully approved.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('donations.index');
    }

    public function reject(DonationRequest $donationRequest, Request $request)
    {
        $donationRequest->update([
            'status' => 'rejected'
        ]);

        Notification::send(
            User::find($donationRequest->user_id),
            new RequestRejected($donationRequest)
        );

        $request->session()->flash('jetstream.flash.banner', 'Donation request successfully rejected.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('donations.index');
    }

    public function querySearchFilter(string $search)
    {
        return DonationRequest::select(self::DONATION_REQUEST_COLUMN)
            ->with(['user' => function ($query) {
                return $query->select(self::USER_COLUMN);
            }])
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->limit(5)
            ->get();
    }

    public function queryStatusFilter(string $status)
    {
        return DonationRequest::select(self::DONATION_REQUEST_COLUMN)
            ->with(['user' => function ($query) {
                return $query->select(self::USER_COLUMN);
            }])
            ->where('status', $status)
            ->paginate(5, ['*'], 'requests');
    }

    public function verify(DonationRequest $donationRequest, Request $request)
    {
        $donationRequest->update([
            'is_verified' => true
        ]);

        Notification::send(
            User::find($donationRequest->user_id),
            new RequestVerified($donationRequest)
        );

        $request->session()->flash('jetstream.flash.banner', 'Donation request successfully verified.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('donations.index');
    }
}
