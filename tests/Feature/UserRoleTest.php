<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\Admin\Role\AdminRoleAdded;
use App\Notifications\Admin\Role\AdminRoleRemoved;
use App\Notifications\Admin\Role\NeedyRoleAdded;
use App\Notifications\Admin\Role\NeedyRoleRemoved;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_screen_can_be_rendered()
    {
        $this->seed(RoleSeeder::class);

        $this->actingAs($user = User::factory()->create());

        $user->assignRole('admin');

        $response = $this->get('/admin/users');

        $response->assertOk();
    }

    public function test_assign_needy_role()
    {
        Notification::fake();
        
        $this->seed(RoleSeeder::class);

        $userToBecomeNeedy = User::factory()->create();

        $this->actingAs($admin = User::factory()->afterCreating(function (User $user) {
            $user->assignRole('admin');
        })->create());

        $response = $this->post('/admin/users/' . $userToBecomeNeedy->id . '/assign-role/needy');

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::where('name', 'needy')->first()->id,
            'model_id' => $userToBecomeNeedy->id
        ]);

        Notification::assertSentTo(
            $userToBecomeNeedy, NeedyRoleAdded::class
        );

        $response->assertSessionHas('jetstream.flash.banner', 'Needy role successfully assigned!');

        $response->assertRedirectToRoute('admin.users.index');
    }

    public function test_remove_needy_role()
    {
        Notification::fake();
        
        $this->seed(RoleSeeder::class);

        $needyUser = User::factory()->afterCreating(function (User $user) {
            $user->assignRole('needy');
        })->create();

        $this->actingAs($admin = User::factory()->afterCreating(function (User $user) {
            $user->assignRole('admin');
        })->create());

        $response = $this->delete('/admin/users/' . $needyUser->id . '/remove-role/needy');

        $this->assertDatabaseMissing('model_has_roles', [
            'role_id' => Role::where('name', 'needy')->first()->id,
            'model_id' => $needyUser->id
        ]);
        
        Notification::assertSentTo(
            $needyUser, NeedyRoleRemoved::class
        );

        $response->assertSessionHas('jetstream.flash.banner', 'Needy role successfully removed!');

        $response->assertRedirectToRoute('admin.users.index');
    }

    public function test_assign_admin_role()
    {
        Notification::fake();
        
        $this->seed(RoleSeeder::class);

        $userToBecomeAdmin = User::factory()->create();

        $this->actingAs($admin = User::factory()->afterCreating(function (User $user) {
            $user->assignRole('admin');
        })->create());

        $response = $this->post('/admin/users/' . $userToBecomeAdmin->id . '/assign-role/admin');

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::where('name', 'admin')->first()->id,
            'model_id' => $userToBecomeAdmin->id
        ]);

        Notification::assertSentTo(
            $userToBecomeAdmin, AdminRoleAdded::class 
        );

        $response->assertSessionHas('jetstream.flash.banner', 'Admin role successfully assigned!');

        $response->assertRedirectToRoute('admin.users.index');
    }

    public function test_remove_admin_role()
    {
        Notification::fake();
        
        $this->seed(RoleSeeder::class);

        $adminUser = User::factory()->afterCreating(function (User $user) {
            $user->assignRole('admin');
        })->create();

        $this->actingAs($admin = User::factory()->afterCreating(function (User $user) {
            $user->assignRole('admin');
        })->create());

        $response = $this->delete('/admin/users/' . $adminUser->id . '/remove-role/admin');

        $this->assertDatabaseMissing('model_has_roles', [
            'role_id' => Role::where('name', 'admin')->first()->id,
            'model_id' => $adminUser->id
        ]);
        
        Notification::assertSentTo(
            $adminUser, AdminRoleRemoved::class
        );

        $response->assertSessionHas('jetstream.flash.banner', 'Admin role successfully removed!');

        $response->assertRedirectToRoute('admin.users.index');
    }
}
