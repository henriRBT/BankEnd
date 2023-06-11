<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deposit_uang extends Model
{
    use HasFactory;

    /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'no_struk_uang',
        'id_pegawai',
        'id_member',
        'id_promo',
        'tanggal_transaksi',
        'jumlah_bayar',
        'bonus',
        'total_deposit',
        'sisa_deposit',
       
    ];
    protected $casts = [
        'no_struk_uang' => 'string'
    ];
    protected $primaryKey = 'no_struk_uang';
}
