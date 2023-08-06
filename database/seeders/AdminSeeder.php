<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                'name'=>'Admin',
                'email'=>'admin@gmail.com',
                'phone'=>'03332227364',
                'role'=>1,
                'password'=>Hash::make('12345'),
                'cnic'=>'4210176219874',
                'salary'=>20000
         

            ]
            );
    }
}
