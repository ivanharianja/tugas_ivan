<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesKecermatan extends Model
{
    use HasFactory;
    protected $table = 'teskecermatan';
    protected $id = 'id';
    protected $idtest = 'idtest';
    protected $fillable = ['kar1', 'kar2', 'kar3', 'kar4', 'kar5'];
}
