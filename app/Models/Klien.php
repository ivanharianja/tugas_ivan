<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Klien extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable, Notifiable;

    protected $table = 'klien';
    protected $id = 'id';
    protected $fillable = [
        'nama',
        'jeniskelamin',
        'tanggallahir',
        'email',
        'nomortelepon',
        'alamat',
        'kota',
        'instansi',
        'pendidikanterakhir',
        'keperluan',
    ];
}