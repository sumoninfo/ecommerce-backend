<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create dummy admin user
        Admin::create([
            'name'     => "Super Admin",
            'email'    => "admin@gmail.com",
            'password' => Hash::make(12345678),
        ]);
        //Create dummy customer user
        User::create([
            'name'     => "Customer",
            'email'    => "customer@gmail.com",
            'password' => Hash::make(12345678),
        ]);
    }
}
