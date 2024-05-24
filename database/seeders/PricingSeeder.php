<?php

namespace Database\Seeders;

use App\Models\Pricing;
use Illuminate\Database\Seeder;

/*
 * Seeds the database with the current pricing data from OpenAI.
 * Last checked: 2024-03-27
 */

class PricingSeeder extends Seeder
{
    public function run(): void
    {
        //empty the table
        Pricing::truncate();

        //insert the new data
        $pricing = [
            [
                'model' => 'gpt-3.5-turbo-0125',
                'input_price' => 0.0005,
                'output_price' => 0.0015
            ],
            [
                'model' => 'gpt-4o',
                'input_price' => 0.0050,
                'output_price' => 0.0150
            ]
        ];

        foreach ($pricing as $price) {
            Pricing::create($price);
        }
    }
}
