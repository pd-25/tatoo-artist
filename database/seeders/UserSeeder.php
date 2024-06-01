<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $data = [
        [
            "name" => 'Admin Artist', 
            "username" => "artistAdmin",
            "email" => "admin@mail.com", 
            "password" =>  Hash::make("12345")
        ],
        [
            "name" => 'User One', 
            "username" => "userOne",
            "email" => "userone@mail.com", 
            "password" =>  Hash::make("12345")
        ],
        [
            "name" => 'User two', 
            "username" => "usertwo",
            "email" => "usertwo@mail.com", 
            "password" =>  Hash::make("12345")
        ],
        [
            "name" => 'User three', 
            "username" => "userthree",
            "email" => "userthree@mail.com", 
            "password" =>  Hash::make("12345")
        ]];

        foreach($data as $d){
            DB::table('users')->insert($d);
        }
    
    }
}
