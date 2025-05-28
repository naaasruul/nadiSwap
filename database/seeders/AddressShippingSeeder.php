<?php
namespace Database\Seeders;

use App\Models\DeliveryAddress;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use Faker\Factory as Faker;

class AddressShippingSeeder extends Seeder
{
	/**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the RoleSeeder and UserSeeder
        $this->call([
            AddressSeeder::class,
			ShippingSeeder::class,
        ]);
    }
}