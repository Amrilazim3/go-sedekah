<?php

namespace Database\Seeders;

use App\Models\DonationRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $requestData = [
            ['I want to buy some medicine', 'I have a headache/stomachache/cold/etc. and need to buy something to alleviate the symptoms.', 150],
            ['Really want a new bicycle', "I'm looking for a specific type of bike that I can't find used, so I want to buy a new one.", 300],
            ['vacation to Japan', "I've heard so many great things about Japan, from the delicious food to the stunning landscapes to the friendly people, and I can't wait to experience it for myself.", 2500],
            ['My grandpa is sick', "My grandpa had a fall while using the toilet and is currently dealing with some health issues.", 1000],
            ['Help me feed my cat', "I'm hoping to find a way to get some help or assistance so that I can buy my cat the food they need.", 200],
            ['Financial problem', "Unfortunately, I'm facing some financial difficulties right now that are making things challenging for me.", 600]
        ];

        $needy = User::where('email', 'fulan177@gmail.com')->first();
        $needyBank = $needy->banks()->first();

        foreach ($requestData as $data) {
            DonationRequest::create([
                'user_id' => $needy->id,
                'bank_id' => $needyBank->id,
                'title' => $data[0],
                'detail' => $data[1],
                'target_amount' => $data[2],
                'status' => 'approved'
            ]);
        }
    }
}
