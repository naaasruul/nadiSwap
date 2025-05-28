<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use Faker\Factory as Faker;

class ShippingSeeder extends Seeder
{
    /**
 * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::role('seller')->get();
        $faker = Faker::create();

        foreach ($user as $seller) {

            $shippingCount = $faker->numberBetween(1, 3);

            for ($i = 0; $i < $shippingCount; $i++) {
                Shipping::insert([
                [
                    'seller_id' => $seller->id,
                    'place' => $faker->city(),
                    'shipping_fee' => $faker->randomFloat(2, 1, 20),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
            }
        }
    }
}
