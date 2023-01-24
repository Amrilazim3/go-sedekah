<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\BankDetail;
use App\Models\User;
use App\Notifications\Needy\Donation\RequestSent;
use Database\Seeders\BankDetailSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DonationRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_needy_user_can_make_donation_request()
    {
        Bus::fake();

        $this->seed(BankDetailSeeder::class);
        $bankDetail = BankDetail::first();

        $roles = ['needy', 'admin'];
        foreach ($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }

        $this->actingAs($user = User::factory()->create());

        $user->assignRole('needy');

        $bank = Bank::create([
            'user_id' => $user->id,
            'bank_detail_id' => $bankDetail->id,
            'name_on_card' => fake()->name(),
            'ic_number' => '030307010711',
            'account_number' => '151584282718',
        ]);

        $response = $this->post('/needy/donation-request', [
            'bankAccountId' => $bank->id,
            'title' => fake()->word(),
            'detail' => fake()->paragraph(1),
            'targetAmount' => rand(10, 100)
        ]);

        Bus::dispatch(new RequestSent($user));

        $response->assertRedirectToRoute('donations.index');
    }
}
