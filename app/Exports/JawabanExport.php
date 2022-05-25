<?php

namespace App\Exports;

use App\Models\Jawaban;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JawabanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id, $data;
    public function __construct($id, $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    public function collection()
    {
        return collect([$this->data]);  
    }

    public function headings(): array
    {
        return ["nomor_soal", "jawaban"];
    }
}
