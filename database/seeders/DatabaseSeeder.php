<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        User::factory()->count(3)
            ->has(Product::factory()->count(12), 'products')
            ->create();

        // $user = User::factory()
        // ->hasProducts(12)
        // ->create();
    }
}
