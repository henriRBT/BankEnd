<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deposit_kelas extends Model
{
    use HasFactory;
     /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'id_member',
        'id_kelas',
        'tanggal_berlaku',
        'sisa_deposit_kelas',
    ];
}
