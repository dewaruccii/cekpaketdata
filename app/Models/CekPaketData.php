<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CekPaketData extends Model
{
    protected $table = 'cek_paket_datas';
    protected $fillable = [
        'uuid',
        'operator',
        'harga',
        'kuota_gb',
        'masa_aktif_hari',
        'ppgb',
        'flag',
        'latitude',
        'longitude',
        'user_email',
    ];

    public function Files()
    {
        return $this->hasMany(File::class, 'fileable_id', 'uuid');
    }
}
