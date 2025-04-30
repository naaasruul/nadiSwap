<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 200 products with random data
        Product::factory(200)->create();

        // You can also create specific products, such as out-of-stock or discounted products
        Product::factory()->outOfStock()->create();
        Product::factory()->discounted(20)->create(); // 20% discount
    }
}
