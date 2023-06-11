<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instruktur extends Model
{
    use HasFactory;
    /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'nama_instruktur',
        'alamat_instruktur',
        'no_telepon',
        'tanggal_lahir',
        'email',
        'username',
        'password'
    ];
}
