<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_dashboard_page_can_be_rendered()
    {
        $this->actingAs($user = User::factory()->create());
        
        $response = $this->get('/dashboard');
        
        $response->assertStatus(200);
    }
}
