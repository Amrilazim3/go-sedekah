<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'amril azim',
            'email' => 'a.azim0711@gmail.com',
            'password' => 'asdasdasd'
        ]);

        User::create([
            'name' => 'admin owner',
            'email' => 'go.sedekah0711@gmail.com',
            'password' => 'asdasdasd'
        ]);

        $firstNeedy = User::create([
            'name' => 'fulan bin fulan',
            'email' => 'fulan177@gmail.com',
            'password' => 'asdasdasd'
        ]);

        User::factory(10)->unverified()->create();
    }
}
