<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTes extends Model
{
    use HasFactory;
    protected $table = 'formtes';
    protected $id = 'id';
    protected $fillable = [
        'idklien',
        'idtest',
        'tanggaltes',
        'status',
    ];
}
