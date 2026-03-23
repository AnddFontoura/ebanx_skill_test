<?php

namespace Tests\Feature;

use App\Models\Accounts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountEventDepositEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_url_with_valid_parameters()
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

        $response->assertJson([
            "destination" => [
                "id" => "100",
                "balance" => 10
            ]
        ]);
        $response->assertStatus(201);
    }


    public function test_event_url_without_amount_parameters()
    {
        $mock = [
            "type" => "deposit",
            "destination" => "100",
        ];

        $response = $this->postJson('/event', $mock);

        $this->invalidParameters($response, 'amount');
        $response->assertStatus(422);
    }

    public function test_event_url_without_type_parameters()
    {
        $mock = [
            "destination" => "100",
            "amount" => 10
        ];

        $response = $this->postJson('/event', $mock);

        $this->invalidParameters($response, 'type');
        $response->assertStatus(422);
    }


    public function test_event_url_without_destination_parameters()
    {
        $mock = [
            "amount" => 10,
            "type" => "deposit",
        ];

        $response = $this->postJson('/event', $mock);

        $this->invalidParameters($response, 'destination');
        $response->assertStatus(422);
    }
}