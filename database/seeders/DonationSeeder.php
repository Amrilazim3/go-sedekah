<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\DonationRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::inRandomOrder()->limit(6)->get();

        foreach ($users as $user) {
            Donation::create([
                'user_id' => $user->id,
                'donation_request_id' => DonationRequest::inRandomOrder()->first()->id,
                'amount' => rand(5, 10),
                'message' => 'hope this can help you',
                'bill_id' => 'abcabcabc',
                'status' => 'completed'
            ]);
        }
    }
}
