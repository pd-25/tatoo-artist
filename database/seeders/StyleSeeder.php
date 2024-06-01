<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $data = [
            [
                'title' => 'Style One'
            ],
            ['title' => 'Style two'],
            ['title' => 'Style three',]
        ];
        foreach ($data as $d) {
            DB::table('styles')->insert($d);
        }
    }
}
