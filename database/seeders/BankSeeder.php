<?php

namespace Database\Seeders;

use App\Models\BankDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $needy = User::where('email', 'fulan177@gmail.com')->first();

        $needy->banks()->create([
            'bank_detail_id' => BankDetail::first()->id,
            'name_on_card' => $needy->name,
            'ic_number' => '080901092212',
            'account_number' => '151580443323',
            'status' => 'verified'
        ]);
    }
}
