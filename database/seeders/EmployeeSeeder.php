<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=[
            [
                'name'=>'ALi',
                'email'=>'ali@gmail.com',
                'phone'=>'03332227365',
                'password'=>Hash::make('12345'),
                'cnic'=>'4210176219854',
                'salary'=>45000,
                'branch_id'=>1

            ],
            [
                'name'=>'Ahmed',
                'email'=>'ahmed@gmail.com',
                'phone'=>'03332227366',
                'password'=>Hash::make('12345'),
                'cnic'=>'4210176219324',
                'salary'=>45000,
                'branch_id'=>1

            ],
            [
                'name'=>'Shayan',
                'email'=>'shayan@gmail.com',
                'phone'=>'03332227367',
                'password'=>Hash::make('12345'),
                'cnic'=>'4210176219114',
                'salary'=>4500,
                'branch_id'=>2

            ],
            
            


        ];
        DB::table('users')->insert($users);

            
    }
}
