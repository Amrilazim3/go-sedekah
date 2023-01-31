<?php

namespace App\Jobs;

use App\Models\DonationRequest;
use App\Models\User;
use App\Notifications\Admin\Donation\RequestVerificationExpired;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class VerifyDonationExpiration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $donationRequest;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DonationRequest $donationRequest)
    {
        $this->donationRequest = $donationRequest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->donationRequest->is_verified) {
            $admins = User::role('admin')->get();

            Notification::send(
                $admins, new RequestVerificationExpired($this->donationRequest)
            );
        }
    }
}
