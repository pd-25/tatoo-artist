<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'subjects One'
            ],
            ['title' => 'subjects two'],
            ['title' => 'subjects three',]
        ];
        foreach ($data as $d) {
            DB::table('subjects')->insert($d);
        }
    }
}
