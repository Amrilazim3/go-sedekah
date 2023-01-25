<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\Admin\Role\NeedyRoleAdded;
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

        $response->assertSessionHas('jetstream.flash.banner');

        $response->assertRedirectToRoute('admin.users.index');
    }
}
