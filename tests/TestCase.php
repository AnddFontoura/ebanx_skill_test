<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    //
    public function invalidParameters($response, string $parameterName): void
    {
        $response->assertJson([
            'message' => 'The ' . $parameterName . ' field is required.',
            'errors' => [
                $parameterName => ['The ' . $parameterName . ' field is required.']
            ]
        ]);
    }
}
