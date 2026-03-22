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

        $response->assertStatus(200);
    }
}