<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ObjekPajak extends Model
{
    protected $table = 'objek_pajak';
    protected $primaryKey = 'id_objek_pajak';

    protected $fillable = [
        'id_wajib_pajak',
        'id_jenis_pajak',
        'id_desa',
        'nop',
        'alamat_objek',
        'luas_bumi',
        'luas_bangunan',
        'nilai_pajak',
        'status_pembayaran',
    ];

    protected function casts(): array
    {
        return [
            'luas_bumi' => 'float',
            'luas_bangunan' => 'float',
            'nilai_pajak' => 'float',
        ];
    }

    public function wajibPajak(): BelongsTo
    {
        return $this->belongsTo(WajibPajak::class, 'id_wajib_pajak', 'id_wajib_pajak');
    }

    public function jenisPajak(): BelongsTo
    {
        return $this->belongsTo(JenisPajak::class, 'id_jenis_pajak', 'id_jenis_pajak');
    }

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id_desa');
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(PembayaranPajak::class, 'id_objek_pajak', 'id_objek_pajak');
    }
}

