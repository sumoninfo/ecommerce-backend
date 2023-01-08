<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create dummy admin user
        User::insert([
            [
                'name'       => "Customer",
                'email'      => "customer@gmail.com",
                'password'   => Hash::make(12345678), // 12345678
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'name'       => "Customer 1",
                'email'      => "customer1@gmail.com",
                'password'   => Hash::make(12345678), // 12345678
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'name'       => "Customer 2",
                'email'      => "customer2@gmail.com",
                'password'   => Hash::make(12345678), // 12345678
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'name'       => "Customer 3",
                'email'      => "customer@gmail.com",
                'password'   => Hash::make(12345678), // 12345678
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'name'       => "Customer 4",
                'email'      => "customer4@gmail.com",
                'password'   => Hash::make(12345678), // 12345678
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'name'       => "Customer 5",
                'email'      => "customer5@gmail.com",
                'password'   => Hash::make(12345678), // 12345678
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
