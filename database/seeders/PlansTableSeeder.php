<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::firstOrCreate([
            'name' => 'Annual Subscription',
            'slug' => 'annual',
            'stripe_plan' => 'price_1KzD2JBe5WJ82t9XfatF5RMt',
            'price' => 179.00,
            'per' => 'year',
            'active' => true,
            'prod' => true,
            'description' => 'Annual subscription to the medscrippts platform'
        ]);

        Plan::firstOrCreate([
            'name' => 'Lifetime Access',
            'slug' => 'lifetime',
            'stripe_plan' => 'price_1KrRvuBe5WJ82t9XdSr1AbnX',
            'price' => 499.00,
            'active' => true,
            'prod' => true,
            'description' => 'Access to platform for ten years. Save $1290 and have medscrippts through the entire duration of your training.'
        ]);

        Plan::firstOrCreate([
            'name' => 'Annual Subscription',
            'slug' => 'annual',
            'stripe_plan' => 'price_1L0J2YBe5WJ82t9XNP0aFj5J',
            'price' => 179.00,
            'per' => 'year',
            'active' => true,
            'prod' => false,
            'description' => 'Annual test'
        ]);

        Plan::firstOrCreate([
            'name' => 'Lifetime Access',
            'slug' => 'lifetime',
            'stripe_plan' => 'price_1MyHZ6Be5WJ82t9Xus9WRfJc',
            'price' => 499.00,
            'active' => true,
            'prod' => false,
            'description' => 'Lifetime test'
        ]);
    }
}
