<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            ['title' => 'placements One'],
            ['title' => 'placements two'],
            ['title' => 'placements three',]
        ];
        foreach($data as $d) {
            DB::table('placements')->insert($d);

        }
    }
}
