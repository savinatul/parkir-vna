<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'tb_transaksi';

    protected $primaryKey = 'id_parkir';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id_parkir',
        'id_kendaraan',
        'waktu_masuk',
        'waktu_keluar',
        'id_tarif',
        'durasi_jam',
        'biaya_total',
        'status',
        'id_user',
        'id_area',
    ];

    protected $casts = [
    'waktu_masuk' => 'datetime',
    'waktu_keluar' => 'datetime',
    'biaya_total' => 'decimal:2',
];

    // Relasi ke kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(
            Kendaraan::class,
            'id_kendaraan',
            'id_kendaraan'
        );
    }

    // Relasi ke tarif
    public function tarif()
    {
        return $this->belongsTo(
            Tarif::class,
            'id_tarif',
            'id_tarif'
        );
    }

    // Relasi ke user/petugas
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

    // Relasi ke area parkir
    public function area()
    {
        return $this->belongsTo(
            AreaParkir::class,
            'id_area',
            'id_area'
        );
    }
}