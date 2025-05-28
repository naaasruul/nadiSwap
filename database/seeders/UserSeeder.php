<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        
        // Create an admin user
        $admin = User::create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'adminuser',
            'gender'=>'male',
            'email' => 'admin@demo.oo',
            'phone_number' => '0167797762',
            'password' => bcrypt('password'), // Use a secure password
        ]);
        $admin->assignRole('admin');

        // Create a seller user
        $sellers = [
            [
                'name' => 'Seller User',
                'first_name' => 'Seller',
                'last_name' => 'User',
                'username' => 'selleruser',
                'gender'=>'male',
                'email' => 'seller@demo.oo',
                'password' => bcrypt('password'), // Use a secure password
                'phone_number' => '1234567890',
                'matrix_number' => 'M123',
            ],
            [
                'name' => 'Seller User 2',
                'first_name' => 'Seller',
                'last_name' => 'User 2',
                'username' => 'selleruser2',
                'gender'=>'female',
                'email' => 'seller2@demo.oo',
                'password' => bcrypt('password'), // Use a secure password
                'phone_number' => '1234567890',
                'matrix_number' => 'M122',
            ],
        ];
        foreach ($sellers as $data) {
            $seller = User::create($data);
            $seller->assignRole('seller');
        }

        // Create a buyer user
        $buyers = 
        [
            [
                'name' => 'Buyer User',
                'first_name' => 'Buyer',
                'last_name' => 'User',
                'username' => 'buyeruser',
                'gender'=>'male',
                'email' => 'buyer@demo.oo',
                'password' => bcrypt('password'), // Use a secure password
                'phone_number' => '1234567890',
                'matrix_number' => 'B123',
            ],
            [
                'name' => 'Buyer User 2',
                'first_name' => 'Buyer',
                'last_name' => 'User 2',
                'username' => 'buyeruser2',
                'gender'=>'female',
                'email' => 'buyer2@demo.oo',
                'password' => bcrypt('password'), // Use a secure password
                'phone_number' => '1234567890',
                'matrix_number' => 'B122',
            ],
        ];

        foreach ($buyers as $data) {
            $buyer = User::create($data);
            $buyer->assignRole('buyer');
        }
    }
}
