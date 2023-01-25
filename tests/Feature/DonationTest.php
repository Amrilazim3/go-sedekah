<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DonationTest extends TestCase
{
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
}
