<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountBalanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_balance_url_with_invalid_account_id()
    {
        $response = $this->get('/balance?account_id=1234');

        $response->assertStatus(200);
    }
}