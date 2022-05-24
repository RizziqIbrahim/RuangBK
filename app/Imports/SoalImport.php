<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Soal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SoalImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $soal = Soal::create([
            'nomor_soal' => $row[0],
            'soal' => $row[1],
            'angket_id' => $row[2],
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        return $soal;
    }
}
