<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class member extends Model
{
    use  HasFactory, Notifiable;
    /**
    * fillable
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'nama_member',
        'no_telepon_member',
        'alamat_member',
        'tanggal_lahir_member',
        'email_member',
        'tanggal_masa_aktif',
        'deposit_uang',
        'status',
        'username',
        'password'
    ];

    protected $casts = [
        'id' => 'string',
    ];
    protected $primaryKey = 'id';
}
