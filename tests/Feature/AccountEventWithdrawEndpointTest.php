<?php

namespace Tests\Feature;

use App\Models\Accounts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountEventWithdrawEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_url_with_valid_parameters()
    {
        $mock = [
            "type" => "withdraw",
            "origin" => "100",
            "amount" => 10
        ];

        Accounts::factory()->create([
            'id' => 100,
        ]);

        $response = $this->postJson('/event', $mock);

        $response->assertStatus(200);
    }
}