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
            'name' => 'default',
            'slug' => 'default',
            'stripe_plan' => 'price_1MxCEjAB46zMuKJxsxHfKdFi',
            'price' => 10.00,
            'active' => true 
        ]);
    }
}
