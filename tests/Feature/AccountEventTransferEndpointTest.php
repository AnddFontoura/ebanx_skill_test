<?php

namespace Tests\Feature;

use App\Models\Accounts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountEventTransferEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_url_with_valid_parameters()
    {
        $mock = [
            "type" => "transfer",
            "destination" => "300",
            "amount" => 10,
            "origin" => "100",
        ];

        Accounts::factory()->create([
            'id' => 100,
        ]);

        Accounts::factory()->create([
            'id' => 300,
        ]);

        $response = $this->postJson('/event', $mock);

        $response->assertStatus(200);
    }
}