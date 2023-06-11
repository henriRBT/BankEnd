<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi_deposit_kelas extends Model
{
    use HasFactory;
    /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'no_struk_kelas',
        'id_pegawai',
        'id_member',
        'id_promo',
        'id_kelas',
        'tanggal_transaksi',
        'tanggal_berlaku',
        'jumlah_deposit_kelas',
        'jumlah_bayar_kelas',
        'bonus',
        'total_deposit_kelas'
    ];
    protected $casts = [
        'no_struk_kelas' => 'string'
    ];
    protected $primaryKey = 'no_struk_kelas';
}
