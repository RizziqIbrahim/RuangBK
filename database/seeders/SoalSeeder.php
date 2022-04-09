<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Soals::create([
            'soal' => 'mtk',
            'angket_id' => 'awok',
            'created_by' => 'bidu',
            'updated_by' => 'setiw',
            'created_at' => 'depok',
            'updated_at'  => 'jogja',
        ]);
    }
}
