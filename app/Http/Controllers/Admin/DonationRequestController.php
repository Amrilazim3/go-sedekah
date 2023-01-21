<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationRequest;
use Illuminate\Http\Request;

class DonationRequestController extends Controller
{
    public function approve(DonationRequest $donationRequest, Request $request)
    {
        // send email to needy
        $donationRequest->update([
            'status' => 'approved'
        ]);

        $request->session()->flash('jetstream.flash.banner', 'Donation request successfully approved.');
        $request->session()->flash('jetstream.flash.bannerStyle', 'success');

        return redirect()->route('donations.index');
    }

    public function reject(DonationRequest $donationRequest, Request $request)
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
