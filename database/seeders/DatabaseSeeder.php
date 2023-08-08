<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user= User::create([
            'name' => 'Admin',
            'phone' => '03111222333',
            'email' => 'admin@karachicity.com',
            'cnic' => '1234567891012',
            'password' => Hash::make('12345'),
            'role' => 1,
            'salary' => 80000
        ]);
    }
}
