<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountBalanceEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_balance_url_with_invalid_account_id()
    {
        $response = $this->get('/balance?account_id=1234');

        $response->assertStatus(404);
    }

    public function test_balance_url_without_account_id()
    {
        $response = $this->get('/balance');

        $response->assertStatus(302);
    }
}