<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminPersmissions = ['view needy', 'view users', 'approve request donation'];
        $donorPermissions = ['send donation'];
        $needyPermissions = ['request donation', 'send donation'];

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $donor = Role::firstOrCreate(['name' => 'donor']);
        $needy = Role::firstOrCreate(['name' => 'needy']);

        foreach ($adminPersmissions as $adminPersmission) {
            $permission = Permission::firstOrCreate(['name' => $adminPersmission]);
            $admin->givePermissionTo($permission);
        }

        foreach ($donorPermissions as $donorPermission) {
            $permission = Permission::firstOrCreate(['name' => $donorPermission]);
            $donor->givePermissionTo($permission);
        }

        foreach ($needyPermissions as $needyPermission) {
            $permission = Permission::firstOrCreate(['name' => $needyPermission]);
            $needy->givePermissionTo($permission);
        }
    }
}
