<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAnggaran extends Model
{
    protected $table = 'tahun_anggaran';
    protected $primaryKey = 'id_tahun';

    protected $fillable = [
        'tahun',
        'status',
    ];

    public function targetPajak(): HasMany
    {
        return $this->hasMany(TargetPajak::class, 'id_tahun', 'id_tahun');
    }

    public function realisasiPajak(): HasMany
    {
        return $this->hasMany(RealisasiPajak::class, 'id_tahun', 'id_tahun');
    }

    public function penggunaanPajak(): HasMany
    {
        return $this->hasMany(PenggunaanPajak::class, 'id_tahun', 'id_tahun');
    }
}

