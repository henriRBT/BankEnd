<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking_kelas extends Model
{
    use HasFactory;
     /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'no_struk_booking_kelas',
        'id_member',
        'id_jadwal_harian',
        'no_struk_transaksi_kelas',
        'no_struk_uang',
        'waktu_booking',
        'tanggal_booking_kelas',
        'slot_kelas',
        'tipe'
    ];
    protected $casts = [
        'no_struk_booking_kelas' => 'string'
    ];
    protected $primaryKey = 'no_struk_booking_kelas';
}
