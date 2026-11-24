<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_user';

    protected $primaryKey = 'id_user';

    public $incrementing = true;

    protected $keyType = 'int';

    // PENTING: tabel tb_user tidak menggunakan created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'username',
        'password',
        'role',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];
}