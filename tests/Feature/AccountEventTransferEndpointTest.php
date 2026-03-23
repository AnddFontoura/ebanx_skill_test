<?php

namespace Tests\Feature;

use App\AccountBalanceEnum;
use App\Models\AccountBalance;
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
            "destination" => "999",
            "amount" => 10,
            "origin" => "333",
        ];

        $accountWithdraw = Accounts::factory()->create([
            'id' => 333,
        ]);

        Accounts::factory()->create([
            'id' => 999,
        ]);

        AccountBalance::factory()->create([
            'account_id' => $accountWithdraw->id,
            'type' => AccountBalanceEnum::deposit->value,
            'amount' => 500,
        ]);

        $response = $this->postJson('/event', $mock);


        $response->assertJson([
            "origin" => [
                "id" => "333",
                "balance" => 490
            ],
            "destination" => [
                "id" => "999",
                "balance" => 10
            ]
        ]);

        $response->assertStatus(201);
    }

    public function test_event_url_without_type_parameters()
    {
        $mock = [
            "destination" => "999",
            "amount" => 10,
            "origin" => "333",
        ];

        $accountWithdraw = Accounts::factory()->create([
            'id' => 333,
        ]);

        Accounts::factory()->create([
            'id' => 999,
        ]);

        AccountBalance::factory()->create([
            'account_id' => $accountWithdraw->id,
            'type' => AccountBalanceEnum::deposit->value,
            'amount' => 500,
        ]);

        $response = $this->postJson('/event', $mock);

        $response->assertJson([
            'message' => 'The type field is required.',
            'errors' => [
                'type' => ['The type field is required.']
            ]
        ]);
        $response->assertStatus(422);
    }

    public function test_event_url_without_destination_parameters()
    {
        $mock = [
            "type" => "transfer",
            "amount" => 10,
            "origin" => "333",
        ];

        $accountWithdraw = Accounts::factory()->create([
            'id' => 333,
        ]);

        Accounts::factory()->create([
            'id' => 999,
        ]);

        AccountBalance::factory()->create([
            'account_id' => $accountWithdraw->id,
            'type' => AccountBalanceEnum::deposit->value,
            'amount' => 500,
        ]);

        $response = $this->postJson('/event', $mock);

        $response->assertJson([
            'message' => 'The destination field is required.',
            'errors' => [
                'destination' => ['The destination field is required.']
            ]
        ]);
        $response->assertStatus(422);
    }

    public function test_event_url_without_origin_parameters()
    {
        $mock = [
            "type" => "transfer",
            "destination" => "999",
            "amount" => "10",
        ];

        $accountWithdraw = Accounts::factory()->create([
            'id' => 333,
        ]);

        Accounts::factory()->create([
            'id' => 999,
        ]);

        AccountBalance::factory()->create([
            'account_id' => $accountWithdraw->id,
            'type' => AccountBalanceEnum::deposit->value,
            'amount' => 500,
        ]);

        $response = $this->postJson('/event', $mock);

        $response->assertJson([
            'message' => 'The origin field is required.',
            'errors' => [
                'origin' => ['The origin field is required.']
            ]
        ]);
        $response->assertStatus(422);
    }

    public function test_event_url_with_invalid_destination()
    {
        $mock = [
            "type" => "transfer",
            "destination" => "999",
            "amount" => 10,
            "origin" => "333",
        ];

        $accountWithdraw = Accounts::factory()->create([
            'id' => 333,
        ]);

        AccountBalance::factory()->create([
            'account_id' => $accountWithdraw->id,
            'type' => AccountBalanceEnum::deposit->value,
            'amount' => 500,
        ]);

        $response = $this->postJson('/event', $mock);

        $response->assertContent("0");

        $response->assertStatus(404);
    }

    public function test_event_url_with_invalid_origin()
    {
        $mock = [
            "type" => "transfer",
            "destination" => "999",
            "amount" => 10,
            "origin" => "666",
        ];

        $response = $this->postJson('/event', $mock);

        $response->assertContent("0");

        $response->assertStatus(404);
    }

    public function test_event_url_with_insufficient_founds()
    {
        $mock = [
            "type" => "transfer",
            "destination" => "999",
            "amount" => 100,
            "origin" => "333",
        ];

        $accountWithdraw = Accounts::factory()->create([
            'id' => 333,
        ]);

        Accounts::factory()->create([
            'id' => 999,
        ]);

        AccountBalance::factory()->create([
            'account_id' => $accountWithdraw->id,
            'type' => AccountBalanceEnum::deposit->value,
            'amount' => 50,
        ]);

        $response = $this->postJson('/event', $mock);


        $response->assertJson([
            'message' => 'Insufficient founds'
        ]);

        $response->assertStatus(422);
    }
}