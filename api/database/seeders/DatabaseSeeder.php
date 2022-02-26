<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $symbols = [
            'USD',
            'JPY',
            'EUR',
            'BRL'
        ];
        foreach ($symbols as $symbol) {
            \App\Models\Currency::factory(1)->create(['symbol' => $symbol]);
        }
    }
}
