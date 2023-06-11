<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking_gym extends Model
{
    use HasFactory;
     /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'no_struk_gym',
        'id_member',
        'waktu_booking',
        'tanggal_booking',
        'slot_waktu',
        'waktu_presensi'
    ];
}
