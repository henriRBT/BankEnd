<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aktivasi extends Model
{
    use HasFactory;
     /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'no_struk_aktivasi',
        'id_member',
        'id_pegawai',
        'tanggal_transaksi',
        'jumlah_bayar',
        'tanggal_berlaku',
    ];
    protected $casts = [
        'no_struk_aktivasi' => 'string'
    ];
}
