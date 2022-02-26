<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class CurrenciesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_currency_list_should_fail()
    {
        $response = $this->get('/api/currencies');

        $response->assertStatus(422);
    }

    public function test_currency_list_should_fail_connection_error()
    {
        Config::set('database.connections.mysql.database', 'errored');
        $response = $this->get('/api/currencies');

        $response->assertStatus(422);
    }

    public function test_currency_list_should_complete()
    {
        $response = $this->call('GET', '/api/currencies', [
            'offset' => 0,
            'limit' => 10
        ]);

        $response->assertStatus(200);
    }
}
