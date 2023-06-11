<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class izin extends Model
{
    use HasFactory;
     /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'id_instruktur',
        'id_jadwal_harian',
        'tanggal_buat',
        'keterangan',
        'status',
        'tanggal_konfirmasi'
    ];
}
