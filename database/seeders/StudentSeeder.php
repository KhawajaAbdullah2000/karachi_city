<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert(
            [
                'first_name'=>'Zayan',
                'last_name'=>'Ali',
                'DOB'=>'2011-06-10',
                'email'=>'zayan@gmail.com',
                'Gender'=>'male',
                'password'=>Hash::make('12345'),
                'phone'=>'04446312313',
                'school'=>'Beaconhouse',
                'medical'=>'NO',
                'parent_email'=>'k200987@gmail.com',
                'parent_phone'=>'09998887643',
                'emergency_name'=>'ALi',
                'emergency_contact'=>'09998887643',
                'branch_id'=>7

            ]
            );
    }
}

