<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = "jawabans";
    protected $fillable = [
        'soal_id',
        'jawaban',
    ];
    protected $casts = [
        'jawaban' => 'array',
    ];
}
