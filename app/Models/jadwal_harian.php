<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwal_harian extends Model
{
    use HasFactory;
     /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'id_kelas',
        'id_instruktur',
        'tanggal',
        'hari',
        'sesi_kelas',
        'status'
    ];
}
