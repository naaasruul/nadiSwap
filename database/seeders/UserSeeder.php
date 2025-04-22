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
            'email' => 'admin@demo.oo',
            'password' => bcrypt('password'), // Use a secure password
        ]);
        $admin->assignRole('admin');

        // Create a seller user
        $seller = User::create([
            'name' => 'Seller User',
            'email' => 'seller@demo.oo',
            'password' => bcrypt('password'), // Use a secure password
        ]);
        $seller->assignRole('seller');
    }
}
