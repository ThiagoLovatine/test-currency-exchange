<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ExchangeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_exchange_should_fail_with_validation_error()
    {
        $response = $this->get('/api/exchange');

        $response->assertStatus(422);
    }

    public function test_exchange_should_fail_with_external_error()
    {
        Config::set('fixer-api.access_key', 'errored');

        $response = $this->call('GET', '/api/exchange', [
            "amount" => 100,
            "from" => "BRL",
            "to" => "USD"
        ]);

        $response->assertStatus(500);
    }

    public function test_exchange_should_complete()
    {
        $response = $this->call('GET', '/api/exchange', [
            "amount" => 100,
            "from" => "BRL",
            "to" => "USD"
        ]);

        $response->assertStatus(200);
    }
}
