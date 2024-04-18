<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSoalTesKecermatan extends Model
{
    use HasFactory;
    protected $table = 'subsoalteskecermatan';
    protected $id = 'id';
    protected $idsoal = 'idsoal';
    protected $fillable = [
        'kar1',
        'kar2',
        'kar3',
        'kar4',
        'karhilang',
    ];
}
