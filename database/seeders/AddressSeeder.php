<?php
namespace Database\Seeders;

use App\Models\DeliveryAddress;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use Faker\Factory as Faker;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::role('buyer')->get();
        $faker = Faker::create();
        
        foreach ($users as $buyer) {
            // Generate multiple addresses per user (1-3 addresses)
            $addressCount = $faker->numberBetween(1, 3);
            
            for ($i = 0; $i < $addressCount; $i++) {
                // Choose a locale for consistent geographical data
                $locales = ['en_US', 'en_GB', 'en_AU', 'en_CA'];
                $selectedLocale = $faker->randomElement($locales);
                $localeFaker = Faker::create($selectedLocale);
                
                // Get country-specific data
                $countryData = $this->getCountrySpecificData($selectedLocale, $localeFaker);
                
                DeliveryAddress::create([
                    'user_id' => $buyer->id,
                    'address_line_1' => $localeFaker->streetAddress,
                    'address_line_2' => $faker->optional(0.3)->secondaryAddress, // 30% chance of having address line 2
                    'city' => $localeFaker->city,
                    'state' => $countryData['state'],
                    'postal_code' => $countryData['postal_code'],
                    'country' => $countryData['country'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
    
    /**
     * Get country-specific geographical data
     *
     * @param string $locale
     * @param \Faker\Generator $faker
     * @return array
     */
    private function getCountrySpecificData($locale, $faker)
    {
        switch ($locale) {
            case 'en_US':
                return [
                    'state' => $faker->stateAbbr,
                    'postal_code' => $faker->postcode,
                    'country' => 'United States'
                ];
            
            case 'en_GB':
                // UK counties - ensure we always have a value
                $ukCounties = [
                    'England', 'Scotland', 'Wales', 'Northern Ireland',
                    'Greater London', 'West Midlands', 'Greater Manchester',
                    'West Yorkshire', 'Merseyside', 'South Yorkshire',
                    'Tyne and Wear', 'Kent', 'Essex', 'Hampshire'
                ];
                return [
                    'state' => $faker->randomElement($ukCounties),
                    'postal_code' => $faker->postcode,
                    'country' => 'United Kingdom'
                ];
            
            case 'en_AU':
                return [
                    'state' => $faker->state,
                    'postal_code' => $faker->postcode,
                    'country' => 'Australia'
                ];
            
            case 'en_CA':
                return [
                    'state' => $faker->province,
                    'postal_code' => $faker->postcode,
                    'country' => 'Canada'
                ];
            
            default:
                return [
                    'state' => $faker->state,
                    'postal_code' => $faker->postcode,
                    'country' => 'United States'
                ];
        }
    }
}