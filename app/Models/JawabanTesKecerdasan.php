<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTesKecerdasan extends Model
{
    use HasFactory;
    protected $table = 'jawabanteskecerdasan';
    protected $id = 'id';
    protected $fillable = [
        'idformtes',
        'idklien',
        'idsoal',
        'kategorisoal',
        'levelsoal',
        'jawabanklien',
        'benarsalah',
    ];
}
