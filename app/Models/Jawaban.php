<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = "jawabans";
    protected $fillable = [
        'angket_id',
        'user_id',
        'kode',
        'jawaban',
    ];
    protected $casts = [
        'jawaban' => 'array',
    ];
}
