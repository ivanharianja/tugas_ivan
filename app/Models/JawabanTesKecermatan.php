<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTesKecermatan extends Model
{
    use HasFactory;
    protected $table = 'jawabanteskecermatan';
    protected $id = 'id';
    protected $fillable = [
        'idformtes',
        'idklien',
        'idsoal',
        'sesi',
        'benar',
    ];
}
