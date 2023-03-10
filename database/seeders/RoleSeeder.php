<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'donor', 'needy'];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role
            ]);
        }

        User::chunk(20, function ($users) {
            foreach ($users as $user) {
                if ($user->email == 'a.azim0711@gmail.com' || $user->email == 'go.sedekah0711@gmail.com') {
                    $user->assignRole('donor');
                    $user->assignRole('admin');
                } else {
                    $user->assignRole('donor');
                }
            }
        });
    }
}
