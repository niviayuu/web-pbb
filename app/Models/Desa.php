<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Desa extends Model
{
    protected $table = 'desa';
    protected $primaryKey = 'id_desa';

    protected $fillable = [
        'id_kecamatan',
        'nama_desa',
        'kode_desa',
        'jenis',
        'latitude',
        'longitude',
        'geojson',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'geojson' => 'array',
        ];
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function targetPajak(): HasMany
    {
        return $this->hasMany(TargetPajak::class, 'id_desa', 'id_desa');
    }

    public function realisasiPajak(): HasMany
    {
        return $this->hasMany(RealisasiPajak::class, 'id_desa', 'id_desa');
    }

    public function wajibPajak(): HasMany
    {
        return $this->hasMany(WajibPajak::class, 'id_desa', 'id_desa');
    }

    public function objekPajak(): HasMany
    {
        return $this->hasMany(ObjekPajak::class, 'id_desa', 'id_desa');
    }
}

