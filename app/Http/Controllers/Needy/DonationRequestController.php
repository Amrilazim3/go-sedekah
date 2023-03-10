<?php

namespace App\Http\Controllers\Needy;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\DonationRequest;
use App\Models\User;
use App\Notifications\Needy\Donation\RequestDeleted;
use App\Notifications\Needy\Donation\RequestSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class DonationRequestController extends Controller
{
    const DONATION_REQUEST_COLUMN = [
        'id',
        'title',
        'currently_received',
        'target_amount',
        'status',
        'is_verified',
        'created_at',
        'verification_expiry_at'
    ];

    public function index()
    {
        return DonationRequest::select(self::DONATION_REQUEST_COLUMN)
            ->where('user_id', auth()->user()->id)->paginate(13, ['*'], 'requests');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:50'],
            'detail' => ['required', 'max:200'],
            'targetAmount' => ['required', 'numeric', 'min:10'],
            'bankAccountId' => ['required']
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

        // $admins = User::role('admin')->get();
        Notification::send(
            User::role('admin')->get(), 
            new RequestSent(auth()->user())
        );

        $request->session()->flash('jetstream.flash.banner', 'Donation request successfully made.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('donations.index');
    }

    public function destroy(DonationRequest $donationRequest, Request $request)
    {
        $donationRequest->delete();

        Notification::send(
            User::role('admin')->get(), 
            new RequestDeleted(auth()->user())
        );

        $request->session()->flash('jetstream.flash.banner', 'Donation request successfully deleted.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('donations.index');
    }

    public function querySearchFilter(string $search)
    {
        return DonationRequest::select(self::DONATION_REQUEST_COLUMN)
            ->where('user_id', auth()->user()->id)
            ->where('title', 'like', '%' . $search . '%')
            ->limit(10)
            ->get();
    }

    public function queryStatusFilter(string $status)
    {
        return DonationRequest::select(self::DONATION_REQUEST_COLUMN)
            ->where('user_id', auth()->user()->id)
            ->where('status', $status)
            ->paginate(13, ['*'], 'requests');
    }
}
