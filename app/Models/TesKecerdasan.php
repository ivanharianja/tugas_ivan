<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesKecerdasan extends Model
{
    use HasFactory;
    protected $table = 'teskecerdasan';
    protected $id = 'id';
    protected $idtest = 'idtest';
    protected $fillable = [
        'pertanyaan',
        'opsi1',
        'opsi2',
        'opsi3',
        'opsi4',
        'opsi5',
        'jawabanbenar',
        'kategori',
        'level',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class, 'idtest');
    }
}
