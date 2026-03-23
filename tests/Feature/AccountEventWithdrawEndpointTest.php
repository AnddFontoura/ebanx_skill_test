<?php

namespace Tests\Feature;

use App\AccountBalanceEnum;
use App\Models\AccountBalance;
use App\Models\Accounts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountEventWithdrawEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected string $url = '/event';

    public function test_event_url_with_valid_parameters()
    {
        $mock = [
            "type" => "withdraw",
            "origin" => "100",
            "amount" => 10
        ];

        $accountWithdraw = Accounts::factory()->create([
            'id' => 100,
        ]);

        AccountBalance::factory()->create([
            'account_id' => $accountWithdraw->id,
            'type' => AccountBalanceEnum::deposit->value,
            'amount' => 500,
        ]);

        $response = $this->postJson($this->url, $mock);

        $response->assertJson([
            "origin" => [
                "id" => "100",
                "balance" => 490
            ]
        ]);
        $response->assertStatus(201);
    }

    public function test_event_url_without_type_parameters()
    {
        $mock = [
            "origin" => "100",
            "amount" => 10
        ];

        $accountWithdraw = Accounts::factory()->create([
            'id' => 100,
        ]);

        AccountBalance::factory()->create([
            'account_id' => $accountWithdraw->id,
            'amount' => 500,
        ]);

        $response = $this->postJson($this->url, $mock);


        $this->invalidParameters($response, 'type');
        $response->assertStatus(422);
    }

    public function test_event_url_without_origin_parameters()
    {
        $mock = [
            "type" => "withdraw",
            "amount" => 10
        ];

        $accountWithdraw = Accounts::factory()->create([
            'id' => 100,
        ]);

        AccountBalance::factory()->create([
            'account_id' => $accountWithdraw->id,
            'amount' => 500,
        ]);

        $response = $this->postJson($this->url, $mock);


        $this->invalidParameters($response, 'origin');
        $response->assertStatus(422);
    }

    public function test_event_url_without_amount_parameters()
    {
        $mock = [
            "origin" => "100",
            "type" => "withdraw",
        ];

        $accountWithdraw = Accounts::factory()->create([
            'id' => 100,
        ]);

        AccountBalance::factory()->create([
            'account_id' => $accountWithdraw->id,
            'amount' => 500,
        ]);

        $response = $this->postJson($this->url, $mock);


        $this->invalidParameters($response, 'amount');
        $response->assertStatus(422);
    }


    public function test_event_url_without_founds()
    {
        $mock = [
            "origin" => "100",
            "type" => "withdraw",
            "amount" => '100'
        ];

        Accounts::factory()->create([
            'id' => 100,
        ]);

        $response = $this->postJson($this->url, $mock);

        $response->assertJson(["message" => "Insufficient founds"]);
        $response->assertStatus(422);
    }
}