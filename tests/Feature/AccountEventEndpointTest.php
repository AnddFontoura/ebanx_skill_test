<?php

namespace Tests\Feature;

use App\Models\Accounts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountEventEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_url_with_invalid_destination()
    {
        $mock = [
            "type" => "deposit",
            "destination" => "100",
            "amount" => 10
        ];

        Accounts::factory()->create([
            'id' => 100,
        ]);

        $response = $this->postJson('/event', $mock);

        $response->assertStatus(200);
    }
}