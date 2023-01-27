<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\BankDetail;
use App\Models\User;
use Database\Seeders\BankDetailSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BankTest extends TestCase
{
    use RefreshDatabase;

    public function test_bank_screen_can_be_rendered()
    {
        $this->seed(RoleSeeder::class);

        $this->actingAs(
            $user = User::factory()
                ->afterCreating(function (User $user) {
                    $user->assignRole('needy');
                })
                ->create()
        );

        $response = $this->get('needy/banks');

        $response->assertSeeInOrder([
            'banksName',
            'banks'
        ]);

        $response->assertOk();
    }

    public function test_can_add_new_bank()
    {
        $this->seed([
            BankDetailSeeder::class,
            RoleSeeder::class,
        ]);

        $this->actingAs(
            $user = User::factory()
                ->afterCreating(function (User $user) {
                    $user->assignRole('needy');
                })
                ->create()
        );

        $response = $this->post('/needy/banks', [
            'name' => fake()->name(),
            'bankAccountNumber' => $bankAccountNumber = "1515" . strval(fake()->randomNumber(8, true)), // maybank account number
            'bankAccountIc' => $bankAccountIc = fake()->numberBetween(pow(10, 11), pow(10, 12) - 1),
            'bankCode' => BankDetail::where('name', 'Maybank')->first()->code
        ]);

        $this->assertDatabaseHas('banks', [
            'ic_number' => $bankAccountIc,
            'account_number' => $bankAccountNumber
        ]);

        $response->assertSessionHas('jetstream.flash.banner', 'Bank account successfully added.');

        $response->assertRedirectToRoute('needy.banks.index');
    }

    public function test_can_delete_created_bank()
    {
        $this->seed([
            BankDetailSeeder::class,
            RoleSeeder::class,
        ]);

        $this->actingAs(
            $user = User::factory()
                ->afterCreating(function (User $user) {
                    $user->assignRole('needy');
                })
                ->create()
        );

        $bank = Bank::factory()->create();

        $response = $this->delete('/needy/banks/' . $bank->id);

        $this->assertDatabaseMissing('banks', [
            'id' => $bank->id
        ]);

        $response->assertSessionHas('jetstream.flash.banner', 'Bank account successfully deleted.');

        $response->assertRedirectToRoute('needy.banks.index');
    }
}
