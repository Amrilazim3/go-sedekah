<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\BankDetail;
use App\Models\DonationRequest;
use App\Models\User;
use App\Notifications\Needy\Donation\RequestDeleted;
use App\Notifications\Needy\Donation\RequestSent;
use Database\Seeders\BankDetailSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DonationRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_needy_user_can_make_donation_request()
    {
        Bus::fake();
        // Queue::fake();

        $this->seed([
            BankDetailSeeder::class,
            RoleSeeder::class
        ]);

        $this->actingAs($user = User::factory()->create());

        $user->assignRole('needy');

        $bankDetail = BankDetail::first();

        $bank = Bank::create([
            'user_id' => $user->id,
            'bank_detail_id' => $bankDetail->id,
            'name_on_card' => fake()->name(),
            'ic_number' => fake()->numberBetween(pow(10, 11), pow(10,12) - 1),
            'account_number' => fake()->creditCardNumber(null, false, ''),
        ]);

        $response = $this->post('/needy/donation-request', [
            'bankAccountId' => $bank->id,
            'title' => fake()->word(),
            'detail' => fake()->paragraph(1),
            'targetAmount' => rand(10, 100)
        ]);

        // Queue::assertPushed(RequestSent::class);

        // Bus::dispatch(new RequestDeleted);
        // Bus::assertDispatched(RequestSent::class);

        $response->assertRedirectToRoute('donations.index');
    }

    public function test_needy_user_can_delete_donation_request()
    {
        Bus::fake();

        $this->seed([
            BankDetailSeeder::class,
            RoleSeeder::class
        ]);

        $this->actingAs($user = User::factory()->create());

        $user->assignRole('needy');

        $bankDetail = BankDetail::first();

        $bank = Bank::create([
            'user_id' => $user->id,
            'bank_detail_id' => $bankDetail->id,
            'name_on_card' => fake()->name(),
            'ic_number' => fake()->numberBetween(pow(10, 11), pow(10,12) - 1),
            'account_number' => fake()->creditCardNumber(null, false, ''),
        ]);

        $donationRequest = DonationRequest::create([
            'user_id' => $user->id,
            'bank_id' => $bank->id,
            'title' => fake()->text(30),
            'detail' => fake()->paragraph(1),
            'currently_received' => 0,
            'target_amount' => rand(10, 100),
        ]);

        $response = $this->delete('/needy/donation-request/' . $donationRequest->id);

        $this->assertModelMissing($donationRequest);

        Bus::dispatch(new RequestSent($user));

        $response->assertRedirectToRoute('donations.index');
    }
}
