<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_welcome_screen_can_be_rendered()
    {
        $response = $this->get('/');

        $response->assertSeeInOrder([
            'donationRequestsData'
        ]);

        $response->assertStatus(200);
    }
}
