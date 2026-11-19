<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $primaryKey = 'id_kecamatan';

    protected $fillable = [
        'nama_kecamatan',
        'kode_kecamatan',
        'latitude',
        'longitude',
        'luas_wilayah',
        'jumlah_penduduk',
        'geojson',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'luas_wilayah' => 'float',
            'jumlah_penduduk' => 'integer',
            'geojson' => 'array',
        ];
    }

    public function desa(): HasMany
    {
        return $this->hasMany(Desa::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function targetPajak(): HasManyThrough
    {
        return $this->hasManyThrough(TargetPajak::class, Desa::class, 'id_kecamatan', 'id_desa');
    }

    public function realisasiPajak(): HasManyThrough
    {
        return $this->hasManyThrough(RealisasiPajak::class, Desa::class, 'id_kecamatan', 'id_desa');
    }
}

