<?php

namespace Tests\Feature;

use App\Models\DonationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationTest extends TestCase
{
    use RefreshDatabase;

    public function test_donations_screen_can_be_rendered()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->get('/donations');

        $response->assertSeeInOrder([
            'props',
            'dataRoles',
            'queryResult',
            'queryParams'
        ], false);

        $response->assertOk();
    }

    public function test_user_can_give_donation()
    {
        $donationRequest = DonationRequest::factory()->create();

        $this->actingAs($user = User::factory()->create());

        $response = $this->post('/donations/' . $donationRequest->id, [
            'name' => $user->name,
            'email' => $user->email,
            'amount' => rand(50, 100),
            'message' => fake()->paragraph(1),
            'isHidden' => false,
        ]);

        $this->assertDatabaseHas('donations', [
            'user_id' => $user->id,
            'donation_request_id' => $donationRequest->id,
        ]);

        $response->assertStatus(302);
    }

    public function test_user_can_donate_without_authenticated()
    {
        $donationRequest = DonationRequest::factory()->create();

        $response = $this->post('/donations/' . $donationRequest->id, [
            'name' => $name = fake()->name(),
            'email' => $email = fake()->email(),
            'amount' => $amount = rand(5, 10),
            'message' => $message = fake()->paragraph(1),
            'isHidden' => $isHidden = false,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);

        $this->assertDatabaseHas('donations', [
            'amount' => $amount,
            'message' => $message,
            'is_hidden' => $isHidden
        ]);

        $response->assertStatus(302);
    }

    public function test_set_date_for_verification_expiry_at_column_if_target_amount_has_reached_goal()
    {
        $donationRequest = DonationRequest::factory()->create();

        $donationRequest->setVerificationExpiryDate();

        $this->assertTrue(
            Carbon::parse($donationRequest->verification_expiry_at)->format('Y-m-d')
            == 
            date(Carbon::now()->addDays(7)->format('Y-m-d'))
        );
    }
}
