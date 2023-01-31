<?php

namespace Tests\Feature;

use App\Models\Bank;
use App\Models\BankDetail;
use App\Models\DonationRequest;
use App\Models\User;
use App\Notifications\Admin\Donation\RequestApproved;
use App\Notifications\Admin\Donation\RequestRejected;
use App\Notifications\Admin\Donation\RequestVerified;
use App\Notifications\Needy\Donation\RequestDeleted;
use App\Notifications\Needy\Donation\RequestSent;
use Database\Seeders\BankDetailSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DonationRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_needy_user_can_make_donation_request()
    {
        Notification::fake();

        $this->seed([
            BankDetailSeeder::class,
            RoleSeeder::class
        ]);

        $admins = User::factory(2)->create()->each(function ($user) {
            $user->assignRole('admin');
        });

        $this->actingAs($user = User::factory()->create());

        $user->assignRole('needy');

        $bankDetail = BankDetail::first();

        $bank = Bank::create([
            'user_id' => $user->id,
            'bank_detail_id' => $bankDetail->id,
            'name_on_card' => fake()->name(),
            'ic_number' => fake()->numberBetween(pow(10, 11), pow(10, 12) - 1),
            'account_number' => fake()->creditCardNumber(null, false, ''),
        ]);

        $response = $this->post('/needy/donation-request', [
            'bankAccountId' => $bank->id,
            'title' => fake()->word(),
            'detail' => fake()->paragraph(1),
            'targetAmount' => rand(10, 100)
        ]);

        Notification::assertSentTo(
            $admins,
            RequestSent::class
        );

        $response->assertRedirectToRoute('donations.index');
    }

    public function test_needy_user_can_delete_donation_request()
    {
        Notification::fake();

        $this->seed([
            BankDetailSeeder::class,
            RoleSeeder::class
        ]);

        $admins = User::factory(2)->create()->each(function ($user) {
            $user->assignRole('admin');
        });

        $this->actingAs($user = User::factory()->create());

        $user->assignRole('needy');

        $bankDetail = BankDetail::first();

        $bank = Bank::create([
            'user_id' => $user->id,
            'bank_detail_id' => $bankDetail->id,
            'name_on_card' => fake()->name(),
            'ic_number' => fake()->numberBetween(pow(10, 11), pow(10, 12) - 1),
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

        Notification::assertSentTo(
            $admins,
            RequestDeleted::class
        );

        $response->assertRedirectToRoute('donations.index');
    }

    public function test_admin_user_can_approve_donation_request()
    {
        Notification::fake();

        $this->seed(RoleSeeder::class);

        Bank::factory()
            ->has(DonationRequest::factory()
                ->count(3)
                ->state(function (array $attributes, Bank $bank) {
                    return [
                        'user_id' => $bank->user_id,
                        'bank_id' => $bank->id
                    ];
                }))
            ->create();

        $this->actingAs($user = User::factory()->create());

        $user->assignRole('admin');

        $donationRequest = DonationRequest::first();

        $response = $this->patch('/admin/donation-request/' . $donationRequest->id . '/approve');

        $this->assertDatabaseHas('donation_requests', [
            'user_id' => $donationRequest->user_id,
            'status' => 'approved'
        ]);

        $needyUser = User::where('id', $donationRequest->user_id)->first();
        Notification::assertSentTo(
            $needyUser, RequestApproved::class
        );

        $response->assertRedirectToRoute('donations.index');
    }

    public function test_admin_user_can_reject_donation_request()
    {
        Notification::fake();

        $this->seed(RoleSeeder::class);

        Bank::factory()
            ->has(DonationRequest::factory()
                ->count(3)
                ->state(function (array $attributes, Bank $bank) {
                    return [
                        'user_id' => $bank->user_id,
                        'bank_id' => $bank->id
                    ];
                }))
            ->create();

        $this->actingAs($user = User::factory()->create());

        $user->assignRole('admin');

        $donationRequest = DonationRequest::first();

        $response = $this->patch('/admin/donation-request/' . $donationRequest->id . '/reject');

        $this->assertDatabaseHas('donation_requests', [
            'user_id' => $donationRequest->user_id,
            'status' => 'rejected'
        ]);

        $needyUser = User::where('id', $donationRequest->user_id)->first();
        Notification::assertSentTo(
            $needyUser, RequestRejected::class
        );

        $response->assertRedirectToRoute('donations.index');
    }

    public function test_admin_user_can_verify_donation_request()
    {
        Notification::fake();

        $this->seed(
            RoleSeeder::class
        );
        
        $donationRequest = DonationRequest::factory()->create();

        $admin = User::factory()->afterCreating(function (User $user) {
            $user->assignRole('admin');
        })->create();

        $this->actingAs($admin);

        $response = $this->patch('/admin/donation-request/' . $donationRequest->id . '/verify');

        $this->assertDatabaseHas('donation_requests', [
            'id' => $donationRequest->id,
            'is_verified' => 1,
        ]);

        Notification::assertSentTo(
            User::find($donationRequest->user_id),
            RequestVerified::class
        );

        $response->assertStatus(302);
    }
}
