<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WajibPajak extends Model
{
    protected $table = 'wajib_pajak';
    protected $primaryKey = 'id_wajib_pajak';

    protected $fillable = [
        'id_desa',
        'nama_wajib_pajak',
        'nik_npwp',
        'alamat',
        'no_telepon',
    ];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id_desa');
    }

    public function objekPajak(): HasMany
    {
        return $this->hasMany(ObjekPajak::class, 'id_wajib_pajak', 'id_wajib_pajak');
    }
}

